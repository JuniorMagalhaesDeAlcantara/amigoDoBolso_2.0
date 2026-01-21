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

    /**
     * Editar Grupo
     */
    public function editar($groupId = null)
    {
        if (!$groupId) {
            $_SESSION['error'] = 'ID do grupo não fornecido!';
            $this->redirect('/grupos/detalhes');
            return;
        }

        $group = $this->groupModel->findById($groupId);

        // Verifica se o grupo existe
        if (!$group) {
            $_SESSION['error'] = 'Grupo não encontrado!';
            $this->redirect('/grupos/detalhes');
            return;
        }

        // Verifica se é o dono do grupo
        if ($group['owner_id'] != $_SESSION['user_id']) {
            $_SESSION['error'] = 'Apenas o dono do grupo pode editá-lo!';
            $this->redirect('/grupos/detalhes');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING));

            if (empty($name)) {
                $error = 'Nome do grupo é obrigatório';
                $this->view('grupos/editar', [
                    'group' => $group,
                    'error' => $error
                ]);
                return;
            }

            if (strlen($name) < 3) {
                $error = 'O nome do grupo deve ter pelo menos 3 caracteres';
                $this->view('grupos/editar', [
                    'group' => $group,
                    'error' => $error
                ]);
                return;
            }

            $success = $this->groupModel->update($groupId, [
                'name' => $name
            ]);

            if ($success) {
                $_SESSION['success'] = 'Grupo atualizado com sucesso!';
                $this->redirect('/grupos/detalhes');
            } else {
                $error = 'Erro ao atualizar grupo';
                $this->view('grupos/editar', [
                    'group' => $group,
                    'error' => $error
                ]);
            }
        } else {
            $this->view('grupos/editar', ['group' => $group]);
        }
    }

    /**
     * Deletar Grupo
     */
    public function deletar($groupId = null)
    {
        if (!$groupId) {
            $_SESSION['error'] = 'ID do grupo não fornecido!';
            $this->redirect('/grupos/detalhes');
            return;
        }

        $group = $this->groupModel->findById($groupId);

        // Verifica se o grupo existe
        if (!$group) {
            $_SESSION['error'] = 'Grupo não encontrado!';
            $this->redirect('/grupos/detalhes');
            return;
        }

        // Verifica se é o dono do grupo
        if ($group['owner_id'] != $_SESSION['user_id']) {
            $_SESSION['error'] = 'Apenas o dono do grupo pode deletá-lo!';
            $this->redirect('/grupos/detalhes');
            return;
        }

        // Verifica quantos membros o grupo tem
        $members = $this->groupModel->getMembers($groupId);

        if (count($members) > 1) {
            $_SESSION['error'] = 'Não é possível deletar um grupo com outros membros! Remova todos os membros primeiro.';
            $this->redirect('/grupos/detalhes');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $confirmation = strtoupper(trim(filter_input(INPUT_POST, 'confirm_delete', FILTER_SANITIZE_STRING)));

            if ($confirmation !== 'DELETAR') {
                $error = 'Digite "DELETAR" para confirmar a exclusão';
                $this->view('grupos/deletar', [
                    'group' => $group,
                    'members' => $members,
                    'error' => $error
                ]);
                return;
            }

            // Deleta membros primeiro (chave estrangeira)
            $this->groupModel->removeAllMembers($groupId);

            // Deleta o grupo
            $success = $this->groupModel->delete($groupId);

            if ($success) {
                // Se era o grupo atual, remove da sessão
                if (isset($_SESSION['current_group_id']) && $_SESSION['current_group_id'] == $groupId) {
                    unset($_SESSION['current_group_id']);
                }

                $_SESSION['success'] = 'Grupo deletado com sucesso!';

                // Busca outros grupos do usuário
                $userGroups = $this->groupModel->getUserGroups($_SESSION['user_id']);

                if (!empty($userGroups)) {
                    // Define o primeiro grupo como atual
                    $_SESSION['current_group_id'] = $userGroups[0]['id'];
                    $this->redirect('/dashboard');
                } else {
                    // Não tem mais grupos, redireciona para criar/entrar
                    $this->redirect('/grupos/selecionar');
                }
            } else {
                $error = 'Erro ao deletar grupo';
                $this->view('grupos/deletar', [
                    'group' => $group,
                    'members' => $members,
                    'error' => $error
                ]);
            }
        } else {
            $this->view('grupos/deletar', [
                'group' => $group,
                'members' => $members
            ]);
        }
    }

    /**
     * Sair do Grupo (não deleta, só remove o membro)
     */
    public function sair($groupId = null)
    {
        if (!$groupId) {
            $_SESSION['error'] = 'ID do grupo não fornecido!';
            $this->redirect('/grupos/detalhes');
            return;
        }

        $group = $this->groupModel->findById($groupId);

        if (!$group) {
            $_SESSION['error'] = 'Grupo não encontrado!';
            $this->redirect('/grupos/detalhes');
            return;
        }

        // Não pode sair se for o dono
        if ($group['owner_id'] == $_SESSION['user_id']) {
            $_SESSION['error'] = 'O dono do grupo não pode sair! Delete o grupo ou transfira a propriedade primeiro.';
            $this->redirect('/grupos/detalhes');
            return;
        }

        // Verifica se é membro
        if (!$this->groupModel->isMember($groupId, $_SESSION['user_id'])) {
            $_SESSION['error'] = 'Você não pertence a este grupo!';
            $this->redirect('/dashboard');
            return;
        }

        // Remove o membro
        $success = $this->groupModel->removeMember($groupId, $_SESSION['user_id']);

        if ($success) {
            // Se era o grupo atual, limpa da sessão
            if (isset($_SESSION['current_group_id']) && $_SESSION['current_group_id'] == $groupId) {
                unset($_SESSION['current_group_id']);
            }

            $_SESSION['success'] = 'Você saiu do grupo com sucesso!';

            // Busca outros grupos
            $userGroups = $this->groupModel->getUserGroups($_SESSION['user_id']);

            if (!empty($userGroups)) {
                $_SESSION['current_group_id'] = $userGroups[0]['id'];
                $this->redirect('/dashboard');
            } else {
                $this->redirect('/grupos/selecionar');
            }
        } else {
            $_SESSION['error'] = 'Erro ao sair do grupo!';
            $this->redirect('/grupos/detalhes');
        }
    }
}
