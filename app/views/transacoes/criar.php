<?php include VIEWS . '/layouts/header.php'; ?>

<div class="container-small">
    <div class="card">
        <h2> Nova Transação</h2>
        
        <form method="POST" action="/transacoes/criar">
            <div class="form-group">
                <label for="type">Tipo</label>
                <select name="type" id="type" required>
                    <option value="">Selecione...</option>
                    <option value="receita"> Receita</option>
                    <option value="despesa"> Despesa</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="category_id">Categoria</label>
                <select name="category_id" id="category_id" required>
                    <option value="">Selecione...</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id'] ?>" data-type="<?= $category['type'] ?>">
                            <?= $category['name'] ?> (<?= ucfirst($category['type']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="description">Descrição</label>
                <input type="text" id="description" name="description" placeholder="Ex: Compra no mercado" required>
            </div>
            
            <div class="form-group">
                <label for="amount">Valor (R$)</label>
                <input type="number" id="amount" name="amount" step="0.01" min="0.01" placeholder="0,00" required>
            </div>
            
            <div class="form-group">
                <label for="transaction_date">Data</label>
                <input type="date" id="transaction_date" name="transaction_date" value="<?= date('Y-m-d') ?>" required>
            </div>
            
            <div class="form-group">
                <label for="installments">Parcelamento (opcional)</label>
                <select name="installments" id="installments">
                    <option value="1">À vista</option>
                    <?php for ($i = 2; $i <= 12; $i++): ?>
                        <option value="<?= $i ?>"><?= $i ?>x</option>
                    <?php endfor; ?>
                </select>
                <small>Para compras parceladas, será criada uma transação para cada mês</small>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Salvar Transação</button>
                <a href="/transacoes" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
// Filtrar categorias por tipo
document.getElementById('type').addEventListener('change', function() {
    const selectedType = this.value;
    const categorySelect = document.getElementById('category_id');
    const options = categorySelect.querySelectorAll('option');
    
    options.forEach(option => {
        if (option.value === '') return;
        
        const optionType = option.getAttribute('data-type');
        if (selectedType === '' || optionType === selectedType) {
            option.style.display = 'block';
        } else {
            option.style.display = 'none';
        }
    });
    
    categorySelect.value = '';
});
</script>

<style>
.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
}

small {
    display: block;
    margin-top: 0.5rem;
    color: #666;
    font-size: 0.85rem;
}
</style>

<?php include VIEWS . '/layouts/footer.php'; ?>
