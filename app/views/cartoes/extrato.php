<?php include VIEWS . '/layouts/header.php'; ?>

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

<style>
.container-extrato {
    max-width: 1000px;
    margin: 0 auto;
    padding: 1.5rem;
}

/* Header Compacto */
.extrato-header {
    margin-bottom: 1.5rem;
}

.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: #667eea;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
    margin-bottom: 1rem;
    padding: 0.5rem 0.75rem;
    border-radius: 6px;
    transition: background 0.2s;
}

.btn-back:hover {
    background: rgba(102, 126, 234, 0.1);
}

.card-info-compact {
    background: white;
    border-radius: 12px;
    padding: 1.25rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.card-main {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.card-icon {
    font-size: 2rem;
}

.card-info-compact h1 {
    font-size: 1.25rem;
    color: #1f2937;
    margin: 0;
}

.card-number {
    font-family: 'Courier New', monospace;
    font-size: 0.85rem;
    color: #6b7280;
    margin: 0.25rem 0 0 0;
}

.card-dates-compact {
    display: flex;
    gap: 1.5rem;
    font-size: 0.85rem;
    color: #6b7280;
}

.limit-compact {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.limit-row {
    display: flex;
    justify-content: space-between;
    font-size: 0.85rem;
    color: #6b7280;
}

.limit-row .available {
    font-weight: 600;
    color: #10b981;
}

.limit-bar {
    width: 100%;
    height: 6px;
    background: #e5e7eb;
    border-radius: 3px;
    overflow: hidden;
}

.limit-used {
    height: 100%;
    transition: width 0.3s;
}

/* Fatura Card */
.fatura-card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.fatura-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 1.25rem;
}

.fatura-nav {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1.5rem;
    margin-bottom: 1rem;
}

.fatura-nav h2 {
    font-size: 1.4rem;
    margin: 0;
    min-width: 150px;
    text-align: center;
}

.btn-nav {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.2);
    color: white;
    text-decoration: none;
    border-radius: 6px;
    font-size: 1.2rem;
    transition: background 0.2s;
}

.btn-nav:hover {
    background: rgba(255, 255, 255, 0.3);
}

.fatura-summary {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
}

.summary-item {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.summary-item.total {
    text-align: center;
    border-left: 1px solid rgba(255, 255, 255, 0.3);
    border-right: 1px solid rgba(255, 255, 255, 0.3);
}

.summary-item .label {
    font-size: 0.75rem;
    opacity: 0.9;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.summary-item .value {
    font-size: 1rem;
    font-weight: 600;
}

.summary-item .value-total {
    font-size: 1.6rem;
    font-weight: 800;
}

/* Tabela de Lançamentos */
.lancamentos-table {
    display: flex;
    flex-direction: column;
}

.table-header {
    display: grid;
    grid-template-columns: 70px 1fr 80px 120px;
    gap: 1rem;
    padding: 0.75rem 1.25rem;
    background: #f9fafb;
    border-bottom: 2px solid #e5e7eb;
    font-size: 0.75rem;
    font-weight: 700;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.table-row {
    display: grid;
    grid-template-columns: 70px 1fr 80px 120px;
    gap: 1rem;
    padding: 0.85rem 1.25rem;
    border-bottom: 1px solid #f3f4f6;
    align-items: center;
    transition: background 0.2s;
}

.table-row:hover {
    background: #f9fafb;
}

.table-row:last-child {
    border-bottom: none;
}

.col-data .data {
    font-size: 0.9rem;
    font-weight: 600;
    color: #667eea;
}

.col-desc {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.col-desc .desc {
    font-size: 0.95rem;
    font-weight: 600;
    color: #1f2937;
}

.col-desc .meta {
    display: flex;
    gap: 1rem;
    font-size: 0.8rem;
    color: #6b7280;
}

.col-parcela {
    text-align: center;
}

.col-parcela .parcela {
    display: inline-block;
    padding: 0.2rem 0.6rem;
    background: #dbeafe;
    color: #1e40af;
    border-radius: 4px;
    font-size: 0.8rem;
    font-weight: 600;
}

.col-parcela .parcela-vazio {
    color: #d1d5db;
    font-size: 1.2rem;
}

.col-valor {
    text-align: right;
}

.col-valor .valor {
    font-size: 1.05rem;
    font-weight: 700;
    color: #ef4444;
}

.table-footer {
    display: grid;
    grid-template-columns: 1fr 120px;
    gap: 1rem;
    padding: 1rem 1.25rem;
    background: #f9fafb;
    border-top: 2px solid #e5e7eb;
}

.footer-label {
    text-align: right;
    font-size: 0.95rem;
    font-weight: 700;
    color: #1f2937;
}

.footer-valor {
    text-align: right;
    font-size: 1.3rem;
    font-weight: 800;
    color: #ef4444;
}

/* Empty State */
.empty-state-compact {
    padding: 3rem 1.5rem;
    text-align: center;
    color: #9ca3af;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.75rem;
}

.empty-icon {
    font-size: 3rem;
    opacity: 0.5;
}

/* Próximas Faturas */
.proximas-faturas {
    margin-top: 2rem;
}

.proximas-faturas h3 {
    font-size: 1.2rem;
    color: #1f2937;
    margin-bottom: 1rem;
}

.faturas-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1rem;
}

.futura-card {
    background: white;
    border-radius: 10px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.futura-header {
    background: #f9fafb;
    padding: 0.85rem 1rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 2px solid #e5e7eb;
}

.futura-mes {
    font-weight: 700;
    color: #667eea;
    font-size: 0.95rem;
}

.futura-total {
    font-weight: 800;
    color: #ef4444;
    font-size: 1.1rem;
}

.futura-items {
    padding: 0.75rem;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.futura-item {
    display: flex;
    justify-content: space-between;
    padding: 0.5rem 0.75rem;
    background: #f9fafb;
    border-radius: 6px;
    font-size: 0.85rem;
}

.futura-desc {
    color: #4b5563;
}

.futura-valor {
    font-weight: 600;
    color: #6b7280;
}

/* Responsive */
@media (max-width: 768px) {
    .container-extrato {
        padding: 1rem;
    }

    .card-dates-compact {
        flex-direction: column;
        gap: 0.5rem;
    }

    .fatura-summary {
        grid-template-columns: 1fr;
        gap: 0.75rem;
    }

    .summary-item.total {
        border: none;
        border-top: 1px solid rgba(255, 255, 255, 0.3);
        border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        padding: 0.75rem 0;
    }

    .table-header {
        display: none;
    }

    .table-row {
        grid-template-columns: 1fr;
        gap: 0.5rem;
        padding: 1rem;
    }

    .col-parcela,
    .col-valor {
        text-align: left;
    }

    .table-footer {
        grid-template-columns: 1fr;
    }

    .footer-label {
        text-align: left;
    }

    .footer-valor {
        text-align: left;
    }

    .faturas-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php include VIEWS . '/layouts/footer.php'; ?>