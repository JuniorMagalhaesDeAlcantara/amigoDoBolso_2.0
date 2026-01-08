<?php include VIEWS . '/layouts/header.php'; ?>

<div class="container">
    <div class="dashboard-header">
        <h1>Dashboard - <?= date('F Y', mktime(0, 0, 0, $month, 1, $year)) ?></h1>
        <div class="group-info">
            <strong>Grupo:</strong> <?= $currentGroup['name'] ?>
            <span class="invite-code" title="Código de convite"> <?= $currentGroup['invite_code'] ?></span>
        </div>
    </div>
    
    <!-- Resumo Financeiro -->
    <div class="cards-grid">
        <div class="card card-success">
            <h3> Receitas</h3>
            <p class="value">R$ <?= number_format($balance['total_income'] ?? 0, 2, ',', '.') ?></p>
        </div>
        
        <div class="card card-danger">
            <h3> Despesas</h3>
            <p class="value">R$ <?= number_format($balance['total_expense'] ?? 0, 2, ',', '.') ?></p>
        </div>
        
        <div class="card card-info">
            <h3> Saldo</h3>
            <?php 
                $saldo = ($balance['total_income'] ?? 0) - ($balance['total_expense'] ?? 0);
                $saldoClass = $saldo >= 0 ? 'positive' : 'negative';
            ?>
            <p class="value <?= $saldoClass ?>">R$ <?= number_format($saldo, 2, ',', '.') ?></p>
        </div>
    </div>
    
    <!-- Gráfico de Gastos por Categoria -->
    <?php if (!empty($spendingByCategory)): ?>
    <div class="card">
        <h3> Gastos por Categoria</h3>
        <div class="category-list">
            <?php foreach ($spendingByCategory as $category): ?>
                <div class="category-item">
                    <div class="category-info">
                        <span class="category-color" style="background-color: <?= $category['color'] ?>"></span>
                        <span class="category-name"><?= $category['category_name'] ?></span>
                    </div>
                    <span class="category-value">R$ <?= number_format($category['total'], 2, ',', '.') ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
    
    <!-- Últimas Transações -->
    <div class="card">
        <div class="card-header">
            <h3> Últimas Transações</h3>
            <a href="/transacoes/criar" class="btn btn-primary">+ Nova Transação</a>
        </div>
        
        <?php if (empty($transactions)): ?>
            <p class="empty-state">Nenhuma transação neste mês</p>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Descrição</th>
                        <th>Categoria</th>
                        <th>Usuário</th>
                        <th>Valor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach (array_slice($transactions, 0, 10) as $transaction): ?>
                        <tr>
                            <td><?= date('d/m/Y', strtotime($transaction['transaction_date'])) ?></td>
                            <td><?= $transaction['description'] ?></td>
                            <td>
                                <span class="badge" style="background-color: <?= $transaction['color'] ?>">
                                    <?= $transaction['category_name'] ?>
                                </span>
                            </td>
                            <td><?= $transaction['user_name'] ?></td>
                            <td class="<?= $transaction['type'] === 'receita' ? 'text-success' : 'text-danger' ?>">
                                <?= $transaction['type'] === 'receita' ? '+' : '-' ?> 
                                R$ <?= number_format($transaction['amount'], 2, ',', '.') ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a href="/transacoes" class="btn btn-link">Ver todas as transações </a>
        <?php endif; ?>
    </div>
    
    <!-- Metas em Andamento -->
    <?php if (!empty($goals)): ?>
    <div class="card">
        <div class="card-header">
            <h3> Metas em Andamento</h3>
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

<?php include VIEWS . '/layouts/footer.php'; ?>
