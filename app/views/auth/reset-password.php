<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="description" content="Amigo do Bolso - Redefinir Senha">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
      <!-- PWA Meta Tags -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#667eea">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Amigo Bolso">

    <!-- Apple Touch Icons -->
    <link rel="apple-touch-icon" href="/assets/icons/icon-152.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/assets/icons/icon-72.png">
    <link rel="apple-touch-icon" sizes="96x96" href="/assets/icons/icon-96.png">
    <link rel="apple-touch-icon" sizes="128x128" href="/assets/icons/icon-128.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/assets/icons/icon-144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/assets/icons/icon-152.png">
    <link rel="apple-touch-icon" sizes="192x192" href="/assets/icons/icon-192.png">
    <link rel="apple-touch-icon" sizes="384x384" href="/assets/icons/icon-384.png">
    <link rel="apple-touch-icon" sizes="512x512" href="/assets/icons/icon-512.png">

    <!-- Registrar Service Worker -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/service-worker.js')
                    .then(reg => console.log('✅ PWA instalado!', reg))
                    .catch(err => console.log('❌ Erro PWA:', err));
            });
        }
    </script>
    <title>Redefinir Senha - Amigo do Bolso</title>
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
            height: 100vh;
            display: flex;
            flex-direction: column;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            overflow: hidden;
        }

        html {
            height: 100%;
            overflow: hidden;
        }

        .container {
            display: flex;
            height: 100vh;
            width: 100%;
            overflow: hidden;
        }

        .branding-side {
            flex: 1;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            color: white;
            position: relative;
            overflow: hidden;
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
            margin-bottom: 1.25rem;
            animation: fadeInUp 0.6s ease-out;
        }

        .logo {
            width: 100%;
            max-width: 260px;
            height: auto;
            filter: drop-shadow(0 4px 12px rgba(0, 0, 0, 0.15));
            display: block;
            margin: 0 auto;
        }

        .tagline {
            font-size: 0.9375rem;
            line-height: 1.55;
            opacity: 0.95;
            margin-bottom: 1.25rem;
            font-weight: 400;
            animation: fadeInUp 0.6s ease-out 0.15s both;
        }

        .mobile-header {
            display: none;
            text-align: center;
            padding: 1.25rem 1.25rem 0.75rem;
            background: linear-gradient(180deg, var(--primary) 0%, var(--secondary) 100%);
        }

        .mobile-logo {
            max-width: 200px;
            height: auto;
            filter: drop-shadow(0 2px 8px rgba(0, 0, 0, 0.1));
            animation: fadeInDown 0.5s ease-out;
        }

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
        }

        .form-header {
            margin-bottom: 1.5rem;
        }

        .form-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            letter-spacing: -0.025em;
        }

        .form-subtitle {
            color: var(--text-secondary);
            font-size: 0.9375rem;
            line-height: 1.5;
        }

        .alert {
            padding: 0.875rem 1rem;
            margin-bottom: 1.25rem;
            border-radius: 10px;
            font-size: 0.875rem;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            animation: slideDown 0.4s ease-out;
            line-height: 1.5;
        }

        .alert-error {
            background: var(--error-bg);
            border-left: 4px solid var(--error);
            color: #991b1b;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        label {
            display: block;
            color: var(--text-primary);
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            letter-spacing: 0.005em;
        }

        .input-wrapper {
            position: relative;
        }

        input {
            width: 100%;
            padding: 0.875rem 1rem;
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

        .password-requirements {
            margin-top: 0.75rem;
            padding: 0.875rem 1rem;
            background: #f9fafb;
            border-radius: 10px;
            font-size: 0.8125rem;
        }

        .password-requirements-title {
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .requirement {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--text-secondary);
            margin-top: 0.375rem;
        }

        .requirement.valid {
            color: var(--success);
        }

        .requirement-icon {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
        }

        .btn-primary {
            width: 100%;
            padding: 0.9375rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 0.5rem;
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

        @media (max-width: 1024px) {
            .branding-side::before {
                width: 400px;
                height: 400px;
            }

            .branding-side::after {
                width: 300px;
                height: 300px;
            }

            .logo {
                max-width: 220px;
            }

            .tagline {
                font-size: 0.875rem;
            }

            .features {
                gap: 0.5rem;
            }

            .feature {
                font-size: 0.75rem;
            }
        }

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
                padding: 1.5rem 1.5rem;
                background: var(--background);
            }

            .form-container {
                background: var(--surface);
                padding: 2rem 1.5rem;
                border-radius: 20px;
                box-shadow: var(--shadow-lg);
            }

            .form-title {
                font-size: 1.5rem;
            }

            .form-subtitle {
                font-size: 0.875rem;
            }

            .form-row {
                grid-template-columns: 1fr;
                gap: 1.25rem;
            }
        }

        @media (max-width: 640px) {
            .mobile-header {
                padding: 1rem 1rem 0.5rem;
            }

            .mobile-logo {
                max-width: 180px;
            }

            .form-side {
                padding: 1rem 1rem;
            }

            .form-container {
                padding: 1.75rem 1.25rem;
                border-radius: 16px;
            }

            .form-header {
                margin-bottom: 1.25rem;
            }

            .form-title {
                font-size: 1.375rem;
            }

            .form-subtitle {
                font-size: 0.8125rem;
            }

            .form-group {
                margin-bottom: 1.125rem;
            }

            .form-row {
                margin-bottom: 1.125rem;
            }

            label {
                font-size: 0.8125rem;
            }

            input,
            select {
                padding: 0.8125rem 0.9375rem;
                font-size: 16px;
                border-radius: 10px;
            }

            .btn-submit {
                padding: 0.875rem;
                font-size: 0.9375rem;
                border-radius: 10px;
            }

            .form-footer {
                font-size: 0.875rem;
                margin-top: 1.25rem;
                padding-top: 1.25rem;
            }

            .alert {
                padding: 0.75rem 0.875rem;
                font-size: 0.8125rem;
            }

            .helper-text {
                font-size: 0.6875rem;
            }
        }

        @media (max-width: 375px) {
            .mobile-logo {
                max-width: 160px;
            }

            .form-container {
                padding: 1.5rem 1rem;
            }

            .form-title {
                font-size: 1.25rem;
            }
        }

        @media (display-mode: standalone) {
            body {
                padding-top: env(safe-area-inset-top);
                padding-bottom: env(safe-area-inset-bottom);
            }

            .mobile-header {
                padding-top: calc(env(safe-area-inset-top) + 1rem);
            }
        }

        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }

        @media (prefers-contrast: high) {
            .btn-submit {
                border: 2px solid white;
            }

            input:focus,
            select:focus {
                border-width: 3px;
            }
        }
    </style>
</head>
<body>
    <div class="mobile-header">
        <img src="/assets/images/logoOficial.png" alt="Amigo do Bolso" class="mobile-logo">
    </div>

    <div class="container">
        <div class="branding-side">
            <div class="brand-content">
                <div class="logo-wrapper">
                    <img src="/assets/images/logoOficial.png" alt="Amigo do Bolso" class="logo">
                </div>
                
                <p class="tagline">
                    Crie uma senha forte e segura para proteger sua conta e suas informações financeiras.
                </p>
            </div>
        </div>

        <div class="form-side">
            <div class="form-container">
                <div class="form-header">
                    <h2 class="form-title">Redefinir senha</h2>
                    <p class="form-subtitle">Digite sua nova senha abaixo</p>
                </div>

                <?php if (isset($error)): ?>
                <div class="alert alert-error">
                    <span class="alert-icon">⚠️</span>
                    <div><?= htmlspecialchars($error) ?></div>
                </div>
                <?php endif; ?>

                <form method="POST" action="/auth/reset-password" id="resetForm">
                    <input type="hidden" name="token" value="<?= htmlspecialchars($token ?? '') ?>">
                    
                    <div class="form-group">
                        <label for="password">Nova senha</label>
                        <div class="input-wrapper">
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                placeholder="Digite sua nova senha"
                                required
                                autofocus
                                autocomplete="new-password"
                                minlength="6">
                            <button 
                                type="button" 
                                class="toggle-password" 
                                onclick="togglePassword('password', 'eyeIcon1')"
                                aria-label="Mostrar ou ocultar senha"
                                tabindex="-1">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="eyeIcon1">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password_confirm">Confirmar nova senha</label>
                        <div class="input-wrapper">
                            <input 
                                type="password" 
                                id="password_confirm" 
                                name="password_confirm" 
                                placeholder="Digite sua senha novamente"
                                required
                                autocomplete="new-password"
                                minlength="6">
                            <button 
                                type="button" 
                                class="toggle-password" 
                                onclick="togglePassword('password_confirm', 'eyeIcon2')"
                                aria-label="Mostrar ou ocultar senha"
                                tabindex="-1">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="eyeIcon2">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="password-requirements">
                        <div class="password-requirements-title">Requisitos da senha:</div>
                        <div class="requirement" id="req-length">
                            <svg class="requirement-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/>
                            </svg>
                            <span>Mínimo de 6 caracteres</span>
                        </div>
                        <div class="requirement" id="req-match">
                            <svg class="requirement-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/>
                            </svg>
                            <span>As senhas devem coincidir</span>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary" id="submitBtn">
                        Redefinir senha
                    </button>
                </form>
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

        const passwordInput = document.getElementById('password');
        const confirmInput = document.getElementById('password_confirm');
        const reqLength = document.getElementById('req-length');
        const reqMatch = document.getElementById('req-match');
        const submitBtn = document.getElementById('submitBtn');

        function updateRequirements() {
            const password = passwordInput.value;
            const confirm = confirmInput.value;

            if (password.length >= 6) {
                reqLength.classList.add('valid');
                reqLength.querySelector('svg').innerHTML = '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>';
            } else {
                reqLength.classList.remove('valid');
                reqLength.querySelector('svg').innerHTML = '<circle cx="12" cy="12" r="10"/>';
            }

            if (password && confirm && password === confirm) {
                reqMatch.classList.add('valid');
                reqMatch.querySelector('svg').innerHTML = '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>';
            } else {
                reqMatch.classList.remove('valid');
                reqMatch.querySelector('svg').innerHTML = '<circle cx="12" cy="12" r="10"/>';
            }

            submitBtn.disabled = !(password.length >= 6 && password === confirm);
        }

        passwordInput.addEventListener('input', updateRequirements);
        confirmInput.addEventListener('input', updateRequirements);

        const resetForm = document.getElementById('resetForm');
        
        resetForm.addEventListener('submit', function(e) {
            submitBtn.classList.add('loading');
            submitBtn.disabled = true;
            submitBtn.textContent = 'Redefinindo';
        });

        if (/iPhone|iPad|iPod/i.test(navigator.userAgent)) {
            const inputs = document.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.style.fontSize = '16px';
                });
            });
        }

        if (window.matchMedia('(display-mode: standalone)').matches) {
            console.log('Executando como PWA');
            document.body.classList.add('pwa-mode');
        }
    </script>
</body>
</html>