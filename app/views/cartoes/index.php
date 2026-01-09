<?php include VIEWS . '/layouts/header.php'; ?>

<div class="container">
    <div class="card-header">
        <h1>💳 Meus Cartões de Crédito</h1>
        <a href="/cartoes/criar" class="btn btn-primary">+ Novo Cartão</a>
    </div>
    
    <div class="card">
        <?php if (empty($cards)): ?>
            <div class="empty-state">
                <div class="empty-icon">💳</div>
                <h3>Nenhum cartão cadastrado</h3>
                <p>Cadastre seus cartões de crédito para controlar melhor suas compras parceladas</p>
                <a href="/cartoes/criar" class="btn btn-primary">Cadastrar Primeiro Cartão</a>
            </div>
        <?php else: ?>
            <div class="cards-grid">
                <?php foreach ($cards as $card): ?>
                    <div class="credit-card">
                        <div class="card-chip">💳</div>
                        <div class="card-name"><?= htmlspecialchars($card['name']) ?></div>
                        <div class="card-number">•••• <?= $card['last_digits'] ?></div>
                        
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
                        
                        <!-- Fatura Atual -->
                        <div class="card-invoice">
                            <div class="invoice-label">Fatura Atual</div>
                            <div class="invoice-value">R$ <?= number_format($card['current_invoice'], 2, ',', '.') ?></div>
                            
                            <?php if ($card['credit_limit']): ?>
                                <div class="limit-progress">
                                    <?php 
                                    $percentUsed = ($card['current_invoice'] / $card['credit_limit']) * 100;
                                    ?>
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: <?= min($percentUsed, 100) ?>%"></div>
                                    </div>
                                    <div class="limit-text">
                                        <span>Limite: R$ <?= number_format($card['credit_limit'], 2, ',', '.') ?></span>
                                        <span class="available">Disponível: R$ <?= number_format($card['available'], 2, ',', '.') ?></span>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="card-actions">
                            <a href="/cartoes/extrato/<?= $card['id'] ?>" class="btn-action btn-primary-action">
                                📊 Ver Extrato
                            </a>
                            <a href="/cartoes/deletar/<?= $card['id'] ?>" 
                               class="btn-action btn-delete-action"
                               onclick="return confirm('Tem certeza que deseja deletar este cartão?\n\nAtenção: As transações já cadastradas não serão deletadas.')">
                                🗑️
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
    grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
    gap: 2rem;
    padding: 1rem;
}

.credit-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 20px;
    padding: 2rem;
    color: white;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    transition: transform 0.3s, box-shadow 0.3s;
    position: relative;
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.credit-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
}

.card-chip {
    font-size: 2.5rem;
}

.card-name {
    font-size: 1.3rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.card-number {
    font-family: 'Courier New', monospace;
    font-size: 1.4rem;
    letter-spacing: 3px;
    margin-bottom: 0.5rem;
}

.card-details-row {
    display: flex;
    gap: 2rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
}

.card-detail {
    display: flex;
    flex-direction: column;
    gap: 0.3rem;
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

.card-invoice {
    background: rgba(255, 255, 255, 0.15);
    padding: 1rem;
    border-radius: 12px;
    margin-top: 0.5rem;
}

.invoice-label {
    font-size: 0.8rem;
    opacity: 0.8;
    margin-bottom: 0.25rem;
}

.invoice-value {
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.limit-progress {
    margin-top: 0.75rem;
}

.progress-bar {
    width: 100%;
    height: 6px;
    background: rgba(255, 255, 255, 0.3);
    border-radius: 3px;
    overflow: hidden;
    margin-bottom: 0.5rem;
}

.progress-fill {
    height: 100%;
    background: #fbbf24;
    transition: width 0.3s;
}

.limit-text {
    display: flex;
    justify-content: space-between;
    font-size: 0.75rem;
    opacity: 0.9;
}

.available {
    font-weight: 600;
}

.card-actions {
    display: flex;
    gap: 0.75rem;
    margin-top: auto;
    padding-top: 1rem;
    border-top: 1px solid rgba(255, 255, 255, 0.2);
}

.btn-action {
    flex: 1;
    padding: 0.75rem 1rem;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: all 0.3s;
    font-size: 0.9rem;
}

.btn-primary-action {
    background: rgba(255, 255, 255, 0.95);
    color: #667eea;
}

.btn-primary-action:hover {
    background: white;
    transform: scale(1.02);
}

.btn-delete-action {
    background: rgba(239, 68, 68, 0.9);
    color: white;
    flex: 0 0 auto;
    padding: 0.75rem;
}

.btn-delete-action:hover {
    background: rgba(239, 68, 68, 1);
    transform: scale(1.05);
}

@media (max-width: 768px) {
    .cards-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php include VIEWS . '/layouts/footer.php'; ?>