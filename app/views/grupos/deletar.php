<?php include VIEWS . '/layouts/header.php'; ?>

<style>
    :root {
        --primary: #667eea;
        --danger: #ef4444;
        --danger-hover: #dc2626;
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
        25% { transform: translateX(-8px); }
        50% { transform: translateX(8px); }
        75% { transform: translateX(-8px); }
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.8; }
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

    .card-danger {
        border: 2px solid var(--danger);
        box-shadow: 0 4px 20px rgba(239, 68, 68, 0.15);
    }

    .card h2 {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--danger);
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        animation: fadeInDown 0.5s ease-out 0.1s both;
    }

    .subtitle {
        color: var(--gray-600);
        font-size: 1rem;
        margin-bottom: 1.75rem;
        line-height: 1.6;
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

    .alert-warning {
        background: #fef3c7;
        border: 2px solid #fde68a;
        color: #92400e;
    }

    /* ========== WARNING BOX ========== */
    .warning-box {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.08) 0%, rgba(239, 68, 68, 0.03) 100%);
        border: 2px solid rgba(239, 68, 68, 0.3);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.75rem;
        animation: fadeInUp 0.5s ease-out 0.2s both;
    }

    .warning-box-header {
        display: flex;
        align-items: center;
        gap: 0.875rem;
        margin-bottom: 1rem;
    }

    .warning-box-header svg {
        color: var(--danger);
        flex-shrink: 0;
    }

    .warning-box-header strong {
        color: var(--danger);
        font-size: 1.0625rem;
        font-weight: 700;
    }

    .warning-box ul {
        margin: 0;
        padding-left: 1.75rem;
        color: var(--gray-700);
    }

    .warning-box li {
        margin: 0.625rem 0;
        font-size: 0.9375rem;
        line-height: 1.6;
    }

    /* ========== GROUP INFO ========== */
    .group-info {
        background: var(--gray-50);
        border: 2px solid var(--gray-200);
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.75rem;
        animation: fadeInUp 0.5s ease-out 0.3s both;
    }

    .group-info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.875rem 0;
        border-bottom: 1px solid var(--gray-200);
    }

    .group-info-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .group-info-item:first-child {
        padding-top: 0;
    }

    .group-info-item strong {
        color: var(--gray-700);
        font-size: 0.9375rem;
        font-weight: 600;
    }

    .group-info-item span {
        color: var(--gray-900);
        font-weight: 600;
    }

    /* ========== FORM ELEMENTS ========== */
    .form-group {
        margin-bottom: 1.75rem;
        animation: fadeInUp 0.5s ease-out 0.4s both;
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
        border: 2px solid var(--danger);
        border-radius: 10px;
        font-size: 0.9375rem;
        color: var(--gray-900);
        transition: var(--transition);
        background: white;
        font-family: 'Courier New', monospace;
        font-weight: 700;
        letter-spacing: 1px;
        text-align: center;
        text-transform: uppercase;
    }

    .form-group input:focus {
        outline: none;
        border-color: var(--danger);
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
        transform: translateY(-1px);
    }

    .form-group input::placeholder {
        color: var(--gray-400);
        text-transform: none;
        letter-spacing: normal;
        font-family: inherit;
        font-weight: 400;
    }

    .confirmation-hint {
        display: flex;
        align-items: center;
        gap: 0.625rem;
        padding: 1rem;
        background: #fef3c7;
        border: 2px solid #fde68a;
        border-radius: 8px;
        margin-top: 0.75rem;
        font-size: 0.875rem;
        color: #92400e;
        font-weight: 600;
    }

    .confirmation-hint svg {
        color: var(--warning);
        flex-shrink: 0;
    }

    /* ========== FORM ACTIONS ========== */
    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2.25rem;
        animation: fadeInUp 0.5s ease-out 0.5s both;
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

    .btn-danger {
        background: linear-gradient(135deg, var(--danger) 0%, var(--danger-hover) 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.25);
    }

    .btn-danger:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(239, 68, 68, 0.35);
    }

    .btn-danger:active {
        transform: translateY(0);
    }

    .btn-danger:disabled {
        opacity: 0.5;
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

        .subtitle {
            font-size: 0.9375rem;
        }

        .form-actions {
            flex-direction: column-reverse;
        }

        .form-actions .btn {
            width: 100%;
        }

        .warning-box,
        .group-info {
            padding: 1.25rem;
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

        .subtitle {
            font-size: 0.875rem;
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

        .warning-box,
        .group-info {
            padding: 1rem;
        }

        .warning-box li,
        .group-info-item {
            font-size: 0.875rem;
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
    <div class="card card-danger">
        <h2>
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <path d="M12 8v4M12 16h.01"/>
            </svg>
            Deletar Grupo
        </h2>
        <p class="subtitle">Esta ação é permanente e não pode ser desfeita. Revise cuidadosamente antes de prosseguir.</p>

        <?php if (isset($error)): ?>
            <div class="alert alert-error">
                ⚠️ <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <div class="warning-box">
            <div class="warning-box-header">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                    <path d="M12 9v4M12 17h.01"/>
                </svg>
                <strong>Atenção! Ao deletar este grupo:</strong>
            </div>
            <ul>
                <li>Todo o histórico de transações será <strong>permanentemente perdido</strong></li>
                <li>Categorias personalizadas serão <strong>deletadas</strong></li>
                <li>Todos os membros <strong>perderão acesso</strong> imediato</li>
                <li>Esta ação <strong>não pode ser revertida</strong></li>
            </ul>
        </div>

        <div class="group-info">
            <div class="group-info-item">
                <strong>Nome do grupo:</strong>
                <span><?= htmlspecialchars($group['name']) ?></span>
            </div>
            <div class="group-info-item">
                <strong>Código de convite:</strong>
                <span><?= $group['invite_code'] ?></span>
            </div>
            <div class="group-info-item">
                <strong>Total de membros:</strong>
                <span><?= count($members) ?> membro(s)</span>
            </div>
            <div class="group-info-item">
                <strong>Criado em:</strong>
                <span><?= date('d/m/Y', strtotime($group['created_at'])) ?></span>
            </div>
        </div>

        <?php if (count($members) > 1): ?>
            <div class="alert alert-warning">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/>
                    <path d="M12 8v4M12 16h.01"/>
                </svg>
                <div>
                    <strong>Não é possível deletar!</strong><br>
                    Este grupo possui <?= count($members) ?> membros. Remova todos os outros membros antes de deletar o grupo.
                </div>
            </div>

            <div class="form-actions">
                <a href="/grupos/detalhes" class="btn btn-secondary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 12H5M12 19l-7-7 7-7"/>
                    </svg>
                    Voltar aos Detalhes
                </a>
            </div>
        <?php else: ?>
            <form method="POST" action="/grupos/deletar/<?= $group['id'] ?>" id="deleteForm">
                <div class="form-group">
                    <label for="confirm_delete">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10z"/>
                            <path d="M9 12l2 2 4-4"/>
                        </svg>
                        Confirmação de Exclusão *
                    </label>
                    <input 
                        type="text"
                        id="confirm_delete"
                        name="confirm_delete"
                        placeholder="Digite DELETAR para confirmar"
                        required
                        autocomplete="off"
                        spellcheck="false">
                    <div class="confirmation-hint">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10"/>
                            <path d="M12 16v-4M12 8h.01"/>
                        </svg>
                        Digite exatamente: <strong>DELETAR</strong> (em letras maiúsculas)
                    </div>
                </div>

                <div class="form-actions">
                    <a href="/grupos/detalhes" class="btn btn-secondary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M18 6L6 18M6 6l12 12"/>
                        </svg>
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-danger" id="deleteBtn" disabled>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="3 6 5 6 21 6"/>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                        </svg>
                        Deletar Permanentemente
                    </button>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>

<script>
    const form = document.getElementById('deleteForm');
    
    <?php if (count($members) <= 1): ?>
    const confirmInput = document.getElementById('confirm_delete');
    const deleteBtn = document.getElementById('deleteBtn');

    // ===== VALIDAÇÃO EM TEMPO REAL =====
    confirmInput.addEventListener('input', function() {
        const value = this.value.trim();
        
        if (value === 'DELETAR') {
            deleteBtn.disabled = false;
            this.style.borderColor = 'var(--danger)';
            this.style.background = 'rgba(239, 68, 68, 0.05)';
        } else {
            deleteBtn.disabled = true;
            this.style.borderColor = 'var(--danger)';
            this.style.background = 'white';
        }
    });

    // ===== VALIDAÇÃO DO FORMULÁRIO =====
    form.addEventListener('submit', function(e) {
        const value = confirmInput.value.trim();

        if (value !== 'DELETAR') {
            e.preventDefault();
            alert('⚠️ Digite exatamente "DELETAR" para confirmar a exclusão!');
            confirmInput.focus();
            confirmInput.classList.add('shake');
            setTimeout(() => confirmInput.classList.remove('shake'), 500);
            return;
        }

        // Confirmação final
        if (!confirm(`⚠️ ÚLTIMA CONFIRMAÇÃO!\n\nVocê está prestes a deletar permanentemente o grupo "${<?= json_encode($group['name']) ?>}".\n\nTodo o histórico de transações será perdido para sempre.\n\nTem certeza ABSOLUTA que deseja continuar?`)) {
            e.preventDefault();
            return;
        }

        // Feedback visual de loading
        deleteBtn.disabled = true;
        deleteBtn.style.animation = 'pulse 1s ease-in-out infinite';
        deleteBtn.innerHTML = `
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
            </svg>
            Deletando...
        `;
    });

    // ===== ANIMAÇÃO DE SHAKE =====
    const style = document.createElement('style');
    style.textContent = `
        .shake {
            animation: shake 0.5s;
        }
    `;
    document.head.appendChild(style);
    <?php endif; ?>

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
        // ESC para cancelar
        if (e.key === 'Escape') {
            const cancelBtn = document.querySelector('.btn-secondary');
            if (cancelBtn && confirm('Deseja cancelar a exclusão do grupo?')) {
                window.location.href = cancelBtn.href;
            }
        }
    });
</script>

<?php include VIEWS . '/layouts/footer.php'; ?>