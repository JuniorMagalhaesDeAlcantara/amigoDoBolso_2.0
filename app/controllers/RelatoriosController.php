<?php
// app/Controllers/RelatoriosController.php

class RelatoriosController extends Controller
{
    private $transactionModel;
    private $categoryModel;

    public function __construct()
    {
        $this->requireLogin();
        $this->transactionModel = new TransactionModel();
        $this->categoryModel = new CategoryModel();
    }

    public function gerar()  // era generate()
    {
        $groupId = $_SESSION['current_group_id'];
        $month = $_GET['month'] ?? date('m');
        $year = $_GET['year'] ?? date('Y');

        $balance = $this->transactionModel->getMonthlyBalance($groupId, $month, $year);
        $spendingByCategory = $this->transactionModel->getSpendingByCategory($groupId, $month, $year);
        $transactions = $this->transactionModel->getByMonthAndStatus($groupId, $month, $year, 'all');

        $reportData = [
            'period' => [
                'month' => $month,
                'year' => $year,
                'monthName' => $this->getMonthName($month)
            ],
            'summary' => [
                'total_income' => $balance['total_income'] ?? 0,
                'total_expense' => $balance['total_expense'] ?? 0,
                'balance' => ($balance['total_income'] ?? 0) - ($balance['total_expense'] ?? 0)
            ],
            'categories' => $spendingByCategory,
            'transactions_count' => count($transactions)
        ];

        $this->view('reports/ai-analysis', [
            'title' => 'Relatório com Análise IA',
            'reportData' => $reportData,
            'month' => $month,
            'year' => $year
        ]);
    }

    public function analyze()
    {
        header('Content-Type: application/json');

        $groupId = $_SESSION['current_group_id'];
        $month = $_POST['month'] ?? date('m');
        $year = $_POST['year'] ?? date('Y');

        try {
            $balance = $this->transactionModel->getMonthlyBalance($groupId, $month, $year);
            $spendingByCategory = $this->transactionModel->getSpendingByCategory($groupId, $month, $year);

            $context = $this->prepareAIContext($balance, $spendingByCategory, $month, $year);

            // Log da requisição
            error_log("[RelatoriosController] Chamando OpenAI - Período: " . $context['period']);
            error_log("[RelatoriosController] Resumo: " . json_encode($context['summary']));

            $analysis = $this->callOpenAI($context);

            error_log("[RelatoriosController] OpenAI respondeu com sucesso. Tamanho: " . strlen($analysis));

            echo json_encode(['success' => true, 'analysis' => $analysis]);
        } catch (Exception $e) {
            error_log("[RelatoriosController] ERRO: " . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => 'Erro ao gerar análise: ' . $e->getMessage()
            ]);
        }

        exit;
    }

    private function prepareAIContext($balance, $categories, $month, $year)
    {
        $totalIncome = $balance['total_income'] ?? 0;
        $totalExpense = $balance['total_expense'] ?? 0;
        $netBalance = $totalIncome - $totalExpense;

        $categoryBreakdown = [];
        $totalCategorySpending = 0;

        foreach ($categories as $cat) {
            $categoryBreakdown[] = [
                'name' => $cat['category_name'],
                'amount' => (float)$cat['total'],
                'percentage' => 0
            ];
            $totalCategorySpending += (float)$cat['total'];
        }

        foreach ($categoryBreakdown as &$cat) {
            $cat['percentage'] = $totalCategorySpending > 0
                ? round(($cat['amount'] / $totalCategorySpending) * 100, 2)
                : 0;
        }

        return [
            'period' => $this->getMonthName($month) . '/' . $year,
            'summary' => [
                'receitas' => $totalIncome,
                'despesas' => $totalExpense,
                'saldo' => $netBalance
            ],
            'categorias' => $categoryBreakdown
        ];
    }

    private function callOpenAI($context)
    {
        $config = include __DIR__ . '/../config/openai.php';
        $apiKey = trim($config['api_key']);
        $modelName = trim($config['model']); // vem do config, não hardcoded

        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$modelName}:generateContent?key={$apiKey}";

        $maskedKey = substr($apiKey, 0, 8) . "..." . substr($apiKey, -4);
        error_log("[Gemini] Modelo: {$modelName} | Key: {$maskedKey}");

        $prompt = $this->buildPrompt($context);

        $data = [
            "system_instruction" => [
                "parts" => [
                    ["text" => "Você é um consultor financeiro especializado em análise de gastos pessoais e familiares. Forneça análises detalhadas, práticas e motivadoras em português do Brasil. Sempre estruture sua resposta com seções claras usando markdown."]
                ]
            ],
            "contents" => [
                [
                    "role" => "user",
                    "parts" => [
                        ["text" => $prompt]
                    ]
                ]
            ],
            "generationConfig" => [
                "temperature" => (float)($config['temperature'] ?? 0.7),
                "maxOutputTokens" => 2048, // aumentado para resposta completa
                "topP" => 0.9,
                "topK" => 40
            ]
        ];

        $jsonPayload = json_encode($data, JSON_UNESCAPED_UNICODE);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonPayload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_TIMEOUT, (int)($config['timeout'] ?? 45));

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            error_log("[Gemini] Erro cURL: " . $curlError);
            throw new Exception("Erro de conexão: " . $curlError);
        }

        error_log("[Gemini] HTTP: {$httpCode}");

        $result = json_decode($response, true);

        if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
            $text = $result['candidates'][0]['content']['parts'][0]['text'];
            $finishReason = $result['candidates'][0]['finishReason'] ?? 'UNKNOWN';
            $outputTokens = $result['usageMetadata']['candidatesTokenCount'] ?? 0;
            error_log("[Gemini] Sucesso | Tokens output: {$outputTokens} | Motivo fim: {$finishReason}");
            return $text;
        }

        error_log("[Gemini] Erro resposta: " . $response);
        throw new Exception("Erro na API (HTTP {$httpCode}): " . ($result['error']['message'] ?? 'Resposta inesperada'));
    }

    private function buildPrompt($context)
    {
        $categoriesText = '';
        foreach ($context['categorias'] as $cat) {
            $categoriesText .= "- {$cat['name']}: R$ " . number_format($cat['amount'], 2, ',', '.') . " ({$cat['percentage']}%)\n";
        }

        $saldoStatus = $context['summary']['saldo'] >= 0 ? 'positivo' : 'negativo';

        return <<<PROMPT
Analise o relatório financeiro de {$context['period']}.

DADOS:
- Receitas: R$ {$context['summary']['receitas']}
- Despesas: R$ {$context['summary']['despesas']}
- Saldo: R$ {$context['summary']['saldo']} ({$saldoStatus})

CATEGORIAS:
{$categoriesText}

Responda em 5 seções curtas e objetivas, usando os números reais:

1. ANÁLISE GERAL: saúde financeira do mês (3-4 linhas)
2. ALERTAS: 3 alertas sobre gastos elevados, com categoria e %
3. ECONOMIA: 4 dicas práticas com valores sugeridos de redução
4. METAS: 3 metas mensuráveis para o próximo mês
5. PONTO POSITIVO: 1 destaque motivador

Tom: encorajador e honesto. Seja direto. Se apresente como Amigo do Bolso.
PROMPT;
    }

    private function getMonthName($month)
    {
        $months = [
            1 => 'Janeiro',
            2 => 'Fevereiro',
            3 => 'Março',
            4 => 'Abril',
            5 => 'Maio',
            6 => 'Junho',
            7 => 'Julho',
            8 => 'Agosto',
            9 => 'Setembro',
            10 => 'Outubro',
            11 => 'Novembro',
            12 => 'Dezembro'
        ];
        return $months[(int)$month] ?? '';
    }
}
