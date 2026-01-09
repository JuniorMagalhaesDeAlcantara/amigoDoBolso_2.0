<?php

class TransacoesController extends Controller {
    private $transactionModel;
    private $categoryModel;
    private $creditCardModel;
    
    public function __construct() {
        $this->requireLogin();
        $this->transactionModel = new TransactionModel();
        $this->categoryModel = new CategoryModel();
        $this->creditCardModel = new CreditCardModel();
    }
    
    public function index() {
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
    
    public function criar() {
        $groupId = $_SESSION['current_group_id'] ?? null;
        
        if (!$groupId) {
            $this->redirect('/dashboard');
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $paymentMethod = filter_input(INPUT_POST, 'payment_method', FILTER_SANITIZE_STRING);
            $isRecurring = isset($_POST['is_recurring']) && $_POST['is_recurring'] === '1';
            
            $data = [
                'group_id' => $groupId,
                'user_id' => $_SESSION['user_id'],
                'category_id' => filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT),
                'description' => filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING),
                'amount' => filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_FLOAT),
                'type' => filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING),
                'transaction_date' => filter_input(INPUT_POST, 'transaction_date', FILTER_SANITIZE_STRING),
                'payment_method' => $paymentMethod
            ];
            
            // Se for cartão de crédito
            if ($paymentMethod === 'cartao_credito') {
                $data['credit_card_id'] = filter_input(INPUT_POST, 'credit_card_id', FILTER_VALIDATE_INT);
                $installments = filter_input(INPUT_POST, 'installments', FILTER_VALIDATE_INT) ?? 1;
                
                if ($installments > 1) {
                    // Cria transações parceladas
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
                // Transação única
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
    
    public function editar($id) {
        $transaction = $this->transactionModel->findById($id);
        
        if (!$transaction || $transaction['group_id'] != $_SESSION['current_group_id']) {
            $this->redirect('/transacoes');
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'category_id' => filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT),
                'description' => filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING),
                'amount' => filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_FLOAT),
                'transaction_date' => filter_input(INPUT_POST, 'transaction_date', FILTER_SANITIZE_STRING),
            ];
            
            $this->transactionModel->update($id, $data);
            $this->redirect('/transacoes');
        } else {
            $categories = $this->categoryModel->getByGroup($transaction['group_id']);
            $this->view('transacoes/editar', [
                'transaction' => $transaction,
                'categories' => $categories
            ]);
        }
    }
    
    public function deletar($id) {
        $transaction = $this->transactionModel->findById($id);
        
        if ($transaction && $transaction['group_id'] == $_SESSION['current_group_id']) {
            $this->transactionModel->delete($id);
        }
        
        $this->redirect('/transacoes');
    }
}
