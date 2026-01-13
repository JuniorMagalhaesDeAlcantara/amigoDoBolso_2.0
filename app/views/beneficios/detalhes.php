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

<style>
.container-details {
    max-width: 1000px;
    margin: 0 auto;
    padding: 1.5rem;
}

/* Header */
.details-header {
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

.benefit-header-card {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header-left {
    display: flex;
    align-items: center;
    gap: 1.25rem;
}

.benefit-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
}

.benefit-type-small {
    font-size: 0.75rem;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 600;
}

.benefit-header-card h1 {
    font-size: 1.5rem;
    color: #1f2937;
    margin: 0.25rem 0;
}

.provider-badge {
    display: inline-block;
    background: #f3f4f6;
    color: #6b7280;
    padding: 0.25rem 0.75rem;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: capitalize;
}

.header-actions {
    display: flex;
    gap: 0.5rem;
}

.btn-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f3f4f6;
    border-radius: 8px;
    text-decoration: none;
    font-size: 1.2rem;
    transition: all 0.2s;
}

.btn-icon:hover {
    background: #e5e7eb;
    transform: translateY(-2px);
}

.btn-danger-icon:hover {
    background: #fee2e2;
}

/* Summary Grid */
.summary-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.summary-card {
    background: white;
    border-radius: 12px;
    padding: 1.25rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    display: flex;
    align-items: center;
    gap: 1rem;
}

.balance-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.summary-icon {
    font-size: 2rem;
}

.summary-content {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.summary-label {
    font-size: 0.75rem;
    opacity: 0.8;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 600;
}

.balance-card .summary-label {
    opacity: 0.9;
}

.summary-value {
    font-size: 1.4rem;
    font-weight: 800;
    color: #1f2937;
}

.balance-card .summary-value {
    color: white;
}

/* Progress Card */
.progress-card {
    background: white;
    border-radius: 12px;
    padding: 1.25rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    margin-bottom: 1.5rem;
}

.progress-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.75rem;
    font-size: 0.85rem;
    color: #6b7280;
    font-weight: 600;
}

.progress-bar-compact {
    width: 100%;
    height: 8px;
    background: #e5e7eb;
    border-radius: 4px;
    overflow: hidden;
}

.progress-fill-compact {
    height: 100%;
    transition: width 0.3s;
}

/* Extrato */
.card-extrato {
    background: white;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    margin-bottom: 1.5rem;
}

.extrato-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 1.25rem 1.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.extrato-header h2 {
    font-size: 1.2rem;
    margin: 0;
}

.month-nav {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.current-period {
    font-size: 0.95rem;
    font-weight: 600;
    min-width: 80px;
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

.extrato-list {
    padding: 0;
}

.extrato-item {
    display: grid;
    grid-template-columns: 70px 1fr auto;
    gap: 1rem;
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #f3f4f6;
    align-items: center;
    transition: background 0.2s;
}

.extrato-item:hover {
    background: #f9fafb;
}

.extrato-date {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.15rem;
}

.date-day {
    font-size: 1.4rem;
    font-weight: 700;
    color: #667eea;
    line-height: 1;
}

.date-month {
    font-size: 0.65rem;
    color: #9ca3af;
    font-weight: 600;
    letter-spacing: 0.5px;
}

.extrato-info {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.extrato-desc {
    font-weight: 600;
    color: #1f2937;
    font-size: 0.95rem;
}

.extrato-cat {
    font-size: 0.8rem;
    font-weight: 500;
}

.extrato-value {
    text-align: right;
    font-size: 1.1rem;
    font-weight: 700;
    color: #ef4444;
}

.extrato-total {
    display: flex;
    justify-content: space-between;
    padding: 1.25rem 1.5rem;
    background: #f9fafb;
    border-top: 2px solid #e5e7eb;
    font-weight: 700;
}

.total-amount {
    font-size: 1.3rem;
    color: #ef4444;
}

/* Recargas */
.card-recharges {
    background: white;
    border-radius: 12px;
    padding: 1.5rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.card-recharges h3 {
    font-size: 1.1rem;
    color: #1f2937;
    margin-bottom: 1rem;
}

.recharges-compact {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.recharge-compact-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.875rem 1rem;
    background: #f0fdf4;
    border-left: 3px solid #10b981;
    border-radius: 8px;
}

.recharge-date {
    font-size: 0.85rem;
    color: #6b7280;
    font-weight: 600;
    min-width: 80px;
}

.recharge-badge {
    flex: 1;
    font-size: 0.85rem;
    color: #059669;
    font-weight: 600;
}

.recharge-value {
    font-size: 1rem;
    font-weight: 700;
    color: #10b981;
}

/* Empty State */
.empty-state-compact {
    padding: 2.5rem 1.5rem;
    text-align: center;
    color: #9ca3af;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
}

.empty-icon {
    font-size: 2.5rem;
    opacity: 0.5;
}

/* Responsive */
@media (max-width: 768px) {
    .container-details {
        padding: 1rem;
    }

    .benefit-header-card {
        flex-direction: column;
        gap: 1rem;
    }

    .header-actions {
        width: 100%;
        justify-content: center;
    }

    .summary-grid {
        grid-template-columns: 1fr;
    }

    .extrato-item {
        grid-template-columns: 1fr;
        gap: 0.75rem;
    }

    .extrato-date {
        flex-direction: row;
        justify-content: flex-start;
        gap: 0.5rem;
    }

    .extrato-value {
        text-align: left;
    }

    .recharge-compact-item {
        flex-direction: column;
        align-items: flex-start;
    }
}
</style>

<?php include VIEWS . '/layouts/footer.php'; ?>