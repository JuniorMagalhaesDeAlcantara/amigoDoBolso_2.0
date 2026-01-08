<?php include VIEWS . '/layouts/header.php'; ?>

<div class="container">
    <div class="card-header">
        <h1> Transações</h1>
        <a href="/transacoes/criar" class="btn btn-primary">+ Nova Transação</a>
    </div>
    
    <!-- Filtro de Mês/Ano -->
    <div class="card">
        <form method="GET" action="/transacoes" class="filter-form">
            <div class="form-row">
                <div class="form-group">
                    <label for="month">Mês</label>
                    <select name="month" id="month">
                        <?php for ($m = 1; $m <= 12; $m++): ?>
                            <option value="<?= $m ?>" <?= $m == $month ? 'selected' : '' ?>>
                                <?= date('F', mktime(0, 0, 0, $m, 1)) ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="year">Ano</label>
                    <select name="year" id="year">
                        <?php for ($y = date('Y') - 2; $y <= date('Y') + 1; $y++): ?>
                            <option value="<?= $y ?>" <?= $y == $year ? 'selected' : '' ?>>
                                <?= $y ?>
                            </option>
                        <?php endfor; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-secondary">Filtrar</button>
                </div>
            </div>
        </form>
    </div>
    
    <!-- Lista de Transações -->
    <div class="card">
        <?php if (empty($transactions)): ?>
            <p class="empty-state">Nenhuma transação encontrada neste período</p>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Descrição</th>
                        <th>Categoria</th>
                        <th>Tipo</th>
                        <th>Valor</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transactions as $transaction): ?>
                        <tr>
                            <td><?= date('d/m/Y', strtotime($transaction['transaction_date'])) ?></td>
                            <td><?= htmlspecialchars($transaction['description']) ?></td>
                            <td>
                                <span class="badge" style="background-color: <?= $transaction['color'] ?>">
                                    <?= $transaction['category_name'] ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($transaction['type'] === 'receita'): ?>
                                    <span class="badge" style="background-color: #27ae60">Receita</span>
                                <?php else: ?>
                                    <span class="badge" style="background-color: #e74c3c">Despesa</span>
                                <?php endif; ?>
                            </td>
                            <td class="<?= $transaction['type'] === 'receita' ? 'text-success' : 'text-danger' ?>">
                                <?= $transaction['type'] === 'receita' ? '+' : '-' ?> 
                                R$ <?= number_format($transaction['amount'], 2, ',', '.') ?>
                            </td>
                            <td>
                                <a href="/transacoes/editar/<?= $transaction['id'] ?>" class="btn btn-sm btn-secondary">Editar</a>
                                <a href="/transacoes/deletar/<?= $transaction['id'] ?>" 
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Tem certeza que deseja deletar esta transação?')">
                                   Deletar
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

<style>
.filter-form {
    display: flex;
    gap: 1rem;
    align-items: flex-end;
}

.form-row {
    display: flex;
    gap: 1rem;
    align-items: flex-end;
    flex-wrap: wrap;
}

.btn-sm {
    padding: 0.4rem 0.8rem;
    font-size: 0.85rem;
}

.btn-danger {
    background: #e74c3c;
    color: white;
}

.btn-danger:hover {
    background: #c0392b;
}
</style>

<?php include VIEWS . '/layouts/footer.php'; ?>
