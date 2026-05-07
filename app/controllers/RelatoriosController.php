<?php
// app/Controllers/RelatoriosController.php

class RelatoriosController extends Controller
{
    private $transactionModel;
    private $categoryModel;
    private $notificationModel; // Para salvar insights de IA como notificações

    public function __construct()
    {
        if (php_sapi_name() !== 'cli') {
            $this->requireLogin();
        }

        $this->transactionModel = new TransactionModel();
        $this->categoryModel = new CategoryModel();
        $this->notificationModel = new NotificationModel();
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
        $userId = $_SESSION['user_id']; // Precisamos do ID do usuário para a notificação

        try {
            $balance = $this->transactionModel->getMonthlyBalance($groupId, $month, $year);
            $spendingByCategory = $this->transactionModel->getSpendingByCategory($groupId, $month, $year);

            $context = $this->prepareAIContext($balance, $spendingByCategory, $month, $year);

            // Log da requisição
            error_log("[RelatoriosController] Chamando IA - Período: " . $context['period']);

            $analysis = $this->callOpenAI($context);

            error_log("[RelatoriosController] IA respondeu com sucesso. Tamanho: " . strlen($analysis));

            // --- LÓGICA DE EXTRAÇÃO DE INSIGHT PARA PUSH ---

            // 1. Tenta encontrar a linha que começa com PUSH_NOTIFICATION:
            if (preg_match('/PUSH_NOTIFICATION:\s*(.*)$/m', $analysis, $matches)) {
                $pushText = trim($matches[1]);

                // Limpeza de segurança: remove colchetes se a IA os colocou por engano
                $pushText = str_replace(['[', ']'], '', $pushText);

                // 2. Remove a linha do Push do texto original para não aparecer no relatório da tela
                $analysis = preg_replace('/PUSH_NOTIFICATION:.*$/m', '', $analysis);
                $analysis = trim($analysis);

                // 3. Salva no banco de dados para o Cron disparar
                // Importante: certifique-se que o NotificationModel está carregado no __construct
                if (isset($this->notificationModel)) {
                    $this->notificationModel->create([
                        'user_id' => $userId,
                        'type' => 'insight_ia',
                        'title' => '💡 Insight do Amigo',
                        'message' => $pushText,
                        'priority' => 'medium'
                    ]);
                    error_log("[RelatoriosController] Insight de IA salvo para push posterior.");
                }
            }

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

        if (!empty($categories)) {
            foreach ($categories as $cat) {
                // Ajuste aqui: tentamos 'total_amount' (do SQL) ou 'amount' ou 'total'
                $valorGasto = (float)($cat['total_amount'] ?? $cat['amount'] ?? $cat['total'] ?? 0);

                $categoryBreakdown[] = [
                    // Tentamos 'category_name' ou 'name'
                    'name' => $cat['category_name'] ?? $cat['name'] ?? 'Outros',
                    'amount' => $valorGasto,
                    'percentage' => 0
                ];
                $totalCategorySpending += $valorGasto;
            }

            // Calcula a porcentagem com segurança
            foreach ($categoryBreakdown as &$cat) {
                $cat['percentage'] = $totalCategorySpending > 0
                    ? round(($cat['amount'] / $totalCategorySpending) * 100, 2)
                    : 0;
            }
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
        $modelName = trim($config['model']);
        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$modelName}:generateContent?key={$apiKey}";

        // Identifica se o contexto já é o prompt pronto (Dicas Semanais) 
        // ou se precisa construir (Relatório Mensal)
        $prompt = is_array($context) ? $this->buildPrompt($context) : $context;

        $maxRetries = 3;         // Tentativas totais
        $retryDelay = 1500000;   // 1.5 segundos (em microssegundos) de espera base

        for ($i = 0; $i < $maxRetries; $i++) {
            try {
                $data = [
                    "system_instruction" => [
                        "parts" => [
                            ["text" => "Você é um consultor financeiro especializado em análise de gastos pessoais e familiares. Forneça análises detalhadas, práticas e motivadoras em português do Brasil. Sempre estruture sua resposta com seções claras usando markdown."]
                        ]
                    ],
                    "contents" => [
                        [
                            "role" => "user",
                            "parts" => [["text" => $prompt]]
                        ]
                    ],
                    "generationConfig" => [
                        "temperature" => (float)($config['temperature'] ?? 0.7),
                        "maxOutputTokens" => 2048,
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

                // Timeout individual por tentativa
                curl_setopt($ch, CURLOPT_TIMEOUT, (int)($config['timeout'] ?? 30));

                $response = curl_exec($ch);
                $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                $curlError = curl_error($ch);
                curl_close($ch);

                // 1. Verifica erro de conexão (Rede/DNS)
                if ($curlError) {
                    throw new Exception("Erro cURL: " . $curlError);
                }

                $result = json_decode($response, true);

                // 2. Verifica se a API retornou erro formal (Cota, Chave Inválida, etc)
                if ($httpCode !== 200) {
                    $msg = $result['error']['message'] ?? 'Erro desconhecido';
                    throw new Exception("API Error (HTTP {$httpCode}): {$msg}");
                }

                // 3. Verifica se o texto da resposta existe
                if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                    $text = $result['candidates'][0]['content']['parts'][0]['text'];

                    if ($i > 0) {
                        error_log("[Gemini] Sucesso na tentativa " . ($i + 1));
                    }

                    return $text;
                }

                throw new Exception("Resposta da IA vazia ou malformada.");
            } catch (Exception $e) {
                error_log("[Gemini] Tentativa " . ($i + 1) . " falhou: " . $e->getMessage());

                // Se for a última tentativa, desiste e joga o erro para o Cron/Controller tratar
                if ($i === $maxRetries - 1) {
                    throw new Exception("Falha após {$maxRetries} tentativas: " . $e->getMessage());
                }

                // Espera progressiva antes de tentar de novo (1.5s, 3s...)
                usleep($retryDelay * ($i + 1));
            }
        }
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

            DICA EXTRA: No final da sua resposta, adicione uma linha EXATAMENTE assim:
            PUSH_NOTIFICATION: [Aqui você escreve uma frase de impacto com emojis, sem colchetes, de até 90 caracteres para o celular do usuário, baseada no dado mais crítico que você encontrou]
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

    public function gerarDicasSemanais()
    {
        header('Content-Type: application/json');

        $groupId = $_SESSION['current_group_id'] ?? null;
        $userId = $_SESSION['user_id'] ?? null;

        if (!$groupId || !$userId) {
            echo json_encode(['success' => false, 'message' => 'Sessão expirada.']);
            return;
        }

        try {
            // 1. Coleta dados reais dos últimos 30 dias para basear as dicas
            $month = date('m');
            $year = date('Y');

            $balance = $this->transactionModel->getMonthlyBalance($groupId, $month, $year);
            $spendingByCategory = $this->transactionModel->getSpendingByCategory($groupId, $month, $year);

            // Formata os dados para o prompt
            $context = [
                'summary' => [
                    'receitas' => number_format($balance['total_income'] ?? 0, 2, ',', '.'),
                    'despesas' => number_format($balance['total_expense'] ?? 0, 2, ',', '.'),
                    'saldo'    => ($balance['total_income'] ?? 0) - ($balance['total_expense'] ?? 0)
                ],
                'categorias' => $spendingByCategory
            ];

            // 2. Constrói o Prompt Educativo 
            $prompt = $this->buildWeeklyPrompt($context);

            // 3. Chama a OpenAI 
            $aiResponse = $this->callOpenAI($prompt);

            // 4. Processa a resposta: Procura por "DIA X: frase"
            preg_match_all('/DIA \d+:\s*(.*)/i', $aiResponse, $matches);
            $dicas = $matches[1];

            if (count($dicas) < 7) {
                throw new Exception("A IA não gerou as 7 dicas no formato correto.");
            }

            // 5. Usa a Model para persistir
            // Limpa o que já estava agendado para o futuro para não duplicar
            $this->notificationModel->clearFutureInsights($userId);

            foreach ($dicas as $index => $texto) {
                // Agenda para os próximos 7 dias (Dia 1 = Amanhã)
                $dataAgendada = date('Y-m-d', strtotime("+" . ($index + 1) . " days"));

                // Limpeza de segurança para remover resquícios de formatação da IA
                $textoLimpo = str_replace(['[', ']', '"', '*'], '', trim($texto));

                $this->notificationModel->scheduleInsight($userId, $textoLimpo, $dataAgendada);
            }

            echo json_encode([
                'success' => true,
                'message' => 'Plano financeiro de 7 dias agendado com sucesso!'
            ]);
        } catch (Exception $e) {
            error_log("Erro ao gerar dicas semanais: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Erro ao processar dicas inteligentes.']);
        }
    }

    /**
     * Monta o prompt para a IA (como você definiu)
     */
    private function buildWeeklyPrompt($context)
    {
        $resumo = $context['summary'];
        $categorias = "";
        foreach ($context['categorias'] as $cat) {
            $categorias .= "- {$cat['name']}: R$ " . number_format($cat['amount'], 2, ',', '.') . " ({$cat['percentage']}%)\n";
        }

        return <<<PROMPT
        Você é o "Amigo do Bolso", um mentor financeiro perspicaz, direto e motivador. 
        Analise os dados reais do usuário abaixo e gere 7 dicas (pílulas de conhecimento) para a próxima semana.

        DADOS REAIS DO MÊS ATUAL:
        - Receitas: R$ {$resumo['receitas']}
        - Despesas: R$ {$resumo['despesas']}
        - Saldo Atual: R$ {$resumo['saldo']}
        - Maiores Gastos por Categoria:
        {$categorias}

        REGRAS PARA AS DICAS:
        1. NUNCA seja genérico. Se o saldo estiver negativo, seja firme. Se houver muito gasto em uma categoria (ex: Lazer), foque nisso.
        2. Use um tom de conversa entre amigos: "Cara, olhei suas contas e...", "Vou te mandar a real...", "Sabia que você gastou X com Y?".
        3. Cada dica deve ser curta (máximo 140 caracteres) para caber no celular.
        4. Varie os temas: uma sobre psicologia do consumo, uma sobre os dados reais dele, uma sobre investimentos e uma sobre metas.
        5. Se as despesas forem > 70% da receita, alerte sobre o risco.

        FORMATO OBRIGATÓRIO (Responda APENAS as 7 linhas):
        DIA 1: [Dica sobre o saldo atual ou maior gasto]
        DIA 2: [Dica de psicologia financeira/hábitos]
        DIA 3: [Dica técnica sobre economia]
        DIA 4: [Dica motivacional baseada no lucro/prejuízo]
        DIA 5: [Dica de planejamento para o final de semana]
        DIA 6: [Dica rápida de investimento ou reserva]
        DIA 7: [Desafio para a próxima semana]
        PROMPT;
    }
    /**
     * Método auxiliar para o Cron: Retorna apenas o array de frases da IA
     */
    public function obterArrayDeDicasIA($groupId)
    {
        $month = date('m');
        $year = date('Y');

        $balance = $this->transactionModel->getMonthlyBalance($groupId, $month, $year);
        $spendingByCategory = $this->transactionModel->getSpendingByCategory($groupId, $month, $year);

        $totalIncome = (float)($balance['total_income'] ?? 0);
        $totalExpense = (float)($balance['total_expense'] ?? 0);

        // --- LÓGICA DE INCENTIVO PARA GRUPOS SEM DADOS ---
        if ($totalIncome == 0 && $totalExpense == 0) {
            error_log("[Insights] Grupo {$groupId} sem movimentação. Enviando mensagens de incentivo.");

            return [
                "Bem-vindo! Que tal começar registrando seu primeiro ganho ou gasto? 📝",
                "Sabia que quem anota os gastos economiza até 30% no fim do mês? 💰",
                "Dica: Categorize seus gastos para saber exatamente para onde vai seu dinheiro. 📊",
                "Crie uma meta financeira hoje e acompanhe seu progresso por aqui! 🎯",
                "O segredo da paz financeira é o hábito de registrar. Vamos juntos? ✨",
                "Já deu uma olhada nas suas contas fixas? Registre-as como recorrentes! 🛡️",
                "Planejar o amanhã começa com os registros de hoje. Boa semana! 💡"
            ];
        }

        // Se houver dados, segue o fluxo normal com a IA
        $context = [
            'summary' => [
                'receitas' => number_format($totalIncome, 2, ',', '.'),
                'despesas' => number_format($totalExpense, 2, ',', '.'),
                'saldo'    => $totalIncome - $totalExpense
            ],
            'categorias' => []
        ];

        if (!empty($spendingByCategory)) {
            foreach ($spendingByCategory as $cat) {
                $context['categorias'][] = [
                    'name'       => $cat['category_name'] ?? $cat['name'] ?? 'Outros',
                    'amount'     => $cat['total_amount'] ?? $cat['total'] ?? 0,
                    'percentage' => $cat['percentage'] ?? 0
                ];
            }
        }

        $prompt = $this->buildWeeklyPrompt($context);
        $aiResponse = $this->callOpenAI($prompt);

        preg_match_all('/DIA \d+:\s*(.*)/i', $aiResponse, $matches);

        return array_map(function ($t) {
            return str_replace(['[', ']', '"', '*'], '', trim($t));
        }, $matches[1]);
    }
}
