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

    /* ========== CARDS GRID ========== */
    .cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(420px, 1fr));
        gap: 2rem;
        padding: 0.5rem;
    }

    .card-wrapper {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        animation: fadeInUp 0.5s ease-out;
    }

    /* ========== CREDIT CARD ========== */
    .credit-card {
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

    .credit-card::before {
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

    .credit-card:hover {
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
    }

    .logo-white {
        filter: brightness(0) invert(1);
        opacity: 0.95;
    }

    /* ========== CARD INFO ========== */
    .card-name {
        font-size: 1rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .card-number {
        font-family: 'Courier New', monospace;
        font-size: 1.125rem;
        letter-spacing: 2.5px;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        font-weight: 500;
    }

    .card-holder {
        font-family: 'Courier New', monospace;
        font-size: 0.8125rem;
        letter-spacing: 1.2px;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        opacity: 0.9;
    }

    /* ========== CARD DETAILS ========== */
    .card-info-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 0.75rem;
        padding: 0.875rem 1rem;
        background: rgba(0, 0, 0, 0.15);
        border-radius: 10px;
        backdrop-filter: blur(10px);
    }

    .card-details-row {
        display: flex;
        gap: 1.5rem;
    }

    .card-detail {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .detail-label {
        font-size: 0.6875rem;
        opacity: 0.8;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 500;
    }

    .detail-value {
        font-size: 0.9375rem;
        font-weight: 700;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    }

    .card-invoice-compact {
        text-align: right;
    }

    .invoice-label {
        font-size: 0.6875rem;
        opacity: 0.8;
        margin-bottom: 0.25rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .invoice-value {
        font-size: 1.25rem;
        font-weight: 800;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        font-family: 'Courier New', monospace;
    }

    /* ========== LIMIT PROGRESS ========== */
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

    .available {
        font-weight: 700;
    }

    /* ========== CARD ACTIONS ========== */
    .card-actions {
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

        .cards-grid {
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

        .cards-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .credit-card {
            padding: 1.25rem;
        }

        .card-name {
            font-size: 1rem;
        }

        .card-number {
            font-size: 1.125rem;
        }

        .card-info-row {
            flex-direction: column;
            gap: 1rem;
            align-items: stretch;
            padding: 0.875rem;
        }

        .card-invoice-compact {
            text-align: left;
        }

        .card-actions {
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

        .cards-grid {
            padding: 0;
        }

        .credit-card {
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

        .card-name {
            font-size: 0.9375rem;
        }

        .card-number {
            font-size: 1rem;
        }

        .invoice-value {
            font-size: 1.25rem;
        }

        .card-details-row {
            gap: 1.5rem;
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
        <h1>💳 Meus Cartões de Crédito</h1>
        <a href="/cartoes/criar" class="btn btn-primary">+ Novo Cartão</a>
    </div>

    <div class="card">
        <?php if (empty($cards)): ?>
            <div class="empty-state">
                <div class="empty-icon">💳</div>
                <h3>Nenhum cartão cadastrado</h3>
                <p>Cadastre seus cartões de crédito para controlar melhor suas compras parceladas</p>
                <a href="/cartoes/criar" class="btn btn-primary">Cadastrar Primeiro Cartão</a>
            </div>
        <?php else: ?>
            <div class="cards-grid">
                <?php foreach ($cards as $card):
                    $bankStyles = [
                        'nubank' => [
                            'gradient' => 'linear-gradient(135deg, #8A05BE 0%, #C000FF 100%)',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/f/f7/Nubank_logo_2021.svg',
                            'logo_white' => true
                        ],
                        'inter' => [
                            'gradient' => 'linear-gradient(135deg, #FF7A00 0%, #FF9500 100%)',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/7/7e/Banco_Inter_logo.svg'
                        ],
                        'c6' => [
                            'gradient' => 'linear-gradient(135deg, #2D2D2D 0%, #1A1A1A 100%)',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/7/7b/C6_Bank_logo.svg'
                        ],
                        'itau' => [
                            'gradient' => 'linear-gradient(135deg, #FF6600 0%, #FF8C00 100%)',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/8/85/Ita%C3%BA_1992.svg'
                        ],
                        'bradesco' => [
                            'gradient' => 'linear-gradient(135deg, #CC092F 0%, #E30613 100%)',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/a/a9/Banco_Bradesco_logo_%28vertical%29.png',
                            'logo_white' => true
                        ],
                        'santander' => [
                            'gradient' => 'linear-gradient(135deg, #EC0000 0%, #FF0000 100%)',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/b/b8/Banco_Santander_Logotipo.svg',
                            'logo_white' => true
                        ],
                        'bb' => [
                            'gradient' => 'linear-gradient(135deg, #FFEB00 0%, #FFD700 100%)',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/5/53/Banco_do_Brasil_Logo.svg'
                        ],
                        'caixa' => [
                            'gradient' => 'linear-gradient(135deg, #0066B3 0%, #0080D6 100%)',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/3/3c/Caixa_Econ%C3%B4mica_Federal_logo_1997.svg',
                            'logo_white' => true
                        ],
                        'picpay' => [
                            'gradient' => 'linear-gradient(135deg, #21C25E 0%, #11D96D 100%)',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/5/5e/PicPay_Logogrande.png'
                        ],
                        'neon' => [
                            'gradient' => 'linear-gradient(135deg, #00D9A5 0%, #00E5B8 100%)',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/2/2b/Neon_logo_2021.png'
                        ],
                        'next' => [
                            'gradient' => 'linear-gradient(135deg, #00AB63 0%, #00C578 100%)',
                            'logo' => 'https://www.banconext.com.br/_next/static/media/logo.2c4f4c98.svg'
                        ],
                        'original' => [
                            'gradient' => 'linear-gradient(135deg, #00A859 0%, #00C069 100%)',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/9/91/Logo_Oficial_Banco_Original_-_Verde.png',
                            'logo_white' => true
                        ],
                        'outros' => [
                            'gradient' => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                            'logo' => ''
                        ]
                    ];

                    $bank = $card['bank'] ?? 'outros';
                    $style = $bankStyles[$bank] ?? $bankStyles['outros'];
                ?>
                    <div class="card-wrapper">
                        <div class="credit-card" style="background: <?= $style['gradient'] ?>">
                            <div class="card-top">
                                <div class="card-chip">
                                    <div class="chip"></div>
                                </div>

                                <div class="card-logo">
                                    <?php if (!empty($style['logo'])): ?>
                                        <img
                                            src="<?= $style['logo'] ?>"
                                            alt="<?= ucfirst($bank) ?>"
                                            class="<?= !empty($style['logo_white']) ? 'logo-white' : '' ?>"
                                            onerror="this.style.display='none'">
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="card-middle">
                                <div class="card-name"><?= htmlspecialchars($card['name']) ?></div>
                                <div class="card-number">•••• •••• •••• <?= $card['last_digits'] ?></div>
                                <?php if (!empty($card['holder_name'])): ?>
                                    <div class="card-holder"><?= strtoupper(htmlspecialchars($card['holder_name'])) ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="card-bottom">
                                <div class="card-info-row">
                                    <div class="card-details-row">
                                        <div class="card-detail">
                                            <span class="detail-label">Fecha</span>
                                            <span class="detail-value">Dia <?= $card['closing_day'] ?></span>
                                        </div>
                                        <div class="card-detail">
                                            <span class="detail-label">Vence</span>
                                            <span class="detail-value">Dia <?= $card['due_day'] ?></span>
                                        </div>
                                    </div>

                                    <div class="card-invoice-compact">
                                        <div class="invoice-label">Fatura</div>
                                        <div class="invoice-value">R$ <?= number_format($card['current_invoice'], 2, ',', '.') ?></div>
                                    </div>
                                </div>

                                <?php if ($card['credit_limit']): ?>
                                    <div class="limit-progress">
                                        <?php
                                        $percentUsed = ($card['current_invoice'] / $card['credit_limit']) * 100;
                                        $progressColor = $percentUsed > 80 ? '#ef4444' : ($percentUsed > 50 ? '#f59e0b' : '#10b981');
                                        ?>
                                        <div class="progress-bar">
                                            <div class="progress-fill" style="width: <?= min($percentUsed, 100) ?>%; background: <?= $progressColor ?>"></div>
                                        </div>
                                        <div class="limit-text">
                                            <span>Limite: R$ <?= number_format($card['credit_limit'], 2, ',', '.') ?></span>
                                            <span class="available">Disponível: R$ <?= number_format($card['available'], 2, ',', '.') ?></span>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="card-actions">
                            <a href="/cartoes/extrato/<?= $card['id'] ?>" class="btn-action btn-primary-action">
                                📊 Ver Extrato
                            </a>
                            <a href="/cartoes/deletar/<?= $card['id'] ?>"
                                class="btn-action btn-delete-action"
                                onclick="return confirm('Tem certeza que deseja deletar este cartão?\n\nAtenção: As transações já cadastradas não serão deletadas.')">
                                🗑️ Excluir
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
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