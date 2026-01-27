<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="theme-color" content="#667eea">
    <meta name="description" content="Amigo do Bolso - Recuperar Senha">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title>Esqueci a Senha - Amigo do Bolso</title>
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
            --success: #10b981;
            --success-bg: #f0fdf4;
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

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-secondary);
            text-decoration: none;
            font-size: 0.9375rem;
            margin-bottom: 1.5rem;
            transition: var(--transition);
            font-weight: 500;
        }

        .back-link:hover {
            color: var(--primary);
            transform: translateX(-4px);
        }

        .back-link svg {
            width: 18px;
            height: 18px;
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
            padding: 1rem 1.125rem;
            margin-bottom: 1.5rem;
            border-radius: 10px;
            font-size: 0.9375rem;
            display: flex;
            align-items: flex-start;
            gap: 0.875rem;
            animation: slideDown 0.4s ease-out;
            line-height: 1.5;
        }

        .alert-error {
            background: var(--error-bg);
            border-left: 4px solid var(--error);
            color: #991b1b;
        }

        .alert-success {
            background: var(--success-bg);
            border-left: 4px solid var(--success);
            color: #065f46;
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

        .help-text {
            margin-top: 1rem;
            padding: 1rem;
            background: #f9fafb;
            border-radius: 10px;
            color: var(--text-secondary);
            font-size: 0.9375rem;
            line-height: 1.5;
        }

        .help-text strong {
            color: var(--text-primary);
            display: block;
            margin-bottom: 0.25rem;
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

            .branding-side {
                display: none;
            }

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
                font-size: 16px;
                border-radius: 10px;
            }

            .btn-primary {
                padding: 0.9375rem;
                font-size: 1rem;
                border-radius: 10px;
            }

            .alert {
                padding: 0.875rem 1rem;
                font-size: 0.875rem;
            }

            .help-text {
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
    <!-- Mobile Header -->
    <div class="mobile-header">
        <img src="/assets/images/logoOficial.png" alt="Amigo do Bolso" class="mobile-logo">
    </div>

    <div class="container">
        <!-- Desktop - Left Side Branding -->
        <div class="branding-side">
            <div class="brand-content">
                <div class="logo-wrapper">
                    <img src="/assets/images/logoOficial.png" alt="Amigo do Bolso" class="logo">
                </div>
                
                <p class="tagline">
                    Não se preocupe! Vamos ajudá-lo a recuperar o acesso à sua conta de forma rápida e segura.
                </p>
            </div>
        </div>

        <!-- Right Side - Form -->
        <div class="form-side">
            <div class="form-container">
                <a href="/auth/login" class="back-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 12H5M12 19l-7-7 7-7"/>
                    </svg>
                    Voltar para o login
                </a>

                <div class="form-header">
                    <h2 class="form-title">Esqueceu a senha?</h2>
                    <p class="form-subtitle">Digite seu email e enviaremos um link para você redefinir sua senha</p>
                </div>

                <?php if (isset($error)): ?>
                <div class="alert alert-error">
                    <span class="alert-icon">⚠️</span>
                    <div><?= htmlspecialchars($error) ?></div>
                </div>
                <?php endif; ?>

                <?php if (isset($success)): ?>
                <div class="alert alert-success">
                    <span class="alert-icon">✓</span>
                    <div>
                        <strong>Email enviado com sucesso!</strong><br>
                        <?= htmlspecialchars($success) ?>
                    </div>
                </div>
                <?php endif; ?>

                <form method="POST" action="/auth/forgot-password" id="forgotForm">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            placeholder="seu@email.com"
                            value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>"
                            required
                            autofocus
                            autocomplete="email"
                            spellcheck="false"
                            autocapitalize="off">
                    </div>

                    <button type="submit" class="btn-primary" id="submitBtn">
                        Enviar link de recuperação
                    </button>
                </form>

                <div class="help-text">
                    <strong>💡 Dica:</strong>
                    Verifique sua caixa de spam caso não receba o email em alguns minutos. O link expira em 1 hora.
                </div>
            </div>
        </div>
    </div>

    <script>
        const forgotForm = document.getElementById('forgotForm');
        const submitBtn = document.getElementById('submitBtn');
        
        forgotForm.addEventListener('submit', function(e) {
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
            submitBtn.textContent = 'Enviando';
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