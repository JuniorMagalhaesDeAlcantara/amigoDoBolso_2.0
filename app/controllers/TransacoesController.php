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
        $year = $_GET['year'] ?? date('Y');
        $status = $_GET['status'] ?? 'all';

        $groupId = $_SESSION['current_group_id'];

        // Busca transações com filtro de status
        $transactions = $this->transactionModel->getByMonthAndStatus($groupId, $month, $year, $status);

        $this->view('transacoes/index', [
            'transactions' => $transactions,
            'month' => $month,
            'year' => $year,
            'status' => $status
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
            $paymentMethod = filter_input(INPUT_POST, 'payment_method', FILTER_SANITIZE_STRING);
            $isRecurring = isset($_POST['is_recurring']) && $_POST['is_recurring'] === '1';

            // NÃO CONVERTA AQUI - deixe como string
            $amount = filter_input(INPUT_POST, 'amount', FILTER_SANITIZE_STRING);

            $data = [
                'group_id' => $groupId,
                'user_id' => $_SESSION['user_id'],
                'category_id' => filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT),
                'description' => filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING),
                'amount' => $amount, // Passa como string
                'type' => filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING),
                'transaction_date' => filter_input(INPUT_POST, 'transaction_date', FILTER_SANITIZE_STRING),
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

                if ($installments > 1) {
                    $this->transactionModel->createInstallments($data, $installments);
                    $this->redirect('/transacoes');
                    return;
                }
            }

            // Se for recorrente
            if ($isRecurring) {
                $data['paid'] = 0; // ← ADICIONAR: Garante que inicia como pendente
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
            $amount = filter_input(INPUT_POST, 'amount', FILTER_SANITIZE_STRING);
            $amount = str_replace(['.', ','], ['', '.'], $amount);
            $amount = floatval($amount);

            $data = [
                'category_id' => filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT),
                'description' => filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING),
                'amount' => $amount,
                'transaction_date' => filter_input(INPUT_POST, 'transaction_date', FILTER_SANITIZE_STRING),
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
    }
}
