<?php include VIEWS . '/layouts/header.php'; ?>

<style>
    :root {
        --primary: #667eea;
        --primary-hover: #5568d3;
        --secondary: #10b981;
        --danger: #ef4444;
        --warning: #f59e0b;
        --info: #3b82f6;
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
    .container-extrato {
        max-width: 1100px;
        margin: 0 auto;
        padding: 2rem;
    }

    /* ========== HEADER ========== */
    .extrato-header {
        margin-bottom: 2rem;
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

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--primary);
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9375rem;
        margin-bottom: 1.25rem;
        padding: 0.625rem 1rem;
        border-radius: 8px;
        transition: var(--transition);
    }

    .btn-back:hover {
        background: rgba(102, 126, 234, 0.1);
    }

    .card-info-compact {
        background: white;
        border-radius: 16px;
        padding: 1.75rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--gray-200);
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }

    .card-main {
        display: flex;
        align-items: center;
        gap: 1.25rem;
    }

    .card-icon {
        font-size: 2.5rem;
    }

    .card-info-compact h1 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--gray-900);
        margin: 0;
    }

    .card-number {
        font-family: 'Courier New', monospace;
        font-size: 0.9375rem;
        color: var(--gray-600);
        margin: 0.375rem 0 0 0;
        font-weight: 500;
    }

    .card-dates-compact {
        display: flex;
        gap: 2rem;
        font-size: 0.9375rem;
        color: var(--gray-600);
        font-weight: 500;
    }

    /* ========== LIMIT COMPACT ========== */
    .limit-compact {
        display: flex;
        flex-direction: column;
        gap: 0.625rem;
    }

    .limit-row {
        display: flex;
        justify-content: space-between;
        font-size: 0.9375rem;
        color: var(--gray-700);
        font-weight: 500;
    }

    .limit-row .available {
        font-weight: 700;
        color: var(--secondary);
    }

    .limit-bar {
        width: 100%;
        height: 7px;
        background: var(--gray-200);
        border-radius: 4px;
        overflow: hidden;
    }

    .limit-used {
        height: 100%;
        transition: width 0.5s ease-out;
    }

    /* ========== FATURA CARD ========== */
    .fatura-card {
        background: white;
        border-radius: 16px;
        box-shadow: var(--shadow-md);
        overflow: hidden;
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

    .fatura-header {
        background: linear-gradient(135deg, var(--primary) 0%, #764ba2 100%);
        color: white;
        padding: 1.75rem;
    }

    .fatura-nav {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 2rem;
        margin-bottom: 1.5rem;
    }

    .fatura-nav h2 {
        font-size: 1.625rem;
        font-weight: 700;
        margin: 0;
        min-width: 180px;
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
    }

    .btn-nav:hover {
        background: rgba(255, 255, 255, 0.35);
        transform: scale(1.05);
    }

    .fatura-summary {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
    }

    .summary-item {
        display: flex;
        flex-direction: column;
        gap: 0.375rem;
    }

    .summary-item.total {
        text-align: center;
        border-left: 1px solid rgba(255, 255, 255, 0.25);
        border-right: 1px solid rgba(255, 255, 255, 0.25);
        padding: 0 1rem;
    }

    .summary-item .label {
        font-size: 0.8125rem;
        opacity: 0.9;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 500;
    }

    .summary-item .value {
        font-size: 1.125rem;
        font-weight: 700;
    }

    .summary-item .value-total {
        font-size: 1.875rem;
        font-weight: 800;
        font-family: 'Courier New', monospace;
    }

    /* ========== TABELA ========== */
    .lancamentos-table {
        display: flex;
        flex-direction: column;
    }

    .table-header {
        display: grid;
        grid-template-columns: 80px 1fr 90px 130px;
        gap: 1.25rem;
        padding: 1rem 1.75rem;
        background: var(--gray-50);
        border-bottom: 2px solid var(--gray-200);
        font-size: 0.8125rem;
        font-weight: 700;
        color: var(--gray-600);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .table-row {
        display: grid;
        grid-template-columns: 80px 1fr 90px 130px;
        gap: 1.25rem;
        padding: 1.125rem 1.75rem;
        border-bottom: 1px solid var(--gray-100);
        align-items: center;
        transition: var(--transition);
    }

    .table-row:hover {
        background: var(--gray-50);
    }

    .table-row:last-child {
        border-bottom: none;
    }

    .col-data .data {
        font-size: 0.9375rem;
        font-weight: 700;
        color: var(--primary);
    }

    .col-desc {
        display: flex;
        flex-direction: column;
        gap: 0.375rem;
    }

    .col-desc .desc {
        font-size: 1rem;
        font-weight: 600;
        color: var(--gray-900);
    }

    .col-desc .meta {
        display: flex;
        gap: 1.25rem;
        font-size: 0.8125rem;
        color: var(--gray-600);
    }

    .category {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        font-weight: 500;
    }

    .user {
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .col-parcela {
        text-align: center;
    }

    .col-parcela .parcela {
        display: inline-block;
        padding: 0.375rem 0.75rem;
        background: #dbeafe;
        color: #1e40af;
        border-radius: 6px;
        font-size: 0.8125rem;
        font-weight: 700;
    }

    .col-parcela .parcela-vazio {
        color: var(--gray-300);
        font-size: 1.25rem;
    }

    .col-valor {
        text-align: right;
    }

    .col-valor .valor {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--danger);
        font-family: 'Courier New', monospace;
    }

    .table-footer {
        display: grid;
        grid-template-columns: 1fr 130px;
        gap: 1.25rem;
        padding: 1.25rem 1.75rem;
        background: var(--gray-50);
        border-top: 2px solid var(--gray-200);
    }

    .footer-label {
        text-align: right;
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--gray-900);
    }

    .footer-valor {
        text-align: right;
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--danger);
        font-family: 'Courier New', monospace;
    }

    /* ========== EMPTY STATE ========== */
    .empty-state-compact {
        padding: 4rem 2rem;
        text-align: center;
        color: var(--gray-400);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
    }

    .empty-icon {
        font-size: 4rem;
        opacity: 0.4;
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    /* ========== PRÓXIMAS FATURAS ========== */
    .proximas-faturas {
        margin-top: 2.5rem;
        animation: fadeInUp 0.5s ease-out 0.2s both;
    }

    .proximas-faturas h3 {
        font-size: 1.375rem;
        font-weight: 700;
        color: var(--gray-900);
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .faturas-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.25rem;
    }

    .futura-card {
        background: white;
        border-radius: 12px;
        box-shadow: var(--shadow-sm);
        overflow: hidden;
        border: 1px solid var(--gray-200);
        transition: var(--transition);
    }

    .futura-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .futura-header {
        background: var(--gray-50);
        padding: 1rem 1.25rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 2px solid var(--gray-200);
    }

    .futura-mes {
        font-weight: 700;
        color: var(--primary);
        font-size: 1rem;
    }

    .futura-total {
        font-weight: 800;
        color: var(--danger);
        font-size: 1.25rem;
        font-family: 'Courier New', monospace;
    }

    .futura-items {
        padding: 1rem;
        display: flex;
        flex-direction: column;
        gap: 0.625rem;
    }

    .futura-item {
        display: flex;
        justify-content: space-between;
        padding: 0.625rem 0.875rem;
        background: var(--gray-50);
        border-radius: 8px;
        font-size: 0.875rem;
        transition: var(--transition);
    }

    .futura-item:hover {
        background: var(--gray-100);
    }

    .futura-desc {
        color: var(--gray-700);
        font-weight: 500;
    }

    .futura-valor {
        font-weight: 700;
        color: var(--gray-900);
        font-family: 'Courier New', monospace;
    }

    /* ========== RESPONSIVE - TABLET ========== */
    @media (max-width: 1024px) {
        .container-extrato {
            padding: 1.5rem;
        }

        .fatura-nav h2 {
            font-size: 1.5rem;
        }

        .summary-item .value-total {
            font-size: 1.625rem;
        }
    }

    /* ========== RESPONSIVE - MOBILE ========== */
    @media (max-width: 768px) {
        .container-extrato {
            padding: 1rem;
        }

        .card-info-compact {
            padding: 1.25rem;
            border-radius: 12px;
        }

        .card-dates-compact {
            flex-direction: column;
            gap: 0.625rem;
        }

        .fatura-header {
            padding: 1.25rem;
        }

        .fatura-nav {
            gap: 1.25rem;
            margin-bottom: 1.25rem;
        }

        .fatura-nav h2 {
            font-size: 1.25rem;
            min-width: 140px;
        }

        .btn-nav {
            width: 32px;
            height: 32px;
        }

        .fatura-summary {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .summary-item.total {
            border: none;
            border-top: 1px solid rgba(255, 255, 255, 0.25);
            border-bottom: 1px solid rgba(255, 255, 255, 0.25);
            padding: 1rem 0;
        }

        .summary-item .value-total {
            font-size: 1.5rem;
        }

        .table-header {
            display: none;
        }

        .table-row {
            grid-template-columns: 1fr;
            gap: 0.75rem;
            padding: 1.25rem 1rem;
        }

        .col-data,
        .col-parcela,
        .col-valor {
            text-align: left;
        }

        .col-desc .meta {
            flex-direction: column;
            gap: 0.375rem;
        }

        .table-footer {
            grid-template-columns: 1fr;
            padding: 1rem;
        }

        .footer-label,
        .footer-valor {
            text-align: left;
        }

        .footer-valor {
            font-size: 1.375rem;
        }

        .faturas-grid {
            grid-template-columns: 1fr;
        }

        .empty-state-compact {
            padding: 3rem 1.5rem;
        }

        .empty-icon {
            font-size: 3rem;
        }
    }

    /* ========== MOBILE PORTRAIT ========== */
    @media (max-width: 480px) {
        .container-extrato {
            padding: 0.875rem;
        }

        .card-info-compact {
            padding: 1rem;
        }

        .card-icon {
            font-size: 2rem;
        }

        .card-info-compact h1 {
            font-size: 1.25rem;
        }

        .fatura-nav h2 {
            font-size: 1.125rem;
        }

        .summary-item .value-total {
            font-size: 1.375rem;
        }

        .table-row {
            padding: 1rem;
        }
    }

    /* PWA/Standalone Mode */
    @media (display-mode: standalone) {
        .container-extrato {
            padding-top: calc(env(safe-area-inset-top) + 2rem);
            padding-bottom: calc(env(safe-area-inset-bottom) + 2rem);
        }
    }
</style>

<div class="container-extrato">
    <!-- Header Compacto -->
    <div class="extrato-header">
        <a href="/cartoes" class="btn-back">← Voltar</a>
        
        <div class="card-info-compact">
            <div class="card-main">
                <div class="card-icon">💳</div>
                <div>
                    <h1><?= htmlspecialchars($card['name']) ?></h1>
                    <p class="card-number">Final <?= htmlspecialchars($card['last_digits']) ?></p>
                </div>
            </div>
            
            <div class="card-dates-compact">
                <span>📅 Fecha dia <?= $card['closing_day'] ?></span>
                <span>💰 Vence dia <?= $card['due_day'] ?></span>
            </div>

            <?php if ($card['credit_limit']): ?>
                <?php 
                $available = $card['credit_limit'] - $invoiceTotal;
                $percentUsed = ($invoiceTotal / $card['credit_limit']) * 100;
                ?>
                <div class="limit-compact">
                    <div class="limit-row">
                        <span>Limite: R$ <?= number_format($card['credit_limit'], 2, ',', '.') ?></span>
                        <span class="available">Disponível: R$ <?= number_format($available, 2, ',', '.') ?></span>
                    </div>
                    <div class="limit-bar">
                        <div class="limit-used" style="width: <?= min($percentUsed, 100) ?>%; background: <?= $percentUsed > 80 ? '#ef4444' : ($percentUsed > 50 ? '#f59e0b' : '#10b981') ?>"></div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Fatura do Mês -->
    <div class="fatura-card">
        <div class="fatura-header">
            <div class="fatura-nav">
                <a href="/cartoes/extrato/<?= $card['id'] ?>?month=<?= $month == 1 ? 12 : $month - 1 ?>&year=<?= $month == 1 ? $year - 1 : $year ?>" 
                   class="btn-nav">◄</a>
                <h2><?= $monthName ?>/<?= $year ?></h2>
                <a href="/cartoes/extrato/<?= $card['id'] ?>?month=<?= $month == 12 ? 1 : $month + 1 ?>&year=<?= $month == 12 ? $year + 1 : $year ?>" 
                   class="btn-nav">►</a>
            </div>
            
            <div class="fatura-summary">
                <div class="summary-item">
                    <span class="label">Vencimento</span>
                    <span class="value"><?= $dueDate ?></span>
                </div>
                <div class="summary-item total">
                    <span class="label">Total da Fatura</span>
                    <span class="value-total">R$ <?= number_format($invoiceTotal, 2, ',', '.') ?></span>
                </div>
                <div class="summary-item">
                    <span class="label">Lançamentos</span>
                    <span class="value"><?= count($transactions) ?></span>
                </div>
            </div>
        </div>
        
        <!-- Lançamentos -->
        <?php if (empty($transactions)): ?>
            <div class="empty-state-compact">
                <span class="empty-icon">📭</span>
                <span>Nenhum lançamento em <?= $monthName ?></span>
            </div>
        <?php else: ?>
            <div class="lancamentos-table">
                <div class="table-header">
                    <div class="col-data">Data</div>
                    <div class="col-desc">Descrição</div>
                    <div class="col-parcela">Parcela</div>
                    <div class="col-valor">Valor</div>
                </div>
                
                <?php foreach ($transactions as $t): ?>
                    <div class="table-row">
                        <div class="col-data">
                            <span class="data"><?= date('d/m', strtotime($t['transaction_date'])) ?></span>
                        </div>
                        <div class="col-desc">
                            <span class="desc"><?= htmlspecialchars($t['description']) ?></span>
                            <span class="meta">
                                <span class="category" style="color: <?= $t['color'] ?>">● <?= htmlspecialchars($t['category_name']) ?></span>
                                <span class="user">👤 <?= htmlspecialchars($t['user_name']) ?></span>
                            </span>
                        </div>
                        <div class="col-parcela">
                            <?php if ($t['installments'] > 0): ?>
                                <span class="parcela"><?= $t['installment_number'] ?>/<?= $t['installments'] ?></span>
                            <?php else: ?>
                                <span class="parcela-vazio">—</span>
                            <?php endif; ?>
                        </div>
                        <div class="col-valor">
                            <span class="valor">R$ <?= number_format($t['amount'], 2, ',', '.') ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
                
                <div class="table-footer">
                    <div class="footer-label">Total</div>
                    <div class="footer-valor">R$ <?= number_format($invoiceTotal, 2, ',', '.') ?></div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Próximas Faturas -->
    <?php if (!empty($upcomingByMonth)): ?>
        <div class="proximas-faturas">
            <h3>🔮 Próximas Faturas</h3>
            
            <div class="faturas-grid">
                <?php foreach ($upcomingByMonth as $monthData): ?>
                    <div class="futura-card">
                        <div class="futura-header">
                            <span class="futura-mes"><?= $monthData['month_name'] ?>/<?= $monthData['year'] ?></span>
                            <span class="futura-total">R$ <?= number_format($monthData['total'], 2, ',', '.') ?></span>
                        </div>
                        <div class="futura-items">
                            <?php foreach ($monthData['transactions'] as $t): ?>
                                <div class="futura-item">
                                    <span class="futura-desc"><?= htmlspecialchars($t['description']) ?></span>
                                    <span class="futura-valor">R$ <?= number_format($t['amount'], 2, ',', '.') ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
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