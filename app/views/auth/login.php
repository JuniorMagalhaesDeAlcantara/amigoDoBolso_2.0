<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="#667eea">
    <meta name="description" content="Amigo do Bolso - Controle financeiro colaborativo">
    <title>Login - Amigo do Bolso</title>
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
            flex-direction: column;
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
        .branding-side {
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

        .branding-side::before,
        .branding-side::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.06);
            pointer-events: none;
        }

        .branding-side::before {
            width: min(400px, 60vw);
            height: min(400px, 60vw);
            top: -20%;
            right: -15%;
        }

        .branding-side::after {
            width: min(300px, 45vw);
            height: min(300px, 45vw);
            bottom: -12%;
            left: -12%;
        }

        .brand-content {
            position: relative;
            z-index: 1;
            max-width: 520px;
            width: 100%;
            text-align: center;
        }

        .logo-wrapper {
            margin-bottom: clamp(1rem, 2vw, 1.5rem);
            animation: fadeInUp 0.8s ease-out;
        }

        .logo {
            width: clamp(180px, 45vw, 340px);
            height: auto;
            filter: drop-shadow(0 4px 12px rgba(0, 0, 0, 0.15));
            display: block;
            margin: 0 auto;
        }

        .tagline {
            font-size: clamp(0.875rem, 1.6vw, 1rem);
            line-height: 1.5;
            opacity: 0.95;
            margin-bottom: clamp(1.25rem, 2.5vw, 2rem);
            animation: fadeInUp 0.8s ease-out 0.2s both;
        }

        .features {
            display: grid;
            gap: clamp(0.5rem, 1vw, 0.75rem);
            text-align: left;
            animation: fadeInUp 0.8s ease-out 0.4s both;
        }

        .feature {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            font-size: clamp(0.75rem, 1.3vw, 0.875rem);
            opacity: 0.9;
            padding: 0.25rem 0;
        }

        .feature-icon {
            width: 20px;
            height: 20px;
            background: rgba(255, 255, 255, 0.25);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-weight: 700;
            font-size: 0.65rem;
        }

        /* Right Side - Form */
        .form-side {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: clamp(1.5rem, 4vw, 3rem);
            background: var(--surface);
        }

        .form-container {
            width: 100%;
            max-width: 440px;
            animation: fadeInUp 0.8s ease-out 0.3s both;
        }

        .form-header {
            margin-bottom: clamp(2rem, 4vw, 2.5rem);
        }

        .form-title {
            font-size: clamp(1.75rem, 4vw, 2.25rem);
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            letter-spacing: -0.02em;
        }

        .form-subtitle {
            color: var(--text-secondary);
            font-size: clamp(0.9375rem, 2vw, 1rem);
        }

        .alert {
            background: var(--error-bg);
            border-left: 4px solid var(--error);
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: 8px;
            color: #991b1b;
            font-size: 0.875rem;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            animation: slideDown 0.3s ease-out;
        }

        .alert-icon {
            font-size: 1.25rem;
            flex-shrink: 0;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            color: var(--text-primary);
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            letter-spacing: 0.01em;
        }

        .input-wrapper {
            position: relative;
        }

        input {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 2px solid var(--border);
            border-radius: 10px;
            font-size: 1rem;
            background: var(--surface);
            transition: var(--transition);
            font-family: inherit;
        }

        input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        input::placeholder {
            color: #9ca3af;
        }

        .toggle-password {
            position: absolute;
            right: 1rem;
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

        .btn-primary {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 0.5rem;
            box-shadow: var(--shadow-md);
            font-family: inherit;
            letter-spacing: 0.01em;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .form-footer {
            text-align: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid var(--border);
            color: var(--text-secondary);
            font-size: 0.9375rem;
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

        /* Mobile Responsive */
        @media (max-width: 968px) {
            .container {
                flex-direction: column;
            }

            .branding-side {
                min-height: auto;
                padding: 3rem 2rem;
            }

            .features {
                max-width: 400px;
                margin: 0 auto;
            }

            .form-side {
                padding: 2rem 1.5rem;
            }
        }

        @media (max-width: 640px) {
            .branding-side {
                padding: 2rem 1.5rem;
            }

            .features {
                display: none;
            }

            .tagline {
                font-size: 1rem;
            }

            .form-side {
                padding: 1.5rem 1.25rem;
            }

            input {
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

        /* Loading state */
        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .btn-primary.loading::after {
            content: '';
            width: 16px;
            height: 16px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: white;
            border-radius: 50%;
            display: inline-block;
            margin-left: 8px;
            animation: spin 0.6s linear infinite;
            vertical-align: middle;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Left Side - Branding -->
        <div class="branding-side">
            <div class="brand-content">
                <div class="logo-wrapper">
                    <img src="/assets/images/logoOficial.png" alt="Amigo do Bolso" class="logo">
                </div>
                
                <p class="tagline">
                    Controle financeiro colaborativo. Organize despesas e alcance suas metas juntos!
                </p>
                
                <div class="features">
                    <div class="feature">
                        <span class="feature-icon">✓</span>
                        <span>Despesas compartilhadas</span>
                    </div>
                    <div class="feature">
                        <span class="feature-icon">✓</span>
                        <span>Controle de cartões de crédito</span>
                    </div>
                    <div class="feature">
                        <span class="feature-icon">✓</span>
                        <span>Gestão de VR e VA</span>
                    </div>
                    <div class="feature">
                        <span class="feature-icon">✓</span>
                        <span>Metas financeiras</span>
                    </div>
                    <div class="feature">
                        <span class="feature-icon">✓</span>
                        <span>Relatórios detalhados</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="form-side">
            <div class="form-container">
                <div class="form-header">
                    <h2 class="form-title">Bem-vindo de volta</h2>
                    <p class="form-subtitle">Entre com suas credenciais para continuar</p>
                </div>

                <!-- Alert de erro (remover PHP na versão final) -->
                <!-- <div class="alert">
                    <span class="alert-icon">⚠️</span>
                    <span>Email ou senha incorretos. Tente novamente.</span>
                </div> -->

                <form method="POST" action="/auth/login" id="loginForm">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            placeholder="seu@email.com"
                            required
                            autofocus
                            autocomplete="email">
                    </div>

                    <div class="form-group">
                        <label for="password">Senha</label>
                        <div class="input-wrapper">
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                placeholder="Digite sua senha"
                                required
                                autocomplete="current-password">
                            <button 
                                type="button" 
                                class="toggle-password" 
                                onclick="togglePassword()"
                                aria-label="Mostrar/ocultar senha">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" id="eyeIcon">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary" id="submitBtn">
                        Entrar
                    </button>
                </form>

                <div class="form-footer">
                    Não tem uma conta? <a href="/auth/register">Cadastre-se gratuitamente</a>
                </div>
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

        // Loading state no submit
        document.getElementById('loginForm').addEventListener('submit', function() {
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