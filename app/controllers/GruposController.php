<?php

class GruposController extends Controller
{
    private $groupModel;

    public function __construct()
    {
        $this->requireLogin();
        $this->groupModel = new GroupModel();
    }

    public function criar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);

            if (empty($name)) {
                $error = 'Nome do grupo é obrigatório';
                $this->view('grupos/criar', ['error' => $error]);
                return;
            }

            $groupId = $this->groupModel->createGroup($name, $_SESSION['user_id']);

            if ($groupId) {
                $_SESSION['current_group_id'] = $groupId;
                $this->redirect('/dashboard');
            } else {
                $error = 'Erro ao criar grupo';
                $this->view('grupos/criar', ['error' => $error]);
            }
        } else {
            $this->view('grupos/criar');
        }
    }

    public function entrar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $inviteCode = strtoupper(filter_input(INPUT_POST, 'invite_code', FILTER_SANITIZE_STRING));

            $group = $this->groupModel->findByInviteCode($inviteCode);

            if (!$group) {
                $error = 'Código de convite inválido';
                $this->view('grupos/entrar', ['error' => $error]);
                return;
            }

            // Verifica se já é membro
            if ($this->groupModel->isMember($group['id'], $_SESSION['user_id'])) {
                $_SESSION['current_group_id'] = $group['id'];
                $this->redirect('/dashboard');
                return;
            }

            // Adiciona como membro
            if ($this->groupModel->addMember($group['id'], $_SESSION['user_id'])) {
                $_SESSION['current_group_id'] = $group['id'];
                $this->redirect('/dashboard');
            } else {
                $error = 'Erro ao entrar no grupo';
                $this->view('grupos/entrar', ['error' => $error]);
            }
        } else {
            $this->view('grupos/entrar');
        }
    }

    public function detalhes()
    {
        $groupId = $_SESSION['current_group_id'] ?? null;

        if (!$groupId) {
            $this->redirect('/dashboard');
            return;
        }

        $group = $this->groupModel->findById($groupId);
        $members = $this->groupModel->getMembers($groupId);

        $this->view('grupos/detalhes', [
            'group' => $group,
            'members' => $members
        ]);
    }

    // Adicione este método no GroupController.php

    public function trocar($groupId)
    {
        // Verifica se o usuário pertence ao grupo
        $isMember = $this->groupModel->getMembers($_SESSION['user_id'], $groupId);

        if (!$isMember) {
            $_SESSION['error'] = 'Você não pertence a este grupo!';
            $this->redirect('/dashboard');
            return;
        }

        // Atualiza o grupo atual na sessão
        $_SESSION['current_group_id'] = $groupId;

        // Busca informações do grupo para mensagem
        $group = $this->groupModel->findById($groupId);
        $_SESSION['success'] = 'Você está agora navegando no grupo: ' . htmlspecialchars($group['name']);

        // Redireciona para o dashboard
        $this->redirect('/dashboard');
    }

    // GroupController.php
    public function selecionar()
    {
        $groups = $this->groupModel->getUserGroups($_SESSION['user_id']);
        $this->view('grupos/selecionar', ['groups' => $groups]);
    }
}
