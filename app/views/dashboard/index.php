<?php include VIEWS . '/layouts/header.php'; ?>

<div class="container">
    <!-- Seção de Boas-vindas -->
    <div class="welcome-section">
        <div class="welcome-content">
            <div class="welcome-text">
                <h1>👋 Olá, <?= explode(' ', $_SESSION['user_name'] ?? 'Usuário')[0] ?>!</h1>
                <p>Bem-vindo ao seu dashboard financeiro • <?= date('d/m/Y', mktime(0, 0, 0, $month, 1, $year)) ?></p>
            </div>
            <div class="group-info">
                <div class="group-name">👥 Grupo: <?= $currentGroup['name'] ?></div>
                <div class="group-code" title="Clique para copiar o código de convite">
                    <?= $currentGroup['invite_code'] ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Cards de Resumo Financeiro -->
    <div class="summary-grid">
        <div class="summary-card income">
            <div class="card-header-row">
                <div class="card-icon">📈</div>
            </div>
            <div class="card-label">Receitas do Mês</div>
            <div class="card-value positive">R$ <?= number_format($balance['total_income'] ?? 0, 2, ',', '.') ?></div>
        </div>

        <div class="summary-card expense">
            <div class="card-header-row">
                <div class="card-icon">📉</div>
            </div>
            <div class="card-label">Despesas do Mês</div>
            <div class="card-value negative">R$ <?= number_format($balance['total_expense'] ?? 0, 2, ',', '.') ?></div>
        </div>

        <div class="summary-card balance">
            <div class="card-header-row">
                <div class="card-icon">💰</div>
            </div>
            <div class="card-label">Saldo do Mês</div>
            <?php
            $saldo = ($balance['total_income'] ?? 0) - ($balance['total_expense'] ?? 0);
            $saldoClass = $saldo >= 0 ? 'positive' : 'negative';
            ?>
            <div class="card-value <?= $saldoClass ?>">R$ <?= number_format($saldo, 2, ',', '.') ?></div>
        </div>


    </div>

    <!-- Cartões de Crédito -->
    <?php if (!empty($creditCards)): ?>
        <div class="cards-section">
            <div class="section-header">
                <h2>💳 Meus Cartões</h2>
                <a href="/cartoes" class="btn btn-link">Ver todos →</a>
            </div>
            <div class="cards-grid">
                <?php
                // Mapear cores por banco
                $bankClasses = [
                    'nubank' => 'nubank',
                    'inter' => 'inter',
                    'c6' => 'c6',
                    'itau' => 'itau',
                    'bradesco' => 'bradesco',
                    'santander' => 'santander',
                    'bb' => 'bb',
                    'caixa' => 'caixa',
                    'picpay' => 'picpay',
                    'neon' => 'neon',
                    'next' => 'next',
                    'original' => 'original',
                ];

                foreach (array_slice($creditCards, 0, 4) as $card):
                    $bankClass = $bankClasses[$card['bank'] ?? 'outros'] ?? 'outros';
                ?>
                    <div class="credit-card-mini <?= $bankClass ?>">
                        <div class="card-mini-chip">
                            <div class="mini-chip"></div>
                        </div>

                        <div class="card-mini-header">
                            <div>
                                <div class="card-mini-name"><?= htmlspecialchars($card['name']) ?></div>
                                <div class="card-mini-number">•••• •••• •••• <?= $card['last_digits'] ?></div>
                            </div>
                        </div>

                        <?php if (!empty($card['holder_name'])): ?>
                            <div class="card-mini-holder"><?= strtoupper(htmlspecialchars($card['holder_name'])) ?></div>
                        <?php endif; ?>

                        <div class="card-mini-details">
                            <div class="card-mini-info">
                                <div class="card-mini-label">Fatura Atual</div>
                                <div class="card-mini-value">R$ <?= number_format($card['current_bill'] ?? 0, 2, ',', '.') ?></div>
                            </div>
                            <div class="card-mini-info">
                                <div class="card-mini-label">Vencimento</div>
                                <div class="card-mini-value"><?= str_pad($card['due_day'], 2, '0', STR_PAD_LEFT) ?>/<?= date('m') ?></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Benefícios -->
    <?php if (!empty($benefitCards)): ?>
        <div class="cards-section">
            <div class="section-header">
                <h2>🎫 Meus Benefícios</h2>
                <a href="/beneficios" class="btn btn-link">Ver todos →</a>
            </div>
            <div class="benefits-grid">
                <?php foreach (array_slice($benefitCards, 0, 4) as $benefit): ?>
                    <div class="benefit-card-mini <?= $benefit['type'] ?>">
                        <div class="benefit-mini-header">
                            <div class="benefit-icon"><?= $benefit['type'] === 'vr' ? '🍽️' : '🛒' ?></div>
                            <div class="benefit-mini-info">
                                <h3><?= htmlspecialchars($benefit['name']) ?></h3>
                                <div class="benefit-type"><?= $benefit['type'] === 'vr' ? 'Vale Refeição' : 'Vale Alimentação' ?></div>
                            </div>
                        </div>
                        <div class="benefit-balance">R$ <?= number_format($benefit['current_balance'], 2, ',', '.') ?></div>
                        <div class="benefit-details">
                            <div>Recarga: R$ <?= number_format($benefit['monthly_amount'], 2, ',', '.') ?></div>
                            <div>Próxima: <?= str_pad($benefit['recharge_day'], 2, '0', STR_PAD_LEFT) ?>/<?= date('m', strtotime('+1 month')) ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

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

        <?php foreach (array_slice($transactions, 0, 8) as $transaction): ?>
            <div class="transaction-item">
                <div class="transaction-info">
                    <div class="transaction-icon <?= $transaction['type'] ?>">
                        <?= $transaction['type'] === 'receita' ? '📈' : '📉' ?>
                    </div>

                    <div class="transaction-details">
                        <h4><?= htmlspecialchars($transaction['description']) ?></h4>

                        <div class="transaction-badges">
                            <!-- Data -->
                            <span class="badge badge-date">
                                <?= date('d/m', strtotime($transaction['transaction_date'])) ?>
                            </span>

                            <!-- Categoria -->
                            <span class="badge badge-category" style="--cat-color: <?= $transaction['color'] ?>">
                                <?= htmlspecialchars($transaction['category_name']) ?>
                            </span>

                            <!-- Forma de Pagamento -->
                            <?php if ($transaction['payment_method'] === 'credito'): ?>
                                <span class="badge badge-payment badge-credit">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="2" y="4" width="20" height="16" rx="2" />
                                        <path d="M2 10h20" />
                                    </svg>

                                    <?php if (!empty($transaction['card_name'])): ?>
                                        <?= $transaction['card_name'] ?>
                                    <?php else: ?>
                                        Cartão de Crédito
                                    <?php endif; ?>

                                    <?php if ($transaction['installments'] > 1): ?>
                                        <span class="installment-badge">
                                            <?= $transaction['installment_number'] ?>/<?= $transaction['installments'] ?>x
                                        </span>
                                    <?php endif; ?>
                                </span>

                            <?php elseif ($transaction['payment_method'] === 'va'): ?>
                                <span class="badge badge-payment badge-va">
                                    🍽️ VA
                                </span>

                            <?php elseif ($transaction['payment_method'] === 'vr'): ?>
                                <span class="badge badge-payment badge-vr">
                                    🛒 VR
                                </span>

                            <?php else: ?>
                                <span class="badge badge-payment badge-cash">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                                    </svg>
                                    À vista
                                </span>
                            <?php endif; ?>

                            <!-- Recorrente -->
                            <?php if (!empty($transaction['is_recurring'])): ?>
                                <span class="badge badge-recurring">
                                    🔁 Recorrente
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="transaction-amount <?= $transaction['type'] === 'receita' ? 'positive' : 'negative' ?>">
                    <?= $transaction['type'] === 'receita' ? '+' : '-' ?>
                    R$ <?= number_format($transaction['amount'], 2, ',', '.') ?>
                </div>
            </div>
        <?php endforeach; ?>


        <div style="text-align: center; margin-top: 1.5rem;">
            <a href="/transacoes" class="btn btn-link">Ver todas as transações →</a>
        </div>

    </div>

    <!-- Metas em Andamento -->
    <?php if (!empty($goals)): ?>
        <div class="card">
            <div class="card-header">
                <h3>🎯 Metas em Andamento</h3>
                <a href="/metas" class="btn btn-link">Ver todas →</a>
            </div>

            <div class="goals-grid">
                <?php foreach (array_slice($goals, 0, 3) as $goal):
                    $progress = ($goal['current_amount'] / $goal['target_amount']) * 100;
                ?>
                    <div class="goal-card">
                        <h4><?= htmlspecialchars($goal['name']) ?></h4>
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
    document.querySelector('.group-code')?.addEventListener('click', function() {
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
        const categoryData = <?= json_encode(array_map(function ($cat) {
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
                                padding: 12,
                                font: {
                                    size: 11
                                }
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
                                padding: 12,
                                font: {
                                    size: 11
                                }
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