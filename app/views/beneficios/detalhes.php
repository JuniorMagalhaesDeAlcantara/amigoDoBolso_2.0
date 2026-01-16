<?php include VIEWS . '/layouts/header.php'; 

// Helper para nome do mês
$months = [
    1 => 'Janeiro', 2 => 'Fevereiro', 3 => 'Março', 4 => 'Abril',
    5 => 'Maio', 6 => 'Junho', 7 => 'Julho', 8 => 'Agosto',
    9 => 'Setembro', 10 => 'Outubro', 11 => 'Novembro', 12 => 'Dezembro'
];

$typeIcon = $benefit['type'] === 'vr' ? '🍔' : '🛒';
$typeName = $benefit['type'] === 'vr' ? 'Vale Refeição' : 'Vale Alimentação';
$percentUsed = $benefit['monthly_amount'] > 0 ? ($monthlyExpense / $benefit['monthly_amount']) * 100 : 0;
?>

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
    .container-details {
        max-width: 1000px;
        margin: 0 auto;
        padding: 2rem;
        animation: fadeIn 0.5s ease-out;
    }

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

    /* ========== HEADER ========== */
    .details-header {
        margin-bottom: 1.5rem;
        animation: fadeInDown 0.5s ease-out;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9375rem;
        margin-bottom: 1rem;
        padding: 0.625rem 1rem;
        border-radius: 8px;
        transition: var(--transition);
    }

    .btn-back:hover {
        background: rgba(102, 126, 234, 0.1);
        transform: translateX(-3px);
    }

    .benefit-header-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--gray-200);
        display: flex;
        justify-content: space-between;
        align-items: center;
        animation: fadeInUp 0.5s ease-out 0.1s both;
    }

    .header-left {
        display: flex;
        align-items: center;
        gap: 1.25rem;
    }

    .benefit-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, var(--primary) 0%, #764ba2 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.25);
    }

    .benefit-type-small {
        font-size: 0.75rem;
        color: var(--gray-500);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }

    .benefit-header-card h1 {
        font-size: 1.5rem;
        color: var(--gray-900);
        margin: 0.25rem 0;
        font-weight: 700;
    }

    .provider-badge {
        display: inline-block;
        background: var(--gray-100);
        color: var(--gray-600);
        padding: 0.25rem 0.875rem;
        border-radius: 12px;
        font-size: 0.8125rem;
        font-weight: 600;
        text-transform: capitalize;
    }

    .header-actions {
        display: flex;
        gap: 0.625rem;
    }

    .btn-icon {
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--gray-100);
        border-radius: 10px;
        text-decoration: none;
        font-size: 1.25rem;
        transition: var(--transition);
        border: 1px solid var(--gray-200);
    }

    .btn-icon:hover {
        background: var(--gray-200);
        transform: translateY(-2px);
        box-shadow: var(--shadow-sm);
    }

    .btn-danger-icon:hover {
        background: #fee2e2;
        border-color: #fecaca;
    }

    /* ========== SUMMARY GRID ========== */
    .summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .summary-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--gray-200);
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: var(--transition);
        animation: fadeInUp 0.5s ease-out 0.2s both;
    }

    .summary-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
    }

    .balance-card {
        background: linear-gradient(135deg, var(--primary) 0%, #764ba2 100%);
        color: white;
        border: none;
    }

    .summary-icon {
        font-size: 2rem;
        line-height: 1;
    }

    .summary-content {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
        flex: 1;
    }

    .summary-label {
        font-size: 0.75rem;
        opacity: 0.75;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }

    .balance-card .summary-label {
        opacity: 0.9;
    }

    .summary-value {
        font-size: 1.375rem;
        font-weight: 800;
        color: var(--gray-900);
        line-height: 1.2;
    }

    .balance-card .summary-value {
        color: white;
    }

    /* ========== PROGRESS CARD ========== */
    .progress-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--gray-200);
        margin-bottom: 1.5rem;
        animation: fadeInUp 0.5s ease-out 0.3s both;
    }

    .progress-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.875rem;
        font-size: 0.875rem;
        color: var(--gray-600);
        font-weight: 600;
    }

    .progress-bar-compact {
        width: 100%;
        height: 10px;
        background: var(--gray-200);
        border-radius: 5px;
        overflow: hidden;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .progress-fill-compact {
        height: 100%;
        transition: width 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
    }

    /* ========== EXTRATO ========== */
    .card-extrato {
        background: white;
        border-radius: 16px;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--gray-200);
        overflow: hidden;
        margin-bottom: 1.5rem;
        animation: fadeInUp 0.5s ease-out 0.4s both;
    }

    .extrato-header {
        background: linear-gradient(135deg, var(--primary) 0%, #764ba2 100%);
        color: white;
        padding: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .extrato-header h2 {
        font-size: 1.25rem;
        margin: 0;
        font-weight: 700;
    }

    .month-nav {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .current-period {
        font-size: 0.9375rem;
        font-weight: 600;
        min-width: 90px;
        text-align: center;
    }

    .btn-nav {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.2);
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-size: 1.25rem;
        transition: var(--transition);
        font-weight: 700;
    }

    .btn-nav:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: scale(1.1);
    }

    .extrato-list {
        padding: 0;
    }

    .extrato-item {
        display: grid;
        grid-template-columns: 70px 1fr auto;
        gap: 1rem;
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--gray-100);
        align-items: center;
        transition: background 0.2s;
    }

    .extrato-item:hover {
        background: var(--gray-50);
    }

    .extrato-item:last-child {
        border-bottom: none;
    }

    .extrato-date {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.15rem;
    }

    .date-day {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary);
        line-height: 1;
    }

    .date-month {
        font-size: 0.6875rem;
        color: var(--gray-400);
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .extrato-info {
        display: flex;
        flex-direction: column;
        gap: 0.375rem;
    }

    .extrato-desc {
        font-weight: 600;
        color: var(--gray-900);
        font-size: 0.9375rem;
    }

    .extrato-cat {
        font-size: 0.8125rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .extrato-value {
        text-align: right;
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--danger);
    }

    .extrato-total {
        display: flex;
        justify-content: space-between;
        padding: 1.5rem;
        background: var(--gray-50);
        border-top: 2px solid var(--gray-200);
        font-weight: 700;
        color: var(--gray-900);
    }

    .total-amount {
        font-size: 1.375rem;
        color: var(--danger);
    }

    /* ========== RECARGAS ========== */
    .card-recharges {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--gray-200);
        animation: fadeInUp 0.5s ease-out 0.5s both;
    }

    .card-recharges h3 {
        font-size: 1.125rem;
        color: var(--gray-900);
        margin-bottom: 1.25rem;
        font-weight: 700;
    }

    .recharges-compact {
        display: flex;
        flex-direction: column;
        gap: 0.875rem;
    }

    .recharge-compact-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem 1.25rem;
        background: #f0fdf4;
        border-left: 4px solid var(--secondary);
        border-radius: 10px;
        transition: var(--transition);
    }

    .recharge-compact-item:hover {
        transform: translateX(4px);
        box-shadow: var(--shadow-sm);
    }

    .recharge-date {
        font-size: 0.875rem;
        color: var(--gray-600);
        font-weight: 600;
        min-width: 85px;
    }

    .recharge-badge {
        flex: 1;
        font-size: 0.875rem;
        color: #059669;
        font-weight: 600;
    }

    .recharge-value {
        font-size: 1.0625rem;
        font-weight: 700;
        color: var(--secondary);
    }

    /* ========== EMPTY STATE ========== */
    .empty-state-compact {
        padding: 3rem 1.5rem;
        text-align: center;
        color: var(--gray-400);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.75rem;
    }

    .empty-icon {
        font-size: 3rem;
        opacity: 0.3;
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    .empty-state-compact span:last-child {
        font-size: 0.9375rem;
        font-weight: 500;
    }

    /* ========== RESPONSIVE - TABLET ========== */
    @media (max-width: 1024px) {
        .container-details {
            padding: 1.5rem;
        }

        .summary-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    /* ========== RESPONSIVE - MOBILE ========== */
    @media (max-width: 768px) {
        .container-details {
            padding: 1rem;
        }

        .benefit-header-card {
            flex-direction: column;
            gap: 1.25rem;
            padding: 1.25rem;
        }

        .header-left {
            width: 100%;
        }

        .header-actions {
            width: 100%;
            justify-content: center;
            gap: 0.5rem;
        }

        .benefit-header-card h1 {
            font-size: 1.25rem;
        }

        .summary-grid {
            grid-template-columns: 1fr;
            gap: 0.875rem;
        }

        .summary-card {
            padding: 1.25rem;
        }

        .summary-value {
            font-size: 1.25rem;
        }

        .progress-card {
            padding: 1.25rem;
        }

        .progress-header {
            flex-direction: column;
            gap: 0.5rem;
            align-items: flex-start;
        }

        .extrato-header {
            padding: 1.25rem;
        }

        .extrato-header h2 {
            font-size: 1.125rem;
        }

        .month-nav {
            width: 100%;
            justify-content: space-between;
        }

        .extrato-item {
            grid-template-columns: 1fr;
            gap: 0.875rem;
            padding: 1rem;
        }

        .extrato-date {
            flex-direction: row;
            justify-content: flex-start;
            gap: 0.625rem;
        }

        .extrato-value {
            text-align: left;
        }

        .extrato-total {
            padding: 1.25rem;
            flex-direction: column;
            gap: 0.5rem;
            align-items: flex-start;
        }

        .recharge-compact-item {
            flex-direction: column;
            align-items: flex-start;
            padding: 1rem;
        }

        .recharge-date {
            min-width: auto;
        }

        .card-recharges {
            padding: 1.25rem;
        }
    }

    /* ========== MOBILE PORTRAIT ========== */
    @media (max-width: 480px) {
        .container-details {
            padding: 0.875rem;
        }

        .benefit-header-card {
            padding: 1rem;
            border-radius: 12px;
        }

        .benefit-icon {
            width: 50px;
            height: 50px;
            font-size: 1.75rem;
        }

        .benefit-header-card h1 {
            font-size: 1.125rem;
        }

        .btn-icon {
            width: 40px;
            height: 40px;
            font-size: 1.125rem;
        }

        .summary-card {
            padding: 1rem;
            border-radius: 12px;
        }

        .summary-icon {
            font-size: 1.75rem;
        }

        .summary-value {
            font-size: 1.125rem;
        }

        .progress-card,
        .card-extrato,
        .card-recharges {
            border-radius: 12px;
        }

        .extrato-header h2 {
            font-size: 1rem;
        }

        .btn-nav {
            width: 32px;
            height: 32px;
            font-size: 1.125rem;
        }

        .current-period {
            font-size: 0.875rem;
            min-width: 80px;
        }

        .date-day {
            font-size: 1.25rem;
        }

        .extrato-desc {
            font-size: 0.875rem;
        }

        .extrato-cat {
            font-size: 0.75rem;
        }

        .extrato-value {
            font-size: 1rem;
        }
    }

    /* ========== PWA/STANDALONE MODE ========== */
    @media (display-mode: standalone) {
        .container-details {
            padding-top: calc(env(safe-area-inset-top) + 2rem);
            padding-bottom: calc(env(safe-area-inset-bottom) + 2rem);
        }
    }

    /* ========== PRINT STYLES ========== */
    @media print {
        .btn-back,
        .header-actions,
        .month-nav {
            display: none;
        }

        .container-details {
            padding: 0;
        }

        .benefit-header-card,
        .summary-card,
        .progress-card,
        .card-extrato,
        .card-recharges {
            box-shadow: none;
            border: 1px solid var(--gray-300);
            page-break-inside: avoid;
        }
    }
</style>

<div class="container-details">
    <!-- Header Compacto -->
    <div class="details-header">
        <a href="/beneficios" class="btn-back">← Voltar</a>
        
        <div class="benefit-header-card">
            <div class="header-left">
                <div class="benefit-icon"><?= $typeIcon ?></div>
                <div>
                    <div class="benefit-type-small"><?= $typeName ?></div>
                    <h1><?= htmlspecialchars($benefit['name']) ?></h1>
                    <span class="provider-badge"><?= ucfirst($benefit['provider']) ?></span>
                </div>
            </div>
            <div class="header-actions">
                <a href="/beneficios/recarregar/<?= $benefit['id'] ?>" class="btn-icon" title="Recarga Manual">
                    💰
                </a>
                <a href="/beneficios/editar/<?= $benefit['id'] ?>" class="btn-icon" title="Editar">
                    ✏️
                </a>
                <a href="/beneficios/deletar/<?= $benefit['id'] ?>" 
                   class="btn-icon btn-danger-icon" 
                   title="Deletar"
                   onclick="return confirm('Tem certeza que deseja deletar este benefício?')">
                    🗑️
                </a>
            </div>
        </div>
    </div>

    <!-- Cards de Resumo -->
    <div class="summary-grid">
        <div class="summary-card balance-card">
            <div class="summary-icon">💰</div>
            <div class="summary-content">
                <span class="summary-label">Saldo Disponível</span>
                <span class="summary-value">R$ <?= number_format($benefit['current_balance'], 2, ',', '.') ?></span>
            </div>
        </div>

        <div class="summary-card">
            <div class="summary-icon">📊</div>
            <div class="summary-content">
                <span class="summary-label">Gasto em <?= $months[$month] ?></span>
                <span class="summary-value">R$ <?= number_format($monthlyExpense, 2, ',', '.') ?></span>
            </div>
        </div>

        <div class="summary-card">
            <div class="summary-icon">💵</div>
            <div class="summary-content">
                <span class="summary-label">Recarga Mensal</span>
                <span class="summary-value">R$ <?= number_format($benefit['monthly_amount'], 2, ',', '.') ?></span>
            </div>
        </div>

        <div class="summary-card">
            <div class="summary-icon">📅</div>
            <div class="summary-content">
                <span class="summary-label">Próxima Recarga</span>
                <span class="summary-value">Dia <?= $benefit['recharge_day'] ?></span>
            </div>
        </div>
    </div>

    <!-- Barra de Progresso -->
    <div class="progress-card">
        <?php 
        $progressColor = $percentUsed > 90 ? '#ef4444' : ($percentUsed > 70 ? '#f59e0b' : '#10b981');
        ?>
        <div class="progress-header">
            <span>Uso do mês: <?= number_format($percentUsed, 1) ?>%</span>
            <span>Restam: R$ <?= number_format($benefit['monthly_amount'] - $monthlyExpense, 2, ',', '.') ?></span>
        </div>
        <div class="progress-bar-compact">
            <div class="progress-fill-compact" style="width: <?= min($percentUsed, 100) ?>%; background: <?= $progressColor ?>"></div>
        </div>
    </div>

    <!-- Extrato de Transações -->
    <div class="card-extrato">
        <div class="extrato-header">
            <h2>📊 Extrato de <?= $months[$month] ?>/<?= $year ?></h2>
            <div class="month-nav">
                <a href="?month=<?= $month > 1 ? $month - 1 : 12 ?>&year=<?= $month > 1 ? $year : $year - 1 ?>" 
                   class="btn-nav">◄</a>
                <span class="current-period"><?= $months[$month] ?></span>
                <a href="?month=<?= $month < 12 ? $month + 1 : 1 ?>&year=<?= $month < 12 ? $year : $year + 1 ?>" 
                   class="btn-nav">►</a>
            </div>
        </div>

        <?php if (empty($transactions)): ?>
            <div class="empty-state-compact">
                <span class="empty-icon">📭</span>
                <span>Nenhuma transação em <?= $months[$month] ?></span>
            </div>
        <?php else: ?>
            <div class="extrato-list">
                <?php foreach ($transactions as $t): ?>
                    <div class="extrato-item">
                        <div class="extrato-date">
                            <span class="date-day"><?= date('d', strtotime($t['transaction_date'])) ?></span>
                            <span class="date-month"><?= strtoupper(substr($months[date('n', strtotime($t['transaction_date']))], 0, 3)) ?></span>
                        </div>
                        <div class="extrato-info">
                            <span class="extrato-desc"><?= htmlspecialchars($t['description']) ?></span>
                            <span class="extrato-cat" style="color: <?= $t['color'] ?>">● <?= $t['category_name'] ?></span>
                        </div>
                        <div class="extrato-value">
                            <span>- R$ <?= number_format($t['amount'], 2, ',', '.') ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>

                <div class="extrato-total">
                    <span>Total do Mês</span>
                    <span class="total-amount">R$ <?= number_format($monthlyExpense, 2, ',', '.') ?></span>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Histórico de Recargas -->
    <div class="card-recharges">
        <h3>🔄 Histórico de Recargas</h3>

        <?php if (empty($rechargeHistory)): ?>
            <div class="empty-state-compact">
                <span class="empty-icon">💰</span>
                <span>Nenhuma recarga registrada</span>
            </div>
        <?php else: ?>
            <div class="recharges-compact">
                <?php foreach ($rechargeHistory as $recharge): ?>
                    <div class="recharge-compact-item">
                        <div class="recharge-date">
                            <?= date('d/m/Y', strtotime($recharge['recharge_date'])) ?>
                        </div>
                        <div class="recharge-badge">Recarga Automática</div>
                        <div class="recharge-value">
                            + R$ <?= number_format($recharge['amount'], 2, ',', '.') ?>
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

    // Adiciona feedback visual ao scroll
    let lastScrollTop = 0;
    const header = document.querySelector('.details-header');
    
    window.addEventListener('scroll', function() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        if (scrollTop > lastScrollTop && scrollTop > 100) {
            header.style.transform = 'translateY(-10px)';
            header.style.opacity = '0.95';
        } else {
            header.style.transform = 'translateY(0)';
            header.style.opacity = '1';
        }
        
        lastScrollTop = scrollTop;
    }, false);

    // Anima progresso ao carregar
    document.addEventListener('DOMContentLoaded', function() {
        const progressFill = document.querySelector('.progress-fill-compact');
        if (progressFill) {
            const targetWidth = progressFill.style.width;
            progressFill.style.width = '0%';
            setTimeout(() => {
                progressFill.style.width = targetWidth;
            }, 300);
        }
    });

    // Pull-to-refresh feedback (apenas visual, não recarrega)
    let touchStartY = 0;
    let touchEndY = 0;
    
    document.addEventListener('touchstart', function(e) {
        touchStartY = e.touches[0].clientY;
    }, false);
    
    document.addEventListener('touchend', function(e) {
        touchEndY = e.changedTouches[0].clientY;
        handleSwipe();
    }, false);
    
    function handleSwipe() {
        const swipeDistance = touchEndY - touchStartY;
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
        // Se estiver no topo e puxar para baixo
        if (scrollTop === 0 && swipeDistance > 100) {
            // Feedback visual de refresh
            const header = document.querySelector('.details-header');
            if (header) {
                header.style.transform = 'translateY(5px)';
                setTimeout(() => {
                    header.style.transform = 'translateY(0)';
                }, 200);
            }
        }
    }

    // Lazy loading para melhor performance
    if ('IntersectionObserver' in window) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, {
            threshold: 0.1
        });

        // Observa elementos que ainda não estão visíveis
        document.querySelectorAll('.extrato-item, .recharge-compact-item').forEach(el => {
            observer.observe(el);
        });
    }

    // Otimização de performance para scroll suave
    const debounce = (func, wait) => {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    };

    // Adiciona classe ao body quando em modo PWA
    if (window.matchMedia('(display-mode: standalone)').matches) {
        document.body.classList.add('pwa-mode');
    }
</script>

<?php include VIEWS . '/layouts/footer.php'; ?>