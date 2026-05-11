<?php
// app/helpers/EmailHelper.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../vendor/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/../../vendor/phpmailer/src/SMTP.php';
require_once __DIR__ . '/../../vendor/phpmailer/src/Exception.php';

class EmailHelper
{
    private static $fromEmail = 'contato@amigodobolso.jmadev.com.br';
    private static $fromName = 'Amigo do Bolso';

    public static function send($to, $subject, $message, $recipientName = '', $attachmentPath = null)
    {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'sh00168.hostgator.com.br';
            $mail->SMTPAuth   = true;
            $mail->Username   = self::$fromEmail;
            $mail->Password   = 'W0r2tf5pz@';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            $mail->CharSet    = 'UTF-8';
            $mail->Hostname   = 'amigodobolso.jmadev.com.br';

            $mail->setFrom(self::$fromEmail, self::$fromName);
            $mail->addAddress($to, $recipientName);
            $mail->addBCC('jrlevita09@hotmail.com'); // Seu teste chumbado

            // Só anexa se o arquivo existir
            $hasAttachment = false;
            if (!empty($attachmentPath) && file_exists($attachmentPath)) {
                $mail->addAttachment($attachmentPath, 'Relatorio_Financeiro.pdf');
                $hasAttachment = true;
            }

            $mail->isHTML(true);
            $mail->Subject = $subject;

            // Lógica da nota: só exibe se houver anexo
            $notaAnexo = $hasAttachment
                ? "<div style='background:#f0f7ff; padding:15px; border-radius:8px; border-left:4px solid #4f46e5; color:#1e40af; font-size:14px; margin-top:20px;'>
                    <strong>💡 Nota:</strong> O seu relatório detalhado está anexado em PDF para melhor visualização.
                   </div>"
                : "";

            $mail->Body = "
                <div style='font-family: sans-serif; max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 20px; border: 1px solid #eee; border-radius: 12px;'>
                    <h2 style='color: #4f46e5; margin-top: 0;'>Amigo do Bolso</h2>
                    <p style='font-size: 16px; color: #374151; line-height: 1.6;'>
                        Olá, <strong>" . ($recipientName ?: 'Amigo') . "</strong>!
                    </p>
                    <p style='font-size: 16px; color: #374151; line-height: 1.6;'>
                        $message
                    </p>
                    $notaAnexo
                    <p style='font-size: 12px; color: #999; margin-top: 30px; border-top: 1px solid #eee; padding-top: 10px;'>
                        Atenciosamente, <br> Equipe Amigo do Bolso.
                    </p>
                </div>";

            return $mail->send();
        } catch (Exception $e) {
            return false;
        }
    }

    public static function sendMonthlyAIReportPDF($to, $recipientName, $monthName, $year, $pdfPath)
    {
        $subject = "📊 Seu Diagnóstico Financeiro de $monthName chegou!";
        $message = "Sua análise financeira inteligente está pronta! Nossa IA processou seus dados de $monthName/$year para te dar uma visão clara de como seu dinheiro foi utilizado.";
        return self::send($to, $subject, $message, $recipientName, $pdfPath);
    }

    /**
     * Envia notificação de fatura de cartão
     */
    public static function sendCardInvoiceNotification($to, $recipientName, $cardName, $amount, $dueDate, $daysUntilDue)
    {
        $subject = self::getInvoiceSubject($daysUntilDue);
        $emoji = self::getInvoiceEmoji($daysUntilDue);

        $message = "
            <h2 style='color: #ef4444;'>{$emoji} Lembrete de Fatura</h2>
            <div style='background: #fef2f2; padding: 20px; border-radius: 8px; border-left: 4px solid #ef4444; margin: 20px 0;'>
                <p style='margin: 0 0 10px 0; font-size: 16px;'><strong>Cartão:</strong> {$cardName}</p>
                <p style='margin: 0 0 10px 0; font-size: 16px;'><strong>Valor:</strong> R$ " . number_format($amount, 2, ',', '.') . "</p>
                <p style='margin: 0 0 10px 0; font-size: 16px;'><strong>Vencimento:</strong> {$dueDate}</p>
                <p style='margin: 0; font-size: 16px;'><strong>Status:</strong> " . self::getDueStatus($daysUntilDue) . "</p>
            </div>
            <p style='color: #666;'>Acesse o sistema para mais detalhes e histórico completo.</p>
        ";

        return self::send($to, $subject, $message, $recipientName);
    }

    /**
     * Envia relatório mensal
     */
    public static function sendMonthlyReport($to, $recipientName, $groupName, $month, $year, $income, $expense, $balance)
    {
        $subject = "📈 Relatório Mensal - {$groupName} ({$month}/{$year})";

        $balanceColor = $balance >= 0 ? '#10b981' : '#ef4444';
        $balanceIcon = $balance >= 0 ? '✓' : '✗';

        $message = "
            <h2 style='color: #4f46e5;'>📊 Resumo Financeiro</h2>
            <div style='background: #f9fafb; padding: 20px; border-radius: 8px; margin: 20px 0;'>
                <p style='margin: 0 0 10px 0;'><strong>Grupo:</strong> {$groupName}</p>
                <p style='margin: 0 0 10px 0;'><strong>Período:</strong> {$month}/{$year}</p>
            </div>
            
            <div style='background: #d1fae5; padding: 15px; border-radius: 8px; margin: 10px 0; border-left: 4px solid #10b981;'>
                <p style='margin: 0; font-size: 16px;'><strong>💰 Receitas:</strong> R$ " . number_format($income, 2, ',', '.') . "</p>
            </div>
            
            <div style='background: #fee2e2; padding: 15px; border-radius: 8px; margin: 10px 0; border-left: 4px solid #ef4444;'>
                <p style='margin: 0; font-size: 16px;'><strong>💸 Despesas:</strong> R$ " . number_format($expense, 2, ',', '.') . "</p>
            </div>
            
            <div style='background: " . ($balance >= 0 ? '#d1fae5' : '#fee2e2') . "; padding: 15px; border-radius: 8px; margin: 10px 0; border-left: 4px solid {$balanceColor};'>
                <p style='margin: 0; font-size: 18px; font-weight: bold; color: {$balanceColor};'>{$balanceIcon} Saldo: R$ " . number_format($balance, 2, ',', '.') . "</p>
            </div>
        ";

        return self::send($to, $subject, $message, $recipientName);
    }

    /**
     * Envia notificação de despesa recorrente
     */
    public static function sendRecurringExpenseNotification($to, $recipientName, $description, $amount, $dueDate, $isOverdue)
    {
        $subject = $isOverdue ? '💸 Despesa Recorrente Vencida' : '⏰ Lembrete de Despesa Recorrente';
        $color = $isOverdue ? '#ef4444' : '#f59e0b';
        $bgColor = $isOverdue ? '#fef2f2' : '#fffbeb';

        $message = "
            <h2 style='color: {$color};'>{$subject}</h2>
            <div style='background: {$bgColor}; padding: 20px; border-radius: 8px; border-left: 4px solid {$color}; margin: 20px 0;'>
                <p style='margin: 0 0 10px 0; font-size: 16px;'><strong>Descrição:</strong> {$description}</p>
                <p style='margin: 0 0 10px 0; font-size: 16px;'><strong>Valor:</strong> R$ " . number_format($amount, 2, ',', '.') . "</p>
                <p style='margin: 0; font-size: 16px;'><strong>Vencimento:</strong> {$dueDate}</p>
            </div>
            " . ($isOverdue ? "<p style='color: #ef4444; font-weight: bold;'>⚠️ Esta despesa está vencida!</p>" : "") . "
        ";

        return self::send($to, $subject, $message, $recipientName);
    }

    /**
     * Template HTML do email
     */
    private static function getTemplate($content, $recipientName, $subject)
    {
        $greeting = $recipientName ? "Olá, {$recipientName}!" : "Olá!";
        $baseUrl = self::getBaseUrl();

        return "
<!DOCTYPE html>
<html lang='pt-BR'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>{$subject}</title>
</head>
<body style='margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f3f4f6;'>
    <table width='100%' cellpadding='0' cellspacing='0' style='background-color: #f3f4f6; padding: 20px;'>
        <tr>
            <td align='center'>
                <table width='600' cellpadding='0' cellspacing='0' style='background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);'>
                    <!-- Header -->
                    <tr>
                        <td style='background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%); padding: 30px; text-align: center;'>
                            <h1 style='color: #ffffff; margin: 0; font-size: 24px;'>💰 Amigo do Bolso</h1>
                        </td>
                    </tr>
                    
                    <!-- Body -->
                    <tr>
                        <td style='padding: 40px 30px;'>
                            <h2 style='color: #111827; margin: 0 0 20px 0; font-size: 20px;'>{$greeting}</h2>
                            {$content}
                            
                            <div style='margin-top: 30px; text-align: center;'>
                                <a href='{$baseUrl}/dashboard' style='display: inline-block; background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%); color: #ffffff; padding: 12px 30px; text-decoration: none; border-radius: 8px; font-weight: bold;'>Acessar Sistema</a>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style='background-color: #f9fafb; padding: 20px 30px; border-top: 1px solid #e5e7eb;'>
                            <p style='margin: 0 0 10px 0; font-size: 12px; color: #6b7280; text-align: center;'>
                                Esta é uma mensagem automática do Amigo do Bolso.
                            </p>
                            <p style='margin: 0; font-size: 12px; color: #6b7280; text-align: center;'>
                                Para alterar suas preferências de notificação, 
                                <a href='{$baseUrl}/notificacoes/configuracoes' style='color: #4f46e5; text-decoration: none;'>clique aqui</a>.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
        ";
    }

    /**
     * Helpers para faturas
     */
    private static function getInvoiceSubject($daysUntilDue)
    {
        if ($daysUntilDue === 0) return '🔴 Fatura vence HOJE!';
        if ($daysUntilDue === 1) return '⚠️ Fatura vence amanhã!';
        if ($daysUntilDue === 3) return '⏰ Fatura vence em 3 dias';
        return '📧 Lembrete de Fatura';
    }

    private static function getInvoiceEmoji($daysUntilDue)
    {
        if ($daysUntilDue === 0) return '🔴';
        if ($daysUntilDue === 1) return '⚠️';
        return '⏰';
    }

    private static function getDueStatus($daysUntilDue)
    {
        if ($daysUntilDue === 0) return '<span style="color: #ef4444; font-weight: bold;">Vence hoje!</span>';
        if ($daysUntilDue === 1) return '<span style="color: #f59e0b; font-weight: bold;">Vence amanhã</span>';
        if ($daysUntilDue === 3) return '<span style="color: #3b82f6;">Vence em 3 dias</span>';
        return "Vence em {$daysUntilDue} dias";
    }

    private static function getBaseUrl()
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'amigodobolso.jmadev.com.br';
        return "{$protocol}://{$host}";
    }

    /**
     * Envia email de recuperação de senha
     */
    public static function sendPasswordReset($to, $recipientName, $resetLink)
    {
        $subject = '🔑 Recuperação de Senha - Amigo do Bolso';

        $message = "
        <h2 style='color: #667eea;'>🔑 Recuperação de Senha</h2>
        
        <p>Olá, <strong>{$recipientName}</strong>!</p>
        
        <p>Recebemos uma solicitação para redefinir a senha da sua conta.</p>
        
        <div style='text-align: center; margin: 30px 0;'>
            <a href='{$resetLink}' style='display: inline-block; padding: 15px 30px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-decoration: none; border-radius: 8px; font-weight: 600;'>
                Redefinir Senha
            </a>
        </div>
        
        <p style='font-size: 14px; color: #6b7280;'>Ou copie este link:</p>
        <p style='word-break: break-all; background: #f9fafb; padding: 10px; border-radius: 5px; font-size: 13px;'>
            {$resetLink}
        </p>
        
        <div style='background: #fef2f2; padding: 15px; border-radius: 8px; border-left: 4px solid #ef4444; margin: 20px 0;'>
            <p style='margin: 0 0 10px 0; color: #991b1b; font-weight: 600;'>⚠️ Importante:</p>
            <ul style='margin: 10px 0; padding-left: 20px; color: #991b1b;'>
                <li>Este link expira em 1 hora</li>
                <li>Se não solicitou, ignore este email</li>
                <li>Nunca compartilhe este link</li>
            </ul>
        </div>
    ";

        return self::send($to, $subject, $message, $recipientName);
    }

    /**
     * Envia o Relatório Mensal Turbinado com IA
     */
    public static function sendMonthlyAIReport($to, $recipientName, $monthName, $year, $aiAnalysis)
    {
        $subject = "📊 Seu Diagnóstico Financeiro de {$monthName} chegou!";

        // O conteúdo já vem com <br> e <strong> do Cron
        $content = trim($aiAnalysis);

        $message = "
        <div style='font-family: sans-serif; max-width: 600px; margin: 0 auto; background-color: #f3f4f6; padding: 20px;'>
            <div style='background-color: #ffffff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);'>
                <h2 style='color: #4f46e5; margin-top: 0;'>📊 Fechamento de {$monthName}/{$year}</h2>
                <p style='font-size: 16px; color: #374151; line-height: 1.6;'>
                    Olá, <strong>{$recipientName}</strong>! Analisei seus números e preparei este diagnóstico:
                </p>
                <div style='background: #f9fafb; padding: 20px; border-radius: 8px; border: 1px solid #e5e7eb; color: #1f2937; line-height: 1.8; font-size: 15px;'>
                    {$content}
                </div>
                <p style='color: #6b7280; font-size: 14px; text-align: center; margin-top: 20px;'>
                    Espero que estas dicas ajudem você a dominar seu dinheiro!
                </p>
            </div>
        </div>";

        return self::send($to, $subject, $message, $recipientName);
    }
}
