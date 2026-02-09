<?php

class CartoesController extends Controller
{
    private $creditCardModel;
    private $transactionModel;

    public function __construct()
    {
        $this->requireLogin();
        $this->creditCardModel = new CreditCardModel();
        $this->transactionModel = new TransactionModel();
    }

    public function index()
    {
        $groupId = $_SESSION['current_group_id'] ?? null;

        if (!$groupId) {
            $this->redirect('/dashboard');
            return;
        }

        $cards = $this->creditCardModel->getByGroup($groupId);

        // Para cada cartão, calcula a fatura do mês atual
        $currentMonth = date('n');
        $currentYear = date('Y');

        foreach ($cards as &$card) {
            $card['current_invoice'] = $this->transactionModel->getCardInvoiceTotal(
                $card['id'],
                $currentMonth,
                $currentYear
            );

            // Calcula disponível
            if ($card['credit_limit']) {
                $card['available'] = $card['credit_limit'] - $card['current_invoice'];
            }
        }

        $this->view('cartoes/index', [
            'cards' => $cards
        ]);
    }

    public function criar()
    {
        $groupId = $_SESSION['current_group_id'] ?? null;

        if (!$groupId) {
            $this->redirect('/dashboard');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Remove formatação do limite se houver - CORRIGIDO
            $limit = filter_input(INPUT_POST, 'credit_limit', FILTER_SANITIZE_STRING);
            if ($limit) {
                // Remove apenas espaços e converte vírgula para ponto
                $limit = trim($limit);
                if (!empty($limit)) {
                    $limit = floatval($limit);
                } else {
                    $limit = null;
                }
            } else {
                $limit = null;
            }

            $data = [
                'group_id' => $groupId,
                'bank' => filter_input(INPUT_POST, 'bank', FILTER_SANITIZE_STRING),
                'name' => filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING),
                'holder_name' => filter_input(INPUT_POST, 'holder_name', FILTER_SANITIZE_STRING),
                'last_digits' => filter_input(INPUT_POST, 'last_digits', FILTER_SANITIZE_STRING),
                'closing_day' => filter_input(INPUT_POST, 'closing_day', FILTER_VALIDATE_INT),
                'due_day' => filter_input(INPUT_POST, 'due_day', FILTER_VALIDATE_INT),
                'credit_limit' => $limit
            ];

            $this->creditCardModel->create($data);
            $this->redirect('/cartoes');
        } else {
            $this->view('cartoes/criar');
        }
    }

    public function deletar($id)
    {
        $card = $this->creditCardModel->findById($id);

        if ($card && $card['group_id'] == $_SESSION['current_group_id']) {
            $this->creditCardModel->delete($id);
        }

        $this->redirect('/cartoes');
    }

    /**
     * Exibe o extrato/fatura do cartão
     */
    public function extrato($cardId)
    {
        $groupId = $_SESSION['current_group_id'] ?? null;

        if (!$groupId) {
            $this->redirect('/dashboard');
            return;
        }

        $card = $this->creditCardModel->findById($cardId);

        // Verifica se o cartão pertence ao grupo do usuário
        if (!$card || $card['group_id'] != $groupId) {
            $this->redirect('/cartoes');
            return;
        }

        // Pega mês e ano da URL ou usa atual
        $month = $_GET['month'] ?? date('n');
        $year = $_GET['year'] ?? date('Y');

        // Busca transações do cartão no período
        $transactions = $this->transactionModel->getByCard($cardId, $month, $year);

        // Calcula total da fatura
        $invoiceTotal = $this->transactionModel->getCardInvoiceTotal($cardId, $month, $year);

        // Busca próximas parcelas
        $upcomingInstallments = $this->transactionModel->getUpcomingInstallments($cardId, 6);

        // Calcula data de vencimento da fatura atual
        $dueDate = new DateTime("{$year}-{$month}-{$card['due_day']}");

        // Se já passou do vencimento, mostra o próximo mês
        $today = new DateTime();
        if ($dueDate < $today) {
            $dueDate->modify('+1 month');
        }

        // Agrupa próximas parcelas por mês
        $upcomingByMonth = [];
        foreach ($upcomingInstallments as $installment) {
            $monthKey = date('Y-m', strtotime($installment['transaction_date']));
            if (!isset($upcomingByMonth[$monthKey])) {
                $upcomingByMonth[$monthKey] = [
                    'month_name' => $this->getMonthName(date('m', strtotime($installment['transaction_date']))),
                    'year' => date('Y', strtotime($installment['transaction_date'])),
                    'total' => 0,
                    'transactions' => []
                ];
            }
            $upcomingByMonth[$monthKey]['total'] += $installment['amount'];
            $upcomingByMonth[$monthKey]['transactions'][] = $installment;
        }

        $this->view('cartoes/extrato', [
            'card' => $card,
            'transactions' => $transactions,
            'invoiceTotal' => $invoiceTotal,
            'upcomingByMonth' => $upcomingByMonth,
            'dueDate' => $dueDate->format('d/m/Y'),
            'month' => $month,
            'year' => $year,
            'monthName' => $this->getMonthName($month)
        ]);
    }

    /**
     * Helper para nome do mês em português
     */
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
        return $months[(int)$month];
    }

    /**
     * Paga fatura do cartão
     */
    public function pagarFatura($cardId)
    {
        $groupId = $_SESSION['current_group_id'] ?? null;

        if (!$groupId) {
            $this->redirect('/dashboard');
            return;
        }

        $card = $this->creditCardModel->findById($cardId);

        if (!$card || $card['group_id'] != $groupId) {
            $this->redirect('/cartoes');
            return;
        }

        // Pega mês e ano da URL ou usa atual
        $month = $_GET['month'] ?? date('n');
        $year = $_GET['year'] ?? date('Y');

        $invoiceModel = new CreditCardInvoiceModel();

        // ✅ CORREÇÃO: Recalcula o total ATUAL da fatura
        $invoiceTotal = $this->transactionModel->getCardInvoiceTotal($cardId, $month, $year);
        
        // ✅ CORREÇÃO: Busca quanto JÁ FOI PAGO
        $invoice = $invoiceModel->findInvoice($cardId, $month, $year);
        $alreadyPaid = $invoice ? $invoice['paid_amount'] : 0;
        
        // ✅ CORREÇÃO: Calcula o SALDO DEVEDOR (quanto ainda falta pagar)
        $remainingAmount = $invoiceTotal - $alreadyPaid;

        // Se não há saldo a pagar
        if ($remainingAmount <= 0) {
            $_SESSION['success'] = 'Esta fatura já está totalmente paga!';
            $this->redirect("/cartoes/extrato/{$cardId}?month={$month}&year={$year}");
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $paymentType = $_POST['payment_type'] ?? 'total';
                
                // ✅ CORREÇÃO: Se escolher "total", paga o SALDO DEVEDOR, não o total original
                $paidAmount = $paymentType === 'custom'
                    ? floatval($_POST['custom_amount'] ?? 0)
                    : $remainingAmount; // MUDOU AQUI!

                // Validações
                if ($paidAmount <= 0) {
                    throw new Exception("Valor de pagamento inválido");
                }
                
                if ($paidAmount > $remainingAmount) {
                    throw new Exception("Valor não pode ser maior que o saldo devedor de R$ " . 
                        number_format($remainingAmount, 2, ',', '.'));
                }

                // Registra o pagamento
                $invoiceModel->payInvoice(
                    $cardId,
                    $month,
                    $year,
                    $invoiceTotal,
                    $paidAmount,
                    $_SESSION['user_id']
                );

                // ✅ CORREÇÃO: Recalcula novamente para ver se ficou saldo
                $newRemainingAmount = $remainingAmount - $paidAmount;

                // Mensagens diferenciadas
                if ($newRemainingAmount > 0) {
                    $_SESSION['warning'] = "Pagamento de R$ " . 
                        number_format($paidAmount, 2, ',', '.') . 
                        " registrado com sucesso! Saldo restante: R$ " .
                        number_format($newRemainingAmount, 2, ',', '.') .
                        ". Este saldo poderá ser pago antes do vencimento ou será movido para a próxima fatura automaticamente.";
                } else {
                    $_SESSION['success'] = 'Fatura paga integralmente!';
                }

                $this->redirect("/cartoes/extrato/{$cardId}?month={$month}&year={$year}");
            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
                $this->redirect("/cartoes/extrato/{$cardId}?month={$month}&year={$year}");
            }
        } else {
            // ✅ CORREÇÃO: Envia o saldo devedor para a view, não o total
            $this->view('cartoes/confirmar-pagamento', [
                'card' => $card,
                'invoiceTotal' => $invoiceTotal,
                'alreadyPaid' => $alreadyPaid,
                'remainingAmount' => $remainingAmount, // NOVO!
                'month' => $month,
                'year' => $year,
                'monthName' => $this->getMonthName($month)
            ]);
        }
    }
}