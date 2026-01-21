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
        50% { transform: translateX(5px); }
        75% { transform: translateX(-5px); }
    }

    /* ========== CONTAINER ========== */
    .container-small {
        max-width: 600px;
        margin: 0 auto;
        padding: 2rem;
        animation: fadeIn 0.5s ease-out;
    }

    /* ========== CARD ========== */
    .card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--gray-200);
        animation: fadeInUp 0.5s ease-out;
    }

    .card h2 {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--gray-900);
        margin-bottom: 1.75rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        animation: fadeInDown 0.5s ease-out 0.1s both;
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

    /* ========== FORM ELEMENTS ========== */
    .form-group {
        margin-bottom: 1.75rem;
        animation: fadeInUp 0.5s ease-out;
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

    small {
        display: block;
        margin-top: 0.625rem;
        color: var(--gray-500);
        font-size: 0.8125rem;
        line-height: 1.4;
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
        margin: 1.75rem 0;
        animation: fadeInUp 0.5s ease-out 0.3s both;
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

    .info-box p {
        margin: 0;
        color: var(--gray-700);
        font-size: 0.875rem;
        line-height: 1.6;
    }

    /* ========== FORM ACTIONS ========== */
    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2.25rem;
        animation: fadeInUp 0.5s ease-out 0.4s both;
    }

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
        flex: 1;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.25);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.35);
    }

    .btn-primary:active {
        transform: translateY(0);
    }

    .btn-primary:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none !important;
    }

    .btn-secondary {
        background: white;
        color: var(--gray-700);
        border: 2px solid var(--gray-300);
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

    /* ========== RESPONSIVE - TABLET ========== */
    @media (max-width: 1024px) {
        .container-small {
            padding: 1.5rem;
        }

        .card {
            padding: 1.75rem;
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

        .form-actions {
            flex-direction: column;
        }

        .form-actions .btn {
            width: 100%;
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
    }

    /* ========== PWA/STANDALONE MODE ========== */
    @media (display-mode: standalone) {
        .container-small {
            padding-top: calc(env(safe-area-inset-top) + 2rem);
            padding-bottom: calc(env(safe-area-inset-bottom) + 2rem);
        }
    }

    /* ========== ACCESSIBILITY ========== */
    @media (prefers-reduced-motion: reduce) {
        * {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
    }
</style>

<div class="container-small">
    <div class="card">
        <h2>✏️ Editar Grupo</h2>

        <?php if (isset($error)): ?>
            <div class="alert alert-error">
                ⚠️ <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="/grupos/editar/<?= $group['id'] ?>" id="groupForm">
            <div class="form-group">
                <label for="name">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                    Nome do Grupo *
                </label>
                <input 
                    type="text"
                    id="name"
                    name="name"
                    value="<?= htmlspecialchars($group['name']) ?>"
                    placeholder="Ex: Família Silva, Moradia Apartamento 101"
                    required
                    maxlength="100"
                    autocomplete="off">
                <small>Escolha um nome que todos os membros reconheçam facilmente</small>
            </div>

            <div class="info-box">
                <span class="info-icon">💡</span>
                <div>
                    <strong>Informações importantes:</strong>
                    <p>
                        • O código de convite permanece o mesmo<br>
                        • Todos os membros verão a alteração imediatamente<br>
                        • O histórico de transações não será afetado
                    </p>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                        <polyline points="17 21 17 13 7 13 7 21"/>
                        <polyline points="7 3 7 8 15 8"/>
                    </svg>
                    Salvar Alterações
                </button>
                <a href="/grupos/detalhes" class="btn btn-secondary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 6L6 18M6 6l12 12"/>
                    </svg>
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    const form = document.getElementById('groupForm');
    const nameInput = document.getElementById('name');
    const submitBtn = form.querySelector('.btn-primary');
    const originalName = nameInput.value;

    // ===== VALIDAÇÃO DO FORMULÁRIO =====
    form.addEventListener('submit', function(e) {
        const name = nameInput.value.trim();

        if (name.length < 3) {
            e.preventDefault();
            alert('⚠️ O nome do grupo deve ter pelo menos 3 caracteres!');
            nameInput.focus();
            nameInput.classList.add('shake');
            setTimeout(() => nameInput.classList.remove('shake'), 500);
            return;
        }

        if (name === originalName) {
            e.preventDefault();
            alert('ℹ️ Você não fez nenhuma alteração no nome do grupo.');
            return;
        }

        // Feedback visual de loading
        submitBtn.disabled = true;
        submitBtn.innerHTML = `
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
            </svg>
            Salvando...
        `;
    });

    // ===== CONTADOR DE CARACTERES =====
    nameInput.addEventListener('input', function() {
        const remaining = 100 - this.value.length;
        if (!this.nextElementSibling.classList.contains('char-counter')) {
            const counter = document.createElement('small');
            counter.classList.add('char-counter');
            counter.style.textAlign = 'right';
            counter.style.color = remaining < 20 ? 'var(--warning)' : 'var(--gray-500)';
            this.parentNode.appendChild(counter);
        }
        
        const counter = this.parentNode.querySelector('.char-counter');
        counter.textContent = `${remaining} caracteres restantes`;
        counter.style.color = remaining < 20 ? 'var(--warning)' : 'var(--gray-500)';
    });

    // ===== AVISO AO SAIR SEM SALVAR =====
    let hasChanges = false;
    nameInput.addEventListener('input', function() {
        hasChanges = this.value.trim() !== originalName;
        if (hasChanges) {
            submitBtn.style.animation = 'pulse 2s ease-in-out infinite';
        } else {
            submitBtn.style.animation = '';
        }
    });

    window.addEventListener('beforeunload', function(e) {
        if (hasChanges) {
            e.preventDefault();
            e.returnValue = '';
        }
    });

    // ===== PREVINE ZOOM EM iOS =====
    if (/iPhone|iPad|iPod/i.test(navigator.userAgent)) {
        const viewport = document.querySelector('meta[name="viewport"]');
        if (viewport) {
            viewport.content = 'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no';
        }
    }

    // ===== ADICIONA CLASSE AO BODY QUANDO EM MODO PWA =====
    if (window.matchMedia('(display-mode: standalone)').matches) {
        document.body.classList.add('pwa-mode');
    }

    // ===== ATALHO DE TECLADO =====
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + S para salvar
        if ((e.ctrlKey || e.metaKey) && e.key === 's') {
            e.preventDefault();
            if (!submitBtn.disabled && hasChanges) {
                form.submit();
            }
        }
        
        // ESC para cancelar
        if (e.key === 'Escape') {
            const cancelBtn = document.querySelector('.btn-secondary');
            if (cancelBtn && hasChanges && confirm('Deseja cancelar as alterações?')) {
                window.location.href = cancelBtn.href;
            }
        }
    });

    // Adiciona animação de shake ao CSS
    const style = document.createElement('style');
    style.textContent = `
        .shake {
            animation: shake 0.5s;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.02); }
        }
    `;
    document.head.appendChild(style);
</script>

<?php include VIEWS . '/layouts/footer.php'; ?>