<?php
define('BASE_PATH', dirname(__DIR__, 2));
require_once BASE_PATH . '/app/config/Database.php';
require_once BASE_PATH . '/app/core/Controller.php';
require_once BASE_PATH . '/app/core/Model.php';

// Carregamento de Models para evitar erros de classe não encontrada
require_once BASE_PATH . '/app/models/CreditCardModel.php';
require_once BASE_PATH . '/app/models/CreditCardInvoiceModel.php';
require_once BASE_PATH . '/app/models/TransactionModel.php';
require_once BASE_PATH . '/app/models/CategoryModel.php';
require_once BASE_PATH . '/app/models/NotificationModel.php';

// Helpers, Controllers e Vendor
require_once BASE_PATH . '/app/helpers/EmailHelper.php';
require_once BASE_PATH . '/vendor/autoload.php';
require_once BASE_PATH . '/app/controllers/RelatoriosController.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Configuração de tempo limite para scripts longos
set_time_limit(0);

echo "--- INÍCIO DO CRON: " . date('Y-m-d H:i:s') . " ---" . PHP_EOL;

$relatorios = new RelatoriosController();
$db = Database::getInstance()->getConnection();
$transactionModel = new TransactionModel();

$mesAnteriorNum = date('m', strtotime('-1 month'));
$anoAnterior = date('Y', strtotime('-1 month'));
$nomeMes = $relatorios->getMonthName($mesAnteriorNum);

// Garante que a pasta temporária para os PDFs existe
$tempDir = BASE_PATH . "/temp";
if (!is_dir($tempDir)) {
    mkdir($tempDir, 0777, true);
}

// Busca todos os usuários ativos
$usuarios = $db->query("SELECT id, name, email FROM users ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
echo "LOG: Processando " . count($usuarios) . " usuários." . PHP_EOL;

foreach ($usuarios as $user) {
    try {
        echo "---------------------------------------" . PHP_EOL;
        $userName = !empty($user['name']) ? $user['name'] : 'Amigo';
        echo "LOG: Usuário: $userName ({$user['email']})" . PHP_EOL;

        // Verifica se o usuário pertence a algum grupo
        $stmt = $db->prepare("SELECT group_id FROM group_members WHERE user_id = ? LIMIT 1");
        $stmt->execute([$user['id']]);
        $membership = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$membership) {
            echo "LOG: Ignorado - Usuário sem grupo." . PHP_EOL;
            continue;
        }

        // Busca o balanço do mês anterior
        $balance = $transactionModel->getMonthlyBalance($membership['group_id'], $mesAnteriorNum, $anoAnterior);
        $temDados = ($balance['total_income'] > 0 || $balance['total_expense'] > 0);

        // --- CENÁRIO A: USUÁRIO SEM MOVIMENTAÇÕES (E-MAIL EDUCATIVO) ---
        if (!$temDados) {
            echo "LOG: Sem dados. Enviando convite educativo motivacional..." . PHP_EOL;
            
            $assunto = "Que tal organizar suas finanças em " . $relatorios->getMonthName(date('m')) . "? 🚀";
            $msgEdu = "Notamos que em <strong>$nomeMes</strong> você não registrou movimentações no Amigo do Bolso. <br><br>
                       Manter seus gastos atualizados é o segredo para realizar seus sonhos financeiros! Que tal tirar 5 minutinhos hoje para registrar suas contas deste mês? <br><br>
                       Assim, no próximo mês, poderei gerar um <strong>relatório exclusivo com IA</strong> para você.";
            
            EmailHelper::send($user['email'], $assunto, $msgEdu, $userName);
            continue;
        }

        // --- CENÁRIO B: USUÁRIO COM DADOS (RELATÓRIO COM IA + PDF) ---
        echo "LOG: Consultando Gemini AI... ";
        $analiseRaw = null;
        $maxTentativas = 3;

        for ($i = 1; $i <= $maxTentativas; $i++) {
            try {
                $reflectionAI = new ReflectionMethod('RelatoriosController', 'callOpenAI');
                $reflectionAI->setAccessible(true);
                
                $prompt = "Gere um resumo financeiro para $userName referente ao mês de $nomeMes. 
                           Seja direto e dê dicas de economia. Use apenas HTML básico (p, br, strong).";
                
                $analiseRaw = $reflectionAI->invoke($relatorios, $prompt);
                
                if ($analiseRaw) {
                    echo "Sucesso!" . PHP_EOL;
                    break;
                }
            } catch (Exception $e) {
                if (strpos($e->getMessage(), '429') !== false) {
                    echo "Cota atingida (429). Dormindo 45s antes da tentativa $i..." . PHP_EOL;
                    sleep(45);
                } else {
                    throw $e;
                }
            }
        }

        if (!$analiseRaw) {
            echo "ERRO: IA não respondeu após as tentativas. Pulando..." . PHP_EOL;
            continue;
        }

        // Geração do PDF
        echo "LOG: Gerando documento PDF... ";
        $textoIA = trim(explode("PUSH_NOTIFICATION:", $analiseRaw)[0]);
        
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('defaultFont', 'Helvetica');
        $dompdf = new Dompdf($options);
        
        $htmlPDF = "
        <html>
        <head>
            <meta charset='UTF-8'>
            <style>
                body { font-family: sans-serif; color: #333; line-height: 1.5; padding: 20px; }
                .header { color: #4f46e5; border-bottom: 2px solid #4f46e5; padding-bottom: 10px; }
                .footer { margin-top: 50px; font-size: 10px; color: #999; text-align: center; }
            </style>
        </head>
        <body>
            <h1 class='header'>Diagnóstico Financeiro - $nomeMes/$anoAnterior</h1>
            <div>" . nl2br($textoIA) . "</div>
            <div class='footer'>Gerado por Inteligência Artificial - Amigo do Bolso</div>
        </body>
        </html>";

        $dompdf->loadHtml($htmlPDF);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $pdfPath = $tempDir . "/relat_financeiro_" . $user['id'] . ".pdf";
        file_put_contents($pdfPath, $dompdf->output());

        // Envio do E-mail com o PDF anexado
        echo "LOG: Despachando e-mail... ";
        $enviado = EmailHelper::sendMonthlyAIReportPDF($user['email'], $userName, $nomeMes, $anoAnterior, $pdfPath);

        if ($enviado) {
            echo "✅ RELATÓRIO ENVIADO!" . PHP_EOL;
        } else {
            echo "❌ ERRO NO ENVIO." . PHP_EOL;
        }

        // Limpeza: Deleta o PDF após enviar
        if (file_exists($pdfPath)) unlink($pdfPath);

        // Pausa de segurança de 12 segundos para não estourar a cota de 15 RPM do Gemini Free
        echo "LOG: Pausa de 12s para próxima requisição..." . PHP_EOL;
        sleep(12);

    } catch (Exception $e) {
        echo "ERRO NO PROCESSAMENTO DO USUÁRIO {$user['id']}: " . $e->getMessage() . PHP_EOL;
    }
}

echo "--- FIM DO PROCESSO: " . date('Y-m-d H:i:s') . " ---" . PHP_EOL;