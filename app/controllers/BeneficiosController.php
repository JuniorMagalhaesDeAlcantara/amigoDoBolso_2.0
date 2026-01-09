<?php

class BeneficiosController extends Controller
{
    private $benefitCardModel;
    private $transactionModel;

    public function __construct()
    {
        $this->benefitCardModel = new BenefitCardModel();
        $this->transactionModel = new TransactionModel();
    }
    /**
     * Lista todos os benefícios (VR/VA)
     */
    public function index()
    {
        $this->requireLogin();

        $groupId = $_SESSION['current_group_id'] ?? null;

        if (!$groupId) {
            $this->redirect('/dashboard');
            return;
        }

        // Verifica recargas pendentes
        $this->benefitCardModel->checkPendingRecharges($groupId);

        // Busca todos os benefícios
        $benefits = $this->benefitCardModel->getByGroup($groupId);

        // Calcula estatísticas para cada benefício
        foreach ($benefits as &$benefit) {
            $benefit['monthly_expense'] = $this->benefitCardModel->getMonthlyExpense($benefit['id']);
            $benefit['percent_used'] = $benefit['monthly_amount'] > 0
                ? ($benefit['monthly_expense'] / $benefit['monthly_amount']) * 100
                : 0;
        }

        $this->view('beneficios/index', [
            'benefits' => $benefits
        ]);
    }

    /**
     * Formulário para criar novo benefício
     */
    public function criar()
    {
        $groupId = $_SESSION['current_group_id'] ?? null;

        if (!$groupId) {
            $this->redirect('/dashboard');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Valor mensal
            $monthlyAmount = filter_input(INPUT_POST, 'monthly_amount', FILTER_SANITIZE_STRING);
            $monthlyAmount = $monthlyAmount
                ? floatval(str_replace(',', '.', $monthlyAmount))
                : 0;

            // Saldo atual
            $initialBalance = filter_input(INPUT_POST, 'initial_balance', FILTER_SANITIZE_STRING);
            $initialBalance = $initialBalance
                ? floatval(str_replace(',', '.', $initialBalance))
                : 0;

            // Dia da recarga
            $rechargeDay = filter_input(INPUT_POST, 'recharge_day', FILTER_VALIDATE_INT);

            // Decide last_recharge_date
            $today = (int)date('j'); // dia do mês atual
            if ($today > $rechargeDay) {
                // Dia da recarga já passou => primeira recarga só no próximo mês
                $lastRechargeDate = date('Y-m-d'); // marca como recarregado
                // saldo inicial NÃO inclui mensal
            } else {
                // Dia da recarga ainda não chegou => saldo inicial NÃO inclui mensal
                $lastRechargeDate = null; // ainda não recarregou
            }

            $data = [
                'group_id'           => $groupId,
                'type'               => filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING),
                'provider'           => filter_input(INPUT_POST, 'provider', FILTER_SANITIZE_STRING),
                'name'               => filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING),
                'monthly_amount'     => $monthlyAmount,
                'current_balance'    => $initialBalance, // apenas o saldo que o usuário informou
                'recharge_day'       => $rechargeDay,
                'last_recharge_date' => $lastRechargeDate
            ];

            $this->benefitCardModel->create($data);

            $this->redirect('/beneficios');
        } else {
            $this->view('beneficios/criar');
        }
    }

    /**
     * Página de detalhes e histórico do benefício
     */
    public function detalhes($id)
    {
        $groupId = $_SESSION['current_group_id'] ?? null;

        if (!$groupId) {
            $this->redirect('/dashboard');
            return;
        }

        $benefit = $this->benefitCardModel->findById($id);

        if (!$benefit || $benefit['group_id'] != $groupId) {
            $this->redirect('/beneficios');
            return;
        }

        // Busca transações do mês atual
        $month = $_GET['month'] ?? date('n');
        $year = $_GET['year'] ?? date('Y');

        $transactions = $this->transactionModel->getByBenefit($id, $month, $year);

        // Calcula gasto do mês
        $monthlyExpense = $this->benefitCardModel->getMonthlyExpense($id);

        // Busca histórico de recargas
        $rechargeHistory = $this->benefitCardModel->getRechargeHistory($id);

        $this->view('beneficios/detalhes', [
            'benefit' => $benefit,
            'transactions' => $transactions,
            'monthlyExpense' => $monthlyExpense,
            'rechargeHistory' => $rechargeHistory,
            'month' => $month,
            'year' => $year
        ]);
    }

    /**
     * Deletar benefício
     */
    public function deletar($id)
    {
        $benefit = $this->benefitCardModel->findById($id);

        if ($benefit && $benefit['group_id'] == $_SESSION['current_group_id']) {
            $this->benefitCardModel->delete($id);
        }

        $this->redirect('/beneficios');
    }

    /**
     * Editar benefício
     */
    public function editar($id)
    {
        $groupId = $_SESSION['current_group_id'] ?? null;

        if (!$groupId) {
            $this->redirect('/dashboard');
            return;
        }

        $benefit = $this->benefitCardModel->findById($id);

        if (!$benefit || $benefit['group_id'] != $groupId) {
            $this->redirect('/beneficios');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $monthlyAmount = filter_input(INPUT_POST, 'monthly_amount', FILTER_SANITIZE_STRING);
            if ($monthlyAmount) {
                $monthlyAmount = trim($monthlyAmount);
                $monthlyAmount = !empty($monthlyAmount) ? floatval($monthlyAmount) : 0;
            }

            $data = [
                'type' => filter_input(INPUT_POST, 'type', FILTER_SANITIZE_STRING),
                'provider' => filter_input(INPUT_POST, 'provider', FILTER_SANITIZE_STRING),
                'name' => filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING),
                'monthly_amount' => $monthlyAmount,
                'recharge_day' => filter_input(INPUT_POST, 'recharge_day', FILTER_VALIDATE_INT)
            ];

            $this->benefitCardModel->update($id, $data);
            $this->redirect('/beneficios/detalhes/' . $id);
        } else {
            $this->view('beneficios/editar', [
                'benefit' => $benefit
            ]);
        }
    }

    /**
     * Recarga manual (caso queira adicionar saldo extra)
     */
    public function recarregar($id)
    {
        $groupId = $_SESSION['current_group_id'] ?? null;
        $benefit = $this->benefitCardModel->findById($id);

        if (!$benefit || $benefit['group_id'] != $groupId) {
            $this->redirect('/beneficios');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $amount = filter_input(INPUT_POST, 'amount', FILTER_SANITIZE_STRING);
            $amount = floatval($amount);

            if ($amount > 0) {
                $this->benefitCardModel->credit($id, $amount);
                $this->benefitCardModel->recordRecharge($id, $amount);
            }

            $this->redirect('/beneficios/detalhes/' . $id);
        } else {
            $this->view('beneficios/recarregar', [
                'benefit' => $benefit
            ]);
        }
    }
}
