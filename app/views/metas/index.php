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
        --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.12);
        --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.15);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* ========== ANIMATIONS ========== */
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
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

    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ========== CONTAINER ========== */
    .container-small {
        max-width: 1200px;
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
        flex-wrap: wrap;
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
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.35);
    }

    .btn-primary:active,
    .btn-secondary:active {
        transform: translateY(0);
    }

    .btn-success {
        background: var(--success);
        color: white;
    }

    .btn-success:hover {
        background: #059669;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .btn-warning {
        background: var(--warning);
        color: white;
    }

    .btn-warning:hover {
        background: #d97706;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
    }

    /* ========== EMPTY STATE ========== */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        animation: fadeInUp 0.5s ease-out 0.2s both;
    }

    .empty-icon {
        font-size: 4rem;
        margin-bottom: 1.5rem;
        opacity: 0.3;
        animation: pulse 2s ease-in-out infinite;
    }

    .empty-state h3 {
        color: var(--gray-900);
        margin-bottom: 0.75rem;
        font-size: 1.5rem;
        font-weight: 600;
    }

    .empty-state p {
        color: var(--gray-500);
        font-size: 1rem;
        line-height: 1.6;
        max-width: 480px;
        margin: 0 auto 2rem auto;
    }

    /* ========== GOALS GRID ========== */
    .goals-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
        gap: 2rem;
        animation: fadeInUp 0.5s ease-out 0.3s both;
    }

    .goal-card {
        background: white;
        border-radius: 16px;
        padding: 1.75rem;
        box-shadow: var(--shadow-md);
        border: 2px solid var(--gray-200);
        transition: var(--transition);
        position: relative;
    }

    .goal-card.completed {
        border-left: 4px solid var(--success);
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.03) 0%, rgba(255, 255, 255, 1) 100%);
    }

    .goal-card.overdue {
        border-left: 4px solid var(--danger);
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.03) 0%, rgba(255, 255, 255, 1) 100%);
    }

    .goal-card.on-track {
        border-left: 4px solid #3b82f6;
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.03) 0%, rgba(255, 255, 255, 1) 100%);
    }

    .goal-card.in-progress {
        border-left: 4px solid var(--warning);
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.03) 0%, rgba(255, 255, 255, 1) 100%);
    }

    .goal-card:hover {
        border-color: var(--primary);
        box-shadow: 0 8px 24px rgba(102, 126, 234, 0.15);
        transform: translateY(-3px);
    }

    .goal-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1.5rem;
        gap: 1rem;
    }

    .goal-title-section {
        flex: 1;
        min-width: 0;
    }

    .goal-name {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--gray-900);
        margin: 0 0 0.5rem 0;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        line-height: 1.4;
    }

    .goal-status {
        display: inline-flex;
        align-items: center;
        padding: 0.375rem 0.875rem;
        border-radius: 20px;
        color: white;
        font-size: 0.6875rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        white-space: nowrap;
    }

    .goal-amount {
        text-align: right;
        flex-shrink: 0;
    }

    .amount-label {
        font-size: 0.75rem;
        color: var(--gray-500);
        margin-bottom: 0.25rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 500;
    }

    .amount-value {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--primary);
        letter-spacing: -0.02em;
    }

    /* ========== PROGRESS SECTION ========== */
    .goal-progress-section {
        margin-bottom: 1.5rem;
    }

    .progress-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 0.75rem;
        gap: 1rem;
    }

    .progress-label {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
        flex: 1;
        min-width: 0;
    }

    .current-amount {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--gray-900);
    }

    .progress-text {
        font-size: 0.875rem;
        color: var(--gray-500);
    }

    .progress-percentage {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--primary);
        flex-shrink: 0;
    }

    .progress-bar-wrapper {
        margin-bottom: 0.5rem;
    }

    .progress-bar-bg {
        width: 100%;
        height: 12px;
        background: var(--gray-200);
        border-radius: 6px;
        overflow: hidden;
    }

    .progress-bar-fill {
        height: 100%;
        transition: width 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 6px;
    }

    /* ========== STATS ========== */
    .goal-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }

    .stat-card {
        background: var(--gray-50);
        padding: 0.875rem;
        border-radius: 10px;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        transition: var(--transition);
    }

    .stat-card:hover {
        background: var(--gray-100);
        transform: translateY(-2px);
    }

    .stat-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin-bottom: 0.25rem;
    }

    .stat-content {
        flex: 1;
        min-width: 0;
    }

    .stat-label {
        font-size: 0.6875rem;
        color: var(--gray-500);
        margin-bottom: 0.25rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .stat-value {
        font-size: 0.9375rem;
        font-weight: 700;
        color: var(--gray-900);
        word-break: break-word;
        line-height: 1.3;
    }

    /* ========== ALERT ========== */
    .alert-warning {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.875rem 1rem;
        background: #fef3c7;
        border: 2px solid #fbbf24;
        border-radius: 10px;
        color: #92400e;
        font-size: 0.875rem;
        margin-bottom: 1rem;
        line-height: 1.5;
    }

    .alert-warning svg {
        flex-shrink: 0;
    }

    /* ========== ACTIONS ========== */
    .goal-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.625rem;
        padding-top: 1rem;
        border-top: 1px solid var(--gray-200);
    }

    .btn-action {
        padding: 0.75rem 1rem;
        border: 2px solid;
        border-radius: 10px;
        font-weight: 600;
        font-size: 0.8125rem;
        cursor: pointer;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: var(--transition);
        font-family: inherit;
        background: white;
    }

    .btn-deposit {
        border-color: var(--success);
        color: var(--success);
    }

    .btn-deposit:hover {
        background: var(--success);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .btn-withdraw {
        border-color: var(--warning);
        color: var(--warning);
    }

    .btn-withdraw:hover {
        background: var(--warning);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
    }

    .btn-edit {
        border-color: #3b82f6;
        color: #3b82f6;
    }

    .btn-edit:hover {
        background: #3b82f6;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }

    .btn-delete-action {
        border-color: var(--danger);
        color: var(--danger);
    }

    .btn-delete-action:hover {
        background: var(--danger);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    .btn-action:active {
        transform: translateY(0);
    }

    /* ========== MODAL ========== */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        align-items: center;
        justify-content: center;
        padding: 1rem;
        backdrop-filter: blur(4px);
        animation: fadeIn 0.3s ease-out;
    }

    .modal-content {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        max-width: 480px;
        width: 100%;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        animation: slideUp 0.3s ease-out;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .modal-header h2 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--gray-900);
        margin: 0;
    }

    .modal-close {
        background: none;
        border: none;
        color: var(--gray-400);
        cursor: pointer;
        padding: 0.5rem;
        display: flex;
        transition: var(--transition);
        border-radius: 8px;
    }

    .modal-close:hover {
        color: var(--gray-600);
        background: var(--gray-100);
    }

    .modal-description {
        color: var(--gray-600);
        margin-bottom: 1rem;
        font-size: 0.9375rem;
        line-height: 1.5;
    }

    .modal-description strong {
        color: var(--gray-900);
    }

    .form-group {
        margin-bottom: 1.25rem;
    }

    .form-group label {
        display: block;
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--gray-700);
        margin-bottom: 0.5rem;
    }

    .form-group input {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 2px solid var(--gray-300);
        border-radius: 10px;
        font-size: 1rem;
        transition: var(--transition);
        font-family: inherit;
    }

    .form-group input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    }

    .form-group small {
        display: block;
        margin-top: 0.5rem;
        font-size: 0.8125rem;
        color: var(--gray-500);
    }

    .modal-actions {
        display: flex;
        gap: 0.75rem;
        margin-top: 1.5rem;
    }

    .modal-actions .btn {
        flex: 1;
        padding: 0.875rem 1.5rem;
        justify-content: center;
    }

    /* ========== RESPONSIVE - TABLET ========== */
    @media (max-width: 1024px) {
        .container-small {
            padding: 1.5rem;
        }

        .card {
            padding: 2rem;
        }

        .goals-grid {
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 1.25rem;
        }

        .goal-card {
            padding: 1.25rem;
        }

        .stat-value {
            font-size: 0.875rem;
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

        .goals-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .goal-card {
            padding: 1.5rem;
        }

        .goal-header {
            flex-direction: column;
            gap: 1rem;
        }

        .goal-amount {
            text-align: left;
        }

        .amount-value {
            font-size: 1.375rem;
        }

        .goal-stats {
            grid-template-columns: 1fr;
            gap: 0.625rem;
        }

        .stat-card {
            padding: 0.75rem;
            flex-direction: row;
            align-items: center;
            gap: 0.75rem;
        }

        .stat-icon {
            margin-bottom: 0;
        }

        .stat-value {
            font-size: 1rem;
        }

        .goal-actions {
            grid-template-columns: 1fr;
            gap: 0.5rem;
        }

        .btn-action {
            width: 100%;
            padding: 0.875rem 1rem;
        }

        .modal-content {
            padding: 1.5rem;
            max-width: 100%;
        }

        .modal-header h2 {
            font-size: 1.25rem;
        }

        .modal-actions {
            flex-direction: column;
        }

        .modal-actions .btn {
            width: 100%;
        }

        .empty-state {
            padding: 3rem 1.5rem;
        }

        .empty-state h3 {
            font-size: 1.25rem;
        }

        .empty-state p {
            font-size: 0.9375rem;
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

        .goal-name {
            font-size: 1.125rem;
        }

        .progress-percentage {
            font-size: 1.25rem;
        }

        .current-amount {
            font-size: 1rem;
        }

        .progress-text {
            font-size: 0.8125rem;
        }

        .alert-warning {
            font-size: 0.8125rem;
            padding: 0.75rem 0.875rem;
        }

        .btn-action {
            font-size: 0.75rem;
            padding: 0.75rem 0.875rem;
        }

        .form-group input {
            font-size: 16px; /* Previne zoom no iOS */
        }

        .goal-card {
            padding: 1rem;
        }

        .amount-value {
            font-size: 1.25rem;
        }

        .stat-value {
            font-size: 0.875rem;
        }

        .modal-content {
            padding: 1.25rem;
        }
    }

    /* ========== PWA/STANDALONE MODE ========== */
    @media (display-mode: standalone) {
        .container-small {
            padding-top: calc(env(safe-area-inset-top) + 2rem);
            padding-bottom: calc(env(safe-area-inset-bottom) + 2rem);
        }

        .modal {
            padding-top: env(safe-area-inset-top);
            padding-bottom: env(safe-area-inset-bottom);
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

    @media (prefers-contrast: high) {
        .goal-card {
            border: 2px solid currentColor;
        }

        .btn-action {
            border-width: 3px;
        }
    }
</style>

<div class="container-small">
    <div class="card">
        <div class="page-header-section">
            <div>
                <h2>🎯 Metas Financeiras</h2>
                <p class="subtitle">Planeje e acompanhe seus objetivos</p>
            </div>
            <div class="header-actions">
                <a href="/metas/criar" class="btn btn-primary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 5v14M5 12h14" />
                    </svg>
                    Nova Meta
                </a>
            </div>
        </div>

        <?php if (empty($goals)): ?>
            <div class="empty-state">
                <div class="empty-icon">🎯</div>
                <h3>Nenhuma meta cadastrada</h3>
                <p>Crie sua primeira meta financeira e comece a realizar seus sonhos!</p>
                <a href="/metas/criar" class="btn btn-primary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 5v14M5 12h14" />
                    </svg>
                    Criar primeira meta
                </a>
            </div>
        <?php else: ?>
            <div class="goals-grid">
                <?php foreach ($goals as $goal):
                    $progress = $goal['progress'];
                    $percentage = $progress['percentage'];
                    $remaining = $progress['remaining'];
                    $daysRemaining = $progress['days_remaining'];
                    $isOverdue = $progress['is_overdue'];

                    // Calcula valor mensal necessário
                    $monthsRemaining = max(1, ceil($daysRemaining / 30));
                    $monthlyNeeded = $remaining / $monthsRemaining;

                    // Define cor do progresso
                    if ($percentage >= 100) {
                        $progressColor = '#10b981';
                        $statusClass = 'completed';
                        $statusText = 'Concluída';
                    } elseif ($isOverdue) {
                        $progressColor = '#ef4444';
                        $statusClass = 'overdue';
                        $statusText = 'Atrasada';
                    } elseif ($percentage >= 75) {
                        $progressColor = '#3b82f6';
                        $statusClass = 'on-track';
                        $statusText = 'No caminho';
                    } else {
                        $progressColor = '#f59e0b';
                        $statusClass = 'in-progress';
                        $statusText = 'Em andamento';
                    }
                ?>
                    <div class="goal-card <?= $statusClass ?>">
                        <div class="goal-header">
                            <div class="goal-title-section">
                                <h3 class="goal-name"><?= htmlspecialchars($goal['name']) ?></h3>
                                <span class="goal-status" style="background: <?= $progressColor ?>">
                                    <?= $statusText ?>
                                </span>
                            </div>

                            <div class="goal-amount">
                                <div class="amount-label">Meta</div>
                                <div class="amount-value">R$ <?= number_format($goal['target_amount'], 2, ',', '.') ?></div>
                            </div>
                        </div>

                        <div class="goal-progress-section">
                            <div class="progress-header">
                                <div class="progress-label">
                                    <span class="current-amount">R$ <?= number_format($goal['current_amount'], 2, ',', '.') ?></span>
                                    <span class="progress-text">de R$ <?= number_format($goal['target_amount'], 2, ',', '.') ?></span>
                                </div>
                                <span class="progress-percentage"><?= number_format($percentage, 1) ?>%</span>
                            </div>

                            <div class="progress-bar-wrapper">
                                <div class="progress-bar-bg">
                                    <div class="progress-bar-fill" style="width: <?= min(100, $percentage) ?>%; background: <?= $progressColor ?>"></div>
                                </div>
                            </div>
                        </div>

                        <div class="goal-stats">
                            <div class="stat-card">
                                <div class="stat-icon" style="background: rgba(239, 68, 68, 0.1); color: #ef4444">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                                    </svg>
                                </div>
                                <div class="stat-content">
                                    <div class="stat-label">Falta</div>
                                    <div class="stat-value">R$ <?= number_format($remaining, 2, ',', '.') ?></div>
                                </div>
                            </div>

                            <div class="stat-card">
                                <div class="stat-icon" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                        <path d="M16 2v4M8 2v4M3 10h18" />
                                    </svg>
                                </div>
                                <div class="stat-content">
                                    <div class="stat-label">Prazo</div>
                                    <div class="stat-value"><?= $daysRemaining ?> dias</div>
                                </div>
                            </div>

                            <div class="stat-card">
                                <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981">
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                                    </svg>
                                </div>
                                <div class="stat-content">
                                    <div class="stat-label">Por mês</div>
                                    <div class="stat-value">R$ <?= number_format($monthlyNeeded, 2, ',', '.') ?></div>
                                </div>
                            </div>
                        </div>

                        <?php if ($isOverdue && $percentage < 100): ?>
                            <div class="alert-warning">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                                    <line x1="12" y1="9" x2="12" y2="13" />
                                    <line x1="12" y1="17" x2="12.01" y2="17" />
                                </svg>
                                <span>Meta em atraso! O prazo expirou em <?= date('d/m/Y', strtotime($goal['deadline'])) ?></span>
                            </div>
                        <?php endif; ?>

                        <div class="goal-actions">
                            <button class="btn-action btn-deposit" onclick="openDepositModal(<?= $goal['id'] ?>, '<?= htmlspecialchars($goal['name']) ?>')">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 5v14M5 12h14" />
                                </svg>
                                Depositar
                            </button>
                            <button class="btn-action btn-withdraw" onclick="openWithdrawModal(<?= $goal['id'] ?>, '<?= htmlspecialchars($goal['name']) ?>', <?= $goal['current_amount'] ?>)">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M5 12h14" />
                                </svg>
                                Retirar
                            </button>
                            <a href="/metas/editar/<?= $goal['id'] ?>" class="btn-action btn-edit">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                </svg>
                                Editar
                            </a>
                            <a href="/metas/deletar/<?= $goal['id'] ?>"
                                class="btn-action btn-delete-action"
                                onclick="return confirm('Tem certeza que deseja deletar esta meta?')">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="3 6 5 6 21 6" />
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                </svg>
                                Excluir
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal de Depósito -->
<div id="depositModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>💰 Depositar na Meta</h2>
            <button class="modal-close" onclick="closeDepositModal()">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                </svg>
            </button>
        </div>

        <form method="POST" id="depositForm">
            <p class="modal-description">Meta: <strong id="goalNameDeposit"></strong></p>

            <div class="form-group">
                <label for="depositAmount">Valor a depositar (R$)</label>
                <input
                    type="text"
                    id="depositAmount"
                    name="amount"
                    placeholder="R$ 0,00"
                    required>
                <small>Digite o valor que deseja adicionar à meta</small>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn btn-secondary" onclick="closeDepositModal()">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                    Cancelar
                </button>
                <button type="submit" class="btn btn-success">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                    Confirmar Depósito
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal de Retirada -->
<div id="withdrawModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>📤 Retirar da Meta</h2>
            <button class="modal-close" onclick="closeWithdrawModal()">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                </svg>
            </button>
        </div>

        <form method="POST" id="withdrawForm">
            <p class="modal-description">Meta: <strong id="goalNameWithdraw"></strong></p>
            <p class="modal-description">Saldo disponível: <strong id="availableBalance">R$ 0,00</strong></p>

            <div class="form-group">
                <label for="withdrawAmount">Valor a retirar (R$)</label>
                <input
                    type="text"
                    id="withdrawAmount"
                    name="amount"
                    placeholder="R$ 0,00"
                    required>
                <small>Digite o valor que deseja retirar da meta</small>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn btn-secondary" onclick="closeWithdrawModal()">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                    Cancelar
                </button>
                <button type="submit" class="btn btn-warning">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                    Confirmar Retirada
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let currentGoalId = null;
let currentBalance = 0;

function openDepositModal(goalId, goalName) {
    currentGoalId = goalId;
    document.getElementById('goalNameDeposit').textContent = goalName;
    document.getElementById('depositForm').action = '/metas/addProgress/' + goalId;
    document.getElementById('depositModal').style.display = 'flex';
    document.getElementById('depositAmount').value = '';
    document.getElementById('depositAmount').focus();
}

function closeDepositModal() {
    document.getElementById('depositModal').style.display = 'none';
    document.getElementById('depositAmount').value = '';
}

function openWithdrawModal(goalId, goalName, balance) {
    currentGoalId = goalId;
    currentBalance = balance;
    document.getElementById('goalNameWithdraw').textContent = goalName;
    document.getElementById('availableBalance').textContent = 'R$ ' + balance.toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    document.getElementById('withdrawForm').action = '/metas/removeProgress/' + goalId;
    document.getElementById('withdrawModal').style.display = 'flex';
    document.getElementById('withdrawAmount').value = '';
    document.getElementById('withdrawAmount').focus();
}

function closeWithdrawModal() {
    document.getElementById('withdrawModal').style.display = 'none';
    document.getElementById('withdrawAmount').value = '';
}

// Máscara de dinheiro simplificada
function formatMoney(input) {
    let value = input.value.replace(/\D/g, ''); // Remove tudo que não é número
    
    if (!value) {
        input.value = '';
        return;
    }
    
    // Converte centavos para reais
    value = (parseInt(value) / 100).toFixed(2);
    
    // Formata: 1.00 -> 1,00 -> R$ 1,00
    value = value.replace('.', ',');
    value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    
    input.value = 'R$ ' + value;
}

// Converte valor formatado para número
function parseMoneyValue(formattedValue) {
    // Remove "R$ ", pontos de milhar e substitui vírgula por ponto
    let value = formattedValue
        .replace('R$', '')
        .replace(/\s/g, '')
        .replace(/\./g, '')
        .replace(',', '.');
    
    return parseFloat(value);
}

// Eventos para os inputs
document.getElementById('depositAmount').addEventListener('input', function() {
    formatMoney(this);
});

document.getElementById('withdrawAmount').addEventListener('input', function() {
    formatMoney(this);
});

// Submit do formulário de depósito
document.getElementById('depositForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Previne envio padrão
    
    const input = document.getElementById('depositAmount');
    const displayValue = input.value;
    
    if (!displayValue || displayValue === 'R$ 0,00' || displayValue === '') {
        alert('Digite um valor válido!');
        return;
    }
    
    const numValue = parseMoneyValue(displayValue);
    
    if (isNaN(numValue) || numValue <= 0) {
        alert('Digite um valor válido!');
        return;
    }
    
    // Cria um formulário temporário com o valor correto
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = this.action;
    
    const amountInput = document.createElement('input');
    amountInput.type = 'hidden';
    amountInput.name = 'amount';
    amountInput.value = numValue.toFixed(2);
    
    form.appendChild(amountInput);
    document.body.appendChild(form);
    form.submit();
});

// Submit do formulário de retirada
document.getElementById('withdrawForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Previne envio padrão
    
    const input = document.getElementById('withdrawAmount');
    const displayValue = input.value;
    
    if (!displayValue || displayValue === 'R$ 0,00' || displayValue === '') {
        alert('Digite um valor válido!');
        return;
    }
    
    const numValue = parseMoneyValue(displayValue);
    
    if (isNaN(numValue) || numValue <= 0) {
        alert('Digite um valor válido!');
        return;
    }
    
    // Valida se não excede o saldo
    if (numValue > currentBalance) {
        alert('Valor de retirada não pode ser maior que o saldo disponível!\n\nDisponível: R$ ' + currentBalance.toFixed(2).replace('.', ','));
        return;
    }
    
    // Cria um formulário temporário com o valor correto
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = this.action;
    
    const amountInput = document.createElement('input');
    amountInput.type = 'hidden';
    amountInput.name = 'amount';
    amountInput.value = numValue.toFixed(2);
    
    form.appendChild(amountInput);
    document.body.appendChild(form);
    form.submit();
});

// Fechar modal ao clicar fora
window.onclick = function(event) {
    const depositModal = document.getElementById('depositModal');
    const withdrawModal = document.getElementById('withdrawModal');
    
    if (event.target == depositModal) {
        closeDepositModal();
    }
    if (event.target == withdrawModal) {
        closeWithdrawModal();
    }
}
</script>

<?php include VIEWS . '/layouts/footer.php'; ?>