<?php
// app/helpers/EmailHelper.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// ✅ CORRIGIDO: Caminho relativo correto
require_once __DIR__ . '/../../vendor/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/../../vendor/phpmailer/src/SMTP.php';
require_once __DIR__ . '/../../vendor/phpmailer/src/Exception.php';

class EmailHelper
{
    private static $fromEmail = 'contato@amigodobolso.jmadev.com.br';
    private static $fromName = 'Amigo do Bolso';
    private static $replyTo = 'contato@amigodobolso.jmadev.com.br';

    /**
     * Envia email HTML usando PHPMailer
     */
    public static function send($to, $subject, $message, $recipientName = '')
    {
        $mail = new PHPMailer(true);
        try {
            // ✅ Config SMTP
            $mail->isSMTP();
            $mail->Host       = 'amigodobolso.jmadev.com.br';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'contato@amigodobolso.jmadev.com.br';
            $mail->Password   = 'W0r2tf5pz@';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // ✅ Debug (remover em produção)
            $mail->SMTPDebug  = 0; // 0 = off, 2 = debug completo

            // ✅ Charset UTF-8
            $mail->CharSet = 'UTF-8';

            $mail->setFrom(self::$fromEmail, self::$fromName);
            $mail->addReplyTo(self::$replyTo, 'Suporte');

            $mail->addAddress($to, $recipientName ?: $to);

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = self::getTemplate($message, $recipientName, $subject);
            $mail->AltBody = strip_tags($message); // ✅ Versão texto

            $mail->send();
            error_log("[EMAIL] ✓ Email enviado com sucesso para {$to}");
            return true;
        } catch (Exception $e) {
            error_log("[EMAIL] ✗ Falha ao enviar email para {$to} | Erro: {$mail->ErrorInfo}");
            return false;
        }
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
}
