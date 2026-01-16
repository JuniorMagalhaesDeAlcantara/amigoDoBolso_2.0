<?php include VIEWS . '/layouts/header.php'; ?>

<style>
    :root {
        --primary: #667eea;
        --primary-hover: #5568d3;
        --secondary: #10b981;
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

    /* ========== CONTAINER ========== */
    .container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 2rem;
    }

    /* ========== CARD HEADER ========== */
    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        gap: 1rem;
        animation: fadeInDown 0.5s ease-out;
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

    .card-header h1 {
        font-size: 2rem;
        font-weight: 700;
        color: var(--gray-900);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    /* ========== CARD WRAPPER ========== */
    .card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--gray-200);
        animation: fadeInUp 0.5s ease-out 0.1s both;
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

    /* ========== EMPTY STATE ========== */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-icon {
        font-size: 5rem;
        margin-bottom: 1.5rem;
        opacity: 0.2;
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    .empty-state h3 {
        color: var(--gray-900);
        margin-bottom: 0.75rem;
        font-size: 1.5rem;
        font-weight: 600;
    }

    .empty-state p {
        color: var(--gray-600);
        margin-bottom: 2rem;
        font-size: 1rem;
        max-width: 400px;
        margin-left: auto;
        margin-right: auto;
        line-height: 1.6;
    }

    /* ========== BENEFITS GRID ========== */
    .benefits-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(420px, 1fr));
        gap: 2rem;
        padding: 0.5rem;
    }

    .benefit-wrapper {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        animation: fadeInUp 0.5s ease-out;
    }

    /* ========== BENEFIT CARD ========== */
    .benefit-card {
        min-height: 280px;
        border-radius: 16px;
        padding: 1.5rem;
        color: white;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.25);
        transition: var(--transition);
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        overflow: visible;
    }

    .benefit-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg,
            rgba(255, 255, 255, 0.1) 0%,
            rgba(255, 255, 255, 0) 50%,
            rgba(0, 0, 0, 0.1) 100%);
        pointer-events: none;
    }

    .benefit-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 45px rgba(0, 0, 0, 0.35);
    }

    .card-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        z-index: 1;
    }

    .card-middle {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        gap: 0.25rem;
        z-index: 1;
        margin: 0.75rem 0;
    }

    .card-bottom {
        z-index: 1;
    }

    /* ========== CHIP ========== */
    .card-chip {
        width: 48px;
        height: 38px;
    }

    .chip {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #e5c07b 0%, #daa520 100%);
        border-radius: 6px;
        position: relative;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .chip::before {
        content: '';
        position: absolute;
        top: 4px;
        left: 4px;
        right: 4px;
        bottom: 4px;
        background: repeating-linear-gradient(45deg,
            transparent,
            transparent 2px,
            rgba(0, 0, 0, 0.1) 2px,
            rgba(0, 0, 0, 0.1) 4px);
        border-radius: 3px;
    }

    /* ========== LOGO ========== */
    .card-logo {
        width: 65px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card-logo img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        filter: brightness(0) invert(1);
        opacity: 0.95;
    }

    /* ========== BENEFIT INFO ========== */
    .benefit-type {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .type-icon {
        font-size: 1.125rem;
    }

    .type-text {
        font-size: 0.6875rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        opacity: 0.9;
        font-weight: 600;
    }

    .benefit-name {
        font-size: 1rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        line-height: 1.3;
    }

    /* ========== CARD DETAILS ========== */
    .card-info-row {
        background: rgba(0, 0, 0, 0.15);
        padding: 0.875rem 1rem;
        border-radius: 10px;
        backdrop-filter: blur(10px);
        margin-bottom: 0.75rem;
    }

    .balance-section {
        text-align: center;
    }

    .balance-label {
        font-size: 0.6875rem;
        opacity: 0.8;
        margin-bottom: 0.25rem;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        font-weight: 600;
    }

    .balance-value {
        font-size: 1.25rem;
        font-weight: 800;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        font-family: 'Courier New', monospace;
    }

    .stats-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 0.75rem;
    }

    .stat-item {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .stat-label {
        font-size: 0.6875rem;
        opacity: 0.8;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 500;
    }

    .stat-value {
        font-size: 0.9375rem;
        font-weight: 700;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    }

    /* ========== PROGRESS ========== */
    .limit-progress {
        margin-bottom: 0;
    }

    .progress-bar {
        width: 100%;
        height: 6px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 3px;
        overflow: hidden;
        margin-bottom: 0.4rem;
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.2);
    }

    .progress-fill {
        height: 100%;
        transition: width 0.5s ease-out;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
    }

    .limit-text {
        display: flex;
        justify-content: space-between;
        font-size: 0.75rem;
        opacity: 0.95;
        font-weight: 600;
    }

    /* ========== BENEFIT ACTIONS ========== */
    .benefit-actions {
        display: flex;
        gap: 0.875rem;
    }

    .btn-action {
        flex: 1;
        padding: 0.875rem 1.25rem;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: var(--transition);
        font-size: 0.9375rem;
        box-shadow: var(--shadow-sm);
        background: white;
        font-family: inherit;
    }

    .btn-primary-action {
        color: var(--primary);
        border: 2px solid var(--primary);
    }

    .btn-primary-action:hover {
        background: var(--primary);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(102, 126, 234, 0.3);
    }

    .btn-delete-action {
        background: white;
        color: var(--danger);
        border: 2px solid var(--danger);
    }

    .btn-delete-action:hover {
        background: var(--danger);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(239, 68, 68, 0.3);
    }

    /* ========== INFO CARD ========== */
    .info-card {
        margin-top: 2.5rem;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, white 100%);
        border-left: 4px solid var(--primary);
        padding: 1.75rem;
        animation: fadeInUp 0.5s ease-out 0.2s both;
    }

    .info-card h3 {
        color: var(--primary);
        margin-bottom: 1.25rem;
        font-size: 1.25rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-card ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .info-card li {
        padding: 0.875rem 0;
        color: var(--gray-700);
        line-height: 1.6;
        font-size: 0.9375rem;
        border-bottom: 1px solid var(--gray-100);
    }

    .info-card li:last-child {
        border-bottom: none;
    }

    .info-card li strong {
        color: var(--gray-900);
        font-weight: 700;
    }

    /* ========== BUTTONS ========== */
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.875rem 1.75rem;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
        cursor: pointer;
        border: none;
        white-space: nowrap;
        font-family: inherit;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, #764ba2 100%);
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

    /* ========== RESPONSIVE - TABLET ========== */
    @media (max-width: 1024px) {
        .container {
            padding: 1.5rem;
        }

        .benefits-grid {
            grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
            gap: 1.5rem;
        }

        .card-header h1 {
            font-size: 1.75rem;
        }
    }

    /* ========== RESPONSIVE - MOBILE ========== */
    @media (max-width: 768px) {
        .container {
            padding: 1rem;
        }

        .card {
            padding: 1.5rem;
            border-radius: 12px;
        }

        .card-header {
            flex-direction: column;
            align-items: stretch;
            gap: 1rem;
        }

        .card-header h1 {
            font-size: 1.5rem;
        }

        .benefits-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .benefit-card {
            padding: 1.25rem;
        }

        .benefit-name {
            font-size: 0.9375rem;
        }

        .benefit-actions {
            flex-direction: column;
            gap: 0.75rem;
        }

        .btn-action {
            width: 100%;
        }

        .empty-state {
            padding: 3rem 1.5rem;
        }

        .empty-icon {
            font-size: 4rem;
        }

        .empty-state h3 {
            font-size: 1.25rem;
        }

        .empty-state p {
            font-size: 0.9375rem;
        }

        .info-card {
            padding: 1.25rem;
        }

        .info-card h3 {
            font-size: 1.125rem;
        }

        .info-card li {
            font-size: 0.875rem;
        }
    }

    /* ========== MOBILE PORTRAIT ========== */
    @media (max-width: 480px) {
        .container {
            padding: 0.875rem;
        }

        .card {
            padding: 1.25rem;
        }

        .card-header h1 {
            font-size: 1.375rem;
        }

        .benefits-grid {
            padding: 0;
        }

        .benefit-card {
            padding: 1rem;
        }

        .card-chip {
            width: 40px;
            height: 32px;
        }

        .card-logo {
            width: 55px;
            height: 35px;
        }

        .benefit-name {
            font-size: 0.875rem;
        }

        .balance-value {
            font-size: 1.125rem;
        }
    }

    /* PWA/Standalone Mode */
    @media (display-mode: standalone) {
        .container {
            padding-top: calc(env(safe-area-inset-top) + 2rem);
            padding-bottom: calc(env(safe-area-inset-bottom) + 2rem);
        }
    }
</style>

<div class="container">
    <div class="card-header">
        <h1>💼 Meus Benefícios (VR / VA)</h1>
        <a href="/beneficios/criar" class="btn btn-primary">+ Novo Benefício</a>
    </div>

    <div class="card">
        <?php if (empty($benefits)): ?>
            <div class="empty-state">
                <div class="empty-icon">🍽️</div>
                <h3>Nenhum benefício cadastrado</h3>
                <p>Cadastre seus vales (VR/VA) para controlar seus gastos com alimentação</p>
                <a href="/beneficios/criar" class="btn btn-primary">Cadastrar Primeiro Benefício</a>
            </div>
        <?php else: ?>
            <div class="benefits-grid">
                <?php foreach ($benefits as $benefit):
                    $providerStyles = [
                        'sodexo' => [
                            'gradient' => 'linear-gradient(135deg, #E4032E 0%, #C50229 100%)',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/7/7e/Sodexo.png'
                        ],
                        'caju' => [
                            'gradient' => 'linear-gradient(135deg, #FF6B35 0%, #E85A2A 100%)',
                            'logo' => 'https://assets-global.website-files.com/5f7a5e0f79d7896e66d6b3e8/5f8f5e3d8f8e5e0f79d789b8_caju-logo.svg'
                        ],
                        'swile' => [
                            'gradient' => 'linear-gradient(135deg, #6C5CE7 0%, #5847D0 100%)',
                            'logo' => 'https://www.swile.co/hubfs/Logo.svg'
                        ],
                        'alelo' => [
                            'gradient' => 'linear-gradient(135deg, #00A859 0%, #008C4A 100%)',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/c/cc/Alelo_logo.svg'
                        ],
                        'ticket' => [
                            'gradient' => 'linear-gradient(135deg, #FF6B00 0%, #E05A00 100%)',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/8/8a/Ticket_logo.svg'
                        ],
                        'vr' => [
                            'gradient' => 'linear-gradient(135deg, #00A859 0%, #00924D 100%)',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/b/b5/VR_Benef%C3%ADcios_logo.svg'
                        ],
                        'ben' => [
                            'gradient' => 'linear-gradient(135deg, #0066CC 0%, #0052A3 100%)',
                            'logo' => ''
                        ],
                        'ifood' => [
                            'gradient' => 'linear-gradient(135deg, #EA1D2C 0%, #C41723 100%)',
                            'logo' => 'https://static-images.ifood.com.br/image/upload/t_thumbnail/logosgde/logo_ifood.png'
                        ],
                        'flash' => [
                            'gradient' => 'linear-gradient(135deg, #FF5722 0%, #E64A19 100%)',
                            'logo' => ''
                        ],
                        'outros' => [
                            'gradient' => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                            'logo' => ''
                        ]
                    ];

                    $provider = $benefit['provider'] ?? 'outros';
                    $style = $providerStyles[$provider] ?? $providerStyles['outros'];

                    $typeIcon = $benefit['type'] === 'vr' ? '🍽️' : '🛒';
                    $typeName = $benefit['type'] === 'vr' ? 'Vale Refeição' : 'Vale Alimentação';

                    $percentUsed = $benefit['percent_used'];
                    $progressColor = $percentUsed > 90 ? '#ef4444' : ($percentUsed > 70 ? '#f59e0b' : '#10b981');
                ?>
                    <div class="benefit-wrapper">
                        <div class="benefit-card" style="background: <?= $style['gradient'] ?>">
                            <div class="card-top">
                                <div class="card-chip">
                                    <div class="chip"></div>
                                </div>
                                <div class="card-logo">
                                    <?php if (!empty($style['logo'])): ?>
                                        <img src="<?= $style['logo'] ?>" alt="<?= ucfirst($provider) ?>" onerror="this.style.display='none'">
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="card-middle">
                                <div class="benefit-type">
                                    <span class="type-icon"><?= $typeIcon ?></span>
                                    <span class="type-text"><?= $typeName ?></span>
                                </div>
                                <div class="benefit-name"><?= htmlspecialchars($benefit['name']) ?></div>
                            </div>

                            <div class="card-bottom">
                                <div class="card-info-row">
                                    <div class="balance-section">
                                        <div class="balance-label">Saldo</div>
                                        <div class="balance-value">R$ <?= number_format($benefit['current_balance'], 2, ',', '.') ?></div>
                                    </div>
                                </div>

                                <div class="stats-row">
                                    <div class="stat-item">
                                        <span class="stat-label">Gasto</span>
                                        <span class="stat-value">R$ <?= number_format($benefit['monthly_expense'], 2, ',', '.') ?></span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-label">Recarga</span>
                                        <span class="stat-value">R$ <?= number_format($benefit['monthly_amount'], 2, ',', '.') ?></span>
                                    </div>
                                </div>

                                <div class="limit-progress">
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: <?= min($percentUsed, 100) ?>%; background: <?= $progressColor ?>"></div>
                                    </div>
                                    <div class="limit-text">
                                        <span><?= number_format($percentUsed, 1) ?>% usado</span>
                                        <span>Recarga dia <?= $benefit['recharge_day'] ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="benefit-actions">
                            <a href="/beneficios/detalhes/<?= $benefit['id'] ?>" class="btn-action btn-primary-action">
                                📊 Detalhes
                            </a>
                            <a href="/beneficios/deletar/<?= $benefit['id'] ?>"
                                class="btn-action btn-delete-action"
                                onclick="return confirm('Tem certeza que deseja deletar este benefício?')">
                                🗑️ Excluir
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="card info-card">
        <h3>ℹ️ Como funcionam os benefícios?</h3>
        <ul>
            <li><strong>🍽️ Vale Refeição (VR):</strong> Para uso em restaurantes, lanchonetes e delivery</li>
            <li><strong>🛒 Vale Alimentação (VA):</strong> Para compras em mercados e supermercados</li>
            <li><strong>💰 Recarga automática:</strong> Todo mês no dia configurado, seu saldo é recarregado</li>
            <li><strong>📊 Controle de gastos:</strong> Acompanhe quanto gastou e quanto ainda tem disponível</li>
        </ul>
    </div>
</div>

<script>
    // Previne zoom em iOS
    if (/iPhone|iPad|iPod/i.test(navigator.userAgent)) {
        const viewport = document.querySelector('meta[name="viewport"]');
        if (viewport) {
            viewport.content = 'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no';
        }
    }
</script>

<?php include VIEWS . '/layouts/footer.php'; ?>