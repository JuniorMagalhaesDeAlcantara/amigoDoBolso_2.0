<?php include VIEWS . '/layouts/header.php'; ?>

<div class="container">
    <div class="confirm-delete-card">
        <div class="warning-icon">⚠️</div>
        
        <h1>Atenção: Transação com Parcelas/Recorrências</h1>
        
        <div class="transaction-info">
            <h3><?= htmlspecialchars($transaction['description']) ?></h3>
            <p class="amount">R$ <?= number_format($transaction['amount'], 2, ',', '.') ?></p>
            <p class="date"><?= date('d/m/Y', strtotime($transaction['transaction_date'])) ?></p>
        </div>
        
        <div class="related-info">
            <p>Esta transação possui <strong><?= count($related) ?> lançamentos relacionados</strong>:</p>
            
            <div class="related-list">
                <?php foreach ($related as $r): ?>
                    <div class="related-item">
                        <span class="related-date"><?= date('d/m/Y', strtotime($r['transaction_date'])) ?></span>
                        <span class="related-desc"><?= htmlspecialchars($r['description']) ?></span>
                        <span class="related-value">R$ <?= number_format($r['amount'], 2, ',', '.') ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <div class="total-info">
            <?php 
            $total = array_sum(array_column($related, 'amount'));
            ?>
            <strong>Valor Total:</strong> R$ <?= number_format($total, 2, ',', '.') ?>
        </div>
        
        <form method="POST" action="/transacoes/deletar/<?= $transaction['id'] ?>">
            <div class="options">
                <label class="option-card">
                    <input type="radio" name="delete_related" value="0" checked>
                    <div class="option-content">
                        <div class="option-title">🔹 Deletar apenas esta transação</div>
                        <div class="option-desc">As outras <?= count($related) - 1 ?> parcelas/recorrências permanecerão</div>
                    </div>
                </label>
                
                <label class="option-card danger">
                    <input type="radio" name="delete_related" value="1">
                    <div class="option-content">
                        <div class="option-title">🔥 Deletar TODAS as parcelas/recorrências</div>
                        <div class="option-desc">Todas as <?= count($related) ?> transações relacionadas serão removidas</div>
                    </div>
                </label>
            </div>
            
            <div class="actions">
                <a href="/transacoes" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-danger">Confirmar Exclusão</button>
            </div>
        </form>
    </div>
</div>

<style>
.confirm-delete-card {
    max-width: 700px;
    margin: 2rem auto;
    background: white;
    padding: 2.5rem;
    border-radius: 16px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.warning-icon {
    font-size: 4rem;
    text-align: center;
    margin-bottom: 1rem;
}

.confirm-delete-card h1 {
    text-align: center;
    color: #dc2626;
    margin-bottom: 2rem;
    font-size: 1.5rem;
}

.transaction-info {
    background: #f9fafb;
    padding: 1.5rem;
    border-radius: 12px;
    text-align: center;
    margin-bottom: 2rem;
}

.transaction-info h3 {
    color: #1f2937;
    margin-bottom: 0.5rem;
}

.amount {
    font-size: 1.8rem;
    font-weight: 700;
    color: #ef4444;
    margin: 0.5rem 0;
}

.date {
    color: #6b7280;
}

.related-info {
    margin-bottom: 2rem;
}

.related-info > p {
    margin-bottom: 1rem;
    font-size: 1.1rem;
}

.related-list {
    background: #f9fafb;
    padding: 1rem;
    border-radius: 8px;
    max-height: 300px;
    overflow-y: auto;
}

.related-item {
    display: grid;
    grid-template-columns: 100px 1fr auto;
    gap: 1rem;
    padding: 0.75rem;
    border-bottom: 1px solid #e5e7eb;
    align-items: center;
}

.related-item:last-child {
    border-bottom: none;
}

.related-date {
    font-weight: 600;
    color: #667eea;
}

.related-desc {
    color: #1f2937;
}

.related-value {
    font-weight: 600;
    color: #6b7280;
}

.total-info {
    background: #fee2e2;
    padding: 1rem;
    border-radius: 8px;
    text-align: center;
    font-size: 1.2rem;
    margin-bottom: 2rem;
}

.options {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin-bottom: 2rem;
}

.option-card {
    display: flex;
    gap: 1rem;
    padding: 1.5rem;
    border: 2px solid #e5e7eb;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s;
}

.option-card:hover {
    border-color: #667eea;
    background: #f9fafb;
}

.option-card.danger:hover {
    border-color: #ef4444;
    background: #fef2f2;
}

.option-card input[type="radio"] {
    margin-top: 0.25rem;
}

.option-card input[type="radio"]:checked + .option-content {
    color: #667eea;
}

.option-card.danger input[type="radio"]:checked + .option-content {
    color: #ef4444;
}

.option-title {
    font-weight: 700;
    font-size: 1.1rem;
    margin-bottom: 0.25rem;
}

.option-desc {
    font-size: 0.9rem;
    color: #6b7280;
}

.actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
}

@media (max-width: 768px) {
    .related-item {
        grid-template-columns: 1fr;
        gap: 0.25rem;
    }
}
</style>

<?php include VIEWS . '/layouts/footer.php'; ?>