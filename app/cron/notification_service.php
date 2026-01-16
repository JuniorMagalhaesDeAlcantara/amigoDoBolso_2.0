<?php

/**
 * Notification Service - Cron
 * Executa via CLI
 */

// ===============================
// BOOTSTRAP (OBRIGATÓRIO)
// ===============================
define('BASE_PATH', dirname(__DIR__, 2));
define('APP', BASE_PATH . '/app'); // ✅ ADICIONADO

// Core
require_once BASE_PATH . '/app/config/Database.php';
require_once BASE_PATH . '/app/core/Model.php';

// Models
require_once BASE_PATH . '/app/models/NotificationModel.php';
require_once BASE_PATH . '/app/models/CreditCardModel.php';
require_once BASE_PATH . '/app/models/TransactionModel.php';
require_once BASE_PATH . '/app/models/GroupModel.php';
require_once BASE_PATH . '/app/models/UserModel.php';

// ✅ Helper
require_once BASE_PATH . '/app/helpers/EmailHelper.php';

// ===============================
// SERVICE
// ===============================
class NotificationService
{
    private NotificationModel $notificationModel;
    private CreditCardModel $creditCardModel;
    private TransactionModel $transactionModel;
    private GroupModel $groupModel;
    private UserModel $userModel;

    public function __construct()
    {
        $this->notificationModel = new NotificationModel();
        $this->creditCardModel   = new CreditCardModel();
        $this->transactionModel  = new TransactionModel();
        $this->groupModel        = new GroupModel();
        $this->userModel         = new UserModel();
    }

    public function processAllNotifications()
    {
        $this->log("=== Iniciando processamento de notificações ===");
        $this->log(date('Y-m-d H:i:s'));

        try {
            $this->processCardNotifications();
            $this->processMonthlyReports();
            $this->cleanOldNotifications();
            $this->processRecurringExpenses();

            $this->log("=== Processamento concluído com sucesso ===");
        } catch (Throwable $e) {
            $this->log("ERRO CRÍTICO: " . $e->getMessage());
            $this->log("Stack trace: " . $e->getTraceAsString());
        }
    }

    // ===============================
    // CARTÕES DE CRÉDITO
    // ===============================
    private function processCardNotifications()
    {
        $this->log("--- Processando notificações de cartões ---");

        $groups = $this->getAllGroups();
        $this->log("Grupos encontrados: " . count($groups));

        if (empty($groups)) {
            $this->log("[AVISO] Nenhum grupo encontrado no sistema");
            return;
        }

        $totalNotifications = 0;

        foreach ($groups as $group) {
            $this->log("Processando grupo ID {$group['id']}: {$group['name']}");

            $members = $this->groupModel->getMembers($group['id']);
            $this->log("  Membros no grupo: " . count($members));

            $cards = $this->creditCardModel->getByGroup($group['id']);
            $this->log("  Cartões no grupo: " . count($cards));

            foreach ($members as $member) {
                $settings = $this->notificationModel->getUserSettings($member['id']);

                $this->log("  Usuário ID {$member['id']}: App={$settings['enable_app_notifications']}, Email={$settings['enable_email_notifications']}");

                if (
                    !$settings['enable_app_notifications'] &&
                    !$settings['enable_email_notifications']
                ) {
                    $this->log("    [SKIP] Notificações desabilitadas para usuário {$member['id']}");
                    continue;
                }

                foreach ($cards as $card) {
                    $sent = $this->checkCardDueDate($member, $card, $settings);
                    if ($sent) {
                        $totalNotifications++;
                    }
                }
            }
        }

        $this->log("Notificações de cartões processadas: {$totalNotifications} criadas");
    }

    private function checkCardDueDate($member, $card, $settings)
    {
        $dueDay       = (int)$card['due_day'];
        $daysUntilDue = $this->calculateDaysUntilDue($dueDay);

        $this->log("    Cartão '{$card['name']}' (dia {$dueDay}): faltam {$daysUntilDue} dias");

        $month = date('n');
        $year  = date('Y');

        $invoiceTotal = $this->transactionModel->getCardInvoiceTotal(
            $card['id'],
            $month,
            $year
        );

        $this->log("      Valor da fatura: R$ " . number_format($invoiceTotal, 2, ',', '.'));

        $sent = false;

        if ($daysUntilDue === 3 && $settings['email_notify_3days']) {
            $this->sendCardNotification(
                $member,
                $card,
                $invoiceTotal,
                'medium',
                '⏰ Fatura vence em 3 dias',
                "A fatura do cartão {$card['name']} vence em 3 dias (dia {$dueDay}).\nValor estimado: R$ " . number_format($invoiceTotal, 2, ',', '.')
            );
            $sent = true;
        }

        if ($daysUntilDue === 1 && $settings['email_notify_1day']) {
            $this->sendCardNotification(
                $member,
                $card,
                $invoiceTotal,
                'high',
                '⚠️ Fatura vence amanhã!',
                "A fatura do cartão {$card['name']} vence amanhã.\nValor estimado: R$ " . number_format($invoiceTotal, 2, ',', '.')
            );
            $sent = true;
        }

        if ($daysUntilDue === 0 && $settings['email_notify_today']) {
            $this->sendCardNotification(
                $member,
                $card,
                $invoiceTotal,
                'urgent',
                '🔴 Fatura vence hoje!',
                "A fatura do cartão {$card['name']} vence HOJE.\nValor: R$ " . number_format($invoiceTotal, 2, ',', '.')
            );
            $sent = true;
        }

        return $sent;
    }

    private function sendCardNotification($member, $card, $amount, $priority, $title, $message)
    {
        $userId = $member['id'];

        if ($this->notificationModel->existsRecent($userId, 'fatura_vencimento', 'card', $card['id'], 24)) {
            $this->log("      [INFO] Notificação já enviada nas últimas 24h");
            return false;
        }

        $emailData = [
            'card_name' => $card['name'],
            'amount' => $amount,
            'due_date' => date('d/m/Y', strtotime(date('Y-m-') . $card['due_day'])),
            'days_until_due' => $this->calculateDaysUntilDue($card['due_day'])
        ];

        $this->notificationModel->createAndNotify(
            $userId,
            'fatura_vencimento',
            $title,
            $message,
            $priority,
            'card',
            $card['id'],
            $emailData
        );

        $this->log("      [OK] ✓ Notificação criada (app + email) para usuário {$userId}");
        return true;
    }

    // ===============================
    // RELATÓRIO MENSAL
    // ===============================
    private function processMonthlyReports()
    {
        if (date('d') !== '01') {
            $this->log("Não é dia 1, pulando relatório mensal");
            return;
        }

        $this->log("--- Processando relatórios mensais ---");

        $groups = $this->getAllGroups();
        $this->log("Grupos para relatório: " . count($groups));

        foreach ($groups as $group) {
            $members = $this->groupModel->getMembers($group['id']);

            foreach ($members as $member) {
                $settings = $this->notificationModel->getUserSettings($member['id']);

                if (!$settings['email_monthly_report']) {
                    continue;
                }

                $this->sendMonthlyReport($member, $group);
            }
        }
    }

    private function sendMonthlyReport($member, $group)
    {
        $lastMonth = date('Y-m', strtotime('first day of last month'));
        [$year, $month] = explode('-', $lastMonth);

        $summary = $this->transactionModel->getMonthlyBalance($group['id'], $month, $year);

        $income  = $summary['total_income'] ?? 0;
        $expense = $summary['total_expense'] ?? 0;
        $balance = $income - $expense;

        $message =
            "Resumo de {$group['name']} - {$month}/{$year}\n\n" .
            "Receitas: R$ " . number_format($income, 2, ',', '.') . "\n" .
            "Despesas: R$ " . number_format($expense, 2, ',', '.') . "\n" .
            "Saldo: R$ " . number_format($balance, 2, ',', '.');

        $emailData = [
            'group_name' => $group['name'],
            'month' => $month,
            'year' => $year,
            'income' => $income,
            'expense' => $expense,
            'balance' => $balance
        ];

        $this->notificationModel->createAndNotify(
            $member['id'],
            'relatorio_mensal',
            '📈 Relatório Mensal',
            $message,
            'low',
            'report',
            $group['id'],
            $emailData
        );

        $this->log("[OK] Relatório mensal enviado para usuário {$member['id']}");
    }

    // ===============================
    // DESPESAS RECORRENTES
    // ===============================
    private function processRecurringExpenses()
    {
        $this->log('--- Processando despesas recorrentes ---');

        $groups = $this->getAllGroups();
        $this->log("Grupos encontrados: " . count($groups));

        $totalNotifications = 0;

        foreach ($groups as $group) {
            $this->log("Verificando grupo ID {$group['id']}: {$group['name']}");

            $transactions = $this->transactionModel->getOverdueRecurringByGroup($group['id']);
            $this->log("  Despesas recorrentes encontradas: " . count($transactions));

            if (empty($transactions)) continue;

            $members = $this->groupModel->getMembers($group['id']);

            foreach ($members as $member) {
                $settings = $this->notificationModel->getUserSettings($member['id']);

                if (!$settings['enable_app_notifications']) {
                    $this->log("  [SKIP] Notificações desabilitadas para usuário {$member['id']}");
                    continue;
                }

                foreach ($transactions as $transaction) {
                    $sent = $this->notifyRecurringExpenseWithDueDays($member, $transaction);
                    if ($sent) $totalNotifications++;
                }
            }
        }

        $this->log("Despesas recorrentes processadas: {$totalNotifications} notificações criadas");
    }

    private function notifyRecurringExpenseWithDueDays($member, $transaction)
    {
        $userId = $member['id'];
        $dueDate = new DateTime($transaction['transaction_date']);
        $daysUntilDue = (int)(new DateTime())->diff($dueDate)->format('%r%a');

        $priority = '';
        $title    = '';
        $send     = false;

        if ($daysUntilDue === 3) {
            $priority = 'medium';
            $title    = '⏰ Despesa vence em 3 dias';
            $send     = true;
        } elseif ($daysUntilDue === 1) {
            $priority = 'high';
            $title    = '⚠️ Despesa vence amanhã';
            $send     = true;
        } elseif ($daysUntilDue === 0) {
            $priority = 'high';
            $title    = '🔴 Despesa vence hoje';
            $send     = true;
        } elseif ($daysUntilDue < 0) {
            $priority = 'urgent';
            $title    = '💸 Despesa recorrente vencida';
            $send     = true;
        }

        if (!$send) return false;

        if ($this->notificationModel->existsRecent(
            $userId,
            'despesa_recorrente_vencida',
            'transaction',
            $transaction['id'],
            24
        )) {
            $this->log("  [INFO] Notificação já enviada para transação {$transaction['id']}");
            return false;
        }

        $message = "A despesa '{$transaction['description']}' " .
            ($daysUntilDue < 0 ? "venceu em " : "vence em ") .
            $dueDate->format('d/m/Y') .
            ".\nValor: R$ " . number_format($transaction['amount'], 2, ',', '.');

        $emailData = [
            'description' => $transaction['description'],
            'amount' => $transaction['amount'],
            'due_date' => $dueDate->format('d/m/Y'),
            'is_overdue' => $daysUntilDue < 0
        ];

        $this->notificationModel->createAndNotify(
            $userId,
            'despesa_recorrente_vencida',
            $title,
            $message,
            $priority,
            'transaction',
            $transaction['id'],
            $emailData
        );

        $this->log("  [OK] ✓ Notificação criada para usuário {$userId}, transação {$transaction['id']} ({$title})");
        return true;
    }

    // ===============================
    // LIMPEZA
    // ===============================
    private function cleanOldNotifications()
    {
        $this->log("--- Limpando notificações antigas ---");

        $users = $this->userModel->getAll();
        $cleaned = 0;

        foreach ($users as $user) {
            $result = $this->notificationModel->cleanOldNotifications($user['id'], 30);
            if ($result) {
                $cleaned++;
            }
        }

        $this->log("Limpeza concluída para {$cleaned} usuários");
    }

    private function calculateDaysUntilDue($dueDay)
    {
        $today = (int)date('d');
        if ($dueDay >= $today) {
            return $dueDay - $today;
        }

        $nextDue = new DateTime(date('Y-m-') . $dueDay);
        $nextDue->modify('+1 month');
        return (int)(new DateTime())->diff($nextDue)->format('%a');
    }

    private function getAllGroups()
    {
        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->query("SELECT id, name, created_at FROM `groups` ORDER BY id");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $this->log("ERRO ao buscar grupos: " . $e->getMessage());
            return [];
        }
    }

    private function log($message)
    {
        echo "[CRON] {$message}\n";
    }
}

// ===============================
// EXECUÇÃO
// ===============================
if (php_sapi_name() === 'cli') {
    $service = new NotificationService();
    $service->processAllNotifications();
}