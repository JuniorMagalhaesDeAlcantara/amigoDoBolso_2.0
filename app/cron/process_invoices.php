<?php

/**
 * Invoice Processing Service - Cron
 * Executa via CLI
 * Processa faturas vencidas e move saldo devedor para próxima fatura
 */

// ===============================
// BOOTSTRAP (OBRIGATÓRIO)
// ===============================
define('BASE_PATH', dirname(__DIR__, 2));
define('APP', BASE_PATH . '/app');

// Core
require_once BASE_PATH . '/app/config/Database.php';
require_once BASE_PATH . '/app/core/Model.php';

// Models
require_once BASE_PATH . '/app/models/CreditCardModel.php';
require_once BASE_PATH . '/app/models/CreditCardInvoiceModel.php';
require_once BASE_PATH . '/app/models/TransactionModel.php';
require_once BASE_PATH . '/app/models/CategoryModel.php';

// ===============================
// SERVICE
// ===============================
class InvoiceProcessingService
{
    private CreditCardModel $creditCardModel;
    private CreditCardInvoiceModel $invoiceModel;
    private TransactionModel $transactionModel;

    public function __construct()
    {
        $this->creditCardModel = new CreditCardModel();
        $this->invoiceModel = new CreditCardInvoiceModel();
        $this->transactionModel = new TransactionModel();
    }

    /**
     * Executa processamento principal
     */
    public function processAll()
    {
        $this->log("=== Iniciando processamento de faturas vencidas ===");
        $this->log(date('Y-m-d H:i:s'));

        try {
            $this->processOverdueInvoices();
            $this->log("=== Processamento concluído com sucesso ===");
        } catch (Throwable $e) {
            $this->log("ERRO CRÍTICO: " . $e->getMessage());
            $this->log("Stack trace: " . $e->getTraceAsString());
        }
    }

    /**
     * Processa faturas que venceram e têm saldo devedor
     */
    private function processOverdueInvoices()
    {
        $this->log("--- Processando faturas vencidas ---");

        $today = new DateTime();
        $currentDay = (int)$today->format('d');
        $currentMonth = (int)$today->format('n');
        $currentYear = (int)$today->format('Y');

        $this->log("Data atual: {$today->format('d/m/Y')} (dia {$currentDay})");

        // Busca todos os cartões ativos
        $cards = $this->getAllCards();
        $this->log("Cartões encontrados: " . count($cards));

        if (empty($cards)) {
            $this->log("[AVISO] Nenhum cartão encontrado no sistema");
            return;
        }

        $processedCount = 0;
        $skippedCount = 0;
        $errorCount = 0;

        foreach ($cards as $card) {
            try {
                $processed = $this->checkCardInvoice($card, $currentDay, $currentMonth, $currentYear);
                
                if ($processed) {
                    $processedCount++;
                } else {
                    $skippedCount++;
                }
            } catch (Exception $e) {
                $errorCount++;
                $this->log("  ❌ ERRO ao processar cartão '{$card['name']}': " . $e->getMessage());
            }
        }

        $this->log("\n=== RESUMO ===");
        $this->log("✅ Faturas processadas: {$processedCount}");
        $this->log("⏭️  Faturas ignoradas: {$skippedCount}");
        $this->log("❌ Erros: {$errorCount}");
    }

    /**
     * Verifica se a fatura de um cartão venceu hoje
     */
    private function checkCardInvoice($card, $currentDay, $currentMonth, $currentYear)
    {
        $dueDay = (int)$card['due_day'];
        $cardName = $card['name'];
        $cardId = $card['id'];

        $this->log("\n📇 Cartão: {$cardName} (ID: {$cardId})");
        $this->log("   Dia de vencimento: {$dueDay}");

        // Verifica se HOJE é o dia SEGUINTE ao vencimento
        $isDayAfterDue = false;
        $invoiceMonth = $currentMonth;
        $invoiceYear = $currentYear;

        // Caso 1: Vencimento era ontem (dia comum)
        if ($currentDay === ($dueDay + 1)) {
            $isDayAfterDue = true;
            $this->log("   ✓ Hoje é o dia seguinte ao vencimento ({$currentDay} = {$dueDay} + 1)");
        }
        // Caso 2: Vencimento era dia 31 e hoje é dia 1 do próximo mês
        elseif ($dueDay === 31 && $currentDay === 1) {
            $isDayAfterDue = true;
            $invoiceMonth = $currentMonth - 1;
            if ($invoiceMonth < 1) {
                $invoiceMonth = 12;
                $invoiceYear--;
            }
            $this->log("   ✓ Vencimento era dia 31 e hoje é dia 1 do mês seguinte");
        }
        // Caso 3: Mês tem menos de 31 dias e vencimento era no último dia
        elseif ($currentDay === 1 && $dueDay >= 28) {
            $lastMonth = $currentMonth - 1;
            $lastYear = $currentYear;
            if ($lastMonth < 1) {
                $lastMonth = 12;
                $lastYear--;
            }
            
            $lastDayOfLastMonth = (int)date('t', mktime(0, 0, 0, $lastMonth, 1, $lastYear));
            
            if ($dueDay >= $lastDayOfLastMonth) {
                $isDayAfterDue = true;
                $invoiceMonth = $lastMonth;
                $invoiceYear = $lastYear;
                $this->log("   ✓ Vencimento ajustado para último dia do mês ({$lastDayOfLastMonth})");
            }
        }

        if (!$isDayAfterDue) {
            $this->log("   ⏭️  Hoje NÃO é dia de processar este cartão (atual: {$currentDay}, vencimento: {$dueDay})");
            return false;
        }

        // Busca a fatura do mês que venceu
        $invoice = $this->invoiceModel->findInvoice($cardId, $invoiceMonth, $invoiceYear);

        if (!$invoice) {
            $this->log("   ℹ️  Nenhuma fatura registrada para {$invoiceMonth}/{$invoiceYear}");
            
            // Verifica se há transações não pagas no período
            $invoiceTotal = $this->transactionModel->getCardInvoiceTotal($cardId, $invoiceMonth, $invoiceYear);
            
            if ($invoiceTotal > 0) {
                $this->log("   ⚠️  ATENÇÃO: Existem R$ {$invoiceTotal} em transações não pagas!");
                $this->log("   💡 A fatura não foi registrada no sistema (usuário não tentou pagar)");
                
                // Cria registro da fatura vencida
                $this->createOverdueInvoiceRecord($cardId, $invoiceMonth, $invoiceYear, $invoiceTotal, $card);
                return true;
            } else {
                $this->log("   ✓ Sem transações pendentes");
                return false;
            }
        }

        // Calcula saldo devedor
        $totalAmount = $invoice['total_amount'];
        $paidAmount = $invoice['paid_amount'];
        $remainingAmount = $totalAmount - $paidAmount;

        $this->log("   Fatura {$invoiceMonth}/{$invoiceYear}:");
        $this->log("   - Total: R$ " . number_format($totalAmount, 2, ',', '.'));
        $this->log("   - Pago: R$ " . number_format($paidAmount, 2, ',', '.'));
        $this->log("   - Saldo: R$ " . number_format($remainingAmount, 2, ',', '.'));

        // Se não tem saldo devedor, ignora
        if ($remainingAmount <= 0) {
            $this->log("   ✅ Fatura totalmente paga!");
            return false;
        }

        // Se já foi processada (saldo já movido), ignora
        if ($invoice['overdue_moved_to_next']) {
            $this->log("   ⏭️  Saldo devedor já foi movido anteriormente");
            return false;
        }

        // PROCESSA: Move saldo devedor para próxima fatura
        $this->log("   🔄 Movendo saldo devedor de R$ {$remainingAmount} para próxima fatura...");

        $debtTransactionId = $this->invoiceModel->moveOverdueToNextInvoice(
            $cardId,
            $invoiceMonth,
            $invoiceYear,
            $remainingAmount,
            $invoice['paid_by']
        );

        $this->log("   ✅ Saldo movido com sucesso!");
        $this->log("   📝 Transação de débito criada: #{$debtTransactionId}");

        return true;
    }

    /**
     * Cria registro de fatura vencida quando não existe (usuário não pagou nada)
     */
    private function createOverdueInvoiceRecord($cardId, $month, $year, $totalAmount, $card)
    {
        $this->log("   📝 Criando registro de fatura vencida não paga...");

        // Cria registro da fatura com saldo total devedor
        $data = [
            'credit_card_id' => $cardId,
            'month' => $month,
            'year' => $year,
            'total_amount' => $totalAmount,
            'paid_amount' => 0,
            'remaining_amount' => $totalAmount,
            'paid_at' => null,
            'paid_by' => null,
            'is_overdue' => 0,
            'overdue_moved_to_next' => 0
        ];

        // Busca o primeiro admin/owner do grupo para registrar como responsável
        $userId = $this->getGroupOwner($card['group_id']);

        $invoiceId = $this->invoiceModel->create($data);
        $this->log("   ✓ Fatura #{$invoiceId} criada");

        // Move imediatamente para próxima fatura
        $debtTransactionId = $this->invoiceModel->moveOverdueToNextInvoice(
            $cardId,
            $month,
            $year,
            $totalAmount,
            $userId
        );

        $this->log("   ✅ Saldo total movido para próxima fatura (transação #{$debtTransactionId})");
    }

    /**
     * Busca o dono/admin do grupo
     */
    private function getGroupOwner($groupId)
    {
        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->prepare("
                SELECT user_id 
                FROM user_groups 
                WHERE group_id = ? 
                AND role = 'owner' 
                LIMIT 1
            ");
            $stmt->execute([$groupId]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $result ? $result['user_id'] : 1; // Fallback para user ID 1
        } catch (Exception $e) {
            $this->log("   ⚠️  Erro ao buscar owner do grupo: " . $e->getMessage());
            return 1;
        }
    }

    /**
     * Busca todos os cartões cadastrados
     */
    private function getAllCards()
    {
        try {
            $db = Database::getInstance()->getConnection();
            $stmt = $db->query("
                SELECT c.*, g.name as group_name 
                FROM credit_cards c
                INNER JOIN `groups` g ON c.group_id = g.id
                ORDER BY c.id
            ");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $this->log("ERRO ao buscar cartões: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Logger simples
     */
    private function log($message)
    {
        echo "[INVOICE-CRON] {$message}\n";
    }
}

// ===============================
// EXECUÇÃO
// ===============================
if (php_sapi_name() === 'cli') {
    $service = new InvoiceProcessingService();
    $service->processAll();
} else {
    die("Este script deve ser executado via CLI apenas.\n");
}