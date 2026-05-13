<?php
// diagnostico_email.php
// Rode na raiz do projeto: php diagnostico_email.php
// DELETE este arquivo depois de usar — contém credenciais em texto plano no output

define('BASE_PATH', dirname(__FILE__));
require_once BASE_PATH . '/vendor/phpmailer/src/PHPMailer.php';
require_once BASE_PATH . '/vendor/phpmailer/src/SMTP.php';
require_once BASE_PATH . '/vendor/phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// ── 1. Gera um PDF mínimo de teste ───────────────────────────────────────────
require_once BASE_PATH . '/vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('defaultFont', 'Helvetica');
$dompdf = new Dompdf($options);
$dompdf->loadHtml("<html><body><h1>Teste de PDF</h1><p>Diagnóstico Amigo do Bolso - " . date('d/m/Y H:i:s') . "</p></body></html>");
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

$pdfPath = BASE_PATH . "/temp/diagnostico_test.pdf";
if (!is_dir(BASE_PATH . "/temp")) mkdir(BASE_PATH . "/temp", 0777, true);
file_put_contents($pdfPath, $dompdf->output());

$fileSizeBytes = filesize($pdfPath);
$fileSizeKB    = round($fileSizeBytes / 1024, 1);
echo "── PDF gerado: {$fileSizeKB} KB ({$fileSizeBytes} bytes)" . PHP_EOL;

// ── 2. Tenta enviar com SMTPDebug = 2 (mostra conversa SMTP completa) ─────────
echo PHP_EOL . "── Iniciando envio com SMTP debug completo..." . PHP_EOL;
echo str_repeat('-', 60) . PHP_EOL;

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->SMTPDebug  = 2;                          // <-- mostra TODA a conversa com o servidor
    $mail->Debugoutput = 'echo';
    $mail->Host       = 'sh00168.hostgator.com.br';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'contato@amigodobolso.jmadev.com.br';
    $mail->Password   = 'W0r2tf5pz@';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;
    $mail->CharSet    = 'UTF-8';
    $mail->Hostname   = 'amigodobolso.jmadev.com.br';

    $mail->setFrom('contato@amigodobolso.jmadev.com.br', 'Amigo do Bolso');
    $mail->addAddress('jrlevita09@hotmail.com', 'Diagnóstico Teste');  // só BCC de teste
    $mail->addAttachment($pdfPath, 'Relatorio_Teste.pdf');

    $mail->isHTML(true);
    $mail->Subject = '[DIAGNÓSTICO] Teste de envio com PDF - ' . date('d/m/Y H:i:s');
    $mail->Body    = "<p>Email de diagnóstico com PDF anexado ({$fileSizeKB} KB). Se chegou aqui, o problema era outro.</p>";
    $mail->AltBody = "Email de diagnóstico com PDF ({$fileSizeKB} KB).";

    $mail->send();
    echo str_repeat('-', 60) . PHP_EOL;
    echo "✅ send() retornou TRUE — verifique a caixa jrlevita09@hotmail.com" . PHP_EOL;

} catch (Exception $e) {
    echo str_repeat('-', 60) . PHP_EOL;
    echo "❌ ERRO: " . $mail->ErrorInfo . PHP_EOL;
}

// ── 3. Limpeza ───────────────────────────────────────────────────────────────
if (file_exists($pdfPath)) unlink($pdfPath);
echo PHP_EOL . "── PDF temporário removido." . PHP_EOL;
echo "── DELETAR este script do servidor após usar!" . PHP_EOL;