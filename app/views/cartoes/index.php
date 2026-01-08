<?php include VIEWS . '/layouts/header.php'; ?>

<div class="container">
    <div class="card-header">
        <h1> Meus Cartões de Crédito</h1>
        <a href="/cartoes/criar" class="btn btn-primary">+ Novo Cartão</a>
    </div>
    
    <div class="card">
        <?php if (empty($cards)): ?>
            <div class="empty-state">
                <div class="empty-icon"></div>
                <h3>Nenhum cartão cadastrado</h3>
                <p>Cadastre seus cartões de crédito para controlar melhor suas compras parceladas</p>
                <a href="/cartoes/criar" class="btn btn-primary">Cadastrar Primeiro Cartão</a>
            </div>
        <?php else: ?>
            <div class="cards-grid">
                <?php foreach ($cards as $card): ?>
                    <div class="credit-card">
                        <div class="card-chip"></div>
                        <div class="card-name"><?= htmlspecialchars($card['name']) ?></div>
                        <div class="card-number">   <?= $card['last_digits'] ?></div>
                        
                        <div class="card-details-row">
                            <div class="card-detail">
                                <span class="detail-label">Fechamento</span>
                                <span class="detail-value">Dia <?= $card['closing_day'] ?></span>
                            </div>
                            <div class="card-detail">
                                <span class="detail-label">Vencimento</span>
                                <span class="detail-value">Dia <?= $card['due_day'] ?></span>
                            </div>
                        </div>
                        
                        <?php if ($card['credit_limit']): ?>
                            <div class="card-limit">
                                <span class="detail-label">Limite</span>
                                <span class="detail-value">R$ <?= number_format($card['credit_limit'], 2, ',', '.') ?></span>
                            </div>
                        <?php endif; ?>
                        
                        <div class="card-footer">
                            <a href="/cartoes/deletar/<?= $card['id'] ?>" 
                               class="btn-icon btn-delete"
                               onclick="return confirm('Tem certeza que deseja deletar este cartão?\n\nAtenção: As transações já cadastradas não serão deletadas.')">
                               
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
}

.empty-icon {
    font-size: 5rem;
    margin-bottom: 1rem;
    opacity: 0.3;
}

.empty-state h3 {
    color: #333;
    margin-bottom: 0.5rem;
}

.empty-state p {
    color: #666;
    margin-bottom: 2rem;
}

.cards-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 2rem;
}

.credit-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    padding: 2rem;
    color: white;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    transition: transform 0.3s, box-shadow 0.3s;
    position: relative;
    min-height: 220px;
    display: flex;
    flex-direction: column;
}

.credit-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
}

.card-chip {
    font-size: 2.5rem;
    margin-bottom: 1.5rem;
}

.card-name {
    font-size: 1.3rem;
    font-weight: 600;
    margin-bottom: 1rem;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.card-number {
    font-family: 'Courier New', monospace;
    font-size: 1.4rem;
    letter-spacing: 3px;
    margin-bottom: 1.5rem;
}

.card-details-row {
    display: flex;
    gap: 2rem;
    margin-bottom: 1rem;
}

.card-detail {
    display: flex;
    flex-direction: column;
    gap: 0.3rem;
}

.card-limit {
    display: flex;
    flex-direction: column;
    gap: 0.3rem;
    margin-top: 0.5rem;
}

.detail-label {
    font-size: 0.75rem;
    opacity: 0.8;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.detail-value {
    font-size: 1rem;
    font-weight: 600;
}

.card-footer {
    margin-top: auto;
    display: flex;
    justify-content: flex-end;
    padding-top: 1rem;
}

.btn-icon {
    background: rgba(255, 255, 255, 0.2);
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 8px;
    cursor: pointer;
    font-size: 1.2rem;
    transition: background 0.3s;
    text-decoration: none;
    display: inline-block;
}

.btn-icon:hover {
    background: rgba(255, 255, 255, 0.3);
}

.btn-delete:hover {
    background: rgba(231, 76, 60, 0.8);
}

@media (max-width: 768px) {
    .cards-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php include VIEWS . '/layouts/footer.php'; ?>
