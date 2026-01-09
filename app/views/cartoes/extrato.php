<?php include VIEWS . '/layouts/header.php'; ?>

<div class="container">
    <!-- Header com Info do Cartão -->
    <div class="extrato-header">
        <div class="back-button">
            <a href="/cartoes" class="btn-back">← Voltar para Cartões</a>
        </div>
        
        <div class="card-info-banner">
            <div class="card-icon">💳</div>
            <div class="card-details">
                <h1><?= htmlspecialchars($card['name']) ?></h1>
                <p class="card-number">•••• <?= htmlspecialchars($card['last_digits']) ?></p>
                <div class="card-dates">
                    <span>Fechamento: Dia <?= $card['closing_day'] ?></span>
                    <span class="separator">|</span>
                    <span>Vencimento: Dia <?= $card['due_day'] ?></span>
                </div>
            </div>
            
            <?php if ($card['credit_limit']): ?>
                <div class="limit-info">
                    <span class="limit-label">Limite Total</span>
                    <span class="limit-value">R$ <?= number_format($card['credit_limit'], 2, ',', '.') ?></span>
                    <?php 
                    $available = $card['credit_limit'] - $invoiceTotal;
                    $percentUsed = ($invoiceTotal / $card['credit_limit']) * 100;
                    ?>
                    <div class="limit-bar">
                        <div class="limit-used" style="width: <?= min($percentUsed, 100) ?>%"></div>
                    </div>
                    <span class="limit-available">Disponível: R$ <?= number_format($available, 2, ',', '.') ?></span>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Navegação de Mês -->
    <div class="month-navigation">
        <a href="/cartoes/extrato/<?= $card['id'] ?>?month=<?= $month == 1 ? 12 : $month - 1 ?>&year=<?= $month == 1 ? $year - 1 : $year ?>" 
           class="btn-month">← Mês Anterior</a>
        
        <h2 class="current-month"><?= $monthName ?> de <?= $year ?></h2>
        
        <a href="/cartoes/extrato/<?= $card['id'] ?>?month=<?= $month == 12 ? 1 : $month + 1 ?>&year=<?= $month == 12 ? $year + 1 : $year ?>" 
           class="btn-month">Próximo Mês →</a>
    </div>
    
    <!-- Resumo da Fatura -->
    <div class="invoice-summary">
        <div class="summary-card total-card">
            <div class="summary-icon">💰</div>
            <div class="summary-content">
                <span class="summary-label">Total da Fatura</span>
                <span class="summary-value">R$ <?= number_format($invoiceTotal, 2, ',', '.') ?></span>
            </div>
        </div>
        
        <div class="summary-card due-card">
            <div class="summary-icon">📅</div>
            <div class="summary-content">
                <span class="summary-label">Vencimento</span>
                <span class="summary-value"><?= $dueDate ?></span>
            </div>
        </div>
        
        <div class="summary-card transactions-card">
            <div class="summary-icon">📊</div>
            <div class="summary-content">
                <span class="summary-label">Transações</span>
                <span class="summary-value"><?= count($transactions) ?></span>
            </div>
        </div>
    </div>
    
    <!-- Lista de Transações -->
    <div class="card">
        <div class="card-header">
            <h2>Lançamentos de <?= $monthName ?></h2>
        </div>
        
        <?php if (empty($transactions)): ?>
            <div class="empty-state">
                <div class="empty-icon">📭</div>
                <h3>Nenhuma transação neste período</h3>
                <p>Não há lançamentos no cartão para <?= $monthName ?> de <?= $year ?></p>
            </div>
        <?php else: ?>
            <div class="transactions-list">
                <?php foreach ($transactions as $t): ?>
                    <div class="transaction-item">
                        <div class="transaction-date">
                            <?= date('d/m', strtotime($t['transaction_date'])) ?>
                        </div>
                        <div class="transaction-info">
                            <div class="transaction-description">
                                <?= htmlspecialchars($t['description']) ?>
                                <?php if ($t['installments'] > 0): ?>
                                    <span class="installment-badge">
                                        Parcela <?= $t['installment_number'] ?>/<?= $t['installments'] ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <div class="transaction-meta">
                                <span class="category" style="color: <?= $t['color'] ?>">
                                    ● <?= htmlspecialchars($t['category_name']) ?>
                                </span>
                                <span class="user">👤 <?= htmlspecialchars($t['user_name']) ?></span>
                            </div>
                        </div>
                        <div class="transaction-amount">
                            R$ <?= number_format($t['amount'], 2, ',', '.') ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Próximas Faturas -->
    <?php if (!empty($upcomingByMonth)): ?>
        <div class="card upcoming-section">
            <div class="card-header">
                <h2>🔮 Próximas Faturas</h2>
                <p class="subtitle">Parcelas que virão nos próximos meses</p>
            </div>
            
            <div class="upcoming-months">
                <?php foreach ($upcomingByMonth as $monthData): ?>
                    <div class="upcoming-month">
                        <div class="upcoming-month-header">
                            <h3><?= $monthData['month_name'] ?>/<?= $monthData['year'] ?></h3>
                            <span class="upcoming-total">R$ <?= number_format($monthData['total'], 2, ',', '.') ?></span>
                        </div>
                        <div class="upcoming-transactions">
                            <?php foreach ($monthData['transactions'] as $t): ?>
                                <div class="upcoming-item">
                                    <span class="upcoming-desc"><?= htmlspecialchars($t['description']) ?></span>
                                    <span class="upcoming-value">R$ <?= number_format($t['amount'], 2, ',', '.') ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
.extrato-header {
    margin-bottom: 2rem;
}

.back-button {
    margin-bottom: 1rem;
}

.btn-back {
    color: #667eea;
    text-decoration: none;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    transition: background 0.3s;
}

.btn-back:hover {
    background: rgba(102, 126, 234, 0.1);
}

.card-info-banner {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    border-radius: 16px;
    display: grid;
    grid-template-columns: auto 1fr auto;
    gap: 2rem;
    align-items: center;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
}

.card-icon {
    font-size: 3rem;
}

.card-details h1 {
    font-size: 1.8rem;
    margin-bottom: 0.5rem;
}

.card-number {
    font-family: 'Courier New', monospace;
    font-size: 1.2rem;
    letter-spacing: 2px;
    opacity: 0.9;
    margin-bottom: 0.5rem;
}

.card-dates {
    display: flex;
    gap: 1rem;
    font-size: 0.9rem;
    opacity: 0.8;
}

.separator {
    opacity: 0.5;
}

.limit-info {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 0.5rem;
    min-width: 200px;
}

.limit-label {
    font-size: 0.85rem;
    opacity: 0.8;
}

.limit-value {
    font-size: 1.5rem;
    font-weight: 700;
}

.limit-bar {
    width: 100%;
    height: 8px;
    background: rgba(255, 255, 255, 0.3);
    border-radius: 4px;
    overflow: hidden;
}

.limit-used {
    height: 100%;
    background: #fbbf24;
    transition: width 0.3s;
}

.limit-available {
    font-size: 0.85rem;
    opacity: 0.9;
}

.month-navigation {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 2rem 0;
    padding: 1rem;
    background: white;
    border-radius: 12px;
}

.btn-month {
    padding: 0.5rem 1rem;
    background: #f3f4f6;
    color: #1f2937;
    text-decoration: none;
    border-radius: 8px;
    font-weight: 600;
    transition: background 0.3s;
}

.btn-month:hover {
    background: #e5e7eb;
}

.current-month {
    font-size: 1.5rem;
    color: #667eea;
}

.invoice-summary {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.summary-card {
    background: white;
    padding: 1.5rem;
    border-radius: 12px;
    display: flex;
    gap: 1rem;
    align-items: center;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.summary-icon {
    font-size: 2.5rem;
}

.summary-content {
    display: flex;
    flex-direction: column;
}

.summary-label {
    font-size: 0.85rem;
    color: #6b7280;
    margin-bottom: 0.25rem;
}

.summary-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1f2937;
}

.total-card .summary-value {
    color: #ef4444;
}

.transactions-list {
    padding: 1rem;
}

.transaction-item {
    display: grid;
    grid-template-columns: 60px 1fr auto;
    gap: 1rem;
    padding: 1rem;
    border-bottom: 1px solid #f3f4f6;
    align-items: center;
}

.transaction-item:last-child {
    border-bottom: none;
}

.transaction-date {
    font-weight: 700;
    color: #667eea;
    text-align: center;
}

.transaction-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.transaction-description {
    font-weight: 600;
    color: #1f2937;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.installment-badge {
    font-size: 0.75rem;
    padding: 0.2rem 0.5rem;
    background: #dbeafe;
    color: #1e40af;
    border-radius: 4px;
}

.transaction-meta {
    display: flex;
    gap: 1rem;
    font-size: 0.85rem;
    color: #6b7280;
}

.transaction-amount {
    font-size: 1.2rem;
    font-weight: 700;
    color: #ef4444;
}

.upcoming-section {
    margin-top: 2rem;
}

.subtitle {
    color: #6b7280;
    font-size: 0.9rem;
    margin-top: 0.25rem;
}

.upcoming-months {
    display: grid;
    gap: 1.5rem;
    padding: 1rem;
}

.upcoming-month {
    background: #f9fafb;
    padding: 1rem;
    border-radius: 8px;
}

.upcoming-month-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #e5e7eb;
}

.upcoming-month-header h3 {
    color: #667eea;
    font-size: 1.1rem;
}

.upcoming-total {
    font-size: 1.2rem;
    font-weight: 700;
    color: #ef4444;
}

.upcoming-transactions {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.upcoming-item {
    display: flex;
    justify-content: space-between;
    padding: 0.5rem;
    background: white;
    border-radius: 6px;
}

.upcoming-desc {
    color: #1f2937;
}

.upcoming-value {
    font-weight: 600;
    color: #6b7280;
}

.empty-state {
    text-align: center;
    padding: 4rem 2rem;
}

.empty-icon {
    font-size: 4rem;
    margin-bottom: 1rem;
}

.empty-state h3 {
    color: #1f2937;
    margin-bottom: 0.5rem;
}

.empty-state p {
    color: #6b7280;
}

@media (max-width: 768px) {
    .card-info-banner {
        grid-template-columns: 1fr;
        text-align: center;
    }
    
    .limit-info {
        align-items: center;
    }
    
    .month-navigation {
        flex-direction: column;
        gap: 1rem;
    }
    
    .transaction-item {
        grid-template-columns: 1fr;
        gap: 0.5rem;
    }
}
</style>

<?php include VIEWS . '/layouts/footer.php'; ?>