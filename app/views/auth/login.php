<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="theme-color" content="#667eea">
    <meta name="description" content="Amigo do Bolso - Controle financeiro colaborativo">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
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
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: var(--background);
            min-height: 100vh;
            min-height: -webkit-fill-available;
            display: flex;
            flex-direction: column;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            overflow-x: hidden;
        }

        html {
            height: -webkit-fill-available;
        }

        .container {
            display: flex;
            flex: 1;
            min-height: 100vh;
            min-height: -webkit-fill-available;
            width: 100%;
        }

        /* Desktop - Left Side Branding */
        .branding-side {
            flex: 1;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem 2rem;
            color: white;
            position: relative;
            overflow: hidden;
            min-height: 400px;
        }

        .branding-side::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            top: -150px;
            right: -150px;
            pointer-events: none;
        }

        .branding-side::after {
            content: '';
            position: absolute;
            width: 350px;
            height: 350px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.06);
            bottom: -100px;
            left: -100px;
            pointer-events: none;
        }

        .brand-content {
            position: relative;
            z-index: 1;
            max-width: 480px;
            width: 100%;
            text-align: center;
        }

        .logo-wrapper {
            margin-bottom: 2rem;
            animation: fadeInUp 0.6s ease-out;
        }

        .logo {
            width: 100%;
            max-width: 280px;
            height: auto;
            filter: drop-shadow(0 8px 16px rgba(0, 0, 0, 0.2));
            display: block;
            margin: 0 auto;
        }

        .tagline {
            font-size: 1.0625rem;
            line-height: 1.6;
            opacity: 0.95;
            margin-bottom: 2rem;
            font-weight: 400;
            animation: fadeInUp 0.6s ease-out 0.15s both;
        }

        .features {
            display: grid;
            gap: 0.875rem;
            text-align: left;
            max-width: 360px;
            margin: 0 auto;
            animation: fadeInUp 0.6s ease-out 0.3s both;
        }

        .feature {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.9375rem;
            opacity: 0.92;
            padding: 0.375rem 0;
            transition: var(--transition);
        }

        .feature:hover {
            opacity: 1;
            transform: translateX(4px);
        }

        .feature-icon {
            width: 22px;
            height: 22px;
            background: rgba(255, 255, 255, 0.22);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-weight: 700;
            font-size: 0.6875rem;
            backdrop-filter: blur(10px);
        }

        /* Mobile - Logo no topo */
        .mobile-header {
            display: none;
            text-align: center;
            padding: 2rem 1.5rem 1rem;
            background: linear-gradient(180deg, var(--primary) 0%, var(--secondary) 100%);
        }

        .mobile-logo {
            width: 140px;
            height: auto;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.15));
            animation: fadeInDown 0.5s ease-out;
        }

        /* Desktop - Right Side Form */
        .form-side {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1.5rem;
            background: var(--surface);
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }

        .form-container {
            width: 100%;
            max-width: 440px;
            animation: fadeInUp 0.6s ease-out 0.2s both;
            padding: 1rem 0;
        }

        .form-header {
            margin-bottom: 2rem;
        }

        .form-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            letter-spacing: -0.025em;
        }

        .form-subtitle {
            color: var(--text-secondary);
            font-size: 1rem;
            line-height: 1.5;
        }

        .alert {
            background: var(--error-bg);
            border-left: 4px solid var(--error);
            padding: 1rem 1.125rem;
            margin-bottom: 1.5rem;
            border-radius: 10px;
            color: #991b1b;
            font-size: 0.9375rem;
            display: flex;
            align-items: flex-start;
            gap: 0.875rem;
            animation: slideDown 0.4s ease-out;
            line-height: 1.5;
        }

        .alert-icon {
            font-size: 1.25rem;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            color: var(--text-primary);
            font-size: 0.9375rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            letter-spacing: 0.005em;
        }

        .input-wrapper {
            position: relative;
        }

        input {
            width: 100%;
            padding: 0.9375rem 1rem;
            border: 2px solid var(--border);
            border-radius: 12px;
            font-size: 1rem;
            background: var(--surface);
            transition: var(--transition);
            font-family: inherit;
            color: var(--text-primary);
        }

        input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.12);
        }

        input::placeholder {
            color: #9ca3af;
        }

        .toggle-password {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            padding: 0.625rem;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition);
            border-radius: 8px;
            -webkit-tap-highlight-color: transparent;
        }

        .toggle-password:hover {
            color: var(--primary);
            background: rgba(102, 126, 234, 0.08);
        }

        .toggle-password:active {
            transform: translateY(-50%) scale(0.92);
        }

        .btn-primary {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.0625rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 0.75rem;
            box-shadow: var(--shadow-md);
            font-family: inherit;
            letter-spacing: 0.01em;
            position: relative;
            overflow: hidden;
            -webkit-tap-highlight-color: transparent;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(102, 126, 234, 0.35);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-primary:disabled {
            opacity: 0.65;
            cursor: not-allowed;
            transform: none !important;
        }

        .btn-primary.loading {
            pointer-events: none;
        }

        .btn-primary.loading::after {
            content: '';
            width: 18px;
            height: 18px;
            border: 2.5px solid rgba(255,255,255,0.3);
            border-top-color: white;
            border-radius: 50%;
            display: inline-block;
            margin-left: 10px;
            animation: spin 0.6s linear infinite;
            vertical-align: middle;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .form-footer {
            text-align: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid var(--border);
            color: var(--text-secondary);
            font-size: 1rem;
        }

        .form-footer a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            transition: var(--transition);
            display: inline-block;
        }

        .form-footer a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .form-footer a:active {
            transform: scale(0.98);
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(24px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                max-height: 0;
                transform: translateY(-12px);
            }
            to {
                opacity: 1;
                max-height: 200px;
                transform: translateY(0);
            }
        }

        /* Tablet */
        @media (max-width: 1024px) {
            .branding-side::before {
                width: 400px;
                height: 400px;
            }

            .branding-side::after {
                width: 300px;
                height: 300px;
            }
        }

        /* Mobile - Layout Vertical */
        @media (max-width: 968px) {
            .container {
                flex-direction: column;
            }

            /* Esconde o branding lateral no mobile */
            .branding-side {
                display: none;
            }

            /* Mostra header mobile com logo */
            .mobile-header {
                display: block;
            }

            .form-side {
                padding: 2rem 1.5rem;
                background: var(--background);
            }

            .form-container {
                background: var(--surface);
                padding: 2rem 1.5rem;
                border-radius: 20px;
                box-shadow: var(--shadow-lg);
            }

            .form-title {
                font-size: 1.75rem;
            }

            .form-subtitle {
                font-size: 0.9375rem;
            }
        }

        /* Mobile Portrait */
        @media (max-width: 640px) {
            .mobile-header {
                padding: 1.5rem 1.25rem 0.75rem;
            }

            .mobile-logo {
                width: 120px;
            }

            .form-side {
                padding: 1.5rem 1rem;
            }

            .form-container {
                padding: 1.75rem 1.25rem;
                border-radius: 16px;
            }

            .form-header {
                margin-bottom: 1.5rem;
            }

            .form-title {
                font-size: 1.5rem;
            }

            .form-subtitle {
                font-size: 0.875rem;
            }

            .form-group {
                margin-bottom: 1.25rem;
            }

            label {
                font-size: 0.875rem;
            }

            input {
                padding: 0.875rem 1rem;
                font-size: 16px; /* Previne zoom em iOS */
                border-radius: 10px;
            }

            .btn-primary {
                padding: 0.9375rem;
                font-size: 1rem;
                border-radius: 10px;
            }

            .form-footer {
                font-size: 0.9375rem;
                margin-top: 1.5rem;
                padding-top: 1.5rem;
            }

            .alert {
                padding: 0.875rem 1rem;
                font-size: 0.875rem;
            }
        }

        /* Extra Small Devices */
        @media (max-width: 375px) {
            .mobile-logo {
                width: 110px;
            }

            .form-container {
                padding: 1.5rem 1rem;
            }

            .form-title {
                font-size: 1.375rem;
            }
        }

        /* PWA/Standalone Mode */
        @media (display-mode: standalone) {
            body {
                padding-top: env(safe-area-inset-top);
                padding-bottom: env(safe-area-inset-bottom);
            }

            .mobile-header {
                padding-top: calc(env(safe-area-inset-top) + 1.5rem);
            }
        }

        /* Reduce Motion */
        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }

        /* High Contrast Mode */
        @media (prefers-contrast: high) {
            .btn-primary {
                border: 2px solid white;
            }

            input:focus {
                border-width: 3px;
            }
        }
    </style>
</head>
<body>
    <!-- Mobile Header - Aparece apenas no mobile -->
    <div class="mobile-header">
        <img src="/assets/images/logoOficial.png" alt="Amigo do Bolso" class="mobile-logo">
    </div>

    <div class="container">
        <!-- Desktop - Left Side Branding (oculto no mobile) -->
        <div class="branding-side">
            <div class="brand-content">
                <div class="logo-wrapper">
                    <img src="/assets/images/logoOficial.png" alt="Amigo do Bolso" class="logo">
                </div>
                
                <p class="tagline">
                    Controle financeiro colaborativo para você e sua família alcançarem suas metas juntos
                </p>
                
                <div class="features">
                    <div class="feature">
                        <span class="feature-icon">✓</span>
                        <span>Despesas compartilhadas em tempo real</span>
                    </div>
                    <div class="feature">
                        <span class="feature-icon">✓</span>
                        <span>Controle de cartões de crédito</span>
                    </div>
                    <div class="feature">
                        <span class="feature-icon">✓</span>
                        <span>Gestão inteligente de VR e VA</span>
                    </div>
                    <div class="feature">
                        <span class="feature-icon">✓</span>
                        <span>Metas financeiras personalizadas</span>
                    </div>
                    <div class="feature">
                        <span class="feature-icon">✓</span>
                        <span>Relatórios e insights detalhados</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="form-side">
            <div class="form-container">
                <div class="form-header">
                    <h2 class="form-title">Bem-vindo de volta</h2>
                    <p class="form-subtitle">Entre com suas credenciais para acessar sua conta</p>
                </div>

                <!-- Alert de erro (descomente se necessário) -->
                <!-- <div class="alert">
                    <span class="alert-icon">⚠️</span>
                    <div>
                        <strong>Erro ao fazer login</strong><br>
                        Email ou senha incorretos. Verifique seus dados e tente novamente.
                    </div>
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
                            autocomplete="email"
                            spellcheck="false"
                            autocapitalize="off">
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
                                aria-label="Mostrar ou ocultar senha"
                                tabindex="-1">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="eyeIcon">
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
        // Toggle senha
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
        const loginForm = document.getElementById('loginForm');
        const submitBtn = document.getElementById('submitBtn');
        
        loginForm.addEventListener('submit', function(e) {
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
            submitBtn.textContent = 'Entrando';
        });

        // Previne zoom em iOS ao focar inputs
        if (/iPhone|iPad|iPod/i.test(navigator.userAgent)) {
            const inputs = document.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.style.fontSize = '16px';
                });
            });
        }

        // Detecta se está em modo standalone (PWA)
        if (window.matchMedia('(display-mode: standalone)').matches) {
            console.log('Executando como PWA');
            document.body.classList.add('pwa-mode');
        }
    </script>
</body>
</html>