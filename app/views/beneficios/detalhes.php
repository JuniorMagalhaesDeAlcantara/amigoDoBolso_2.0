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

<div class="container">
    <!-- Card do Benefício -->
    <div class="benefit-card-large">
        <div class="card-header-benefit">
            <div>
                <div class="benefit-type-badge">
                    <span class="type-icon-large"><?= $typeIcon ?></span>
                    <span><?= $typeName ?></span>
                </div>
                <h1><?= htmlspecialchars($benefit['name']) ?></h1>
                <p class="provider-name"><?= ucfirst($benefit['provider']) ?></p>
            </div>
        </div>

        <div class="balance-section">
            <div class="balance-item balance-main">
                <span class="balance-label">Saldo Disponível</span>
                <span class="balance-value-large">R$ <?= number_format($benefit['current_balance'], 2, ',', '.') ?></span>
            </div>

            <div class="balance-grid">
                <div class="balance-item">
                    <span class="balance-label">Gasto em <?= $months[$month] ?></span>
                    <span class="balance-value">R$ <?= number_format($monthlyExpense, 2, ',', '.') ?></span>
                </div>
                <div class="balance-item">
                    <span class="balance-label">Recarga Mensal</span>
                    <span class="balance-value">R$ <?= number_format($benefit['monthly_amount'], 2, ',', '.') ?></span>
                </div>
                <div class="balance-item">
                    <span class="balance-label">Próxima Recarga</span>
                    <span class="balance-value">Dia <?= $benefit['recharge_day'] ?></span>
                </div>
            </div>

            <!-- Barra de Progresso -->
            <div class="progress-section">
                <div class="progress-bar-large">
                    <?php 
                    $progressColor = $percentUsed > 90 ? '#ef4444' : ($percentUsed > 70 ? '#f59e0b' : '#10b981');
                    ?>
                    <div class="progress-fill-large" style="width: <?= min($percentUsed, 100) ?>%; background: <?= $progressColor ?>"></div>
                </div>
                <div class="progress-info">
                    <span><?= number_format($percentUsed, 1) ?>% usado este mês</span>
                    <span>Restam R$ <?= number_format($benefit['current_balance'], 2, ',', '.') ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Transações do Mês -->
    <div class="card">
        <div class="card-header">
            <h2>📊 Transações de <?= $months[$month] ?> / <?= $year ?></h2>
            <div class="filter-buttons">
                <a href="?month=<?= $month > 1 ? $month - 1 : 12 ?>&year=<?= $month > 1 ? $year : $year - 1 ?>" 
                   class="btn btn-secondary btn-sm">← Mês Anterior</a>
                <a href="?month=<?= $month < 12 ? $month + 1 : 1 ?>&year=<?= $month < 12 ? $year : $year + 1 ?>" 
                   class="btn btn-secondary btn-sm">Próximo Mês →</a>
            </div>
        </div>

        <?php if (empty($transactions)): ?>
            <div class="empty-state-small">
                <p>Nenhuma transação neste mês</p>
            </div>
        <?php else: ?>
            <div class="transactions-list">
                <?php foreach ($transactions as $t): ?>
                    <div class="transaction-item">
                        <div class="transaction-icon" style="background: <?= $t['color'] ?>20; color: <?= $t['color'] ?>">
                            💳
                        </div>
                        <div class="transaction-info">
                            <strong><?= htmlspecialchars($t['description']) ?></strong>
                            <small><?= $t['category_name'] ?> • <?= date('d/m/Y', strtotime($t['transaction_date'])) ?></small>
                        </div>
                        <div class="transaction-amount">
                            <span class="amount-value">R$ <?= number_format($t['amount'], 2, ',', '.') ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="total-section">
                <strong>Total do Mês:</strong>
                <span class="total-value">R$ <?= number_format($monthlyExpense, 2, ',', '.') ?></span>
            </div>
        <?php endif; ?>
    </div>

    <!-- Histórico de Recargas -->
    <div class="card">
        <div class="card-header">
            <h2>🔄 Histórico de Recargas</h2>
        </div>

        <?php if (empty($rechargeHistory)): ?>
            <div class="empty-state-small">
                <p>Nenhuma recarga registrada</p>
            </div>
        <?php else: ?>
            <div class="recharges-list">
                <?php foreach ($rechargeHistory as $recharge): ?>
                    <div class="recharge-item">
                        <div class="recharge-icon">💰</div>
                        <div class="recharge-info">
                            <strong>Recarga</strong>
                            <small><?= date('d/m/Y', strtotime($recharge['recharge_date'])) ?></small>
                        </div>
                        <div class="recharge-amount">
                            +R$ <?= number_format($recharge['amount'], 2, ',', '.') ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- Botões de Ação -->
    <div class="action-buttons">
        <a href="/beneficios" class="btn btn-secondary">← Voltar</a>
        <div class="action-buttons-right">
            <a href="/beneficios/recarregar/<?= $benefit['id'] ?>" class="btn btn-success">
                💰 Recarga Manual
            </a>
            <a href="/beneficios/editar/<?= $benefit['id'] ?>" class="btn btn-primary">
                ✏️ Editar
            </a>
            <a href="/beneficios/deletar/<?= $benefit['id'] ?>" 
               class="btn btn-danger"
               onclick="return confirm('Tem certeza que deseja deletar este benefício?')">
                🗑️ Deletar
            </a>
        </div>
    </div>
</div>

<style>
.benefit-card-large {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    padding: 2.5rem;
    color: white;
    margin-bottom: 2rem;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
}

.card-header-benefit {
    margin-bottom: 2rem;
}

.benefit-type-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(255, 255, 255, 0.2);
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.9rem;
    margin-bottom: 1rem;
    backdrop-filter: blur(10px);
}

.type-icon-large {
    font-size: 1.2rem;
}

.card-header-benefit h1 {
    font-size: 2rem;
    margin: 0.5rem 0;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.provider-name {
    opacity: 0.9;
    text-transform: capitalize;
    font-size: 1rem;
}

.balance-section {
    background: rgba(0, 0, 0, 0.2);
    padding: 2rem;
    border-radius: 15px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.balance-main {
    text-align: center;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
    margin-bottom: 1.5rem;
}

.balance-label {
    display: block;
    font-size: 0.85rem;
    opacity: 0.9;
    margin-bottom: 0.5rem;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.balance-value-large {
    display: block;
    font-size: 3rem;
    font-weight: 800;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.balance-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.balance-item {
    text-align: center;
}

.balance-value {
    display: block;
    font-size: 1.3rem;
    font-weight: 700;
    margin-top: 0.5rem;
}

.progress-section {
    margin-top: 1.5rem;
}

.progress-bar-large {
    width: 100%;
    height: 12px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 6px;
    overflow: hidden;
    margin-bottom: 0.75rem;
}

.progress-fill-large {
    height: 100%;
    transition: width 0.3s;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.progress-info {
    display: flex;
    justify-content: space-between;
    font-size: 0.9rem;
    opacity: 0.95;
}

.filter-buttons {
    display: flex;
    gap: 0.5rem;
}

.transactions-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.transaction-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 10px;
    transition: transform 0.2s;
}

.transaction-item:hover {
    transform: translateX(5px);
    background: #e9ecef;
}

.transaction-icon {
    width: 45px;
    height: 45px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
}

.transaction-info {
    flex: 1;
}

.transaction-info strong {
    display: block;
    color: #333;
    margin-bottom: 0.25rem;
}

.transaction-info small {
    color: #666;
    font-size: 0.85rem;
}

.transaction-amount {
    text-align: right;
}

.amount-value {
    font-size: 1.2rem;
    font-weight: 700;
    color: #ef4444;
}

.total-section {
    display: flex;
    justify-content: space-between;
    padding: 1.5rem;
    background: #f1f5f9;
    border-radius: 10px;
    margin-top: 1rem;
    font-size: 1.1rem;
}

.total-value {
    font-size: 1.4rem;
    font-weight: 800;
    color: #ef4444;
}

.recharges-list {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.recharge-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: #f0fdf4;
    border-radius: 10px;
    border-left: 4px solid #10b981;
}

.recharge-icon {
    width: 45px;
    height: 45px;
    background: #10b98120;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
}

.recharge-info {
    flex: 1;
}

.recharge-info strong {
    display: block;
    color: #333;
    margin-bottom: 0.25rem;
}

.recharge-info small {
    color: #666;
    font-size: 0.85rem;
}

.recharge-amount {
    font-size: 1.2rem;
    font-weight: 700;
    color: #10b981;
}

.action-buttons {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
    justify-content: space-between;
}

.empty-state-small {
    text-align: center;
    padding: 3rem;
    color: #666;
}

@media (max-width: 768px) {
    .balance-grid {
        grid-template-columns: 1fr;
    }

    .filter-buttons {
        flex-direction: column;
    }

    .balance-value-large {
        font-size: 2rem;
    }
}
</style>

<?php include VIEWS . '/layouts/footer.php'; ?>