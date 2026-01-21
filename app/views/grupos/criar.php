<?php include VIEWS . '/layouts/header.php'; ?>

<style>
    :root {
        --primary: #667eea;
        --primary-hover: #5568d3;
        --secondary: #764ba2;
        --success: #10b981;
        --danger: #ef4444;
        --warning: #f59e0b;
        --gray-50: #f9fafb;
        --gray-100: #f3f4f6;
        --gray-200: #e5e7eb;
        --gray-300: #d1d5db;
        --gray-400: #9ca3af;
        --gray-500: #6b7280;
        --gray-600: #4b5563;
        --gray-700: #374151;
        --gray-800: #1f2937;
        --gray-900: #111827;
        --shadow-sm: 0 1px 3px rgba(0,0,0,0.12);
        --shadow-md: 0 4px 6px rgba(0,0,0,0.1);
        --shadow-lg: 0 10px 25px rgba(0,0,0,0.15);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* ========== ANIMATIONS ========== */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
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

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-10px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    /* ========== CONTAINER ========== */
    .container-small {
        max-width: 700px;
        margin: 0 auto;
        padding: 2rem;
        animation: fadeIn 0.5s ease-out;
    }

    /* ========== CARD ========== */
    .card {
        background: white;
        border-radius: 16px;
        padding: 2.5rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--gray-200);
        animation: fadeInUp 0.5s ease-out;
    }

    .card h2 {
        font-size: 1.875rem;
        font-weight: 700;
        color: var(--gray-900);
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        animation: fadeInDown 0.5s ease-out 0.1s both;
    }

    .card h2::before {
        content: '👥';
        font-size: 2.25rem;
        animation: float 3s ease-in-out infinite;
    }

    .card > p {
        color: var(--gray-600);
        font-size: 1rem;
        line-height: 1.6;
        margin-bottom: 2rem;
        animation: fadeInDown 0.5s ease-out 0.2s both;
    }

    /* ========== ALERTS ========== */
    .alert {
        display: flex;
        align-items: center;
        gap: 0.875rem;
        padding: 1.125rem 1.5rem;
        border-radius: 12px;
        margin-bottom: 1.75rem;
        font-size: 0.9375rem;
        font-weight: 500;
        animation: slideIn 0.5s ease-out;
    }

    .alert-error {
        background: #fee2e2;
        border: 2px solid #fca5a5;
        color: #991b1b;
    }

    .alert-error::before {
        content: '⚠️';
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    /* ========== FORM ELEMENTS ========== */
    .form-group {
        margin-bottom: 1.75rem;
        animation: fadeInUp 0.5s ease-out 0.3s both;
    }

    .form-group:last-child {
        margin-bottom: 0;
    }

    .form-group label {
        display: flex;
        align-items: center;
        gap: 0.625rem;
        font-size: 0.9375rem;
        font-weight: 600;
        color: var(--gray-700);
        margin-bottom: 0.625rem;
    }

    .form-group label::before {
        content: '✏️';
        font-size: 1.125rem;
    }

    .form-group input {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 2px solid var(--gray-300);
        border-radius: 10px;
        font-size: 0.9375rem;
        color: var(--gray-900);
        transition: var(--transition);
        background: white;
        font-family: inherit;
    }

    .form-group input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        transform: translateY(-1px);
    }

    .form-group input:hover {
        border-color: var(--gray-400);
    }

    .form-group input::placeholder {
        color: var(--gray-400);
    }

    /* ========== DIVIDER ========== */
    hr {
        border: none;
        border-top: 2px solid var(--gray-200);
        margin: 2rem 0 1.5rem 0;
        opacity: 0.6;
        animation: fadeIn 0.5s ease-out 0.4s both;
    }

    /* ========== TEXT CENTER ========== */
    .text-center {
        text-align: center;
        color: var(--gray-500);
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin: 1.5rem 0;
        animation: fadeIn 0.5s ease-out 0.5s both;
    }

    /* ========== INFO BOX ========== */
    .info-box {
        display: flex;
        align-items: flex-start;
        gap: 1.125rem;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.08) 0%, rgba(102, 126, 234, 0.03) 100%);
        border: 2px solid rgba(102, 126, 234, 0.25);
        border-radius: 12px;
        padding: 1.25rem 1.5rem;
        margin: 1.75rem 0 0 0;
        animation: fadeInUp 0.5s ease-out 0.6s both;
    }

    .info-icon {
        font-size: 1.75rem;
        flex-shrink: 0;
        line-height: 1;
    }

    .info-box strong {
        color: var(--primary);
        font-size: 1rem;
        display: block;
        margin-bottom: 0.75rem;
        font-weight: 700;
    }

    .info-box ul {
        margin: 0;
        padding-left: 1.5rem;
        color: var(--gray-700);
    }

    .info-box li {
        margin: 0.5rem 0;
        font-size: 0.875rem;
        line-height: 1.6;
    }

    /* ========== BUTTONS ========== */
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.9375rem 1.875rem;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
        cursor: pointer;
        border: none;
        white-space: nowrap;
        font-family: inherit;
        width: 100%;
        margin-top: 0.75rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.25);
        animation: fadeInUp 0.5s ease-out 0.4s both;
    }

    .btn-primary::before {
        content: '✨';
        font-size: 1.125rem;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.35);
    }

    .btn-primary:active {
        transform: translateY(0);
    }

    .btn-secondary {
        background: white;
        color: var(--gray-700);
        border: 2px solid var(--gray-300);
        animation: fadeInUp 0.5s ease-out 0.7s both;
    }

    .btn-secondary::before {
        content: '🔑';
        font-size: 1.125rem;
    }

    .btn-secondary:hover {
        background: var(--gray-50);
        border-color: var(--gray-400);
        transform: translateY(-2px);
        box-shadow: var(--shadow-sm);
    }

    .btn-secondary:active {
        transform: translateY(0);
    }

    .btn-block {
        display: flex;
    }

    /* ========== RESPONSIVE - TABLET ========== */
    @media (max-width: 1024px) {
        .container-small {
            padding: 1.5rem;
        }

        .card {
            padding: 2rem;
        }
    }

    /* ========== RESPONSIVE - MOBILE ========== */
    @media (max-width: 768px) {
        .container-small {
            padding: 1rem;
        }

        .card {
            padding: 1.5rem;
            border-radius: 12px;
        }

        .card h2 {
            font-size: 1.5rem;
        }

        .card h2::before {
            font-size: 1.875rem;
        }

        .card > p {
            font-size: 0.9375rem;
        }

        .info-box {
            padding: 1rem 1.25rem;
        }
    }

    /* ========== MOBILE PORTRAIT ========== */
    @media (max-width: 480px) {
        .container-small {
            padding: 0.875rem;
        }

        .card {
            padding: 1.25rem;
        }

        .card h2 {
            font-size: 1.375rem;
            flex-direction: column;
            text-align: center;
        }

        .card h2::before {
            font-size: 2.5rem;
        }

        .card > p {
            font-size: 0.875rem;
            text-align: center;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group input {
            padding: 0.75rem 0.875rem;
            font-size: 0.875rem;
        }

        .alert {
            padding: 1rem 1.25rem;
            font-size: 0.875rem;
        }

        .info-box {
            flex-direction: column;
            gap: 0.75rem;
        }

        .info-icon {
            font-size: 1.5rem;
        }

        .btn {
            padding: 0.875rem 1.5rem;
            font-size: 0.9375rem;
        }
    }

    /* ========== PWA/STANDALONE MODE ========== */
    @media (display-mode: standalone) {
        .container-small {
            padding-top: calc(env(safe-area-inset-top) + 2rem);
            padding-bottom: calc(env(safe-area-inset-bottom) + 2rem);
        }
    }

    /* ========== LOADING STATE ========== */
    .btn-primary:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none !important;
    }

    /* ========== FORM VALIDATION ========== */
    .form-group input:invalid:not(:placeholder-shown) {
        border-color: var(--danger);
    }

    .form-group input:valid {
        border-color: var(--gray-300);
    }

    .form-group input:focus:valid {
        border-color: var(--primary);
    }

    /* ========== ACCESSIBILITY ========== */
    @media (prefers-reduced-motion: reduce) {
        *,
        *::before,
        *::after {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
    }
</style>

<div class="container-small">
    <div class="card">
        <h2>Criar Grupo Financeiro</h2>
        <p>Crie um grupo para compartilhar o controle financeiro com outras pessoas</p>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?= $error ?></div>
        <?php endif; ?>
        
        <form method="POST" action="/grupos/criar" id="groupForm">
            <div class="form-group">
                <label for="name">Nome do Grupo</label>
                <input type="text" 
                    id="name" 
                    name="name" 
                    placeholder="Ex: Família Silva" 
                    required
                    maxlength="50"
                    autocomplete="off">
            </div>
            
            <button type="submit" class="btn btn-primary">Criar Grupo</button>
        </form>
        
        <hr>
        
        <p class="text-center">Ou</p>
        
        <a href="/grupos/entrar" class="btn btn-secondary btn-block">Entrar em um Grupo Existente</a>

        <div class="info-box">
            <span class="info-icon">💡</span>
            <div>
                <strong>Sobre Grupos Financeiros:</strong>
                <ul>
                    <li>Compartilhe despesas e receitas com familiares ou amigos</li>
                    <li>Acompanhe as finanças do grupo em tempo real</li>
                    <li>Cada membro pode adicionar suas próprias transações</li>
                    <li>Defina metas financeiras conjuntas e alcance objetivos juntos</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    const form = document.getElementById('groupForm');
    const submitBtn = form.querySelector('.btn-primary');
    const nameInput = document.getElementById('name');

    // ===== VALIDAÇÃO DO FORMULÁRIO =====
    form.addEventListener('submit', function(e) {
        const name = nameInput.value.trim();
        
        if (!name) {
            e.preventDefault();
            alert('⚠️ Digite um nome para o grupo!');
            nameInput.focus();
            nameInput.style.borderColor = 'var(--danger)';
            nameInput.style.animation = 'shake 0.5s';
            
            setTimeout(() => {
                nameInput.style.borderColor = '';
                nameInput.style.animation = '';
            }, 500);
            return;
        }

        if (name.length < 3) {
            e.preventDefault();
            alert('⚠️ O nome do grupo deve ter pelo menos 3 caracteres!');
            nameInput.focus();
            nameInput.style.borderColor = 'var(--danger)';
            nameInput.style.animation = 'shake 0.5s';
            
            setTimeout(() => {
                nameInput.style.borderColor = '';
                nameInput.style.animation = '';
            }, 500);
            return;
        }

        // Feedback visual de loading
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span style="display: flex; align-items: center; gap: 0.5rem;"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="animation: spin 0.6s linear infinite;"><circle cx="12" cy="12" r="10" opacity="0.25"/><path d="M12 2a10 10 0 0 1 10 10"/></svg> Criando...</span>';
    });

    // ===== FEEDBACK VISUAL NO INPUT =====
    nameInput.addEventListener('invalid', function(e) {
        e.preventDefault();
        this.style.borderColor = 'var(--danger)';
        this.style.animation = 'shake 0.5s';
    });

    nameInput.addEventListener('input', function() {
        this.style.borderColor = '';
        this.style.animation = '';
    });

    // ===== CAPITALIZA PRIMEIRA LETRA =====
    nameInput.addEventListener('blur', function() {
        const value = this.value.trim();
        if (value) {
            this.value = value.charAt(0).toUpperCase() + value.slice(1);
        }
    });

    // ===== PREVINE ZOOM EM iOS =====
    if (/iPhone|iPad|iPod/i.test(navigator.userAgent)) {
        const viewport = document.querySelector('meta[name="viewport"]');
        if (viewport) {
            viewport.content = 'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no';
        }
    }

    // ===== AUTO-FOCUS NO CAMPO NOME =====
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(() => {
            nameInput.focus();
        }, 300);
    });

    // ===== ADICIONA CLASSE AO BODY QUANDO EM MODO PWA =====
    if (window.matchMedia('(display-mode: standalone)').matches) {
        document.body.classList.add('pwa-mode');
    }

    // ===== ANIMAÇÃO DE SPIN PARA LOADING =====
    const style = document.createElement('style');
    style.textContent = `
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    `;
    document.head.appendChild(style);
</script>

<?php include VIEWS . '/layouts/footer.php'; ?>