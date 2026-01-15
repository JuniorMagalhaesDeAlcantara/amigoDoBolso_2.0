<?php

class AuthController extends Controller
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function login()
    {
        // DEBUG
        error_log("AuthController::login() chamado");

        if ($this->isLoggedIn()) {
            $this->redirect('/dashboard');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';

            $user = $this->userModel->verifyPassword($email, $password);

            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];

                // Verifica grupos do usuário
                $groupModel = new GroupModel();
                $groups = $groupModel->getUserGroups($user['id']);

                if (empty($groups)) {
                    // Sem grupos - redireciona para criar
                    $_SESSION['info'] = 'Crie seu primeiro grupo para começar!';
                    $this->redirect('/grupos/criar');
                } elseif (count($groups) == 1) {
                    // Apenas 1 grupo - seleciona automaticamente
                    $_SESSION['current_group_id'] = $groups[0]['id'];
                    $_SESSION['success'] = 'Bem-vindo de volta, ' . $user['name'] . '!';
                    $this->redirect('/dashboard');
                } else {
                    // Múltiplos grupos - deixa usuário escolher
                    $_SESSION['info'] = 'Selecione o grupo que deseja acessar';
                    $this->redirect('/grupos/selecionar');
                }
            } else {
                $error = 'Email ou senha incorretos';
                $this->view('auth/login', ['error' => $error]);
            }
        } else {
            $this->view('auth/login');
        }
    }

    public function register()
    {
        if ($this->isLoggedIn()) {
            $this->redirect('/dashboard');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $name  = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['password_confirm'] ?? ''; // 👈 AJUSTE AQUI

            // Validações
            if ($name === '' || $email === '' || $password === '' || $confirmPassword === '') {
                $this->view('auth/register', [
                    'error' => 'Todos os campos são obrigatórios'
                ]);
                return;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->view('auth/register', [
                    'error' => 'Email inválido'
                ]);
                return;
            }

            if ($password !== $confirmPassword) {
                $this->view('auth/register', [
                    'error' => 'As senhas não coincidem'
                ]);
                return;
            }

            if (strlen($password) < 6) {
                $this->view('auth/register', [
                    'error' => 'A senha deve ter no mínimo 6 caracteres'
                ]);
                return;
            }

            // Verifica se email já existe
            if ($this->userModel->findByEmail($email)) {
                $this->view('auth/register', [
                    'error' => 'Este email já está cadastrado'
                ]);
                return;
            }

            // Cria usuário
            $userId = $this->userModel->create([
                'name'     => $name,
                'email'    => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT)
            ]);

            if ($userId) {
                $_SESSION['user_id']    = $userId;
                $_SESSION['user_name']  = $name;
                $_SESSION['user_email'] = $email;

                $this->redirect('/grupos/criar');
                return;
            }

            $this->view('auth/register', [
                'error' => 'Erro ao criar usuário'
            ]);
            return;
        }

        $this->view('auth/register');
    }

    public function logout()
    {
        session_destroy();
        $this->redirect('/auth/login');
    }
}
