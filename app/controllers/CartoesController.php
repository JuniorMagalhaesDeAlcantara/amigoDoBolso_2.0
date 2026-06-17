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

        $currentMonth = date('n');
        $currentYear  = date('Y');

        foreach ($cards as &$card) {
            $card['current_invoice'] = $this->transactionModel->getCardInvoiceTotal(
                $card['id'],
                $currentMonth,
                $currentYear
            );

            if ($card['credit_limit']) {
                $card['available'] = $card['credit_limit'] - $card['current_invoice'];
            }
        }

        $this->view('cartoes/index', ['cards' => $cards]);
    }

    public function criar()
    {
        $groupId = $_SESSION['current_group_id'] ?? null;

        if (!$groupId) {
            $this->redirect('/dashboard');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // FIX: FILTER_SANITIZE_STRING foi removido no PHP 8.1 — usar FILTER_DEFAULT + htmlspecialchars
            $sanitize = fn($key) => htmlspecialchars(trim($_POST[$key] ?? ''), ENT_QUOTES, 'UTF-8') ?: null;

            $limitRaw = trim($_POST['credit_limit'] ?? '');
            $limit    = ($limitRaw !== '') ? floatval($limitRaw) : null;

            $data = [
                'group_id'     => $groupId,
                'bank'         => $sanitize('bank'),
                'name'         => $sanitize('name'),
                'holder_name'  => $sanitize('holder_name'),
                'last_digits'  => $sanitize('last_digits'),
                'closing_day'  => filter_input(INPUT_POST, 'closing_day', FILTER_VALIDATE_INT) ?: null,
                'due_day'      => filter_input(INPUT_POST, 'due_day',     FILTER_VALIDATE_INT) ?: null,
                'credit_limit' => $limit,
            ];

            // FIX: validação mínima antes de salvar
            if (empty($data['name']) || empty($data['closing_day']) || empty($data['due_day'])) {
                $_SESSION['error'] = 'Preencha todos os campos obrigatórios.';
                $this->view('cartoes/criar');
                return;
            }

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

        if (!$card || $card['group_id'] != $groupId) {
            $this->redirect('/cartoes');
            return;
        }

        $month = (int) ($_GET['month'] ?? date('n'));
        $year  = (int) ($_GET['year']  ?? date('Y'));

        // Compras do período (sem transação de pagamento)
        $transactions = $this->transactionModel->getByCard($cardId, $month, $year);

        // Total das compras do período
        $invoiceTotal = $this->transactionModel->getCardInvoiceTotal($cardId, $month, $year);

        // Status de pagamento vem SEMPRE da tabela credit_card_invoices
        $invoiceModel  = new CreditCardInvoiceModel();
        $invoiceRecord = $invoiceModel->findInvoice($cardId, $month, $year);

        $alreadyPaid = $invoiceRecord ? floatval($invoiceRecord['paid_amount']) : 0;
        $paidAt      = $invoiceRecord ? $invoiceRecord['paid_at']               : null;

        // FIX: comparação de float com tolerância de 1 centavo
        $isPaid    = $invoiceRecord && ($invoiceRecord['paid_amount'] >= $invoiceRecord['total_amount'] - 0.01);
        $remaining = max(0, round($invoiceTotal - $alreadyPaid, 2));

        // Próximas parcelas
        $upcomingInstallments = $this->transactionModel->getUpcomingInstallments($cardId, 6);

        // FIX: trata meses com dias inválidos (ex: 31/fev) usando mktime
        $dueDateTs = mktime(0, 0, 0, $month, $card['due_day'], $year);
        $dueDate   = date('d/m/Y', $dueDateTs);

        $upcomingByMonth = [];
        foreach ($upcomingInstallments as $installment) {
            $monthKey = date('Y-m', strtotime($installment['transaction_date']));
            if (!isset($upcomingByMonth[$monthKey])) {
                $upcomingByMonth[$monthKey] = [
                    'month_name'   => $this->getMonthName(date('m', strtotime($installment['transaction_date']))),
                    'year'         => date('Y', strtotime($installment['transaction_date'])),
                    'total'        => 0,
                    'transactions' => [],
                ];
            }
            $upcomingByMonth[$monthKey]['total']         += $installment['amount'];
            $upcomingByMonth[$monthKey]['transactions'][] = $installment;
        }

        $this->view('cartoes/extrato', [
            'card'            => $card,
            'transactions'    => $transactions,
            'invoiceTotal'    => $invoiceTotal,
            'alreadyPaid'     => $alreadyPaid,
            'paidAt'          => $paidAt,
            'remainingAmount' => $remaining,
            'isPaid'          => $isPaid,
            'upcomingByMonth' => $upcomingByMonth,
            'dueDate'         => $dueDate,
            'month'           => $month,
            'year'            => $year,
            'monthName'       => $this->getMonthName($month),
        ]);
    }

    /**
     * Helper para nome do mês em português
     */
    private function getMonthName($month)
    {
        $months = [
            1  => 'Janeiro',  2  => 'Fevereiro', 3  => 'Março',
            4  => 'Abril',    5  => 'Maio',       6  => 'Junho',
            7  => 'Julho',    8  => 'Agosto',     9  => 'Setembro',
            10 => 'Outubro',  11 => 'Novembro',   12 => 'Dezembro',
        ];
        return $months[(int) $month] ?? '';
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

        // FIX: mês/ano lidos do GET em ambos os métodos; no POST, vêm do form hidden
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $month = filter_input(INPUT_POST, 'month', FILTER_VALIDATE_INT);
            $year  = filter_input(INPUT_POST, 'year',  FILTER_VALIDATE_INT);

            // FIX: fallback explícito com cast seguro — nunca usa date() cegamente
            $month = ($month && $month >= 1 && $month <= 12) ? $month : (int) date('n');
            $year  = ($year  && $year  >= 2000)              ? $year  : (int) date('Y');
        } else {
            $month = (int) ($_GET['month'] ?? date('n'));
            $year  = (int) ($_GET['year']  ?? date('Y'));
        }

        $invoiceModel = new CreditCardInvoiceModel();

        $invoiceTotal    = $this->transactionModel->getCardInvoiceTotal($cardId, $month, $year);
        $invoice         = $invoiceModel->findInvoice($cardId, $month, $year);
        $alreadyPaid     = $invoice ? floatval($invoice['paid_amount']) : 0;
        $remainingAmount = round($invoiceTotal - $alreadyPaid, 2);

        if ($remainingAmount <= 0.01) {
            $_SESSION['success'] = 'Esta fatura já está totalmente paga!';
            $this->redirect("/cartoes/extrato/{$cardId}?month={$month}&year={$year}");
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $paymentType = $_POST['payment_type'] ?? 'total';

                $paidAmount = $paymentType === 'custom'
                    ? round(floatval($_POST['custom_amount'] ?? 0), 2)
                    : $remainingAmount;

                if ($paidAmount <= 0) {
                    throw new Exception('Valor de pagamento inválido.');
                }

                if ($paidAmount > $remainingAmount + 0.01) {
                    throw new Exception(
                        'Valor não pode ser maior que o saldo devedor de R$ ' .
                        number_format($remainingAmount, 2, ',', '.')
                    );
                }

                $invoiceModel->payInvoice(
                    $cardId,
                    $month,
                    $year,
                    $invoiceTotal,
                    $paidAmount,
                    $_SESSION['user_id']
                );

                $newRemainingAmount = round($remainingAmount - $paidAmount, 2);

                if ($newRemainingAmount > 0.01) {
                    $_SESSION['warning'] =
                        'Pagamento de R$ ' . number_format($paidAmount, 2, ',', '.') .
                        ' registrado! Saldo restante: R$ ' . number_format($newRemainingAmount, 2, ',', '.') .
                        '. Será movido para a próxima fatura automaticamente.';
                } else {
                    $_SESSION['success'] = 'Fatura paga integralmente!';
                }

                $this->redirect("/cartoes/extrato/{$cardId}?month={$month}&year={$year}");

            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
                $this->redirect("/cartoes/extrato/{$cardId}?month={$month}&year={$year}");
            }
        } else {
            $this->view('cartoes/confirmar-pagamento', [
                'card'            => $card,
                'invoiceTotal'    => $invoiceTotal,
                'alreadyPaid'     => $alreadyPaid,
                'remainingAmount' => $remainingAmount,
                'month'           => $month,
                'year'            => $year,
                'monthName'       => $this->getMonthName($month),
            ]);
        }
    }
}