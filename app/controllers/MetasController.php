<?php

class MetasController extends Controller
{
    private $goalModel;

    public function __construct()
    {
        $this->requireLogin();
        $this->goalModel = new GoalModel();
    }

    public function index()
    {
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

    public function criar()
    {
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

    public function addProgress($id)
    {
        $goal = $this->goalModel->findById($id);

        if (!$goal || $goal['group_id'] != $_SESSION['current_group_id']) {
            $this->redirect('/metas');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // NÃO USE filter_input com FILTER_VALIDATE_FLOAT - ele pode causar problemas
            // Pegue o valor direto e converta manualmente
            $amount = isset($_POST['amount']) ? $_POST['amount'] : null;

            if ($amount !== null) {
                // Remove qualquer formatação que possa ter sobrado
                $amount = str_replace(',', '.', $amount);
                $amount = (float)$amount;

                if ($amount > 0) {
                    $this->goalModel->addProgress($id, $amount);
                    $_SESSION['success'] = 'Depósito realizado com sucesso!';
                    $this->redirect('/metas');
                } else {
                    $_SESSION['error'] = 'Valor inválido';
                    $this->redirect('/metas');
                }
            } else {
                $_SESSION['error'] = 'Valor não informado';
                $this->redirect('/metas');
            }
        }
    }

    public function removeProgress($id)
    {
        $goal = $this->goalModel->findById($id);

        if (!$goal || $goal['group_id'] != $_SESSION['current_group_id']) {
            $this->redirect('/metas');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Mesma correção aqui
            $amount = isset($_POST['amount']) ? $_POST['amount'] : null;

            if ($amount !== null) {
                $amount = str_replace(',', '.', $amount);
                $amount = (float)$amount;

                if ($amount > 0 && $amount <= $goal['current_amount']) {
                    $this->goalModel->removeProgress($id, $amount);
                    $_SESSION['success'] = 'Retirada realizada com sucesso!';
                    $this->redirect('/metas');
                } else {
                    $_SESSION['error'] = 'Valor inválido ou maior que o saldo disponível';
                    $this->redirect('/metas');
                }
            } else {
                $_SESSION['error'] = 'Valor não informado';
                $this->redirect('/metas');
            }
        }
    }

    public function deletar($id)
    {
        $goal = $this->goalModel->findById($id);

        if ($goal && $goal['group_id'] == $_SESSION['current_group_id']) {
            $this->goalModel->delete($id);
        }

        $this->redirect('/metas');
    }

    // Adicione no MetasController.php

    public function editar($id)
    {
        $goal = $this->goalModel->findById($id);

        if (!$goal || $goal['group_id'] != $_SESSION['current_group_id']) {
            $this->redirect('/metas');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $targetAmount = filter_input(INPUT_POST, 'target_amount', FILTER_VALIDATE_FLOAT);
            $deadline = filter_input(INPUT_POST, 'deadline', FILTER_SANITIZE_STRING);

            $this->goalModel->update($id, [
                'name' => $name,
                'target_amount' => $targetAmount,
                'deadline' => $deadline
            ]);

            $this->redirect('/metas');
        } else {
            $this->view('metas/editar', ['goal' => $goal]);
        }
    }
}
