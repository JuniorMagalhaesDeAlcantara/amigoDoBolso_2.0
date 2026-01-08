<?php include VIEWS . '/layouts/header.php'; ?>

<div class="container-small">
    <div class="card">
        <h2> Editar Transação</h2>
        
        <form method="POST" action="/transacoes/editar/<?= $transaction['id'] ?>">
            <div class="form-group">
                <label for="category_id">Categoria</label>
                <select name="category_id" id="category_id" required>
                    <?php foreach ($categories as $category): ?>
                        <?php if ($category['type'] === $transaction['type']): ?>
                            <option value="<?= $category['id'] ?>" <?= $category['id'] == $transaction['category_id'] ? 'selected' : '' ?>>
                                <?= $category['name'] ?>
                            </option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="description">Descrição</label>
                <input type="text" id="description" name="description" value="<?= htmlspecialchars($transaction['description']) ?>" required>
            </div>
            
            <div class="form-group">
                <label for="amount">Valor (R$)</label>
                <input type="number" id="amount" name="amount" step="0.01" min="0.01" value="<?= $transaction['amount'] ?>" required>
            </div>
            
            <div class="form-group">
                <label for="transaction_date">Data</label>
                <input type="date" id="transaction_date" name="transaction_date" value="<?= $transaction['transaction_date'] ?>" required>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                <a href="/transacoes" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<style>
.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
}
</style>

<?php include VIEWS . '/layouts/footer.php'; ?>
