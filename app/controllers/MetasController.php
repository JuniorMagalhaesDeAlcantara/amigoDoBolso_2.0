<?php

class MetasController extends Controller {
    private $goalModel;
    
    public function __construct() {
        $this->requireLogin();
        $this->goalModel = new GoalModel();
    }
    
    public function index() {
        $groupId = $_SESSION['current_group_id'] ?? null;
        
        if (!$groupId) {
            $this->redirect('/dashboard');
            return;
        }
        
        $goals = $this->goalModel->getByGroup($groupId);
        
        // Calcula progresso de cada meta
        foreach ($goals as &$goal) {
            $goal['progress'] = $this->goalModel->getProgress($goal['id']);
        }
        
        $this->view('metas/index', ['goals' => $goals]);
    }
    
    public function criar() {
        $groupId = $_SESSION['current_group_id'] ?? null;
        
        if (!$groupId) {
            $this->redirect('/dashboard');
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $targetAmount = filter_input(INPUT_POST, 'target_amount', FILTER_VALIDATE_FLOAT);
            $deadline = filter_input(INPUT_POST, 'deadline', FILTER_SANITIZE_STRING);
            
            $this->goalModel->createGoal($groupId, $name, $targetAmount, $deadline);
            $this->redirect('/metas');
        } else {
            $this->view('metas/criar');
        }
    }
    
    public function addProgress($id) {
        $goal = $this->goalModel->findById($id);
        
        if (!$goal || $goal['group_id'] != $_SESSION['current_group_id']) {
            $this->redirect('/metas');
            return;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $amount = filter_input(INPUT_POST, 'amount', FILTER_VALIDATE_FLOAT);
            $this->goalModel->addProgress($id, $amount);
            $this->redirect('/metas');
        }
    }
    
    public function deletar($id) {
        $goal = $this->goalModel->findById($id);
        
        if ($goal && $goal['group_id'] == $_SESSION['current_group_id']) {
            $this->goalModel->delete($id);
        }
        
        $this->redirect('/metas');
    }
}
