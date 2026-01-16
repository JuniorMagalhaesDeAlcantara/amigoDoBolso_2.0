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

<style>
    /* ==================== RESET & VARIABLES ==================== */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        -webkit-tap-highlight-color: transparent;
    }

    :root {
        --primary: #667eea;
        --primary-dark: #5568d3;
        --secondary: #10b981;
        --danger: #ef4444;
        --warning: #f59e0b;
        --info: #3b82f6;
        --dark: #1e293b;
        --gray-50: #f8fafc;
        --gray-100: #f1f5f9;
        --gray-200: #e2e8f0;
        --gray-300: #cbd5e1;
        --gray-400: #94a3b8;
        --gray-500: #64748b;
        --gray-600: #475569;
        --gray-700: #334155;
        --gray-800: #1e293b;
        --gray-900: #0f172a;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    body {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        background: var(--gray-50);
        color: var(--gray-900);
        line-height: 1.6;
        min-height: 100vh;
        min-height: -webkit-fill-available;
        margin: 0;
        padding: 0;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    html {
        height: -webkit-fill-available;
    }

    .container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 1.5rem;
    }

    /* ==================== NAVBAR RESPONSIVA ==================== */
    .navbar {
        position: sticky;
        top: 0;
        z-index: 1000;
        background: #ffffff;
        border-bottom: 1px solid var(--gray-200);
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        margin: 0;
    }

    .navbar .container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.875rem 1.5rem;
        gap: 1.5rem;
    }

    .navbar-brand a {
        display: flex;
        align-items: center;
        text-decoration: none;
        transition: opacity 0.2s;
    }

    .navbar-brand a:hover {
        opacity: 0.85;
    }

    .logo {
        height: 50px;
        width: auto;
    }

    /* Desktop Menu */
    .navbar-menu {
        display: flex;
        list-style: none;
        gap: 0.25rem;
        margin: 0;
        padding: 0;
        align-items: center;
        flex: 1;
        justify-content: center;
    }

    .navbar-menu li a {
        color: var(--gray-600);
        text-decoration: none;
        padding: 0.625rem 1rem;
        border-radius: 8px;
        transition: var(--transition);
        font-weight: 500;
        font-size: 0.875rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        white-space: nowrap;
    }

    .navbar-menu li a svg {
        width: 18px;
        height: 18px;
    }

    .navbar-menu li a:hover {
        background: var(--gray-100);
        color: var(--gray-900);
    }

    .navbar-menu li a.active {
        background: var(--primary);
        color: white;
    }

    .btn-logout {
        background: transparent !important;
        color: var(--danger) !important;
    }

    .btn-logout:hover {
        background: rgba(239, 68, 68, 0.1) !important;
    }

    /* Mobile Toggle */
    .mobile-toggle {
        display: none;
        flex-direction: column;
        gap: 4px;
        cursor: pointer;
        padding: 0.5rem;
        border-radius: 8px;
        transition: var(--transition);
    }

    .mobile-toggle:hover {
        background: var(--gray-100);
    }

    .mobile-toggle span {
        width: 24px;
        height: 2px;
        background: var(--gray-700);
        border-radius: 2px;
        transition: var(--transition);
    }

    /* ==================== WELCOME SECTION RESPONSIVA ==================== */
    .welcome-section {
        background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        color: white;
        padding: 1.75rem 1.5rem;
        border-radius: 16px;
        margin: 1.5rem 0;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
    }

    .welcome-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 300px;
        height: 300px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.08);
        pointer-events: none;
    }

    .welcome-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1.5rem;
        position: relative;
        z-index: 1;
    }

    .welcome-text h1 {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.375rem;
        letter-spacing: -0.02em;
    }

    .welcome-text p {
        font-size: 0.9375rem;
        opacity: 0.92;
    }

    .group-info {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        padding: 0.875rem 1.25rem;
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        text-align: right;
    }

    .group-name {
        font-size: 0.8125rem;
        opacity: 0.88;
        margin-bottom: 0.25rem;
    }

    .group-code {
        font-family: 'Courier New', monospace;
        font-size: 1.0625rem;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        user-select: none;
    }

    .group-code:hover {
        opacity: 0.8;
        transform: scale(1.05);
    }

    /* ==================== SUMMARY CARDS RESPONSIVOS ==================== */
    .summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .summary-card {
        background: white;
        border-radius: 12px;
        padding: 1.25rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        transition: var(--transition);
        border-left: 4px solid;
    }

    .summary-card:hover {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }

    .summary-card.income {
        border-left-color: var(--secondary);
    }

    .summary-card.expense {
        border-left-color: var(--danger);
    }

    .summary-card.balance {
        border-left-color: var(--info);
    }

    .card-header-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
    }

    .card-icon {
        font-size: 1.5rem;
    }

    .card-label {
        font-size: 0.8125rem;
        color: var(--gray-500);
        font-weight: 500;
        margin-bottom: 0.375rem;
    }

    .card-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--gray-900);
    }

    .card-value.positive {
        color: var(--secondary);
    }

    .card-value.negative {
        color: var(--danger);
    }

    /* ==================== SECTIONS RESPONSIVAS ==================== */
    .cards-section,
    .transactions-card {
        margin-bottom: 2rem;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .section-header h2 {
        font-size: 1.375rem;
        font-weight: 700;
        color: var(--gray-900);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* ==================== CARTÕES DE CRÉDITO RESPONSIVOS ==================== */
    .cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.25rem;
    }

    .credit-card-mini {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        min-height: 200px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        color: white;
    }

    .credit-card-mini:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .credit-card-mini::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        pointer-events: none;
    }

    /* Cores dos Bancos */
    .credit-card-mini.nubank {
        background: linear-gradient(135deg, #8A05BE 0%, #C000FF 100%);
    }

    .credit-card-mini.inter {
        background: linear-gradient(135deg, #FF7A00 0%, #FF9500 100%);
    }

    .credit-card-mini.c6 {
        background: linear-gradient(135deg, #2D2D2D 0%, #1A1A1A 100%);
    }

    .credit-card-mini.itau {
        background: linear-gradient(135deg, #FF6600 0%, #FF8C00 100%);
    }

    .credit-card-mini.bradesco {
        background: linear-gradient(135deg, #CC092F 0%, #E30613 100%);
    }

    .credit-card-mini.santander {
        background: linear-gradient(135deg, #EC0000 0%, #FF0000 100%);
    }

    .credit-card-mini.bb {
        background: linear-gradient(135deg, #FFEB00 0%, #FFD700 100%);
        color: #333;
    }

    .credit-card-mini.caixa {
        background: linear-gradient(135deg, #0066B3 0%, #0080D6 100%);
    }

    .credit-card-mini.picpay {
        background: linear-gradient(135deg, #21C25E 0%, #11D96D 100%);
    }

    .credit-card-mini.neon {
        background: linear-gradient(135deg, #00D9A5 0%, #00E5B8 100%);
    }

    .credit-card-mini.next {
        background: linear-gradient(135deg, #00AB63 0%, #00C578 100%);
    }

    .credit-card-mini.original {
        background: linear-gradient(135deg, #00A859 0%, #00C069 100%);
    }

    .credit-card-mini.outros {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .card-mini-chip {
        width: 42px;
        height: 32px;
        margin-bottom: 1.25rem;
        position: relative;
        z-index: 1;
    }

    .mini-chip {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #e5c07b 0%, #daa520 100%);
        border-radius: 5px;
        position: relative;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .mini-chip::before {
        content: '';
        position: absolute;
        top: 3px;
        left: 3px;
        right: 3px;
        bottom: 3px;
        background: repeating-linear-gradient(45deg,
                transparent,
                transparent 2px,
                rgba(0, 0, 0, 0.1) 2px,
                rgba(0, 0, 0, 0.1) 4px);
        border-radius: 3px;
    }

    .card-mini-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1.5rem;
        position: relative;
    }

    .card-mini-name {
        font-size: 1.0625rem;
        font-weight: 700;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        letter-spacing: 0.3px;
    }

    .card-mini-number {
        font-family: 'Courier New', monospace;
        font-size: 1.0625rem;
        letter-spacing: 2px;
        margin-bottom: 0.875rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        font-weight: 500;
    }

    .card-mini-holder {
        font-family: 'Courier New', monospace;
        font-size: 0.75rem;
        letter-spacing: 1.2px;
        margin-bottom: 1rem;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
        opacity: 0.92;
    }

    .card-mini-details {
        display: flex;
        justify-content: space-between;
        padding-top: 0.875rem;
        border-top: 1px solid rgba(255, 255, 255, 0.2);
    }

    .card-mini-info {
        flex: 1;
    }

    .card-mini-label {
        font-size: 0.625rem;
        opacity: 0.82;
        margin-bottom: 0.25rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 500;
    }

    .card-mini-value {
        font-size: 1rem;
        font-weight: 700;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    }

    /* ==================== BENEFÍCIOS RESPONSIVOS ==================== */
    .benefits-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.25rem;
    }

    .benefit-card-mini {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        min-height: 170px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
        color: white;
    }

    .benefit-card-mini:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }

    .benefit-card-mini::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        pointer-events: none;
    }

    .benefit-card-mini.vr {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .benefit-card-mini.va {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    .benefit-mini-header {
        display: flex;
        align-items: flex-start;
        gap: 0.875rem;
        margin-bottom: 1.25rem;
    }

    .benefit-icon {
        font-size: 2.25rem;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    .benefit-mini-info h3 {
        font-size: 1.0625rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .benefit-type {
        font-size: 0.75rem;
        opacity: 0.88;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    }

    .benefit-balance {
        font-size: 1.625rem;
        font-weight: 800;
        margin-bottom: 0.875rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.25);
    }

    .benefit-details {
        display: flex;
        justify-content: space-between;
        font-size: 0.75rem;
        padding-top: 0.875rem;
        border-top: 1px solid rgba(255, 255, 255, 0.2);
        opacity: 0.92;
    }

    /* ==================== GRÁFICOS RESPONSIVOS ==================== */
    .charts-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.25rem;
        margin-bottom: 2rem;
    }

    .chart-card {
        background: white;
        border-radius: 12px;
        padding: 1.25rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        min-width: 0;
        /* IMPORTANTE: permite que o card encolha */
        overflow: hidden;
        /* IMPORTANTE: evita overflow */
    }

    .chart-card h3 {
        font-size: 1.0625rem;
        font-weight: 600;
        color: var(--gray-900);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .chart-card canvas {
        max-height: 260px;
        width: 100% !important;
        /* IMPORTANTE: força largura 100% */
        height: auto !important;
        /* IMPORTANTE: altura automática */
    }

    /* ==================== TRANSAÇÕES RESPONSIVAS ==================== */
    .transactions-card {
        background: white;
        border-radius: 12px;
        padding: 1.25rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.25rem;
        gap: 1rem;
    }

    .card-header h3 {
        font-size: 1.1875rem;
        font-weight: 600;
        color: var(--gray-900);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .transaction-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.875rem;
        border-bottom: 1px solid var(--gray-200);
        transition: var(--transition);
        gap: 1rem;
    }

    .transaction-item:last-child {
        border-bottom: none;
    }

    .transaction-item:hover {
        background: var(--gray-50);
    }

    .transaction-info {
        display: flex;
        align-items: center;
        gap: 0.875rem;
        flex: 1;
        min-width: 0;
    }

    .transaction-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.125rem;
        flex-shrink: 0;
    }

    .transaction-icon.receita {
        background: rgba(16, 185, 129, 0.12);
    }

    .transaction-icon.despesa {
        background: rgba(239, 68, 68, 0.12);
    }

    .transaction-details {
        flex: 1;
        min-width: 0;
    }

    .transaction-details h4 {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--gray-900);
        margin-bottom: 0.375rem;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .transaction-badges {
        display: flex;
        align-items: center;
        gap: 0.375rem;
        flex-wrap: wrap;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.1875rem 0.5rem;
        border-radius: 5px;
        font-size: 0.6875rem;
        font-weight: 500;
        white-space: nowrap;
    }

    .badge-date {
        background: var(--gray-100);
        color: var(--gray-600);
    }

    .badge-category {
        background: color-mix(in srgb, var(--cat-color) 12%, white);
        color: var(--cat-color);
    }

    .badge-payment {
        background: rgba(102, 126, 234, 0.12);
        color: var(--primary);
    }

    .badge-credit {
        background: rgba(245, 158, 11, 0.12);
        color: #d97706;
    }

    .badge-va,
    .badge-vr {
        background: rgba(16, 185, 129, 0.12);
        color: var(--secondary);
    }

    .badge-cash {
        background: rgba(100, 116, 139, 0.12);
        color: var(--gray-600);
    }

    .badge-recurring {
        background: rgba(245, 158, 11, 0.12);
        color: #d97706;
    }

    .installment-badge {
        margin-left: 0.125rem;
        padding: 0 0.25rem;
        background: rgba(0, 0, 0, 0.1);
        border-radius: 3px;
        font-weight: 600;
    }

    .transaction-amount {
        font-size: 1.0625rem;
        font-weight: 700;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .transaction-amount.positive {
        color: var(--secondary);
    }

    .transaction-amount.negative {
        color: var(--danger);
    }

    /* ==================== METAS RESPONSIVAS ==================== */
    .goals-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1rem;
    }

    .goal-card {
        background: var(--gray-50);
        padding: 1.125rem;
        border-radius: 12px;
        transition: var(--transition);
    }

    .goal-card:hover {
        background: var(--gray-100);
    }

    .goal-card h4 {
        margin-bottom: 0.875rem;
        color: var(--gray-900);
        font-size: 0.9375rem;
        font-weight: 600;
    }

    .goal-progress {
        display: flex;
        align-items: center;
        gap: 0.875rem;
        margin-bottom: 0.625rem;
    }

    .progress-bar {
        flex: 1;
        height: 7px;
        background: var(--gray-200);
        border-radius: 4px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--primary) 0%, var(--primary-dark) 100%);
        transition: width 0.3s ease;
        border-radius: 4px;
    }

    .progress-text {
        font-weight: 600;
        color: var(--primary);
        font-size: 0.8125rem;
        min-width: 42px;
    }

    .goal-info {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.375rem;
        font-size: 0.8125rem;
        color: var(--gray-600);
    }

    .goal-deadline {
        color: var(--gray-500);
        font-size: 0.75rem;
    }

    /* ==================== BUTTONS RESPONSIVOS ==================== */
    .btn {
        padding: 0.625rem 1.125rem;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 0.8125rem;
        font-weight: 600;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        white-space: nowrap;
    }

    .btn-primary {
        background: var(--primary);
        color: white;
    }

    .btn-primary:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
    }

    .btn-link {
        background: transparent;
        color: var(--primary);
        padding: 0.5rem;
    }

    .btn-link:hover {
        background: var(--gray-100);
    }

    .card {
        background: white;
        border-radius: 12px;
        padding: 1.25rem;
        margin-bottom: 2rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .empty-state {
        text-align: center;
        padding: 2.5rem 1.5rem;
        color: var(--gray-400);
    }

    /* ==================== TABLET RESPONSIVO ==================== */
    @media (max-width: 1024px) {
        .container {
            padding: 0 1.25rem;
        }

        .logo {
            height: 45px;
        }

        .navbar-menu li a {
            padding: 0.5rem 0.75rem;
            font-size: 0.8125rem;
        }

        .charts-grid {
            grid-template-columns: 1fr;
        }

        .cards-grid {
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        }
    }

    /* ==================== MOBILE RESPONSIVO ==================== */
    @media (max-width: 768px) {
        .container {
            padding: 0 1rem;
        }

        /* Navbar Mobile */
        .navbar .container {
            padding: 0.75rem 1rem;
        }

        .logo {
            height: 40px;
        }

        .mobile-toggle {
            display: flex;
        }

        .navbar-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            flex-direction: column;
            padding: 1rem;
            gap: 0.375rem;
            border-bottom: 1px solid var(--gray-200);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .navbar-menu.mobile-open {
            display: flex;
        }

        .navbar-menu li {
            width: 100%;
        }

        .navbar-menu li a {
            width: 100%;
            justify-content: flex-start;
            padding: 0.75rem 1rem;
        }

        /* Welcome Mobile */
        .welcome-section {
            padding: 1.25rem 1rem;
            margin: 1rem 0;
        }

        .welcome-content {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
        }

        .welcome-text h1 {
            font-size: 1.375rem;
        }

        .welcome-text p {
            font-size: 0.875rem;
        }

        .group-info {
            width: 100%;
            text-align: left;
        }

        /* Summary Cards Mobile */
        .summary-grid {
            grid-template-columns: 1fr;
            gap: 0.875rem;
        }

        .summary-card {
            padding: 1rem;
        }

        .card-value {
            font-size: 1.5rem;
        }

        /* Cards Grid Mobile */
        .cards-grid,
        .benefits-grid {
            grid-template-columns: 1fr;
        }

        .credit-card-mini,
        .benefit-card-mini {
            min-height: auto;
        }

        /* Section Header Mobile */
        .section-header h2 {
            font-size: 1.125rem;
        }

        .btn {
            padding: 0.5rem 0.875rem;
            font-size: 0.75rem;
        }

        /* Transações Mobile */
        .transaction-item {
            flex-direction: column;
            align-items: flex-start;
            padding: 0.75rem;
            gap: 0.625rem;
        }

        .transaction-info {
            width: 100%;
        }

        .transaction-amount {
            align-self: flex-end;
            font-size: 1rem;
        }

        .transaction-badges {
            gap: 0.25rem;
        }

        .badge {
            font-size: 0.625rem;
            padding: 0.125rem 0.375rem;
        }

        /* Charts Mobile */
        .charts-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .chart-card {
            padding: 1rem;
            overflow: hidden;
            /* IMPORTANTE */
        }

        .chart-card canvas {
            max-height: 220px;
            width: 100% !important;
            /* IMPORTANTE */
            height: auto !important;
            /* IMPORTANTE */
        }

        /* Card Header Mobile */
        .card-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .card-header h3 {
            font-size: 1.0625rem;
        }

        .card-header .btn-primary {
            width: 100%;
            justify-content: center;
        }
    }

    /* ==================== MOBILE EXTRA SMALL ==================== */
    @media (max-width: 375px) {
        .welcome-text h1 {
            font-size: 1.25rem;
        }

        .card-value {
            font-size: 1.375rem;
        }

        .credit-card-mini,
        .benefit-card-mini {
            padding: 1.25rem;
        }

        .card-mini-name,
        .benefit-mini-info h3 {
            font-size: 1rem;
        }

        .benefit-balance {
            font-size: 1.5rem;
        }
    }

    /* ==================== PWA STANDALONE MODE ==================== */
    @media (display-mode: standalone) {
        body {
            padding-top: env(safe-area-inset-top);
            padding-bottom: env(safe-area-inset-bottom);
        }

        .navbar {
            padding-top: env(safe-area-inset-top);
        }
    }

    /* ==================== LANDSCAPE MOBILE ==================== */
    @media (max-width: 968px) and (orientation: landscape) {
        .welcome-section {
            padding: 1rem;
        }

        .welcome-text h1 {
            font-size: 1.25rem;
        }

        .summary-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 0.75rem;
        }

        .summary-card {
            padding: 0.875rem;
        }

        .card-value {
            font-size: 1.375rem;
        }
    }

    /* ==================== REDUCE MOTION ==================== */
    @media (prefers-reduced-motion: reduce) {

        *,
        *::before,
        *::after {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
    }

    /* ==================== HIGH CONTRAST ==================== */
    @media (prefers-contrast: high) {

        .summary-card,
        .credit-card-mini,
        .benefit-card-mini {
            border: 2px solid currentColor;
        }

        .btn-primary {
            border: 2px solid white;
        }
    }
</style>