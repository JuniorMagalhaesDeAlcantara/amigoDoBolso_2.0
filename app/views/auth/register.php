<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Amigo do Bolso</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            min-height: 100vh;
            display: flex;
            overflow: hidden;
        }

        /* Left Side - Logo e Branding */
        .register-left {
            flex: 1;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 60px;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .register-left::before {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            top: -150px;
            right: -150px;
        }

        .register-left::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 50%;
            bottom: -100px;
            left: -100px;
        }

        .logo-container {
            position: relative;
            z-index: 1;
            text-align: center;
            max-width: 500px;
        }

        .logo {
            width: 420px;
            height: auto;
            margin-bottom: 0px;
            filter: drop-shadow(0 8px 24px rgba(0, 0, 0, 0.2));
        }

        .brand-description {
            font-size: 1.0625rem;
            line-height: 1.6;
            opacity: 0.92;
            margin-bottom: 40px;
        }

        .benefits-list {
            display: grid;
            grid-template-columns: 1fr;
            gap: 14px;
            text-align: left;
        }

        .benefit-item {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.9375rem;
            opacity: 0.88;
        }

        .benefit-item::before {
            content: '✓';
            display: flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            font-weight: 700;
            font-size: 0.875rem;
            flex-shrink: 0;
        }

        /* Right Side - Form */
        .register-right {
            flex: 1;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px 40px;
            overflow-y: auto;
        }

        .register-form {
            width: 100%;
            max-width: 480px;
            padding: 20px 0;
        }

        .form-header {
            margin-bottom: 36px;
        }

        .form-header h2 {
            font-size: 2rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 8px;
        }

        .form-header p {
            color: #6b7280;
            font-size: 1rem;
        }

        .alert {
            background: #fef2f2;
            border-left: 4px solid #ef4444;
            padding: 14px 16px;
            margin-bottom: 24px;
            border-radius: 8px;
            color: #991b1b;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .alert::before {
            content: '⚠️';
            font-size: 1.125rem;
        }

        .alert-success {
            background: #f0fdf4;
            border-left-color: #22c55e;
            color: #166534;
        }

        .alert-success::before {
            content: '✓';
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            color: #374151;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 8px;
        }

        label .required {
            color: #ef4444;
            margin-left: 2px;
        }

        input, select {
            width: 100%;
            padding: 13px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 0.9375rem;
            background: white;
            transition: all 0.2s;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        input::placeholder {
            color: #9ca3af;
        }

        .password-wrapper {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #9ca3af;
            cursor: pointer;
            padding: 6px;
            display: flex;
            align-items: center;
            transition: color 0.2s;
        }

        .toggle-password:hover {
            color: #667eea;
        }

        .password-strength {
            margin-top: 8px;
            font-size: 0.8125rem;
        }

        .strength-bar {
            height: 4px;
            background: #e5e7eb;
            border-radius: 2px;
            margin-top: 6px;
            overflow: hidden;
        }

        .strength-fill {
            height: 100%;
            width: 0%;
            transition: all 0.3s;
            border-radius: 2px;
        }

        .strength-weak { width: 33%; background: #ef4444; }
        .strength-medium { width: 66%; background: #f59e0b; }
        .strength-strong { width: 100%; background: #22c55e; }

        .helper-text {
            display: block;
            font-size: 0.8125rem;
            color: #6b7280;
            margin-top: 6px;
        }

        .btn-submit {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 12px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(102, 126, 234, 0.35);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .form-footer {
            text-align: center;
            margin-top: 32px;
            padding-top: 28px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 0.875rem;
        }

        .form-footer a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }

        .form-footer a:hover {
            color: #5568d3;
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 968px) {
            body {
                flex-direction: column;
                overflow-y: auto;
            }

            .register-left {
                min-height: auto;
                padding: 48px 32px;
            }

            .logo {
                width: 220px;
                margin-bottom: 28px;
            }

            .brand-description {
                font-size: 0.9375rem;
                margin-bottom: 32px;
            }

            .benefits-list {
                gap: 10px;
            }

            .benefit-item {
                font-size: 0.875rem;
            }

            .register-right {
                padding: 48px 32px;
            }

            .form-header h2 {
                font-size: 1.75rem;
            }

            .form-row {
                grid-template-columns: 1fr;
                gap: 20px;
            }
        }

        @media (max-width: 640px) {
            .register-left {
                padding: 36px 24px;
            }

            .logo {
                width: 180px;
                margin-bottom: 24px;
            }

            .benefits-list {
                display: none;
            }

            .register-right {
                padding: 36px 24px;
            }

            .form-header h2 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Left Side - Logo -->
    <div class="register-left">
        <div class="logo-container">
            <img src="/assets/images/logoOficial.png" alt="Amigo do Bolso" class="logo">
            
            <p class="brand-description">
                Crie sua conta gratuita e comece a organizar suas finanças de forma inteligente e colaborativa!
            </p>
            
            <div class="benefits-list">
                <div class="benefit-item">100% gratuito</div>
                <div class="benefit-item">Cadastro rápido e fácil</div>
                <div class="benefit-item">Compartilhe com família</div>
                <div class="benefit-item">Acesso ilimitado</div>
                <div class="benefit-item">Seguro e confiável</div>
            </div>
        </div>
    </div>

    <!-- Right Side - Form -->
    <div class="register-right">
        <div class="register-form">
            <div class="form-header">
                <h2>Criar Conta</h2>
                <p>Preencha seus dados para começar</p>
            </div>

            <?php if (isset($error)): ?>
                <div class="alert">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <?php if (isset($success)): ?>
                <div class="alert alert-success">
                    <?= htmlspecialchars($success) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="/auth/register" id="registerForm">
                <!-- Nome -->
                <div class="form-group">
                    <label for="name">
                        Nome completo
                        <span class="required">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        placeholder="Seu nome completo"
                        required
                        autofocus>
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label for="email">
                        Email
                        <span class="required">*</span>
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        placeholder="seu@email.com"
                        required>
                    <small class="helper-text">Usaremos este email para contato e login</small>
                </div>

                <!-- Senha e Confirmar Senha -->
                <div class="form-row">
                    <div class="form-group">
                        <label for="password">
                            Senha
                            <span class="required">*</span>
                        </label>
                        <div class="password-wrapper">
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                placeholder="Mínimo 6 caracteres"
                                required
                                minlength="6">
                            <button type="button" class="toggle-password" onclick="togglePassword('password', 'eyeIcon1')" aria-label="Mostrar senha">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" id="eyeIcon1">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </div>
                        <div class="password-strength">
                            <div class="strength-bar">
                                <div class="strength-fill" id="strengthBar"></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password_confirm">
                            Confirmar senha
                            <span class="required">*</span>
                        </label>
                        <div class="password-wrapper">
                            <input 
                                type="password" 
                                id="password_confirm" 
                                name="password_confirm" 
                                placeholder="Repita a senha"
                                required
                                minlength="6">
                            <button type="button" class="toggle-password" onclick="togglePassword('password_confirm', 'eyeIcon2')" aria-label="Mostrar senha">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" id="eyeIcon2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-submit">Criar minha conta</button>
            </form>

            <div class="form-footer">
                Já tem uma conta? <a href="/auth/login">Faça login</a>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const eyeIcon = document.getElementById(iconId);
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
            }
        }

        // Password strength indicator
        document.getElementById('password').addEventListener('input', function(e) {
            const password = e.target.value;
            const strengthBar = document.getElementById('strengthBar');
            
            strengthBar.className = 'strength-fill';
            
            if (password.length === 0) {
                strengthBar.style.width = '0%';
            } else if (password.length < 6) {
                strengthBar.classList.add('strength-weak');
            } else if (password.length < 10) {
                strengthBar.classList.add('strength-medium');
            } else {
                strengthBar.classList.add('strength-strong');
            }
        });

        // Form validation
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const passwordConfirm = document.getElementById('password_confirm').value;
            
            if (password !== passwordConfirm) {
                e.preventDefault();
                alert('As senhas não coincidem!');
                return false;
            }
        });
    </script>
</body>
</html>