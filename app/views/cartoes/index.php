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
                <?php foreach ($cards as $card):
                    // Define cores e logos baseado no banco - LOGOS REAIS
                    $bankStyles = [
                        'nubank' => [
                            'gradient' => 'linear-gradient(135deg, #8A05BE 0%, #C000FF 100%)',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/f/f7/Nubank_logo_2021.svg'
                        ],
                        'inter' => [
                            'gradient' => 'linear-gradient(135deg, #FF7A00 0%, #FF9500 100%)',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/7/7e/Banco_Inter_logo.svg'
                        ],
                        'c6' => [
                            'gradient' => 'linear-gradient(135deg, #2D2D2D 0%, #1A1A1A 100%)',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/7/7b/C6_Bank_logo.svg'
                        ],
                        'itau' => [
                            'gradient' => 'linear-gradient(135deg, #FF6600 0%, #FF8C00 100%)',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/c/cb/Itau_logo.svg'
                        ],
                        'bradesco' => [
                            'gradient' => 'linear-gradient(135deg, #CC092F 0%, #E30613 100%)',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/0/04/Bradesco_logo.svg'
                        ],
                        'santander' => [
                            'gradient' => 'linear-gradient(135deg, #EC0000 0%, #FF0000 100%)',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/b/b8/Banco_Santander_Logotipo.svg'
                        ],
                        'bb' => [
                            'gradient' => 'linear-gradient(135deg, #FFEB00 0%, #FFD700 100%)',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/8/89/Banco_do_Brasil_logo.svg'
                        ],
                        'caixa' => [
                            'gradient' => 'linear-gradient(135deg, #0066B3 0%, #0080D6 100%)',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/4/4d/Caixa_Econ%C3%B4mica_Federal_logo.svg'
                        ],
                        'picpay' => [
                            'gradient' => 'linear-gradient(135deg, #21C25E 0%, #11D96D 100%)',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/7/7c/PicPay_logo.svg'
                        ],
                        'neon' => [
                            'gradient' => 'linear-gradient(135deg, #00D9A5 0%, #00E5B8 100%)',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/6/65/Neon_Pagamentos_logo.svg'
                        ],
                        'next' => [
                            'gradient' => 'linear-gradient(135deg, #00AB63 0%, #00C578 100%)',
                            'logo' => 'https://www.banconext.com.br/_next/static/media/logo.2c4f4c98.svg'
                        ],
                        'original' => [
                            'gradient' => 'linear-gradient(135deg, #00A859 0%, #00C069 100%)',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/b/bc/Banco_Original.svg'
                        ],
                        'outros' => [
                            'gradient' => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                            'logo' => ''
                        ]
                    ];

                    $bank = $card['bank'] ?? 'outros';
                    $style = $bankStyles[$bank] ?? $bankStyles['outros'];
                ?>
                    <div class="credit-card" style="background: <?= $style['gradient'] ?>">
                        <!-- Chip do Cartão -->
                        <div class="card-chip">
                            <div class="chip"></div>
                        </div>

                        <!-- Logo do Banco -->
                        <div class="card-logo">
                            <?php if ($style['logo']): ?>
                                <img src="<?= $style['logo'] ?>" alt="<?= $bank ?>" onerror="this.style.display='none'">
                            <?php endif; ?>
                        </div>

                        <!-- Nome do Cartão -->
                        <div class="card-name"><?= htmlspecialchars($card['name']) ?></div>

                        <!-- Número do Cartão -->
                        <div class="card-number">•••• •••• •••• <?= $card['last_digits'] ?></div>

                        <!-- Nome do Titular -->
                        <?php if (!empty($card['holder_name'])): ?>
                            <div class="card-holder"><?= strtoupper(htmlspecialchars($card['holder_name'])) ?></div>
                        <?php endif; ?>

                        <!-- Detalhes -->
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

                        <!-- Divisor -->
                        <div class="card-divider"></div>

                        <!-- Fatura Atual -->
                        <div class="card-invoice">
                            <div class="invoice-header">
                                <div>
                                    <div class="invoice-label">Fatura Atual</div>
                                    <div class="invoice-value">R$ <?= number_format($card['current_invoice'], 2, ',', '.') ?></div>
                                </div>
                            </div>

                            <?php if ($card['credit_limit']): ?>
                                <div class="limit-progress">
                                    <?php
                                    $percentUsed = ($card['current_invoice'] / $card['credit_limit']) * 100;
                                    $progressColor = $percentUsed > 80 ? '#ef4444' : ($percentUsed > 50 ? '#f59e0b' : '#10b981');
                                    ?>
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: <?= min($percentUsed, 100) ?>%; background: <?= $progressColor ?>"></div>
                                    </div>
                                    <div class="limit-text">
                                        <span>Limite: R$ <?= number_format($card['credit_limit'], 2, ',', '.') ?></span>
                                        <span class="available">Disponível: R$ <?= number_format($card['available'], 2, ',', '.') ?></span>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Ações -->
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
        grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
        gap: 2rem;
        padding: 1rem;
    }

    .credit-card {
        min-height: 340px;
        border-radius: 20px;
        padding: 2rem;
        color: white;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        transition: transform 0.3s, box-shadow 0.3s;
        position: relative;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    /* Textura de cartão */
    .credit-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg,
                rgba(255, 255, 255, 0.1) 0%,
                rgba(255, 255, 255, 0) 50%,
                rgba(0, 0, 0, 0.1) 100%);
        pointer-events: none;
    }

    .credit-card:hover {
        transform: translateY(-10px) rotateY(5deg);
        box-shadow: 0 30px 80px rgba(0, 0, 0, 0.4);
    }

    /* Chip do cartão */
    .card-chip {
        width: 50px;
        height: 40px;
        margin-bottom: 1rem;
        z-index: 1;
    }

    .chip {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #e5c07b 0%, #daa520 100%);
        border-radius: 8px;
        position: relative;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .chip::before {
        content: '';
        position: absolute;
        top: 5px;
        left: 5px;
        right: 5px;
        bottom: 5px;
        background: repeating-linear-gradient(45deg,
                transparent,
                transparent 2px,
                rgba(0, 0, 0, 0.1) 2px,
                rgba(0, 0, 0, 0.1) 4px);
        border-radius: 4px;
    }

    .card-logo {
        position: absolute;
        top: 2rem;
        right: 2rem;
        width: 80px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1;
    }

    .card-logo img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        filter: brightness(0) invert(1);
        opacity: 0.9;
    }

    .card-name {
        font-size: 1.2rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        z-index: 1;
    }

    .card-number {
        font-family: 'Courier New', monospace;
        font-size: 1.4rem;
        letter-spacing: 4px;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        font-weight: 500;
        z-index: 1;
    }

    .card-holder {
        font-family: 'Courier New', monospace;
        font-size: 0.9rem;
        letter-spacing: 2px;
        margin-bottom: 1rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        opacity: 0.9;
        z-index: 1;
    }

    .card-details-row {
        display: flex;
        gap: 2.5rem;
        margin-bottom: 0.8rem;
        z-index: 1;
    }

    .card-detail {
        display: flex;
        flex-direction: column;
        gap: 0.3rem;
    }

    .detail-label {
        font-size: 0.7rem;
        opacity: 0.8;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 500;
    }

    .detail-value {
        font-size: 1.1rem;
        font-weight: 700;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    }

    .card-divider {
        height: 1px;
        background: linear-gradient(90deg,
                transparent 0%,
                rgba(255, 255, 255, 0.5) 50%,
                transparent 100%);
        margin: 0.8rem 0;
        z-index: 1;
    }

    .card-invoice {
        background: rgba(0, 0, 0, 0.2);
        padding: 1.2rem;
        border-radius: 12px;
        margin-top: auto;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        z-index: 1;
    }

    .invoice-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .invoice-label {
        font-size: 0.75rem;
        opacity: 0.9;
        margin-bottom: 0.3rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .invoice-value {
        font-size: 1.8rem;
        font-weight: 800;
        margin-bottom: 0.8rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .limit-progress {
        margin-top: 0.8rem;
    }

    .progress-bar {
        width: 100%;
        height: 8px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 4px;
        overflow: hidden;
        margin-bottom: 0.5rem;
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.2);
    }

    .progress-fill {
        height: 100%;
        transition: width 0.3s;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
    }

    .limit-text {
        display: flex;
        justify-content: space-between;
        font-size: 0.75rem;
        opacity: 0.95;
        font-weight: 500;
    }

    .available {
        font-weight: 700;
    }

    .card-actions {
        display: flex;
        gap: 0.75rem;
        margin-top: 1rem;
        z-index: 1;
    }

    .btn-action {
        flex: 1;
        padding: 0.75rem 1rem;
        border: none;
        border-radius: 10px;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.3s;
        font-size: 0.85rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .btn-primary-action {
        background: rgba(255, 255, 255, 0.95);
        color: #333;
    }

    .btn-primary-action:hover {
        background: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.3);
    }

    .btn-delete-action {
        background: rgba(239, 68, 68, 0.9);
        color: white;
        flex: 0 0 auto;
        padding: 0.75rem 1.25rem;
    }

    .btn-delete-action:hover {
        background: rgba(220, 38, 38, 1);
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.3);
    }

    @media (max-width: 768px) {
        .cards-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<?php include VIEWS . '/layouts/footer.php'; ?>