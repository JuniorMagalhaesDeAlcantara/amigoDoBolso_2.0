<?php
define('BASE_PATH', dirname(__DIR__, 2));
require_once BASE_PATH . '/app/config/Database.php';
require_once BASE_PATH . '/app/core/Controller.php';
require_once BASE_PATH . '/app/core/Model.php';

require_once BASE_PATH . '/app/models/CreditCardModel.php';
require_once BASE_PATH . '/app/models/CreditCardInvoiceModel.php';
require_once BASE_PATH . '/app/models/TransactionModel.php';
require_once BASE_PATH . '/app/models/CategoryModel.php';
require_once BASE_PATH . '/app/models/NotificationModel.php';

require_once BASE_PATH . '/app/helpers/EmailHelper.php';
require_once BASE_PATH . '/vendor/autoload.php';
require_once BASE_PATH . '/app/controllers/RelatoriosController.php';

use Dompdf\Dompdf;
use Dompdf\Options;

set_time_limit(0);

echo "--- INÍCIO DO CRON: " . date('Y-m-d H:i:s') . " ---" . PHP_EOL;

$relatorios = new RelatoriosController();
$db = Database::getInstance()->getConnection();
$transactionModel = new TransactionModel();

$mesAnteriorNum = date('m', strtotime('-1 month'));
$anoAnterior    = date('Y', strtotime('-1 month'));
$nomeMes        = $relatorios->getMonthName($mesAnteriorNum);

$tempDir = BASE_PATH . "/temp";
if (!is_dir($tempDir)) mkdir($tempDir, 0777, true);

$pdfDir = BASE_PATH . "/public/relatorios";
$pdfWeb = "https://amigodobolso.jmadev.com.br/relatorios";
if (!is_dir($pdfDir)) mkdir($pdfDir, 0755, true);

// Limpeza automática de PDFs com mais de 7 dias
foreach (glob($pdfDir . "/relat_*.pdf") as $arquivoAntigo) {
    if (filemtime($arquivoAntigo) < strtotime('-7 days')) {
        unlink($arquivoAntigo);
        echo "LOG: PDF antigo removido: " . basename($arquivoAntigo) . PHP_EOL;
    }
}

$usuarios = $db->query("SELECT id, name, email FROM users ORDER BY id ASC")->fetchAll(PDO::FETCH_ASSOC);
echo "LOG: Processando " . count($usuarios) . " usuários." . PHP_EOL;

foreach ($usuarios as $user) {
    try {
        echo "---------------------------------------" . PHP_EOL;
        $userName = !empty($user['name']) ? $user['name'] : 'Amigo';
        echo "LOG: Usuário: $userName ({$user['email']})" . PHP_EOL;

        $stmt = $db->prepare("SELECT group_id FROM group_members WHERE user_id = ? LIMIT 1");
        $stmt->execute([$user['id']]);
        $membership = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$membership) {
            echo "LOG: Ignorado - Usuário sem grupo." . PHP_EOL;
            continue;
        }

        $balance = $transactionModel->getMonthlyBalance($membership['group_id'], $mesAnteriorNum, $anoAnterior);
        $temDados = ($balance['total_income'] > 0 || $balance['total_expense'] > 0);

        // --- CENÁRIO A: SEM MOVIMENTAÇÕES ---
        if (!$temDados) {
            echo "LOG: Sem dados. Enviando convite educativo..." . PHP_EOL;
            $assunto = "Que tal organizar suas financas em " . $relatorios->getMonthName(date('m')) . "?";
            $msgEdu  = "Notamos que em <strong>$nomeMes</strong> você não registrou movimentações no Amigo do Bolso.<br><br>
                        Manter seus gastos atualizados é o segredo para realizar seus sonhos financeiros!
                        Que tal tirar 5 minutinhos hoje para registrar suas contas deste mês?<br><br>
                        Assim, no próximo mês, posso gerar um <strong>relatório exclusivo com Inteligência Artificial</strong> para você. 🚀";
            EmailHelper::send($user['email'], $assunto, $msgEdu, $userName);
            continue;
        }

        // --- CENÁRIO B: COM DADOS — IA + PDF ---
        echo "LOG: Consultando IA... ";
        $analiseRaw  = null;
        $maxTentativas = 3;

        for ($i = 1; $i <= $maxTentativas; $i++) {
            try {
                $reflectionAI = new ReflectionMethod('RelatoriosController', 'callOpenAI');
                $reflectionAI->setAccessible(true);

                // Prompt estruturado para o Amigo do Bolso retornar seções bem definidas
                $totalReceita  = 'R$ ' . number_format($balance['total_income'],  2, ',', '.');
                $totalDespesa  = 'R$ ' . number_format($balance['total_expense'], 2, ',', '.');
                $saldoLiquido  = 'R$ ' . number_format($balance['total_income'] - $balance['total_expense'], 2, ',', '.');

                $prompt = "Você é o Amigo do Bolso, um assistente financeiro amigável e direto ao ponto.
Gere um diagnóstico financeiro para {$userName} referente ao mês de {$nomeMes}/{$anoAnterior}.

DADOS DO MÊS:
- Receitas totais: {$totalReceita}
- Despesas totais: {$totalDespesa}
- Saldo do período: {$saldoLiquido}

REGRAS DE FORMATAÇÃO — siga exatamente:
1. Apresente-se como 'Amigo do Bolso' no primeiro parágrafo (tag <p>).
2. Use exatamente estas seções em ordem, cada uma com sua tag <h3> e conteúdo em <p> ou <ul><li>:
   - <h3>1. ANÁLISE GERAL</h3>
   - <h3>2. ALERTAS</h3>
   - <h3>3. DICAS DE ECONOMIA</h3>
   - <h3>4. METAS PARA O PRÓXIMO MÊS</h3>
   - <h3>5. PONTO POSITIVO</h3>
3. Use apenas tags HTML simples: p, br, strong, ul, li, h3.
4. Seja direto, empático e motivador. Use valores reais fornecidos acima.
5. No final, adicione exatamente esta linha separada por '|||':
   PUSH_NOTIFICATION: [mensagem curta de push de até 100 caracteres]";

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

        // Separa o texto da IA da notificação push
        $partes  = explode("PUSH_NOTIFICATION:", $analiseRaw);
        $textoIA = trim($partes[0]);

        // ── Geração do PDF com visual do app ─────────────────────────────────
        echo "LOG: Gerando PDF com visual do app... ";

        $receitaFmt = number_format($balance['total_income'],  2, ',', '.');
        $despesaFmt = number_format($balance['total_expense'], 2, ',', '.');
        $saldoVal   = $balance['total_income'] - $balance['total_expense'];
        $saldoFmt   = number_format(abs($saldoVal), 2, ',', '.');
        $saldoSinal = $saldoVal >= 0 ? '+' : '-';
        $saldoCor   = $saldoVal >= 0 ? '#10b981' : '#ef4444';
        $saldoLabel = $saldoVal >= 0 ? 'positivo' : 'negativo';

        // Processa o HTML da IA para estilizar as seções
        $textoEstilizado = processarSecoesPDF($textoIA);

        $htmlPDF = "
<!DOCTYPE html>
<html lang='pt-BR'>
<head>
  <meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
      background: #f0f0f8;
      color: #1f2937;
      font-size: 13px;
      line-height: 1.6;
    }

    /* ── HEADER GRADIENTE ────────────────────────── */
    .header {
      background: #4f46e5;;
      padding: 36px 36px 40px 50px;
      color: #ffffff;
    }
    .header-top {
      display: flex;
      align-items: center;
      gap: 14px;
      margin-bottom: 20px;
    }
    .header-icon {
      width: 52px; height: 52px;
      background: rgba(255,255,255,0.20);
      border-radius: 14px;
      display: flex; align-items: center; justify-content: center;
      font-size: 26px; line-height: 1;
    }
    .header-title {
        font-size: 24px;
        font-weight: 700;
        letter-spacing: -0.3px;
        padding-left: 2px;
        }

        .header-sub {
        font-size: 13px;
        color: rgba(255,255,255,0.75);
        margin-top: 4px;
        padding-left: 2px;
        }

        .header-badge {
        display: inline-block;
        background: rgba(255,255,255,0.20);
        border: 1px solid rgba(255,255,255,0.35);
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        padding: 6px 18px;
        border-radius: 20px;
        letter-spacing: 0.4px;
        margin-top: 10px;
        }
    /* ── CARDS DE RESUMO ─────────────────────────── */
    .summary-row {
      display: table; width: 100%;
      background: #fff;
      padding: 20px 24px;
      border-bottom: 1px solid #e5e7eb;
    }
    .summary-cell {
      display: table-cell;
      width: 33.33%;
      padding: 0 8px;
      vertical-align: top;
    }
    .summary-cell:first-child { padding-left: 0; }
    .summary-cell:last-child  { padding-right: 0; }
    .summary-label {
      font-size: 10px; font-weight: 700; letter-spacing: 1px;
      text-transform: uppercase; color: #6b7280; margin-bottom: 4px;
    }
    .summary-value {
      font-size: 20px; font-weight: 700; color: #1f2937;
    }
    .summary-value.green { color: #10b981; }
    .summary-value.red   { color: #ef4444; }

    /* ── CORPO ───────────────────────────────────── */
    .body { background: #ffffff; padding: 24px 28px; }

    /* ── CARD DE ANÁLISE IA ──────────────────────── */
    .ai-header {
      display: flex; align-items: center; gap: 10px;
      margin-bottom: 16px;
    }
    .ai-badge {
      background: linear-gradient(135deg, #6c3fc5, #4f46e5);
      color: #fff; font-size: 11px; font-weight: 700;
      padding: 3px 10px; border-radius: 20px; letter-spacing: 0.5px;
    }
    .ai-title {
      font-size: 15px; font-weight: 700; color: #1f2937;
    }

    /* intro do Amigo do Bolso */
    .intro-box {
      background: #f5f3ff;
      border-left: 4px solid #7c3aed;
      border-radius: 0 8px 8px 0;
      padding: 16px 18px;
      font-size: 13px; color: #374151; line-height: 1.7;
      margin-bottom: 18px;
    }

    /* seções numeradas */
    .section-card {
      border: 1px solid #e5e7eb;
      border-radius: 10px;
      overflow: hidden;
      margin-bottom: 14px;
    }
    .section-header {
      padding: 10px 16px;
      font-size: 12px; font-weight: 700;
      letter-spacing: 0.5px; text-transform: uppercase;
      border-bottom: 1px solid #e5e7eb;
    }
    .section-header.analise  { background:#eff6ff; color:#1d4ed8; border-color:#dbeafe; }
    .section-header.alertas  { background:#fff7ed; color:#c2410c; border-color:#fed7aa; }
    .section-header.economia { background:#f0fdf4; color:#166534; border-color:#bbf7d0; }
    .section-header.metas    { background:#faf5ff; color:#7e22ce; border-color:#e9d5ff; }
    .section-header.positivo { background:#f0fdf4; color:#065f46; border-color:#a7f3d0; }

    .section-body {
      padding: 14px 16px;
      font-size: 13px; color: #374151; line-height: 1.7;
    }
    .section-body ul  { padding-left: 18px; margin: 0; }
    .section-body li  { margin-bottom: 5px; }
    .section-body p   { margin: 0 0 8px; }
    .section-body strong { color: #1f2937; }

    /* ── FOOTER ──────────────────────────────────── */
    .footer {
      background: linear-gradient(135deg, #6c3fc5, #4f46e5);
      padding: 18px 28px;
      text-align: center;
      color: rgba(255,255,255,0.80);
      font-size: 11px;
    }
    .footer strong { color: #fff; }

    /* página */
    @page { margin: 0; size: A4 portrait; }
  </style>
</head>
<body>

  <!-- HEADER -->
  <div class='header'>
    <div class='header-top'>
      <div>
        <div class='header-title'>Relatório Financeiro</div>
        <div class='header-sub'>Análise inteligente dos seus gastos</div>
      </div>
    </div>
    <span class='header-badge'>$nomeMes / $anoAnterior</span>
  </div>

  <!-- CARDS RESUMO -->
  <div class='summary-row'>
    <div class='summary-cell'>
      <div class='summary-label'>Receitas</div>
      <div class='summary-value green'>R$ $receitaFmt</div>
    </div>
    <div class='summary-cell'>
      <div class='summary-label'>Despesas</div>
      <div class='summary-value red'>R$ $despesaFmt</div>
    </div>
    <div class='summary-cell'>
      <div class='summary-label'>Saldo</div>
      <div class='summary-value' style='color:{$saldoCor};'>
        $saldoSinal R$ $saldoFmt
        <div style='font-size:11px;font-weight:400;color:{$saldoCor};margin-top:2px;'>
           $saldoLabel
        </div>
      </div>
    </div>
  </div>

  <!-- CORPO -->
  <div class='body'>

    <!-- cabeçalho análise IA -->
    <div class='ai-header'>
      <span class='ai-title'>Análise Inteligente</span>
      <span class='ai-badge'>IA</span>
    </div>

    <!-- conteúdo estilizado -->
    $textoEstilizado

  </div>

  <!-- FOOTER -->
  <div class='footer'>
    <strong>Amigo do Bolso</strong> &mdash;
    Gerado por Inteligência Artificial &bull;
    Simplicidade &bull; Organização &bull; Evolução<br>
    <span style='font-size:10px;'>© " . date('Y') . " amigodobolso.jmadev.com.br</span>
  </div>

</body>
</html>";

        // ── Renderiza o PDF ───────────────────────────────────────────────────
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', false);
        $options->set('defaultFont', 'Helvetica');
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($htmlPDF);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $token   = bin2hex(random_bytes(16));
        $pdfFile = "relat_{$user['id']}_{$anoAnterior}_{$mesAnteriorNum}_{$token}.pdf";
        $pdfPath = $pdfDir . "/" . $pdfFile;
        $pdfUrl  = $pdfWeb  . "/" . $pdfFile;

        file_put_contents($pdfPath, $dompdf->output());
        $pdfSize = filesize($pdfPath);
        echo "PDF gerado: {$pdfSize} bytes | {$pdfFile}" . PHP_EOL;

        // ── Envia o e-mail ────────────────────────────────────────────────────
        echo "LOG: Despachando e-mail... ";
        $enviado = EmailHelper::sendMonthlyAIReportLink(
            $user['email'],
            $userName,
            $nomeMes,
            $anoAnterior,
            $pdfUrl
        );

        echo $enviado
            ? "✅ ENVIADO! Link: $pdfUrl" . PHP_EOL
            : "❌ ERRO NO ENVIO." . PHP_EOL;

        echo "LOG: Pausa de 12s..." . PHP_EOL;
        sleep(12);
    } catch (Exception $e) {
        echo "ERRO NO USUÁRIO {$user['id']}: " . $e->getMessage() . PHP_EOL;
    }
}

echo "--- FIM DO PROCESSO: " . date('Y-m-d H:i:s') . " ---" . PHP_EOL;


// ── Função auxiliar: estiliza as seções vindas da IA para o PDF ──────────────
function processarSecoesPDF(string $html): string
{
    // Mapa de seções → classe CSS
    $secoes = [
        'ANÁLISE GERAL'           => 'analise',
        'ANALISE GERAL'           => 'analise',
        '1. ANÁLISE GERAL'        => 'analise',
        'ALERTAS'                 => 'alertas',
        '2. ALERTAS'              => 'alertas',
        'DICAS DE ECONOMIA'       => 'economia',
        'ECONOMIA'                => 'economia',
        '3. DICAS DE ECONOMIA'    => 'economia',
        '3. ECONOMIA'             => 'economia',
        'METAS PARA O PRÓXIMO MÊS' => 'metas',
        'METAS'                   => 'metas',
        '4. METAS PARA O PRÓXIMO MÊS' => 'metas',
        '4. METAS'                => 'metas',
        'PONTO POSITIVO'          => 'positivo',
        '5. PONTO POSITIVO'       => 'positivo',
    ];

    // Separa o parágrafo de introdução (antes do primeiro <h3>)
    $intro    = '';
    $restante = $html;

    if (preg_match('/^(.*?)(<h3\s*>)/is', $html, $m)) {
        $intro    = trim($m[1]);
        $restante = substr($html, strlen($m[1]));
    }

    $output = '';

    // Bloco de introdução
    if ($intro) {
        $output .= "<div class='intro-box'>{$intro}</div>";
    }

    // Divide em seções por <h3>
    $blocos = preg_split('/(<h3\s*>.*?<\/h3\s*>)/is', $restante, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

    $tituloAtual  = null;
    $classeAtual  = 'analise';

    foreach ($blocos as $bloco) {
        if (preg_match('/<h3[^>]*>(.*?)<\/h3>/is', $bloco, $m)) {
            // É um título
            $tituloAtual = strtoupper(trim(strip_tags($m[1])));
            $classeAtual = 'analise'; // padrão
            foreach ($secoes as $chave => $classe) {
                if (str_contains($tituloAtual, strtoupper($chave)) || str_contains(strtoupper($chave), $tituloAtual)) {
                    $classeAtual = $classe;
                    break;
                }
            }
            // não imprime o título ainda — aguarda o conteúdo no próximo bloco
        } else {
            $conteudo = trim($bloco);
            if ($conteudo && $tituloAtual !== null) {
                $labelDisplay = $tituloAtual;
                $output .= "
<div class='section-card'>
  <div class='section-header {$classeAtual}'>{$labelDisplay}</div>
  <div class='section-body'>{$conteudo}</div>
</div>";
            }
        }
    }

    return $output ?: "<div class='intro-box'>{$html}</div>";
}
