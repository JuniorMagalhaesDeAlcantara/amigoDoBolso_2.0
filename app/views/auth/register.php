<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#667eea">
    <meta name="description" content="Amigo do Bolso - Crie sua conta gratuita">
    <title>Cadastro - Amigo do Bolso</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent;
        }

        :root {
            --primary: #667eea;
            --primary-dark: #5568d3;
            --secondary: #764ba2;
            --background: #f8f9fa;
            --surface: #ffffff;
            --text-primary: #1f2937;
            --text-secondary: #6b7280;
            --border: #e5e7eb;
            --error: #ef4444;
            --error-bg: #fef2f2;
            --success: #22c55e;
            --success-bg: #f0fdf4;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.12);
            --shadow-md: 0 4px 6px rgba(0,0,0,0.1);
            --shadow-lg: 0 10px 25px rgba(0,0,0,0.15);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
            background: var(--background);
            height: 100vh;
            display: flex;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            overflow: hidden;
        }

        .container {
            display: flex;
            flex: 1;
            height: 100vh;
            overflow: hidden;
        }

        /* Left Side - Branding */
        .register-left {
            flex: 1;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: clamp(2rem, 4vw, 3rem);
            color: white;
            position: relative;
            overflow: hidden;
        }

        .register-left::before,
        .register-left::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.06);
            pointer-events: none;
        }

        .register-left::before {
            width: min(400px, 60vw);
            height: min(400px, 60vw);
            top: -20%;
            right: -15%;
        }

        .register-left::after {
            width: min(300px, 45vw);
            height: min(300px, 45vw);
            bottom: -12%;
            left: -12%;
        }

        .logo-container {
            position: relative;
            z-index: 1;
            max-width: 520px;
            width: 100%;
            text-align: center;
        }

        .logo {
            width: clamp(180px, 45vw, 340px);
            height: auto;
            filter: drop-shadow(0 4px 12px rgba(0, 0, 0, 0.15));
            display: block;
            margin: 0 auto clamp(1rem, 2vw, 1.5rem);
            animation: fadeInUp 0.8s ease-out;
        }

        .brand-description {
            font-size: clamp(0.875rem, 1.6vw, 1rem);
            line-height: 1.5;
            opacity: 0.95;
            margin-bottom: clamp(1.25rem, 2.5vw, 2rem);
            animation: fadeInUp 0.8s ease-out 0.2s both;
        }

        .benefits-list {
            display: grid;
            gap: clamp(0.5rem, 1vw, 0.75rem);
            text-align: left;
            animation: fadeInUp 0.8s ease-out 0.4s both;
        }

        .benefit-item {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            font-size: clamp(0.75rem, 1.3vw, 0.875rem);
            opacity: 0.9;
            padding: 0.25rem 0;
        }

        .benefit-item::before {
            content: '✓';
            display: flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            height: 20px;
            background: rgba(255, 255, 255, 0.25);
            border-radius: 50%;
            font-weight: 700;
            font-size: 0.65rem;
            flex-shrink: 0;
        }

        /* Right Side - Form */
        .register-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: clamp(1.5rem, 3vw, 2.5rem);
            background: var(--surface);
            overflow-y: auto;
        }

        .register-form {
            width: 100%;
            max-width: 480px;
            animation: fadeInUp 0.8s ease-out 0.3s both;
        }

        .form-header {
            margin-bottom: clamp(1.5rem, 3vw, 2rem);
        }

        .form-header h2 {
            font-size: clamp(1.5rem, 3.5vw, 2rem);
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.375rem;
            letter-spacing: -0.02em;
        }

        .form-header p {
            color: var(--text-secondary);
            font-size: clamp(0.875rem, 1.8vw, 0.9375rem);
        }

        .alert {
            background: var(--error-bg);
            border-left: 4px solid var(--error);
            padding: 0.875rem 1rem;
            margin-bottom: 1.25rem;
            border-radius: 8px;
            color: #991b1b;
            font-size: 0.8125rem;
            display: flex;
            align-items: flex-start;
            gap: 0.625rem;
            animation: slideDown 0.3s ease-out;
        }

        .alert::before {
            content: '⚠️';
            font-size: 1.125rem;
            flex-shrink: 0;
        }

        .alert-success {
            background: var(--success-bg);
            border-left-color: var(--success);
            color: #166534;
        }

        .alert-success::before {
            content: '✓';
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1.25rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        label {
            display: block;
            color: var(--text-primary);
            font-size: 0.8125rem;
            font-weight: 600;
            margin-bottom: 0.4rem;
            letter-spacing: 0.01em;
        }

        label .required {
            color: var(--error);
            margin-left: 2px;
        }

        input, select {
            width: 100%;
            padding: 0.75rem 0.875rem;
            border: 2px solid var(--border);
            border-radius: 10px;
            font-size: 0.9375rem;
            background: var(--surface);
            transition: var(--transition);
            font-family: inherit;
        }

        input:focus, select:focus {
            outline: none;
            border-color: var(--primary);
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
            right: 0.875rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            padding: 0.5rem;
            display: flex;
            align-items: center;
            transition: var(--transition);
            border-radius: 6px;
        }

        .toggle-password:hover {
            color: var(--primary);
            background: rgba(102, 126, 234, 0.1);
        }

        .toggle-password:active {
            transform: translateY(-50%) scale(0.95);
        }

        .password-strength {
            margin-top: 0.5rem;
        }

        .strength-bar {
            height: 3px;
            background: var(--border);
            border-radius: 2px;
            overflow: hidden;
        }

        .strength-fill {
            height: 100%;
            width: 0%;
            transition: var(--transition);
            border-radius: 2px;
        }

        .strength-weak { width: 33%; background: var(--error); }
        .strength-medium { width: 66%; background: #f59e0b; }
        .strength-strong { width: 100%; background: var(--success); }

        .helper-text {
            display: block;
            font-size: 0.75rem;
            color: var(--text-secondary);
            margin-top: 0.375rem;
        }

        .btn-submit {
            width: 100%;
            padding: 0.875rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 0.9375rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 0.5rem;
            box-shadow: var(--shadow-md);
            font-family: inherit;
            letter-spacing: 0.01em;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .btn-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .btn-submit.loading::after {
            content: '';
            width: 14px;
            height: 14px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: white;
            border-radius: 50%;
            display: inline-block;
            margin-left: 8px;
            animation: spin 0.6s linear infinite;
            vertical-align: middle;
        }

        .form-footer {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border);
            color: var(--text-secondary);
            font-size: 0.8125rem;
        }

        .form-footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
        }

        .form-footer a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Mobile Responsive */
        @media (max-width: 968px) {
            body {
                height: auto;
                overflow-y: auto;
            }

            .container {
                flex-direction: column;
                height: auto;
            }

            .register-left {
                min-height: auto;
                padding: 2.5rem 2rem;
            }

            .benefits-list {
                max-width: 400px;
                margin: 0 auto;
            }

            .register-right {
                padding: 2rem 1.5rem;
            }

            .form-row {
                grid-template-columns: 1fr;
                gap: 1.25rem;
            }
        }

        @media (max-width: 640px) {
            .register-left {
                padding: 2rem 1.5rem;
            }

            .benefits-list {
                display: none;
            }

            .register-right {
                padding: 1.5rem 1.25rem;
            }

            input, select {
                font-size: 16px; /* Previne zoom em iOS */
            }
        }

        /* PWA/App Mode */
        @media (display-mode: standalone) {
            body {
                padding-top: env(safe-area-inset-top);
                padding-bottom: env(safe-area-inset-bottom);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Left Side - Logo -->
        <div class="register-left">
            <div class="logo-container">
                <img src="/assets/images/logoOficial.png" alt="Amigo do Bolso" class="logo">
                
                <p class="brand-description">
                    Crie sua conta gratuita e comece a organizar suas finanças de forma inteligente!
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
                            autofocus
                            autocomplete="name">
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
                            required
                            autocomplete="email">
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
                                    minlength="6"
                                    autocomplete="new-password">
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
                                    minlength="6"
                                    autocomplete="new-password">
                                <button type="button" class="toggle-password" onclick="togglePassword('password_confirm', 'eyeIcon2')" aria-label="Mostrar senha">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" id="eyeIcon2">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit" id="submitBtn">Criar minha conta</button>
                </form>

                <div class="form-footer">
                    Já tem uma conta? <a href="/auth/login">Faça login</a>
                </div>
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

            // Loading state
            const btn = document.getElementById('submitBtn');
            btn.classList.add('loading');
            btn.disabled = true;
        });

        // Previne zoom em iOS ao focar inputs
        if (navigator.userAgent.match(/iPhone|iPad|iPod/i)) {
            const viewportMeta = document.querySelector('meta[name="viewport"]');
            viewportMeta.content = 'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no';
        }
    </script>
</body>
</html>