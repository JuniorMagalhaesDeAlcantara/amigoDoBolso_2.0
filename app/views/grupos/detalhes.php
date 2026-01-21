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

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }

    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }

    /* ========== CONTAINER ========== */
    .container-small {
        max-width: 900px;
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

    /* ========== PAGE HEADER ========== */
    .page-header-section {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 2.5rem;
        gap: 1.5rem;
        animation: fadeInDown 0.5s ease-out 0.1s both;
    }

    .page-header-section h2 {
        margin: 0 0 0.5rem 0;
        font-size: 1.875rem;
        font-weight: 700;
        color: var(--gray-900);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .subtitle {
        color: var(--gray-600);
        margin: 0;
        font-size: 1rem;
        line-height: 1.5;
    }

    .header-actions {
        display: flex;
        gap: 0.75rem;
        flex-shrink: 0;
    }

    /* ========== BUTTONS ========== */
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.75rem 1.25rem;
        border-radius: 10px;
        font-size: 0.9375rem;
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
        cursor: pointer;
        border: none;
        white-space: nowrap;
        font-family: inherit;
    }

    .btn-success {
        background: linear-gradient(135deg, var(--success) 0%, #059669 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);
    }

    .btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.35);
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

    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.25);
        width: 100%;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.35);
    }

    .btn-primary:active,
    .btn-success:active,
    .btn-secondary:active {
        transform: translateY(0);
    }

    /* ========== GROUP DETAILS ========== */
    .group-details {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
        margin-bottom: 2.5rem;
        animation: fadeInUp 0.5s ease-out 0.2s both;
    }

    .detail-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem;
        background: var(--gray-50);
        border-radius: 12px;
        border: 2px solid var(--gray-200);
        transition: var(--transition);
    }

    .detail-item:hover {
        background: white;
        border-color: var(--gray-300);
        box-shadow: 0 4px 12px rgba(0,0,0,0.06);
        transform: translateY(-2px);
    }

    .detail-item.highlight {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        color: white;
        border: none;
        position: relative;
        overflow: hidden;
    }

    .detail-item.highlight::before {
        content: '';
        position: absolute;
        top: 0;
        left: -200%;
        width: 200%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        animation: shimmer 3s infinite;
    }

    .detail-item.highlight strong {
        color: white;
    }

    .detail-label {
        display: flex;
        align-items: center;
        gap: 0.875rem;
    }

    .detail-label strong {
        font-size: 0.9375rem;
        font-weight: 600;
        color: var(--gray-700);
    }

    .detail-label svg {
        color: var(--primary);
        flex-shrink: 0;
    }

    .detail-item.highlight .detail-label svg,
    .detail-item.highlight .detail-label strong {
        color: white;
    }

    .detail-item > span {
        font-size: 1rem;
        font-weight: 600;
        color: var(--gray-900);
    }

    /* ========== INVITE CODE SECTION ========== */
    .invite-code-section {
        display: flex;
        align-items: center;
        gap: 1.25rem;
    }

    .invite-code-display {
        font-family: 'Courier New', monospace;
        font-size: 1.625rem;
        font-weight: 800;
        color: white;
        letter-spacing: 3px;
        padding: 0.75rem 1.25rem;
        background: rgba(255,255,255,0.2);
        border-radius: 10px;
        border: 2px dashed rgba(255,255,255,0.6);
        backdrop-filter: blur(10px);
    }

    .btn-copy {
        background: white;
        color: var(--primary);
        border: 2px solid white;
        padding: 0.625rem 1.125rem;
        font-size: 0.875rem;
        font-weight: 700;
        transition: var(--transition);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .btn-copy:hover {
        background: rgba(255,255,255,0.95);
        transform: scale(1.05);
    }

    .btn-copy.copied {
        background: var(--success);
        color: white;
        border-color: var(--success);
        animation: pulse 0.5s;
    }

    /* ========== DIVIDER ========== */
    hr {
        border: none;
        border-top: 2px solid var(--gray-200);
        margin: 2.5rem 0;
        opacity: 0.6;
    }

    /* ========== SECTION HEADER ========== */
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 2.5rem 0 1.5rem 0;
        animation: fadeInUp 0.5s ease-out 0.3s both;
    }

    .section-header h3 {
        margin: 0;
        font-size: 1.375rem;
        font-weight: 700;
        color: var(--gray-900);
        display: flex;
        align-items: center;
        gap: 0.625rem;
    }

    .member-count {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 700;
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
    }

    /* ========== MEMBERS LIST ========== */
    .members-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        margin-top: 1.5rem;
        animation: fadeInUp 0.5s ease-out 0.4s both;
    }

    .member-card {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.25rem 1.5rem;
        background: white;
        border: 2px solid var(--gray-200);
        border-radius: 12px;
        transition: var(--transition);
    }

    .member-card:hover {
        border-color: var(--primary);
        box-shadow: 0 6px 16px rgba(102, 126, 234, 0.15);
        transform: translateY(-3px);
    }

    .member-info {
        display: flex;
        align-items: center;
        gap: 1.125rem;
    }

    .member-avatar {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.0625rem;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .member-details {
        display: flex;
        flex-direction: column;
        gap: 0.375rem;
    }

    .member-details strong {
        font-size: 1.0625rem;
        font-weight: 600;
        color: var(--gray-900);
    }

    .member-details small {
        color: var(--gray-500);
        font-size: 0.875rem;
    }

    .member-meta {
        text-align: right;
    }

    .member-date {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--gray-600);
        font-size: 0.875rem;
        font-weight: 500;
        padding: 0.625rem 1rem;
        background: var(--gray-50);
        border-radius: 8px;
        border: 1px solid var(--gray-200);
    }

    .member-date svg {
        color: var(--gray-400);
    }

    /* ========== FORM ACTIONS ========== */
    .form-actions {
        margin-top: 2.5rem;
        padding-top: 2.5rem;
        border-top: 2px solid var(--gray-200);
        animation: fadeInUp 0.5s ease-out 0.5s both;
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

        .page-header-section {
            flex-direction: column;
            align-items: stretch;
            gap: 1.25rem;
        }

        .page-header-section h2 {
            font-size: 1.5rem;
        }

        .header-actions {
            flex-direction: column;
        }

        .header-actions .btn {
            width: 100%;
        }

        .detail-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
            padding: 1.25rem;
        }

        .detail-item > span {
            font-size: 0.9375rem;
        }

        .invite-code-section {
            flex-direction: column;
            align-items: stretch;
            width: 100%;
            gap: 1rem;
        }

        .invite-code-display {
            font-size: 1.375rem;
            letter-spacing: 2px;
            text-align: center;
        }

        .btn-copy {
            width: 100%;
        }

        .member-card {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
            padding: 1.25rem;
        }

        .member-meta {
            text-align: left;
            width: 100%;
        }

        .member-date {
            width: 100%;
            justify-content: center;
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

        .page-header-section h2 {
            font-size: 1.375rem;
        }

        .subtitle {
            font-size: 0.875rem;
        }

        .detail-item {
            padding: 1rem;
        }

        .detail-label {
            gap: 0.625rem;
        }

        .detail-label svg {
            width: 18px;
            height: 18px;
        }

        .invite-code-display {
            font-size: 1.125rem;
            padding: 0.625rem 1rem;
        }

        .member-avatar {
            width: 48px;
            height: 48px;
            font-size: 1rem;
        }

        .member-details strong {
            font-size: 1rem;
        }

        .section-header h3 {
            font-size: 1.1875rem;
        }

        .btn {
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
        }

        .btn svg {
            width: 16px;
            height: 16px;
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
        <div class="page-header-section">
            <div>
                <h2>🏠 Detalhes do Grupo</h2>
                <p class="subtitle">Gerencie informações e membros do grupo</p>
            </div>
            <div class="header-actions">
                <a href="/grupos/criar" class="btn btn-success">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 5v14M5 12h14"/>
                    </svg>
                    Criar Novo Grupo
                </a>
                <a href="/grupos/entrar" class="btn btn-secondary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M13.8 12H3"/>
                    </svg>
                    Entrar em Grupo
                </a>
            </div>
        </div>
        
        <div class="group-details">
            <div class="detail-item">
                <div class="detail-label">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                    <strong>Nome do Grupo:</strong>
                </div>
                <span><?= htmlspecialchars($group['name']) ?></span>
            </div>
            
            <div class="detail-item highlight">
                <div class="detail-label">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    </svg>
                    <strong>Código de Convite:</strong>
                </div>
                <div class="invite-code-section">
                    <span class="invite-code-display"><?= $group['invite_code'] ?></span>
                    <button onclick="copyInviteCode('<?= $group['invite_code'] ?>')" class="btn btn-copy">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="9" y="9" width="13" height="13" rx="2" ry="2"/>
                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                        </svg>
                        Copiar
                    </button>
                </div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                        <path d="M16 2v4M8 2v4M3 10h18"/>
                    </svg>
                    <strong>Criado em:</strong>
                </div>
                <span><?= date('d/m/Y', strtotime($group['created_at'])) ?></span>
            </div>
        </div>
        
        <hr>
        
        <div class="section-header">
            <h3>👥 Membros do Grupo</h3>
            <span class="member-count"><?= count($members) ?> membro(s)</span>
        </div>
        
        <div class="members-list">
            <?php foreach ($members as $member): ?>
                <div class="member-card">
                    <div class="member-info">
                        <div class="member-avatar">
                            <?= strtoupper(substr($member['name'], 0, 2)) ?>
                        </div>
                        <div class="member-details">
                            <strong><?= htmlspecialchars($member['name']) ?></strong>
                            <small><?= htmlspecialchars($member['email']) ?></small>
                        </div>
                    </div>
                    <div class="member-meta">
                        <span class="member-date">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                <path d="M16 2v4M8 2v4M3 10h18"/>
                            </svg>
                            <?= date('d/m/Y', strtotime($member['joined_at'])) ?>
                        </span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="form-actions">
            <a href="/dashboard" class="btn btn-primary">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
                Voltar ao Dashboard
            </a>
        </div>
    </div>
</div>

<script>
function copyInviteCode(code) {
    navigator.clipboard.writeText(code).then(() => {
        const btn = event.target.closest('button');
        const originalHTML = btn.innerHTML;
        
        btn.innerHTML = `
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
            Copiado!
        `;
        btn.classList.add('copied');
        
        setTimeout(() => {
            btn.innerHTML = originalHTML;
            btn.classList.remove('copied');
        }, 2000);
    }).catch(() => {
        alert('Código: ' + code);
    });
}

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

// ===== ANIMAÇÃO DOS MEMBER CARDS =====
document.addEventListener('DOMContentLoaded', function() {
    const memberCards = document.querySelectorAll('.member-card');
    
    memberCards.forEach((card, index) => {
        card.style.animation = `fadeInUp 0.5s ease-out ${0.5 + (index * 0.08)}s both`;
    });
});
</script>

<?php include VIEWS . '/layouts/footer.php'; ?>