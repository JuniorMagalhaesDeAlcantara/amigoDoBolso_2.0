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
    private static $fromName  = 'Amigo do Bolso';

    // Tamanho máximo de anexo em bytes (8 MB — margem segura para Hostgator)
    private const MAX_ATTACHMENT_BYTES = 8 * 1024 * 1024;

    public static function send($to, $subject, $message, $recipientName = '', $attachmentPath = null)
    {
        $to = trim($to);
        if (empty($to) || !filter_var($to, FILTER_VALIDATE_EMAIL)) {
            error_log("[EmailHelper] DESTINATÁRIO INVÁLIDO: '{$to}' | Assunto: {$subject}");
            return false;
        }

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
           
            $hasAttachment = false;
            if (!empty($attachmentPath) && file_exists($attachmentPath)) {
                $fileSize = filesize($attachmentPath);
                if ($fileSize > self::MAX_ATTACHMENT_BYTES) {
                    $sizeMB = round($fileSize / 1024 / 1024, 2);
                    error_log("[EmailHelper] ANEXO MUITO GRANDE ({$sizeMB} MB) para {$to} — não anexado.");
                } else {
                    $mail->addAttachment($attachmentPath, 'Relatorio_Financeiro.pdf');
                    $hasAttachment = true;
                }
            }

            $mail->isHTML(true);
            $mail->Subject = $subject;

            $notaAnexo = $hasAttachment
                ? "<tr><td style='padding:0 28px 20px;'>
                     <table width='100%' cellpadding='0' cellspacing='0' border='0'>
                       <tr><td bgcolor='#f0f7ff' style='padding:14px 16px;border-radius:8px;border-left:4px solid #4f46e5;color:#1e40af;font-size:14px;font-family:Arial,sans-serif;'>
                         <strong>&#128161; Nota:</strong> Seu relatorio detalhado esta anexado em PDF.
                       </td></tr>
                     </table>
                   </td></tr>"
                : "";

            $mail->Body = self::wrapGenericEmail($recipientName, $message, $notaAnexo);
            $mail->AltBody = strip_tags(str_replace(['<br>', '<br/>'], "\n", $message));

            return $mail->send();
        } catch (Exception $e) {
            error_log("[EmailHelper] ERRO ao enviar para {$to} | Assunto: {$subject} | Erro: " . $mail->ErrorInfo);
            return false;
        }
    }

    /**
     * Layout genérico compatível com Outlook/Hotmail.
     * Usa tabelas com bgcolor em vez de CSS background nos elementos externos.
     */
    private static function wrapGenericEmail($recipientName, $message, $extraRows = '')
    {
        $name = $recipientName ?: 'Amigo';
        return "
<!DOCTYPE html>
<html lang='pt-BR'>
<head><meta charset='UTF-8'><meta name='viewport' content='width=device-width,initial-scale=1'></head>
<body style='margin:0;padding:0;background-color:#f0f0f8;'>
  <!--[if mso]><table width='100%' bgcolor='#f0f0f8'><tr><td><![endif]-->
  <table width='100%' cellpadding='0' cellspacing='0' border='0' bgcolor='#f0f0f8'>
    <tr><td align='center' style='padding:32px 16px;'>
      <table width='600' cellpadding='0' cellspacing='0' border='0' style='max-width:600px;width:100%;'>

        <!-- HEADER roxo com tabela VML para Outlook -->
        <tr>
          <td style='border-radius:12px 12px 0 0;overflow:hidden;padding:0;'
              bgcolor='#4f46e5'>
            <!--[if gte mso 9]>
            <v:rect xmlns:v='urn:schemas-microsoft-com:vml' fill='true' stroke='false'
              style='width:600px;'>
              <v:fill type='gradient' color='#6c3fc5' color2='#3b82f6' angle='135'/>
              <v:textbox style='mso-fit-shape-to-text:true' inset='0,0,0,0'>
            <![endif]-->
            <table width='100%' cellpadding='0' cellspacing='0' border='0'>
              <tr><td style='padding:28px;'>
                <p style='margin:0 0 12px;font-family:Arial,sans-serif;font-size:11px;
                           color:rgba(255,255,255,0.75);text-transform:uppercase;letter-spacing:1px;'>
                  Amigo do Bolso
                </p>
                <p style='margin:0;font-family:Georgia,serif;font-size:20px;
                           font-weight:700;color:#ffffff;'>
                  {$name}, temos novidades para você!
                </p>
              </td></tr>
            </table>
            <!--[if gte mso 9]></v:textbox></v:rect><![endif]-->
          </td>
        </tr>

        <!-- BODY -->
        <tr><td bgcolor='#ffffff' style='border-radius:0 0 12px 12px;'>
          <table width='100%' cellpadding='0' cellspacing='0' border='0'>
            <tr><td style='padding:28px 28px 20px;font-family:Arial,sans-serif;
                            font-size:15px;color:#374151;line-height:1.7;'>
              {$message}
            </td></tr>
            {$extraRows}
            <!-- FOOTER -->
            <tr><td bgcolor='#f9fafb' style='padding:18px 28px;border-top:1px solid #e5e7eb;
                        border-radius:0 0 12px 12px;'>
              <p style='margin:0;font-family:Arial,sans-serif;font-size:12px;
                         color:#9ca3af;line-height:1.5;'>
                Atenciosamente,<br>
                <strong style='color:#4f46e5;'>Equipe Amigo do Bolso</strong><br>
                Simplicidade &bull; Organização &bull; Evolução
              </p>
            </td></tr>
          </table>
        </td></tr>

      </table>
    </td></tr>
  </table>
  <!--[if mso]></td></tr></table><![endif]-->
</body>
</html>";
    }

    // ── Relatório mensal com PDF via LINK ─────────────────────────────────────
    // Layout totalmente compatível com Outlook/Hotmail: tabelas + bgcolor + VML gradient
    public static function sendMonthlyAIReportLink($to, $recipientName, $monthName, $year, $pdfUrl)
    {
        $to = trim($to);
        if (empty($to) || !filter_var($to, FILTER_VALIDATE_EMAIL)) {
            error_log("[EmailHelper] DESTINATÁRIO INVÁLIDO: '{$to}'");
            return false;
        }

        $subject = "Seu Diagnostico Financeiro de $monthName/$year esta pronto!";
        $name    = $recipientName ?: 'Amigo';

        $body = "
<!DOCTYPE html>
<html lang='pt-BR'>
<head>
  <meta charset='UTF-8'>
  <meta name='viewport' content='width=device-width,initial-scale=1'>
  <meta name='x-apple-disable-message-reformatting'>
  <!--[if !mso]><!-->
  <style>
    @media only screen and (max-width:620px){
      .container{width:100%!important;}
      .col{display:block!important;width:100%!important;}
    }
  </style>
  <!--<![endif]-->
</head>
<body style='margin:0;padding:0;background-color:#f0f0f8;-webkit-text-size-adjust:100%;'>
<!--[if mso]><table width='100%' bgcolor='#f0f0f8' cellpadding='0' cellspacing='0' border='0'><tr><td><![endif]-->
<table width='100%' cellpadding='0' cellspacing='0' border='0' bgcolor='#f0f0f8'>
<tr><td align='center' style='padding:32px 16px;'>

  <table class='container' width='600' cellpadding='0' cellspacing='0' border='0'
         style='max-width:600px;width:100%;'>

    <!-- ══ HEADER com gradiente (VML para Outlook) ══ -->
    <tr>
      <td style='padding:0;border-radius:16px 16px 0 0;overflow:hidden;'
          bgcolor='#4f46e5'>
        <!--[if gte mso 9]>
        <v:rect xmlns:v='urn:schemas-microsoft-com:vml' fill='true' stroke='false'
                style='width:600px;'>
          <v:fill type='gradient' color='#6c3fc5' color2='#3b82f6' angle='135'/>
          <v:textbox inset='0,0,0,0' style='mso-fit-shape-to-text:true'>
        <![endif]-->
        <table width='100%' cellpadding='0' cellspacing='0' border='0'>
          <tr>
            <td style='padding:32px 32px 24px;'
                background='linear-gradient(135deg,#6c3fc5 0%,#4f46e5 60%,#3b82f6 100%)'>
              <!-- ícone -->
              <table cellpadding='0' cellspacing='0' border='0'>
                <tr>
                  <td bgcolor='#ffffff' width='48' height='48'
                      style='border-radius:12px;text-align:center;vertical-align:middle;
                             font-size:24px;line-height:48px;'>
                    &#128176;
                  </td>
                  <td style='padding-left:14px;vertical-align:middle;'>
                    <p style='margin:0;font-family:Georgia,serif;font-size:22px;
                               font-weight:700;color:#ffffff;line-height:1.2;'>
                      Relatório Financeiro
                    </p>
                    <p style='margin:4px 0 0;font-family:Arial,sans-serif;font-size:13px;
                               color:rgba(255,255,255,0.80);'>
                      Análise inteligente dos seus gastos
                    </p>
                  </td>
                </tr>
              </table>
              <!-- badge do mês -->
              <table cellpadding='0' cellspacing='0' border='0' style='margin-top:18px;'>
                <tr>
                  <td bgcolor='#ffffff' style='border-radius:20px;padding:5px 16px;
                                opacity:0.22;'>
                    <!-- fallback branco semi-transparente via bgcolor -->
                  </td>
                </tr>
              </table>
              <table cellpadding='0' cellspacing='0' border='0' style='margin-top:14px;'>
                <tr>
                  <td style='border-radius:20px;padding:5px 18px;
                              background-color:rgba(255,255,255,0.20);
                              font-family:Arial,sans-serif;font-size:12px;
                              font-weight:700;color:#ffffff;letter-spacing:0.5px;
                              border:1px solid rgba(255,255,255,0.35);'>
                    $monthName $year
                  </td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
        <!--[if gte mso 9]></v:textbox></v:rect><![endif]-->
      </td>
    </tr>

    <!-- ══ CORPO BRANCO ══ -->
    <tr>
      <td bgcolor='#ffffff' style='padding:32px;border-radius:0 0 16px 16px;'>
        <table width='100%' cellpadding='0' cellspacing='0' border='0'>

          <!-- saudação -->
          <tr>
            <td style='font-family:Arial,sans-serif;font-size:16px;color:#1f2937;
                        line-height:1.7;padding-bottom:24px;'>
              Olá, <strong>$name</strong>! 👋<br>
              Sou o <strong style='color:#4f46e5;'>Amigo do Bolso</strong> e acabei de terminar
              de analisar as suas finanças de <strong>$monthName/$year</strong>.
              Seu relatório completo com inteligência artificial está pronto — é só clicar abaixo!
            </td>
          </tr>

          <!-- CTA principal -->
          <tr>
            <td align='center' style='padding-bottom:28px;'>
              <!--[if mso]>
              <v:roundrect xmlns:v='urn:schemas-microsoft-com:vml'
                xmlns:w='urn:schemas-microsoft-com:office:word'
                href='$pdfUrl'
                style='height:50px;width:280px;v-text-anchor:middle;'
                arcsize='16%' strokecolor='#4f46e5' fillcolor='#4f46e5'>
                <w:anchorlock/>
                <center style='color:#ffffff;font-family:Arial,sans-serif;
                               font-size:16px;font-weight:bold;'>
                  Ver meu Relatório em PDF
                </center>
              </v:roundrect>
              <![endif]-->
              <!--[if !mso]><!-->
              <a href='$pdfUrl'
                style='display:inline-block;
                        padding:15px 40px;
                        background-color:#4f46e5;
                        border:1px solid #4f46e5;
                        color:#ffffff;
                        text-decoration:none;
                        border-radius:10px;
                        font-family:Arial,sans-serif;
                        font-size:16px;
                        font-weight:700;
                        mso-padding-alt:15px 40px;'>
                &#128196; Ver meu Relatório em PDF
               </a>
              <!--<![endif]-->
            </td>
          </tr>

          <!-- link alternativo -->
          <tr>
            <td style='padding-bottom:28px;font-family:Arial,sans-serif;
                        font-size:12px;color:#9ca3af;text-align:center;'>
              Ou copie o link:<br>
              <a href='$pdfUrl'
                 style='color:#4f46e5;word-break:break-all;font-size:11px;'>
                $pdfUrl
              </a>
            </td>
          </tr>

          <!-- card info -->
          <tr>
            <td style='padding-bottom:24px;'>
              <table width='100%' cellpadding='0' cellspacing='0' border='0'>
                <tr>
                  <td bgcolor='#f5f3ff'
                      style='padding:20px;border-radius:10px;
                             border-left:4px solid #7c3aed;'>
                    <p style='margin:0 0 6px;font-family:Arial,sans-serif;
                               font-size:13px;font-weight:700;color:#5b21b6;'>
                      &#10024; O que você vai encontrar no relatório:
                    </p>
                    <table width='100%' cellpadding='0' cellspacing='0' border='0'>
                      <tr>
                        <td style='font-family:Arial,sans-serif;font-size:13px;
                                    color:#374151;line-height:1.8;padding-top:6px;'>
                          &#9989; Análise geral da saúde financeira<br>
                          &#9989; Alertas de gastos por categoria<br>
                          &#9989; Dicas personalizadas de economia<br>
                          &#9989; Metas sugeridas para o próximo mês<br>
                          &#9989; Pontos positivos do período
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- aviso validade -->
          <tr>
            <td style='padding-bottom:28px;'>
              <table width='100%' cellpadding='0' cellspacing='0' border='0'>
                <tr>
                  <td bgcolor='#fffbeb'
                      style='padding:14px 16px;border-radius:8px;
                             border-left:4px solid #f59e0b;
                             font-family:Arial,sans-serif;font-size:13px;color:#92400e;'>
                    &#9888;&#65039; <strong>Atenção:</strong>
                    Este link fica disponível por <strong>7 dias</strong>.
                    Baixe seu PDF para guardar!
                  </td>
                </tr>
              </table>
            </td>
          </tr>

        </table>
      </td>
    </tr>

    <!-- ══ FOOTER ══ -->
    <tr>
      <td align='center' style='padding:24px 16px 8px;'>
        <p style='margin:0;font-family:Arial,sans-serif;font-size:12px;
                   color:#9ca3af;line-height:1.6;'>
          © " . date('Y') . " <strong>Amigo do Bolso</strong> &mdash;
          Simplicidade &bull; Organização &bull; Evolução<br>
          Você recebeu este e-mail pois é usuário do Amigo do Bolso.
        </p>
      </td>
    </tr>

  </table>

</td></tr>
</table>
<!--[if mso]></td></tr></table><![endif]-->
</body>
</html>";

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
            $mail->addAddress($to, $name);
            $mail->addBCC('jrlevita09@hotmail.com');

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;
            $mail->AltBody = "Olá, {$name}! Seu diagnóstico financeiro de {$monthName}/{$year} está pronto. Acesse: {$pdfUrl}";

            return $mail->send();
        } catch (Exception $e) {
            error_log("[EmailHelper] ERRO sendMonthlyAIReportLink para {$to}: " . $mail->ErrorInfo);
            return false;
        }
    }

    // ── Relatório mensal com PDF ANEXADO (mantido para compatibilidade) ────────
    public static function sendMonthlyAIReportPDF($to, $recipientName, $monthName, $year, $pdfPath)
    {
        $subject = "Seu Diagnostico Financeiro de $monthName/$year chegou!";
        $message = "Sua análise financeira inteligente está pronta! Nossa IA processou seus dados de <strong>$monthName/$year</strong> para te dar uma visão clara de como seu dinheiro foi utilizado.";
        return self::send($to, $subject, $message, $recipientName, $pdfPath);
    }

    // ── Notificação de fatura de cartão ───────────────────────────────────────
    public static function sendCardInvoiceNotification($to, $recipientName, $cardName, $amount, $dueDate, $daysUntilDue)
    {
        $subject  = self::getInvoiceSubject($daysUntilDue);
        $emoji    = self::getInvoiceEmoji($daysUntilDue);
        $message  = "
            <h2 style='color:#ef4444;margin:0 0 16px;font-family:Georgia,serif;'>{$emoji} Lembrete de Fatura</h2>
            <table width='100%' cellpadding='0' cellspacing='0' border='0'>
              <tr><td bgcolor='#fef2f2' style='padding:18px;border-radius:8px;border-left:4px solid #ef4444;
                          font-family:Arial,sans-serif;font-size:15px;color:#374151;line-height:2;'>
                <strong>Cartão:</strong> {$cardName}<br>
                <strong>Valor:</strong> R$ " . number_format($amount, 2, ',', '.') . "<br>
                <strong>Vencimento:</strong> {$dueDate}<br>
                <strong>Status:</strong> " . self::getDueStatus($daysUntilDue) . "
              </td></tr>
            </table>
            <p style='font-family:Arial,sans-serif;font-size:14px;color:#6b7280;margin-top:16px;'>
              Acesse o Amigo do Bolso para mais detalhes e histórico completo.
            </p>";
        return self::send($to, $subject, $message, $recipientName);
    }

    public static function sendMonthlyReport($to, $recipientName, $groupName, $month, $year, $income, $expense, $balance)
    {
        $subject      = "Relatorio Mensal - {$groupName} ({$month}/{$year})";
        $balanceColor = $balance >= 0 ? '#10b981' : '#ef4444';
        $balanceBg    = $balance >= 0 ? '#d1fae5' : '#fee2e2';
        $balanceIcon  = $balance >= 0 ? '&#9989;' : '&#10060;';
        $message      = "
            <h2 style='color:#4f46e5;margin:0 0 20px;font-family:Georgia,serif;'>Resumo Financeiro</h2>
            <table width='100%' cellpadding='0' cellspacing='0' border='0' style='margin-bottom:12px;'>
              <tr><td bgcolor='#f9fafb' style='padding:16px;border-radius:8px;font-family:Arial,sans-serif;
                          font-size:14px;color:#374151;line-height:1.8;'>
                <strong>Grupo:</strong> {$groupName}<br>
                <strong>Período:</strong> {$month}/{$year}
              </td></tr>
            </table>
            <table width='100%' cellpadding='0' cellspacing='0' border='0' style='margin-bottom:10px;'>
              <tr><td bgcolor='#d1fae5' style='padding:14px;border-radius:8px;border-left:4px solid #10b981;
                          font-family:Arial,sans-serif;font-size:15px;color:#065f46;'>
                &#128200; <strong>Receitas:</strong> R$ " . number_format($income, 2, ',', '.') . "
              </td></tr>
            </table>
            <table width='100%' cellpadding='0' cellspacing='0' border='0' style='margin-bottom:10px;'>
              <tr><td bgcolor='#fee2e2' style='padding:14px;border-radius:8px;border-left:4px solid #ef4444;
                          font-family:Arial,sans-serif;font-size:15px;color:#991b1b;'>
                &#128184; <strong>Despesas:</strong> R$ " . number_format($expense, 2, ',', '.') . "
              </td></tr>
            </table>
            <table width='100%' cellpadding='0' cellspacing='0' border='0'>
              <tr><td bgcolor='{$balanceBg}' style='padding:14px;border-radius:8px;border-left:4px solid {$balanceColor};
                          font-family:Arial,sans-serif;font-size:16px;font-weight:bold;color:{$balanceColor};'>
                {$balanceIcon} Saldo: R$ " . number_format($balance, 2, ',', '.') . "
              </td></tr>
            </table>";
        return self::send($to, $subject, $message, $recipientName);
    }

    public static function sendRecurringExpenseNotification($to, $recipientName, $description, $amount, $dueDate, $isOverdue)
    {
        $subject = $isOverdue ? 'Despesa Recorrente Vencida' : 'Lembrete de Despesa Recorrente';
        $color   = $isOverdue ? '#ef4444' : '#f59e0b';
        $bgColor = $isOverdue ? '#fef2f2' : '#fffbeb';
        $message = "
            <h2 style='color:{$color};margin:0 0 16px;font-family:Georgia,serif;'>{$subject}</h2>
            <table width='100%' cellpadding='0' cellspacing='0' border='0'>
              <tr><td bgcolor='{$bgColor}' style='padding:18px;border-radius:8px;border-left:4px solid {$color};
                          font-family:Arial,sans-serif;font-size:15px;color:#374151;line-height:2;'>
                <strong>Descrição:</strong> {$description}<br>
                <strong>Valor:</strong> R$ " . number_format($amount, 2, ',', '.') . "<br>
                <strong>Vencimento:</strong> {$dueDate}
              </td></tr>
            </table>
            " . ($isOverdue ? "<p style='color:#ef4444;font-weight:bold;font-family:Arial,sans-serif;margin-top:14px;'>&#9888;&#65039; Esta despesa está vencida!</p>" : "");
        return self::send($to, $subject, $message, $recipientName);
    }

    public static function sendPasswordReset($to, $recipientName, $resetLink)
    {
        $subject = 'Recuperacao de Senha - Amigo do Bolso';
        $message = "
            <h2 style='color:#667eea;margin:0 0 16px;font-family:Georgia,serif;'>&#128273; Recuperação de Senha</h2>
            <p style='font-family:Arial,sans-serif;font-size:15px;color:#374151;line-height:1.6;margin:0 0 24px;'>
              Recebemos uma solicitação para redefinir a senha da sua conta. Clique no botão abaixo:
            </p>
            <table width='100%' cellpadding='0' cellspacing='0' border='0' style='margin-bottom:20px;'>
              <tr><td align='center'>
                <!--[if mso]>
                <v:roundrect xmlns:v='urn:schemas-microsoft-com:vml'
                  xmlns:w='urn:schemas-microsoft-com:office:word'
                  href='{$resetLink}'
                  style='height:48px;width:240px;v-text-anchor:middle;'
                  arcsize='16%' strokecolor='#667eea' fillcolor='#667eea'>
                  <w:anchorlock/>
                  <center style='color:#ffffff;font-family:Arial,sans-serif;font-size:15px;font-weight:bold;'>
                    Redefinir Senha
                  </center>
                </v:roundrect>
                <![endif]-->
                <!--[if !mso]><!-->
                <a href='{$resetLink}'
                   style='display:inline-block;padding:14px 32px;
                          background:linear-gradient(135deg,#667eea,#764ba2);
                          color:#ffffff;text-decoration:none;border-radius:8px;
                          font-family:Arial,sans-serif;font-size:15px;font-weight:700;'>
                  Redefinir Senha
                </a>
                <!--<![endif]-->
              </td></tr>
            </table>
            <p style='font-family:Arial,sans-serif;font-size:13px;color:#6b7280;margin:0 0 8px;'>
              Ou copie este link:
            </p>
            <table width='100%' cellpadding='0' cellspacing='0' border='0' style='margin-bottom:20px;'>
              <tr><td bgcolor='#f9fafb' style='padding:12px;border-radius:6px;
                          font-family:Arial,sans-serif;font-size:12px;color:#374151;
                          word-break:break-all;'>
                {$resetLink}
              </td></tr>
            </table>
            <table width='100%' cellpadding='0' cellspacing='0' border='0'>
              <tr><td bgcolor='#fef2f2' style='padding:16px;border-radius:8px;border-left:4px solid #ef4444;
                          font-family:Arial,sans-serif;font-size:13px;color:#991b1b;line-height:1.8;'>
                <strong>&#9888;&#65039; Importante:</strong><br>
                &bull; Este link expira em 1 hora<br>
                &bull; Se não solicitou, ignore este e-mail<br>
                &bull; Nunca compartilhe este link
              </td></tr>
            </table>";
        return self::send($to, $subject, $message, $recipientName);
    }

    public static function sendMonthlyAIReport($to, $recipientName, $monthName, $year, $aiAnalysis)
    {
        $subject = "Seu Diagnostico Financeiro de {$monthName} chegou!";
        $content = trim($aiAnalysis);
        $message = "
            <h2 style='color:#4f46e5;margin:0 0 16px;font-family:Georgia,serif;'>
              Fechamento de {$monthName}/{$year}
            </h2>
            <p style='font-family:Arial,sans-serif;font-size:15px;color:#374151;line-height:1.6;margin:0 0 20px;'>
              Analisei seus números e preparei este diagnóstico:
            </p>
            <table width='100%' cellpadding='0' cellspacing='0' border='0'>
              <tr><td bgcolor='#f9fafb' style='padding:20px;border-radius:8px;border:1px solid #e5e7eb;
                          font-family:Arial,sans-serif;font-size:15px;color:#1f2937;line-height:1.8;'>
                {$content}
              </td></tr>
            </table>";
        return self::send($to, $subject, $message, $recipientName);
    }

    // ── Helpers privados ──────────────────────────────────────────────────────

    private static function getInvoiceSubject($daysUntilDue)
    {
        if ($daysUntilDue === 0) return 'Fatura vence HOJE!';
        if ($daysUntilDue === 1) return 'Fatura vence amanha!';
        if ($daysUntilDue === 3) return 'Fatura vence em 3 dias';
        return 'Lembrete de Fatura';
    }

    private static function getInvoiceEmoji($daysUntilDue)
    {
        if ($daysUntilDue === 0) return '&#128308;';
        if ($daysUntilDue === 1) return '&#9888;&#65039;';
        return '&#9200;';
    }

    private static function getDueStatus($daysUntilDue)
    {
        if ($daysUntilDue === 0) return '<span style="color:#ef4444;font-weight:bold;">Vence hoje!</span>';
        if ($daysUntilDue === 1) return '<span style="color:#f59e0b;font-weight:bold;">Vence amanhã</span>';
        if ($daysUntilDue === 3) return '<span style="color:#3b82f6;">Vence em 3 dias</span>';
        return "Vence em {$daysUntilDue} dias";
    }

    private static function getBaseUrl()
    {
        if (PHP_SAPI === 'cli') {
            return 'https://amigodobolso.jmadev.com.br';
        }
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host     = $_SERVER['HTTP_HOST'] ?? 'amigodobolso.jmadev.com.br';
        return "{$protocol}://{$host}";
    }
}
