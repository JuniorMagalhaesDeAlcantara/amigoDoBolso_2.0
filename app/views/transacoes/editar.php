<?php include VIEWS . '/layouts/header.php'; ?>

<div class="container">
    <div class="page-header">
        <h1>Editar Transação</h1>
    </div>
    
    <?php if ($hasRelated): ?>
        <div class="alert alert-warning">
            ⚠️ Esta transação possui <strong><?= count($related) ?> lançamentos relacionados</strong> (parcelas/recorrências).
            Você pode optar por editar apenas esta ou todas as relacionadas.
        </div>
    <?php endif; ?>
    
    <div class="card">
        <form method="POST" action="/transacoes/editar/<?= $transaction['id'] ?>" class="form">
            <div class="form-row">
                <div class="form-group">
                    <label for="tipo">Tipo *</label>
                    <select id="tipo" name="tipo" required disabled>
                        <option value="despesa" <?= $transaction['type'] === 'despesa' ? 'selected' : '' ?>>Despesa</option>
                        <option value="receita" <?= $transaction['type'] === 'receita' ? 'selected' : '' ?>>Receita</option>
                    </select>
                    <small class="help-text">Tipo não pode ser alterado</small>
                </div>
                
                <div class="form-group">
                    <label for="valor">Valor *</label>
                    <input 
                        type="text" 
                        id="valor" 
                        name="amount" 
                        value="<?= number_format($transaction['amount'], 2, ',', '.') ?>" 
                        class="money-input"
                        required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="descricao">Descrição *</label>
                <input 
                    type="text" 
                    id="descricao" 
                    name="description" 
                    value="<?= htmlspecialchars($transaction['description']) ?>" 
                    required>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label for="categoria_id">Categoria</label>
                    <select id="categoria_id" name="category_id">
                        <option value="">Sem categoria</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $transaction['category_id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="data_transacao">Data *</label>
                    <input 
                        type="date" 
                        id="data_transacao" 
                        name="transaction_date" 
                        value="<?= $transaction['transaction_date'] ?>" 
                        required>
                </div>
            </div>
            
            <?php if ($hasRelated): ?>
                <div class="related-section">
                    <h3>Transações Relacionadas</h3>
                    <div class="related-preview">
                        <?php foreach (array_slice($related, 0, 3) as $r): ?>
                            <div class="related-item-preview">
                                <span><?= date('d/m/Y', strtotime($r['transaction_date'])) ?></span>
                                <span><?= htmlspecialchars($r['description']) ?></span>
                                <span>R$ <?= number_format($r['amount'], 2, ',', '.') ?></span>
                            </div>
                        <?php endforeach; ?>
                        
                        <?php if (count($related) > 3): ?>
                            <p class="more-items">... e mais <?= count($related) - 3 ?> transações</p>
                        <?php endif; ?>
                    </div>
                    
                    <label class="checkbox-label">
                        <input type="checkbox" name="update_related" value="1" id="update_related">
                        <span>Aplicar alterações em <strong>TODAS</strong> as <?= count($related) ?> transações relacionadas</span>
                    </label>
                    
                    <div class="help-note">
                        💡 <strong>Dica:</strong> Se marcar esta opção, categoria, descrição e data serão atualizadas em todas as parcelas/recorrências.
                        O valor <strong>não será alterado</strong> em compras parceladas para manter o valor de cada parcela.
                    </div>
                </div>
            <?php endif; ?>
            
            <div class="form-actions">
                <a href="/transacoes" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            </div>
        </form>
    </div>
</div>

<style>
.alert {
    padding: 1rem 1.5rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
}

.alert-warning {
    background: #fef3c7;
    border-left: 4px solid #f59e0b;
    color: #92400e;
}

.help-text {
    font-size: 0.85rem;
    color: #6b7280;
    margin-top: 0.25rem;
    display: block;
}

.related-section {
    background: #f9fafb;
    padding: 1.5rem;
    border-radius: 12px;
    margin: 2rem 0;
}

.related-section h3 {
    color: #1f2937;
    margin-bottom: 1rem;
}

.related-preview {
    background: white;
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1rem;
}

.related-item-preview {
    display: grid;
    grid-template-columns: 100px 1fr auto;
    gap: 1rem;
    padding: 0.75rem;
    border-bottom: 1px solid #f3f4f6;
    font-size: 0.9rem;
}

.related-item-preview:last-child {
    border-bottom: none;
}

.more-items {
    text-align: center;
    color: #6b7280;
    font-style: italic;
    margin-top: 0.5rem;
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem;
    background: white;
    border-radius: 8px;
    cursor: pointer;
    margin-bottom: 1rem;
}

.checkbox-label input[type="checkbox"] {
    width: 20px;
    height: 20px;
    cursor: pointer;
}

.checkbox-label:hover {
    background: #f3f4f6;
}

.help-note {
    background: #dbeafe;
    padding: 1rem;
    border-radius: 8px;
    font-size: 0.9rem;
    color: #1e40af;
}

/* Máscara de dinheiro */
.money-input {
    text-align: right;
    font-family: 'Courier New', monospace;
    font-weight: 600;
}
</style>

<script>
// Máscara de dinheiro no input
document.getElementById('valor').addEventListener('input', function(e) {
    let value = e.target.value;
    
    // Remove tudo que não é número
    value = value.replace(/\D/g, '');
    
    // Converte para centavos
    value = (parseInt(value) / 100).toFixed(2);
    
    // Formata para BR
    value = value.replace('.', ',');
    value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    
    e.target.value = value;
});

// Aviso ao marcar checkbox
document.getElementById('update_related')?.addEventListener('change', function() {
    if (this.checked) {
        if (!confirm('Tem certeza que deseja aplicar as alterações em TODAS as transações relacionadas?')) {
            this.checked = false;
        }
    }
});
</script>

<?php include VIEWS . '/layouts/footer.php'; ?>