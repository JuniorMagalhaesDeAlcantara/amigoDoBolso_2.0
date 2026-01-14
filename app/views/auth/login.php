<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Amigo do Bolso</title>
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
        .login-left {
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

        .login-left::before {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
            top: -150px;
            right: -150px;
        }

        .login-left::after {
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

        .features-list {
            display: grid;
            grid-template-columns: 1fr;
            gap: 14px;
            text-align: left;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 0.9375rem;
            opacity: 0.88;
        }

        .feature-item::before {
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
        .login-right {
            flex: 1;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px;
        }

        .login-form {
            width: 100%;
            max-width: 420px;
        }

        .form-header {
            margin-bottom: 40px;
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

        .form-group {
            margin-bottom: 24px;
        }

        label {
            display: block;
            color: #374151;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 10px;
            font-size: 0.9375rem;
            background: white;
            transition: all 0.2s;
        }

        input:focus {
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
            margin-top: 8px;
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

            .login-left {
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

            .features-list {
                gap: 10px;
            }

            .feature-item {
                font-size: 0.875rem;
            }

            .login-right {
                padding: 48px 32px;
            }

            .form-header h2 {
                font-size: 1.75rem;
            }
        }

        @media (max-width: 640px) {
            .login-left {
                padding: 36px 24px;
            }

            .logo {
                width: 180px;
                margin-bottom: 24px;
            }

            .features-list {
                display: none;
            }

            .login-right {
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
    <div class="login-left">
        <div class="logo-container">
            <img src="/assets/images/logoOficial.png" alt="Amigo do Bolso" class="logo">
            
            <p class="brand-description">
                Controle financeiro colaborativo para casais e grupos. Organize despesas, acompanhe cartões e alcance suas metas juntos!
            </p>
            
            <div class="features-list">
                <div class="feature-item">Despesas compartilhadas</div>
                <div class="feature-item">Controle de cartões de crédito</div>
                <div class="feature-item">Gestão de VR e VA</div>
                <div class="feature-item">Metas financeiras</div>
                <div class="feature-item">Relatórios detalhados</div>
            </div>
        </div>
    </div>

    <!-- Right Side - Form -->
    <div class="login-right">
        <div class="login-form">
            <div class="form-header">
                <h2>Login</h2>
                <p>Entre com suas credenciais</p>
            </div>

            <?php if (isset($error)): ?>
                <div class="alert">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="/auth/login">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        placeholder="seu@email.com"
                        required
                        autofocus>
                </div>

                <div class="form-group">
                    <label for="password">Senha</label>
                    <div class="password-wrapper">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            placeholder="••••••••"
                            required>
                        <button type="button" class="toggle-password" onclick="togglePassword()" aria-label="Mostrar senha">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" id="eyeIcon">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-submit">Entrar</button>
            </form>

            <div class="form-footer">
                Não tem uma conta? <a href="/auth/register">Cadastre-se gratuitamente</a>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
            }
        }
    </script>
</body>
</html>