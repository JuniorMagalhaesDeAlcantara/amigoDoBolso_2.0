<?php

class TransacoesController extends Controller
{
    private $transactionModel;
    private $categoryModel;
    private $creditCardModel;
    private $benefitCardModel;

    public function __construct()
    {
        $this->requireLogin();
        $this->transactionModel = new TransactionModel();
        $this->categoryModel = new CategoryModel();
        $this->creditCardModel = new CreditCardModel();
        $this->benefitCardModel = new BenefitCardModel();
    }

    // TransactionController.php - Método index atualizado

    public function index()
    {
        $month = $_GET['month'] ?? date('m');
        $year  = $_GET['year']  ?? date('Y');
        $status = $_GET['status'] ?? 'all';

        $groupId = $_SESSION['current_group_id'];

        $transactions = $this->transactionModel->getByMonthAndStatus($groupId, $month, $year, $status);
        $balance      = $this->transactionModel->getMonthlyBalance($groupId, $month, $year);
        $overdueTransactions = $this->transactionModel->getOverdue($groupId); // ← novo

        $creditCardModel = new CreditCardModel();
        $cards = $creditCardModel->getByGroup($groupId);
        $creditCardTotal = 0;
        foreach ($cards as $card) {
            $creditCardTotal += $this->transactionModel->getCardInvoiceTotal($card['id'], $month, $year);
        }

        $this->view('transacoes/index', [
            'transactions'       => $transactions,
            'overdueTransactions' => $overdueTransactions, // ← novo
            'balance'            => $balance,
            'creditCardTotal'    => $creditCardTotal,
            'month'              => $month,
            'year'               => $year,
            'status'             => $status
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
            // Usa htmlspecialchars ao invés de FILTER_SANITIZE_STRING
            $paymentMethod = htmlspecialchars(trim($_POST['payment_method'] ?? ''), ENT_QUOTES, 'UTF-8');
            $isRecurring = isset($_POST['is_recurring']) && $_POST['is_recurring'] === '1';

            // Valor como string (será convertido depois)
            $amount = htmlspecialchars(trim($_POST['amount'] ?? ''), ENT_QUOTES, 'UTF-8');

            $data = [
                'group_id' => $groupId,
                'user_id' => $_SESSION['user_id'],
                'category_id' => filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT),
                'description' => htmlspecialchars(trim($_POST['description'] ?? ''), ENT_QUOTES, 'UTF-8'),
                'amount' => $amount,
                'type' => htmlspecialchars(trim($_POST['type'] ?? ''), ENT_QUOTES, 'UTF-8'),
                'transaction_date' => htmlspecialchars(trim($_POST['transaction_date'] ?? ''), ENT_QUOTES, 'UTF-8'),
                'payment_method' => $paymentMethod
            ];

            // Se for VR ou VA
            if ($paymentMethod === 'vr' || $paymentMethod === 'va') {
                $benefitCardId = filter_input(INPUT_POST, 'benefit_card_id', FILTER_VALIDATE_INT);
                $benefit = $this->benefitCardModel->findById($benefitCardId);

                if (!$benefit) {
                    $_SESSION['error'] = "Benefício não encontrado";
                    $this->redirect('/transacoes/criar');
                    return;
                }

                // Converte valor para float
                $amountFloat = floatval($amount);

                // Verifica se tem saldo suficiente
                if ($benefit['current_balance'] < $amountFloat) {
                    $_SESSION['error'] = "Saldo insuficiente no benefício. Disponível: R$ " .
                        number_format($benefit['current_balance'], 2, ',', '.');
                    $this->redirect('/transacoes/criar');
                    return;
                }

                // Adiciona benefit_card_id aos dados
                $data['benefit_card_id'] = $benefitCardId;

                // IMPORTANTE: Marca como PAGA automaticamente
                $data['paid'] = 1;

                // Cria a transação
                $this->transactionModel->create($data);

                // Debita do saldo do benefício
                $this->benefitCardModel->debit($benefitCardId, $amountFloat);

                $this->redirect('/transacoes');
                return;
            }

            // Se for cartão de crédito
            if ($paymentMethod === 'credito') {
                $data['credit_card_id'] = filter_input(INPUT_POST, 'credit_card_id', FILTER_VALIDATE_INT);
                $installments = filter_input(INPUT_POST, 'installments', FILTER_VALIDATE_INT) ?? 1;

                // IMPORTANTE: Compra no crédito NÃO nasce paga no saldo bancário.
                // Ela fica como 0 (pendente) porque quem vai pagar é a fatura depois.
                $data['paid'] = 0;

                if ($installments > 1) {
                    $this->transactionModel->createInstallments($data, $installments);
                } else {
                    $this->transactionModel->create($data);
                }

                $this->redirect('/transacoes');
                return; // <-- ESSENCIAL: Impede que o script continue rodando para o "else" abaixo!
            }

            // Se for recorrente
            if ($isRecurring) {
                $data['paid'] = 0; // Garante que inicia como pendente
                $recurrenceMonths = filter_input(INPUT_POST, 'recurrence_months', FILTER_VALIDATE_INT) ?? 1;
                $this->transactionModel->createRecurring($data, $recurrenceMonths);
            } else {
                $this->transactionModel->create($data);
            }

            $this->redirect('/transacoes');
        } else {
            $categories = $this->categoryModel->getByGroup($groupId);
            $creditCards = $this->creditCardModel->getByGroup($groupId);
            $benefitCards = $this->benefitCardModel->getByGroup($groupId);

            $this->view('transacoes/criar', [
                'categories' => $categories,
                'creditCards' => $creditCards,
                'benefitCards' => $benefitCards
            ]);
        }
    }

    public function editar($id)
    {
        $transaction = $this->transactionModel->findById($id);

        if (!$transaction || $transaction['group_id'] != $_SESSION['current_group_id']) {
            $this->redirect('/transacoes');
            return;
        }

        // Verifica se tem transações relacionadas
        $hasRelated = $this->transactionModel->hasRelatedTransactions($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Converte valor
            $amount = htmlspecialchars(trim($_POST['amount'] ?? ''), ENT_QUOTES, 'UTF-8');
            $amount = str_replace(['.', ','], ['', '.'], $amount);
            $amount = floatval($amount);

            $data = [
                'category_id' => filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT),
                'description' => htmlspecialchars(trim($_POST['description'] ?? ''), ENT_QUOTES, 'UTF-8'),
                'amount' => $amount,
                'transaction_date' => htmlspecialchars(trim($_POST['transaction_date'] ?? ''), ENT_QUOTES, 'UTF-8'),
            ];

            // Verifica se deve atualizar todas as relacionadas
            $updateAll = isset($_POST['update_related']) && $_POST['update_related'] === '1';

            if ($hasRelated && $updateAll) {
                $this->transactionModel->updateWithRelated($id, $data, true);
            } else {
                $this->transactionModel->update($id, $data);
            }

            $this->redirect('/transacoes');
        } else {
            $categories = $this->categoryModel->getByGroup($transaction['group_id']);
            $related = $hasRelated ? $this->transactionModel->getRelatedTransactions($id) : [];

            $this->view('transacoes/editar', [
                'transaction' => $transaction,
                'categories' => $categories,
                'hasRelated' => $hasRelated,
                'related' => $related
            ]);
        }
    }

    public function deletar($id)
    {
        $transaction = $this->transactionModel->findById($id);

        if (!$transaction || $transaction['group_id'] != $_SESSION['current_group_id']) {
            $this->redirect('/transacoes');
            return;
        }

        // Verifica se tem transações relacionadas
        $hasRelated = $this->transactionModel->hasRelatedTransactions($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verifica se deve deletar todas
            $deleteAll = isset($_POST['delete_related']) && $_POST['delete_related'] === '1';

            if ($deleteAll) {
                // Se vai deletar todas as relacionadas, precisa devolver o saldo de cada uma
                $related = $this->transactionModel->getRelatedTransactions($id);
                foreach ($related as $rel) {
                    if ($rel['benefit_card_id']) {
                        $this->benefitCardModel->credit($rel['benefit_card_id'], $rel['amount']);
                    }
                }
                $this->transactionModel->deleteWithRelated($id, true);
            } else {
                // Deleta apenas esta, devolvendo o saldo se for benefício
                if ($transaction['benefit_card_id']) {
                    $this->benefitCardModel->credit($transaction['benefit_card_id'], $transaction['amount']);
                }
                $this->transactionModel->delete($id);
            }

            $this->redirect('/transacoes');
            return;
        }

        // SEMPRE mostra página de confirmação
        $related = $hasRelated ? $this->transactionModel->getRelatedTransactions($id) : [$transaction];

        $this->view('transacoes/confirmar-delete', [
            'transaction' => $transaction,
            'related' => $related,
            'hasRelated' => $hasRelated
        ]);
    }

    public function togglePaid()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Método inválido']);
            exit; // ← ADICIONAR exit
        }

        $transactionId = $_POST['transaction_id'] ?? null;
        $paid = $_POST['paid'] ?? '0';

        if (!$transactionId) {
            echo json_encode(['success' => false, 'message' => 'ID inválido']);
            exit; // ← ADICIONAR exit
        }

        // Verifica se a transação pertence ao grupo atual
        $transaction = $this->transactionModel->findById($transactionId);

        if (!$transaction || $transaction['group_id'] != $_SESSION['current_group_id']) {
            echo json_encode(['success' => false, 'message' => 'Transação não encontrada']);
            exit; // ← ADICIONAR exit
        }

        // Atualiza o status usando método específico
        $success = $this->transactionModel->updatePaidStatus($transactionId, $paid === '1' ? 1 : 0);

        echo json_encode([
            'success' => true,
            'message' => $paid === '1' ? 'Transação marcada como paga' : 'Transação marcada como pendente'
        ]);
        exit;
    }

    public function pagarFatura()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['success' => false, 'message' => 'Método inválido']);
            exit;
        }

        $cardId     = filter_input(INPUT_POST, 'card_id', FILTER_VALIDATE_INT);
        $month      = filter_input(INPUT_POST, 'month',   FILTER_VALIDATE_INT);
        $year       = filter_input(INPUT_POST, 'year',    FILTER_VALIDATE_INT);
        $amount     = floatval($_POST['amount']      ?? 0);
        $totalAmount = floatval($_POST['total_amount'] ?? $amount); // total da fatura

        if (!$cardId || !$month || !$year || $amount <= 0) {
            echo json_encode(['success' => false, 'message' => 'Dados inválidos']);
            exit;
        }

        $groupId = $_SESSION['current_group_id'];
        $userId  = $_SESSION['user_id'];

        $card = $this->creditCardModel->findById($cardId);
        if (!$card || $card['group_id'] != $groupId) {
            echo json_encode(['success' => false, 'message' => 'Cartão não encontrado']);
            exit;
        }

        try {
            // ✅ Chama o model correto, que já cria a transação de despesa via registerPaymentTransaction()
            $invoiceModel = new CreditCardInvoiceModel();
            $invoiceModel->payInvoice($cardId, $month, $year, $totalAmount, $amount, $userId);

            echo json_encode(['success' => true, 'message' => 'Fatura paga com sucesso']);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }
}
