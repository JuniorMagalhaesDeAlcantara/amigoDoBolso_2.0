<?php

class AuthController extends Controller {
    private $userModel;
    
    public function __construct() {
        $this->userModel = new UserModel();
    }
    
    public function login() {
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
                
                $this->redirect('/dashboard');
            } else {
                $error = 'Email ou senha incorretos';
                $this->view('auth/login', ['error' => $error]);
            }
        } else {
            $this->view('auth/login');
        }
    }
    
    public function register() {
        // DEBUG
        error_log("AuthController::register() chamado");
        error_log("REQUEST_METHOD: " . $_SERVER['REQUEST_METHOD']);
        
        if ($this->isLoggedIn()) {
            $this->redirect('/dashboard');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            error_log("POST detectado no register");
            
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';
            
            $errors = [];
            
            // Validações
            if (empty($name)) {
                $errors[] = 'Nome é obrigatório';
            }
            
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Email inválido';
            }
            
            if (strlen($password) < 6) {
                $errors[] = 'Senha deve ter no mínimo 6 caracteres';
            }
            
            if ($password !== $confirmPassword) {
                $errors[] = 'As senhas não coincidem';
            }
            
            // Verifica se email já existe
            if (empty($errors) && $this->userModel->findByEmail($email)) {
                $errors[] = 'Email já cadastrado';
            }
            
            if (empty($errors)) {
                $userId = $this->userModel->register($name, $email, $password);
                
                if ($userId) {
                    $_SESSION['user_id'] = $userId;
                    $_SESSION['user_name'] = $name;
                    $_SESSION['user_email'] = $email;
                    
                    $this->redirect('/dashboard');
                } else {
                    $errors[] = 'Erro ao criar conta';
                }
            }
            
            error_log("Erros: " . print_r($errors, true));
            $this->view('auth/register', ['errors' => $errors]);
        } else {
            error_log("GET detectado no register - carregando view");
            $this->view('auth/register');
        }
    }
    
    public function logout() {
        session_destroy();
        $this->redirect('/auth/login');
    }
}