<?php

/**
 * Notification Service - Cron
 * Executa via CLI
 */

// ===============================
// BOOTSTRAP (OBRIGATÓRIO)
// ===============================
define('BASE_PATH', dirname(__DIR__, 2));
// Core
require_once BASE_PATH . '/app/config/Database.php';
require_once BASE_PATH . '/app/core/Model.php';

// Models
require_once BASE_PATH . '/app/models/NotificationModel.php';
require_once BASE_PATH . '/app/models/CreditCardModel.php';
require_once BASE_PATH . '/app/models/TransactionModel.php';
require_once BASE_PATH . '/app/models/GroupModel.php';
require_once BASE_PATH . '/app/models/UserModel.php';

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
            $this->log("ERRO: " . $e->getMessage());
        }
    }

    // ===============================
    // CARTÕES DE CRÉDITO
    // ===============================
    private function processCardNotifications()
    {
        $this->log("--- Processando notificações de cartões ---");

        $groups = $this->userModel->getAll();

        foreach ($groups as $group) {
            $members = $this->groupModel->getMembers($group['id']);
            $cards   = $this->creditCardModel->getByGroup($group['id']);

            foreach ($members as $member) {
                $settings = $this->notificationModel->getUserSettings($member['id']);

                if (
                    !$settings['enable_app_notifications'] &&
                    !$settings['enable_email_notifications']
                ) {
                    continue;
                }

                foreach ($cards as $card) {
                    $this->checkCardDueDate($member, $card, $settings);
                }
            }
        }

        $this->log("Notificações de cartões processadas");
    }

    private function checkCardDueDate($member, $card, $settings)
    {
        $dueDay       = (int)$card['due_day'];
        $daysUntilDue = $this->calculateDaysUntilDue($dueDay);

        $month = date('n');
        $year  = date('Y');

        $invoiceTotal = $this->transactionModel->getCardInvoiceTotal(
            $card['id'],
            $month,
            $year
        );

        if ($daysUntilDue === 3 && $settings['email_notify_3days']) {
            $this->sendCardNotification(
                $member,
                $card,
                $invoiceTotal,
                'medium',
                '⏰ Fatura vence em 3 dias',
                "A fatura do cartão {$card['name']} vence em 3 dias (dia {$dueDay}).\nValor estimado: R$ " . number_format($invoiceTotal, 2, ',', '.')
            );
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
        }
    }

    private function sendCardNotification($member, $card, $amount, $priority, $title, $message)
    {
        $userId = $member['id'];

        if ($this->notificationModel->existsRecent($userId, 'fatura_vencimento', 'card', $card['id'], 24)) {
            return;
        }

        if ($settings['enable_app_notifications'] ?? true) {
            $this->notificationModel->create([
                'user_id'      => $userId,
                'type'         => 'fatura_vencimento',
                'title'        => $title,
                'message'      => $message,
                'priority'     => $priority,
                'related_type' => 'card',
                'related_id'   => $card['id']
            ]);
        }
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

        $groups = $this->userModel->getAll();

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

        $this->notificationModel->create(
            $member['id'],
            'relatorio_mensal',
            '📈 Relatório Mensal',
            $message,
            'low',
            'report',
            $group['id']
        );
    }

    // ===============================
    // LIMPEZA
    // ===============================
    private function cleanOldNotifications()
    {
        foreach ($this->userModel->getAll() as $user) {
            $this->notificationModel->cleanOldNotifications($user['id'], 30);
        }
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

    private function log($message)
    {
        echo "[CRON] {$message}\n";
    }
    // ===============================
    // DESPESAS RECORRENTES VENCIDAS

    private function processRecurringExpenses()
    {
        $this->log('--- Processando despesas recorrentes vencidas ---');

        $groups = $this->userModel->getAll();

        foreach ($groups as $group) {
            $transactions = $this->transactionModel
                ->getOverdueRecurringByGroup($group['id']);

            if (empty($transactions)) {
                continue;
            }

            $members = $this->groupModel->getMembers($group['id']);

            foreach ($members as $member) {
                $settings = $this->notificationModel->getUserSettings($member['id']);

                if (!$settings['enable_app_notifications']) {
                    continue;
                }

                foreach ($transactions as $transaction) {
                    $this->notifyRecurringExpense($member, $transaction);
                }
            }
        }

        $this->log('Despesas recorrentes vencidas processadas');
    }

    private function notifyRecurringExpense($member, $transaction)
    {
        $userId = $member['id'];

        if ($this->notificationModel->existsRecent(
            $userId,
            'despesa_recorrente_vencida',
            'transaction',
            $transaction['id'],
            24
        )) {
            return;
        }

        $this->notificationModel->create([
            'user_id'      => $userId,
            'type'         => 'despesa_recorrente_vencida',
            'title'        => '💸 Despesa recorrente vencida',
            'message'      =>
            "A despesa '{$transaction['description']}' venceu em " .
                date('d/m/Y', strtotime($transaction['transaction_date'])) .
                ".\nValor: R$ " . number_format($transaction['amount'], 2, ',', '.'),
            'priority'     => 'high',
            'related_type' => 'transaction',
            'related_id'   => $transaction['id']
        ]);
    }
}

// ===============================
// EXECUÇÃO
// ===============================
if (php_sapi_name() === 'cli') {
    (new NotificationService())->processAllNotifications();
}
