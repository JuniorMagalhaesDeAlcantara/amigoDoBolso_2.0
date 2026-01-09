<?php

class TransacoesController extends Controller
{
    private $transactionModel;
    private $categoryModel;
    private $creditCardModel;

    public function __construct()
    {
        $this->requireLogin();
        $this->transactionModel = new TransactionModel();
        $this->categoryModel = new CategoryModel();
        $this->creditCardModel = new CreditCardModel();
    }

    public function index()
    {
        $groupId = $_SESSION['current_group_id'] ?? null;

        if (!$groupId) {
            $this->redirect('/dashboard');
            return;
        }

        $month = $_GET['month'] ?? date('n');
        $year = $_GET['year'] ?? date('Y');

        $transactions = $this->transactionModel->getByGroup($groupId, $month, $year);
        $categories = $this->categoryModel->getByGroup($groupId);

        $this->view('transacoes/index', [
            'transactions' => $transactions,
            'categories' => $categories,
            'month' => $month,
            'year' => $year
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

            // Se for cartão de crédito
            if ($paymentMethod === 'cartao_credito') {
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
                $recurrenceMonths = filter_input(INPUT_POST, 'recurrence_months', FILTER_VALIDATE_INT) ?? 1;
                $this->transactionModel->createRecurring($data, $recurrenceMonths);
            } else {
                $this->transactionModel->create($data);
            }

            $this->redirect('/transacoes');
        } else {
            $categories = $this->categoryModel->getByGroup($groupId);
            $creditCards = $this->creditCardModel->getByGroup($groupId);

            $this->view('transacoes/criar', [
                'categories' => $categories,
                'creditCards' => $creditCards
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

            if ($hasRelated && $deleteAll) {
                $this->transactionModel->deleteWithRelated($id, true);
            } else {
                $this->transactionModel->delete($id);
            }

            $this->redirect('/transacoes');
            return;
        }

        // Se tem relacionadas, mostra página de confirmação
        if ($hasRelated) {
            $related = $this->transactionModel->getRelatedTransactions($id);
            $this->view('transacoes/confirmar-delete', [
                'transaction' => $transaction,
                'related' => $related
            ]);
        } else {
            // Se não tem relacionadas, deleta direto
            $this->transactionModel->delete($id);
            $this->redirect('/transacoes');
        }
    }
}
