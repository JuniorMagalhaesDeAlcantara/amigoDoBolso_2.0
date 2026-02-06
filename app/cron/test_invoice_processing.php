<?php

/**
 * Script de Teste - Processamento de Faturas
 * Simula diferentes cenários de vencimento
 */

define('BASE_PATH', dirname(__DIR__, 2));
define('APP', BASE_PATH . '/app');

require_once BASE_PATH . '/app/config/Database.php';
require_once BASE_PATH . '/app/core/Model.php';
require_once BASE_PATH . '/app/models/CreditCardModel.php';
require_once BASE_PATH . '/app/models/CreditCardInvoiceModel.php';
require_once BASE_PATH . '/app/models/TransactionModel.php';

echo "===========================================\n";
echo "TESTE DE PROCESSAMENTO DE FATURAS\n";
echo "===========================================\n\n";

$invoiceModel = new CreditCardInvoiceModel();
$cardModel = new CreditCardModel();
$transactionModel = new TransactionModel();

// Busca todos os cartões
$db = Database::getInstance()->getConnection();
$stmt = $db->query("SELECT * FROM credit_cards ORDER BY id LIMIT 5");
$cards = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($cards)) {
    echo "❌ Nenhum cartão encontrado no sistema!\n";
    exit(1);
}

echo "📇 CARTÕES CADASTRADOS:\n";
echo str_repeat("-", 80) . "\n";

foreach ($cards as $card) {
    echo "\nID: {$card['id']}\n";
    echo "Nome: {$card['name']}\n";
    echo "Banco: {$card['bank']}\n";
    echo "Dia de vencimento: {$card['due_day']}\n";
    
    // Verifica fatura atual
    $month = date('n');
    $year = date('Y');
    
    $invoice = $invoiceModel->findInvoice($card['id'], $month, $year);
    
    if ($invoice) {
        echo "\n📄 FATURA ATUAL ({$month}/{$year}):\n";
        echo "   Total: R$ " . number_format($invoice['total_amount'], 2, ',', '.') . "\n";
        echo "   Pago: R$ " . number_format($invoice['paid_amount'], 2, ',', '.') . "\n";
        echo "   Saldo: R$ " . number_format($invoice['remaining_amount'], 2, ',', '.') . "\n";
        echo "   Status: " . ($invoice['overdue_moved_to_next'] ? "❌ Vencida (saldo movido)" : "✅ Ativa") . "\n";
    } else {
        // Verifica se há transações
        $total = $transactionModel->getCardInvoiceTotal($card['id'], $month, $year);
        
        if ($total > 0) {
            echo "\n⚠️  FATURA NÃO REGISTRADA ({$month}/{$year}):\n";
            echo "   Transações não pagas: R$ " . number_format($total, 2, ',', '.') . "\n";
            echo "   (Usuário ainda não tentou pagar)\n";
        } else {
            echo "\n✅ Sem fatura atual\n";
        }
    }
    
    // Verifica próximas faturas
    $nextMonth = $month + 1;
    $nextYear = $year;
    if ($nextMonth > 12) {
        $nextMonth = 1;
        $nextYear++;
    }
    
    $nextTotal = $transactionModel->getCardInvoiceTotal($card['id'], $nextMonth, $nextYear);
    if ($nextTotal > 0) {
        echo "\n📅 PRÓXIMA FATURA ({$nextMonth}/{$nextYear}): R$ " . number_format($nextTotal, 2, ',', '.') . "\n";
    }
    
    echo str_repeat("-", 80) . "\n";
}

// SIMULAÇÃO DE PROCESSAMENTO
echo "\n\n🧪 SIMULAÇÃO DE PROCESSAMENTO:\n";
echo str_repeat("=", 80) . "\n";

$today = new DateTime();
$currentDay = (int)$today->format('d');

echo "\nData atual: {$today->format('d/m/Y')} (dia {$currentDay})\n\n";

echo "CARTÕES QUE SERIAM PROCESSADOS HOJE:\n";
echo str_repeat("-", 80) . "\n";

$wouldProcess = 0;

foreach ($cards as $card) {
    $dueDay = (int)$card['due_day'];
    $shouldProcess = false;
    
    // Verifica se hoje é dia seguinte ao vencimento
    if ($currentDay === ($dueDay + 1)) {
        $shouldProcess = true;
        $reason = "Dia seguinte ao vencimento";
    } elseif ($dueDay === 31 && $currentDay === 1) {
        $shouldProcess = true;
        $reason = "Vencimento dia 31, hoje é dia 1";
    }
    
    if ($shouldProcess) {
        echo "\n✅ {$card['name']} (vencimento: dia {$dueDay})\n";
        echo "   Motivo: {$reason}\n";
        
        $month = date('n');
        $year = date('Y');
        
        $invoice = $invoiceModel->findInvoice($card['id'], $month, $year);
        
        if ($invoice && $invoice['remaining_amount'] > 0 && !$invoice['overdue_moved_to_next']) {
            echo "   🔄 SERIA PROCESSADO: Mover R$ " . number_format($invoice['remaining_amount'], 2, ',', '.') . " para próxima fatura\n";
            $wouldProcess++;
        } else {
            echo "   ⏭️  Não precisa processar (sem saldo devedor ou já processado)\n";
        }
    }
}

if ($wouldProcess === 0) {
    echo "\n❌ Nenhum cartão seria processado hoje.\n";
    echo "💡 O cron só processa cartões no dia seguinte ao vencimento.\n";
}

echo "\n" . str_repeat("=", 80) . "\n";
echo "\n✅ TESTE CONCLUÍDO!\n\n";

echo "PRÓXIMOS PASSOS:\n";
echo "1. Configure o crontab para rodar diariamente\n";
echo "2. Execute manualmente para testar: php cron/process_invoices.php\n";
echo "3. Monitore os logs em /var/log/invoice_cron.log\n\n";