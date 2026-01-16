<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config/config.php';
require_once 'app/helpers/EmailHelper.php';

echo "<h2>🧪 Teste de Envio de Email (mail() nativo)</h2>";
echo "<hr>";

// ⚠️ COLOQUE SEU EMAIL AQUI
$testEmail = 'jrlevita09@gmail.com';

echo "<h3>📧 Teste 1: Email Simples</h3>";

$result1 = EmailHelper::send(
    $testEmail,
    'Teste de Email - ' . date('H:i:s'),
    '<p>Este é um <strong>teste simples</strong> de email!</p><p>Se você recebeu isso, o sistema está funcionando! ✅</p>',
    'João Teste'
);

echo "Resultado: " . ($result1 ? '✅ TRUE (enviado)' : '❌ FALSE (falhou)') . "<br>";
echo "Para: {$testEmail}<br>";

echo "<hr>";

echo "<h3>💳 Teste 2: Notificação de Fatura</h3>";

$result2 = EmailHelper::sendCardInvoiceNotification(
    $testEmail,
    'Maria Silva',
    'Nubank',
    1234.56,
    '20/01/2026',
    3
);

echo "Resultado: " . ($result2 ? '✅ TRUE (enviado)' : '❌ FALSE (falhou)') . "<br>";

echo "<hr>";

echo "<h3>📊 Teste 3: Relatório Mensal</h3>";

$result3 = EmailHelper::sendMonthlyReport(
    $testEmail,
    'Carlos Santos',
    'Família Silva',
    '12',
    '2024',
    8500.00,
    6234.50,
    2265.50
);

echo "Resultado: " . ($result3 ? '✅ TRUE (enviado)' : '❌ FALSE (falhou)') . "<br>";

echo "<hr>";

echo "<h3>💸 Teste 4: Despesa Recorrente</h3>";

$result4 = EmailHelper::sendRecurringExpenseNotification(
    $testEmail,
    'Ana Costa',
    'Aluguel do Apartamento',
    1500.00,
    '05/01/2026',
    true // vencida
);

echo "Resultado: " . ($result4 ? '✅ TRUE (enviado)' : '❌ FALSE (falhou)') . "<br>";

echo "<hr>";

echo "<h3>📝 Verificar:</h3>";
echo "<ul>";
echo "<li>✅ Verifique sua caixa de entrada: <strong>{$testEmail}</strong></li>";
echo "<li>⚠️ Verifique a pasta de SPAM/Lixo Eletrônico</li>";
echo "<li>⏰ Aguarde 1-5 minutos (pode haver delay no servidor)</li>";
echo "</ul>";

echo "<hr>";

// Mostrar últimos logs
echo "<h3>📋 Últimos Logs (se configurado):</h3>";
$logFile = ini_get('error_log');

if ($logFile && file_exists($logFile)) {
    $logs = file($logFile);
    $emailLogs = array_filter($logs, function($line) {
        return stripos($line, '[EMAIL]') !== false;
    });
    
    if (!empty($emailLogs)) {
        $recent = array_slice($emailLogs, -10);
        echo "<pre style='background: #1e1e1e; color: #60a5fa; padding: 15px; border-radius: 8px; max-height: 300px; overflow: auto;'>";
        foreach ($recent as $log) {
            echo htmlspecialchars($log);
        }
        echo "</pre>";
    } else {
        echo "<p>Nenhum log de email encontrado ainda.</p>";
    }
} else {
    echo "<p>Arquivo de log não configurado.</p>";
}