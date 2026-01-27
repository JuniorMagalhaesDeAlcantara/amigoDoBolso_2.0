<?php

require_once __DIR__ . '/../helpers/EmailHelper.php';

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
            $confirmPassword = $_POST['password_confirm'] ?? '';

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

    public function forgotPassword()
    {
        if ($this->isLoggedIn()) {
            $this->redirect('/dashboard');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

            if (empty($email)) {
                $this->view('auth/forgot-password', [
                    'error' => 'Por favor, digite seu email'
                ]);
                return;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->view('auth/forgot-password', [
                    'error' => 'Email inválido'
                ]);
                return;
            }

            // Verifica se usuário existe
            $user = $this->userModel->findByEmail($email);

            if (!$user) {
                // Por segurança, não revela se o email existe ou não
                $this->view('auth/forgot-password', [
                    'success' => 'Se o email estiver cadastrado, você receberá um link para redefinir sua senha em breve.'
                ]);
                return;
            }

            // Gera token de recuperação
            $token = bin2hex(random_bytes(32));
            $expiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

            // Salva token no banco
            $saved = $this->userModel->createPasswordResetToken($user['id'], $token, $expiry);

            if ($saved) {
                // Envia email
                $resetLink = $this->getBaseUrl() . '/auth/reset-password?token=' . $token;
                $sent = $this->sendPasswordResetEmail($email, $user['name'], $resetLink);

                if ($sent) {
                    $this->view('auth/forgot-password', [
                        'success' => 'Um link para redefinir sua senha foi enviado para seu email. Verifique sua caixa de entrada.'
                    ]);
                } else {
                    error_log("Erro ao enviar email de recuperação para: {$email}");
                    $this->view('auth/forgot-password', [
                        'error' => 'Erro ao enviar email. Tente novamente mais tarde.'
                    ]);
                }
            } else {
                $this->view('auth/forgot-password', [
                    'error' => 'Erro ao processar solicitação. Tente novamente.'
                ]);
            }
        } else {
            $this->view('auth/forgot-password');
        }
    }

    /**
     * Retorna a URL base da aplicação
     */
    private function getBaseUrl()
    {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'amigodobolso.jmadev.com.br';
        return "{$protocol}://{$host}";
    }

    public function resetPassword()
    {
        if ($this->isLoggedIn()) {
            $this->redirect('/dashboard');
        }

        $token = $_GET['token'] ?? $_POST['token'] ?? null;

        if (!$token) {
            $_SESSION['error'] = 'Token inválido ou expirado';
            $this->redirect('/auth/forgot-password');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['password_confirm'] ?? '';

            // Validações
            if (empty($password) || empty($confirmPassword)) {
                $this->view('auth/reset-password', [
                    'error' => 'Todos os campos são obrigatórios',
                    'token' => $token
                ]);
                return;
            }

            if ($password !== $confirmPassword) {
                $this->view('auth/reset-password', [
                    'error' => 'As senhas não coincidem',
                    'token' => $token
                ]);
                return;
            }

            if (strlen($password) < 6) {
                $this->view('auth/reset-password', [
                    'error' => 'A senha deve ter no mínimo 6 caracteres',
                    'token' => $token
                ]);
                return;
            }

            // Valida token
            $resetData = $this->userModel->validatePasswordResetToken($token);

            if (!$resetData) {
                $_SESSION['error'] = 'Token inválido ou expirado. Solicite um novo link.';
                $this->redirect('/auth/forgot-password');
                return;
            }

            // Atualiza senha
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $updated = $this->userModel->updatePassword($resetData['user_id'], $hashedPassword);

            if ($updated) {
                // Remove token usado
                $this->userModel->deletePasswordResetToken($token);

                $_SESSION['success'] = 'Senha redefinida com sucesso! Faça login com sua nova senha.';
                $this->redirect('/auth/login');
            } else {
                $this->view('auth/reset-password', [
                    'error' => 'Erro ao redefinir senha. Tente novamente.',
                    'token' => $token
                ]);
            }
        } else {
            // Valida token antes de mostrar o formulário
            $resetData = $this->userModel->validatePasswordResetToken($token);

            if (!$resetData) {
                $_SESSION['error'] = 'Token inválido ou expirado. Solicite um novo link.';
                $this->redirect('/auth/forgot-password');
                return;
            }

            $this->view('auth/reset-password', ['token' => $token]);
        }
    }

    private function sendPasswordResetEmail($email, $name, $resetLink)
    {
        $subject = '🔑 Recuperação de Senha - Amigo do Bolso';

        $message = "
        <h2 style='color: #667eea;'>🔑 Recuperação de Senha</h2>
        
        <p>Olá, <strong>{$name}</strong>!</p>
        
        <p>Recebemos uma solicitação para redefinir a senha da sua conta no Amigo do Bolso.</p>
        
        <p>Para criar uma nova senha, clique no botão abaixo:</p>
        
        <div style='text-align: center; margin: 30px 0;'>
            <a href='{$resetLink}' style='display: inline-block; padding: 15px 30px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-decoration: none; border-radius: 8px; font-weight: 600;'>
                Redefinir Senha
            </a>
        </div>
        
        <p style='font-size: 14px; color: #6b7280;'>Ou copie e cole este link no seu navegador:</p>
        <p style='word-break: break-all; background: #f9fafb; padding: 10px; border-radius: 5px; font-size: 13px; color: #4b5563;'>
            {$resetLink}
        </p>
        
        <div style='background: #fef2f2; padding: 15px; border-radius: 8px; border-left: 4px solid #ef4444; margin: 20px 0;'>
            <p style='margin: 0 0 10px 0; color: #991b1b; font-weight: 600;'>⚠️ Importante:</p>
            <ul style='margin: 10px 0; padding-left: 20px; color: #991b1b;'>
                <li>Este link expira em 1 hora</li>
                <li>Se você não solicitou esta redefinição, ignore este email</li>
                <li>Nunca compartilhe este link com outras pessoas</li>
            </ul>
        </div>
        
        <p style='color: #6b7280;'>Se você tiver alguma dúvida ou precisar de ajuda, entre em contato conosco.</p>
    ";

        // Usa EmailHelper ao invés de mail() nativo
        return EmailHelper::send($email, $subject, $message, $name);
    }

    public function logout()
    {
        session_destroy();
        $this->redirect('/auth/login');
    }
}
