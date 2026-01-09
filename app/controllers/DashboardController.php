<?php

class DashboardController extends Controller {

    private $groupModel;
    private $transactionModel;
    private $creditCardModel;
    private $benefitCardModel;
    private $goalModel;
    private $userModel;

    public function __construct() {
        $this->requireLogin();

        $this->groupModel = new GroupModel();
        $this->transactionModel = new TransactionModel();
        $this->creditCardModel = new CreditCardModel();
        $this->benefitCardModel = new BenefitCardModel();
        $this->goalModel = new GoalModel();
        $this->userModel = new UserModel();
    }

    public function index() {
        $userId = $_SESSION['user_id'];

        // Buscar grupos do usuário
        $groups = $this->userModel->getUserGroups($userId);

        // Se não tiver grupo, mostra tela de criação
        if (empty($groups)) {
            $this->view('grupos/criar');
            return;
        }

        // Grupo atual
        $currentGroupId = $_SESSION['current_group_id'] ?? $groups[0]['id'];
        $_SESSION['current_group_id'] = $currentGroupId;

        // Dados do grupo atual
        $currentGroup = null;
        foreach ($groups as $group) {
            if ($group['id'] == $currentGroupId) {
                $currentGroup = $group;
                break;
            }
        }

        // Mês e ano (permite trocar via GET)
        $month = $_GET['month'] ?? date('n');
        $year  = $_GET['year']  ?? date('Y');

        // ===== Dados do Dashboard =====
        $balance = $this->transactionModel->getMonthlyBalance($currentGroupId, $month, $year);

        $creditCardTotal = $this->creditCardModel
            ->getCurrentMonthTotal($currentGroupId, $month, $year);

        $creditCards = $this->creditCardModel
            ->getCardsWithCurrentBill($currentGroupId, $month, $year);

        $benefitCards = $this->benefitCardModel
            ->getByGroup($currentGroupId);

        $spendingByCategory = $this->transactionModel
            ->getSpendingByCategory($currentGroupId, $month, $year);

        $monthlyEvolution = $this->transactionModel
            ->getMonthlyEvolution($currentGroupId, 6);

        $transactions = $this->transactionModel
            ->getByGroupAndMonth($currentGroupId, $month, $year);

        $goals = $this->goalModel
            ->getActiveGoals($currentGroupId);

        // Enviar para a view
        $this->view('dashboard/index', [
            'title' => 'Dashboard - Amigo do Bolso',
            'groups' => $groups,
            'currentGroup' => $currentGroup,
            'balance' => $balance,
            'creditCardTotal' => $creditCardTotal,
            'creditCards' => $creditCards,
            'benefitCards' => $benefitCards,
            'spendingByCategory' => $spendingByCategory,
            'monthlyEvolution' => $monthlyEvolution,
            'transactions' => $transactions,
            'goals' => $goals,
            'month' => $month,
            'year' => $year
        ]);
    }

    public function switchGroup($groupId) {
        $userId = $_SESSION['user_id'];

        if ($this->groupModel->isMember($groupId, $userId)) {
            $_SESSION['current_group_id'] = $groupId;
        }

        $this->redirect('/dashboard');
    }
}
