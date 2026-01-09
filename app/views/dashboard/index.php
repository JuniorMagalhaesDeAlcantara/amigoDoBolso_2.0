<?php include VIEWS . '/layouts/header.php'; ?>

<div class="container">
    <div class="dashboard-header">
        <div class="header-info">
            <h2>Dashboard - <?= date('F Y', mktime(0, 0, 0, $month, 1, $year)) ?></h2>
            <div class="group-badge">
                <span>👥 Grupo:</span> <?= $currentGroup['name'] ?>
                <span class="invite-code" title="Clique para copiar o código de convite"><?= $currentGroup['invite_code'] ?></span>
            </div>
        </div>
    </div>
    
    <!-- Cards de Resumo Financeiro -->
    <div class="summary-grid">
        <div class="summary-card income">
            <div class="card-icon">📈</div>
            <div class="card-label">Receitas do Mês</div>
            <div class="card-value positive">R$ <?= number_format($balance['total_income'] ?? 0, 2, ',', '.') ?></div>
        </div>
        
        <div class="summary-card expense">
            <div class="card-icon">📉</div>
            <div class="card-label">Despesas do Mês</div>
            <div class="card-value negative">R$ <?= number_format($balance['total_expense'] ?? 0, 2, ',', '.') ?></div>
        </div>
        
        <div class="summary-card balance">
            <div class="card-icon">💰</div>
            <div class="card-label">Saldo do Mês</div>
            <?php 
                $saldo = ($balance['total_income'] ?? 0) - ($balance['total_expense'] ?? 0);
                $saldoClass = $saldo >= 0 ? 'positive' : 'negative';
            ?>
            <div class="card-value <?= $saldoClass ?>">R$ <?= number_format($saldo, 2, ',', '.') ?></div>
        </div>
        
        <div class="summary-card credit">
            <div class="card-icon">💳</div>
            <div class="card-label">Fatura de Cartões</div>
            <div class="card-value">R$ <?= number_format($creditCardTotal ?? 0, 2, ',', '.') ?></div>
        </div>
    </div>

    <!-- Cartões de Crédito e Benefícios -->
    <div class="cards-section">
        <?php if (!empty($creditCards)): ?>
            <?php foreach (array_slice($creditCards, 0, 3) as $card): ?>
                <div class="credit-card">
                    <div class="card-header">
                        <div class="card-brand"><?= $card['name'] ?></div>
                        <div class="card-type">💳 Crédito</div>
                    </div>
                    <div class="card-number">•••• •••• •••• <?= $card['last_digits'] ?></div>
                    <div class="card-details">
                        <div class="card-info">
                            <span>Fatura Atual</span>
                            <strong>R$ <?= number_format($card['current_bill'] ?? 0, 2, ',', '.') ?></strong>
                        </div>
                        <div class="card-info">
                            <span>Vencimento</span>
                            <strong><?= str_pad($card['due_day'], 2, '0', STR_PAD_LEFT) ?>/<?= date('m/Y') ?></strong>
                        </div>
                        <?php if ($card['credit_limit']): ?>
                        <div class="card-info">
                            <span>Limite</span>
                            <strong>R$ <?= number_format($card['credit_limit'], 2, ',', '.') ?></strong>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if (!empty($benefitCards)): ?>
            <?php foreach (array_slice($benefitCards, 0, 2) as $benefit): ?>
                <div class="benefit-card <?= $benefit['type'] ?>">
                    <div class="benefit-header">
                        <div>
                            <div style="font-size: 2rem; margin-bottom: 0.5rem;">
                                <?= $benefit['type'] === 'vr' ? '🍽️' : '🛒' ?>
                            </div>
                            <div class="benefit-provider"><?= $benefit['name'] ?></div>
                        </div>
                        <div class="card-type"><?= $benefit['type'] === 'vr' ? 'Vale Refeição' : 'Vale Alimentação' ?></div>
                    </div>
                    <div class="benefit-balance">R$ <?= number_format($benefit['current_balance'], 2, ',', '.') ?></div>
                    <div class="benefit-info">
                        <div>
                            <div>Recarga: R$ <?= number_format($benefit['monthly_amount'], 2, ',', '.') ?>/mês</div>
                            <div>Próxima: <?= str_pad($benefit['recharge_day'], 2, '0', STR_PAD_LEFT) ?>/<?= date('m/Y', strtotime('+1 month')) ?></div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    
    <!-- Gráficos -->
    <div class="charts-grid">
        <!-- Gráfico de Gastos por Categoria -->
        <?php if (!empty($spendingByCategory)): ?>
        <div class="chart-card">
            <h3>📊 Gastos por Categoria</h3>
            <canvas id="categoryChart"></canvas>
        </div>
        <?php endif; ?>
        
        <!-- Gráfico de Evolução Mensal -->
        <?php if (!empty($monthlyEvolution)): ?>
        <div class="chart-card">
            <h3>📈 Evolução Mensal</h3>
            <canvas id="monthlyChart"></canvas>
        </div>
        <?php endif; ?>
    </div>
    
    <!-- Últimas Transações -->
    <div class="transactions-card">
        <div class="card-header">
            <h3>💸 Últimas Transações</h3>
            <a href="/transacoes/criar" class="btn btn-primary">+ Nova Transação</a>
        </div>
        
        <?php if (empty($transactions)): ?>
            <p class="empty-state">Nenhuma transação neste mês</p>
        <?php else: ?>
            <?php foreach (array_slice($transactions, 0, 8) as $transaction): ?>
                <div class="transaction-item">
                    <div class="transaction-info">
                        <div class="transaction-icon <?= $transaction['type'] ?>">
                            <?= $transaction['type'] === 'receita' ? '📈' : '📉' ?>
                        </div>
                        <div class="transaction-details">
                            <h4><?= $transaction['description'] ?></h4>
                            <p><?= date('d/m', strtotime($transaction['transaction_date'])) ?> • <?= $transaction['category_name'] ?></p>
                        </div>
                    </div>
                    <div class="transaction-amount <?= $transaction['type'] === 'receita' ? 'positive' : 'negative' ?>">
                        <?= $transaction['type'] === 'receita' ? '+' : '-' ?> R$ <?= number_format($transaction['amount'], 2, ',', '.') ?>
                    </div>
                </div>
            <?php endforeach; ?>
            
            <div style="text-align: center; margin-top: 1.5rem;">
                <a href="/transacoes" class="btn btn-link">Ver todas as transações →</a>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Metas em Andamento -->
    <?php if (!empty($goals)): ?>
    <div class="card">
        <div class="card-header">
            <h3>🎯 Metas em Andamento</h3>
            <a href="/metas" class="btn btn-primary">Ver todas</a>
        </div>
        
        <div class="goals-grid">
            <?php foreach (array_slice($goals, 0, 3) as $goal): 
                $progress = ($goal['current_amount'] / $goal['target_amount']) * 100;
            ?>
                <div class="goal-card">
                    <h4><?= $goal['name'] ?></h4>
                    <div class="goal-progress">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: <?= min(100, $progress) ?>%"></div>
                        </div>
                        <span class="progress-text"><?= number_format($progress, 1) ?>%</span>
                    </div>
                    <div class="goal-info">
                        <span>R$ <?= number_format($goal['current_amount'], 2, ',', '.') ?></span>
                        <span>de R$ <?= number_format($goal['target_amount'], 2, ',', '.') ?></span>
                    </div>
                    <p class="goal-deadline">Prazo: <?= date('d/m/Y', strtotime($goal['deadline'])) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<script>
// Copiar código de convite
document.querySelector('.invite-code')?.addEventListener('click', function() {
    const code = this.textContent.trim();
    navigator.clipboard.writeText(code).then(() => {
        const original = this.textContent;
        this.textContent = '✓ Copiado!';
        setTimeout(() => {
            this.textContent = original;
        }, 2000);
    });
});

<?php if (!empty($spendingByCategory)): ?>
// Gráfico de Gastos por Categoria
const categoryData = <?= json_encode(array_map(function($cat) {
    return [
        'label' => $cat['category_name'],
        'value' => floatval($cat['total']),
        'color' => $cat['color']
    ];
}, $spendingByCategory)) ?>;

const categoryCtx = document.getElementById('categoryChart');
if (categoryCtx) {
    new Chart(categoryCtx.getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: categoryData.map(d => d.label),
            datasets: [{
                data: categoryData.map(d => d.value),
                backgroundColor: categoryData.map(d => d.color),
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        font: { size: 12 }
                    }
                }
            }
        }
    });
}
<?php endif; ?>

<?php if (!empty($monthlyEvolution)): ?>
// Gráfico de Evolução Mensal
const monthlyData = <?= json_encode($monthlyEvolution) ?>;

const monthlyCtx = document.getElementById('monthlyChart');
if (monthlyCtx) {
    new Chart(monthlyCtx.getContext('2d'), {
        type: 'line',
        data: {
            labels: monthlyData.map(d => d.month),
            datasets: [{
                label: 'Receitas',
                data: monthlyData.map(d => parseFloat(d.income)),
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                tension: 0.4,
                fill: true
            }, {
                label: 'Despesas',
                data: monthlyData.map(d => parseFloat(d.expense)),
                borderColor: '#ef4444',
                backgroundColor: 'rgba(239, 68, 68, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        font: { size: 12 }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'R$ ' + value.toLocaleString('pt-BR');
                        }
                    }
                }
            }
        }
    });
}
<?php endif; ?>
</script>

<?php include VIEWS . '/layouts/footer.php'; ?>