<?php

class CartoesController extends Controller {
    private $creditCardModel;
    
    public function __construct() {
        $this->requireLogin();
        $this->creditCardModel = new CreditCardModel();
    }
    
    public function index() {
        $groupId = $_SESSION['current_group_id'] ?? null;
        
        if (!$groupId) {
            $this->redirect('/dashboard');
            return;
        }
        
        $cards = $this->creditCardModel->getByGroup($groupId);
        $this->view('cartoes/index', ['cards' => $cards]);
    }
    
    public function criar() {
        $groupId = $_SESSION['current_group_id'] ?? null;
        
        if (!$groupId) {
            $this->redirect('/dashboard');
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'group_id' => $groupId,
                'name' => filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING),
                'last_digits' => filter_input(INPUT_POST, 'last_digits', FILTER_SANITIZE_STRING),
                'closing_day' => filter_input(INPUT_POST, 'closing_day', FILTER_VALIDATE_INT),
                'due_day' => filter_input(INPUT_POST, 'due_day', FILTER_VALIDATE_INT),
                'credit_limit' => filter_input(INPUT_POST, 'credit_limit', FILTER_VALIDATE_FLOAT)
            ];
            
            $this->creditCardModel->create($data);
            $this->redirect('/cartoes');
        } else {
            $this->view('cartoes/criar');
        }
    }
    
    public function deletar($id) {
        $card = $this->creditCardModel->findById($id);
        
        if ($card && $card['group_id'] == $_SESSION['current_group_id']) {
            $this->creditCardModel->delete($id);
        }
        
        $this->redirect('/cartoes');
    }
}
