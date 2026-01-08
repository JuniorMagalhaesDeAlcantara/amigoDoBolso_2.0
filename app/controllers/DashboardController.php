<?php

class DashboardController extends Controller {
    private $groupModel;
    private $transactionModel;
    private $goalModel;
    
    public function __construct() {
        $this->requireLogin();
        $this->groupModel = new GroupModel();
        $this->transactionModel = new TransactionModel();
        $this->goalModel = new GoalModel();
    }
    
    public function index() {
        $userId = $_SESSION['user_id'];
        $groups = $this->groupModel->getUserGroups($userId);
        
        // Se não tem grupo, redireciona para criar
        if (empty($groups)) {
            $this->redirect('/grupos/criar');
        }
        
        // Pega o primeiro grupo (ou o selecionado na sessão)
        $currentGroupId = $_SESSION['current_group_id'] ?? $groups[0]['id'];
        $_SESSION['current_group_id'] = $currentGroupId;
        
        $currentGroup = null;
        foreach ($groups as $group) {
            if ($group['id'] == $currentGroupId) {
                $currentGroup = $group;
                break;
            }
        }
        
        // Dados do mês atual
        $month = date('n');
        $year = date('Y');
        
        $balance = $this->transactionModel->getMonthlyBalance($currentGroupId, $month, $year);
        $transactions = $this->transactionModel->getByGroup($currentGroupId, $month, $year);
        $spendingByCategory = $this->transactionModel->getSpendingByCategory($currentGroupId, $month, $year);
        $goals = $this->goalModel->getByGroup($currentGroupId, 'em_andamento');
        
        $data = [
            'groups' => $groups,
            'currentGroup' => $currentGroup,
            'balance' => $balance,
            'transactions' => $transactions,
            'spendingByCategory' => $spendingByCategory,
            'goals' => $goals,
            'month' => $month,
            'year' => $year
        ];
        
        $this->view('dashboard/index', $data);
    }
    
    public function switchGroup($groupId) {
        $userId = $_SESSION['user_id'];
        
        // Verifica se o usuário é membro do grupo
        if ($this->groupModel->isMember($groupId, $userId)) {
            $_SESSION['current_group_id'] = $groupId;
        }
        
        $this->redirect('/dashboard');
    }
}
