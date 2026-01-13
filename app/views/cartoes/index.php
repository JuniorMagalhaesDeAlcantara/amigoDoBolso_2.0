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
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/f/f7/Nubank_logo_2021.svg',
                            'logo_white' => true
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
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/8/85/Ita%C3%BA_1992.svg'
                        ],
                        'bradesco' => [
                            'gradient' => 'linear-gradient(135deg, #CC092F 0%, #E30613 100%)',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/a/a9/Banco_Bradesco_logo_%28vertical%29.png',
                            'logo_white' => true
                        ],
                        'santander' => [
                            'gradient' => 'linear-gradient(135deg, #EC0000 0%, #FF0000 100%)',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/b/b8/Banco_Santander_Logotipo.svg',
                            'logo_white' => true
                        ],
                        'bb' => [
                            'gradient' => 'linear-gradient(135deg, #FFEB00 0%, #FFD700 100%)',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/5/53/Banco_do_Brasil_Logo.svg'
                        ],
                        'caixa' => [
                            'gradient' => 'linear-gradient(135deg, #0066B3 0%, #0080D6 100%)',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/3/3c/Caixa_Econ%C3%B4mica_Federal_logo_1997.svg',
                            'logo_white' => true
                        ],
                        'picpay' => [
                            'gradient' => 'linear-gradient(135deg, #21C25E 0%, #11D96D 100%)',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/5/5e/PicPay_Logogrande.png'
                        ],
                        'neon' => [
                            'gradient' => 'linear-gradient(135deg, #00D9A5 0%, #00E5B8 100%)',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/2/2b/Neon_logo_2021.png'
                        ],
                        'next' => [
                            'gradient' => 'linear-gradient(135deg, #00AB63 0%, #00C578 100%)',
                            'logo' => 'https://www.banconext.com.br/_next/static/media/logo.2c4f4c98.svg'
                        ],
                        'original' => [
                            'gradient' => 'linear-gradient(135deg, #00A859 0%, #00C069 100%)',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/9/91/Logo_Oficial_Banco_Original_-_Verde.png',
                            'logo_white' => true
                        ],
                        'outros' => [
                            'gradient' => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                            'logo' => ''
                        ]
                    ];

                    $bank = $card['bank'] ?? 'outros';
                    $style = $bankStyles[$bank] ?? $bankStyles['outros'];
                ?>
                    <div class="card-wrapper">
                        <div class="credit-card" style="background: <?= $style['gradient'] ?>">
                            <div class="card-top">
                                <!-- Chip do Cartão -->
                                <div class="card-chip">
                                    <div class="chip"></div>
                                </div>

                                <!-- Logo do Banco -->
                                <div class="card-logo">
                                    <?php if (!empty($style['logo'])): ?>
                                        <img
                                            src="<?= $style['logo'] ?>"
                                            alt="<?= ucfirst($bank) ?>"
                                            class="<?= !empty($style['logo_white']) ? 'logo-white' : '' ?>"
                                            onerror="this.style.display='none'">
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="card-middle">
                                <!-- Nome do Cartão -->
                                <div class="card-name"><?= htmlspecialchars($card['name']) ?></div>

                                <!-- Número do Cartão -->
                                <div class="card-number">•••• •••• •••• <?= $card['last_digits'] ?></div>

                                <!-- Nome do Titular -->
                                <?php if (!empty($card['holder_name'])): ?>
                                    <div class="card-holder"><?= strtoupper(htmlspecialchars($card['holder_name'])) ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="card-bottom">
                                <!-- Linha de Info -->
                                <div class="card-info-row">
                                    <!-- Detalhes -->
                                    <div class="card-details-row">
                                        <div class="card-detail">
                                            <span class="detail-label">Fecha</span>
                                            <span class="detail-value">Dia <?= $card['closing_day'] ?></span>
                                        </div>
                                        <div class="card-detail">
                                            <span class="detail-label">Vence</span>
                                            <span class="detail-value">Dia <?= $card['due_day'] ?></span>
                                        </div>
                                    </div>

                                    <!-- Fatura -->
                                    <div class="card-invoice-compact">
                                        <div class="invoice-label">Fatura</div>
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
                        </div>

                        <!-- Ações ABAIXO do cartão -->
                        <div class="card-actions">
                            <a href="/cartoes/extrato/<?= $card['id'] ?>" class="btn-action btn-primary-action">
                                📊 Ver Extrato
                            </a>
                            <a href="/cartoes/deletar/<?= $card['id'] ?>"
                                class="btn-action btn-delete-action"
                                onclick="return confirm('Tem certeza que deseja deletar este cartão?\n\nAtenção: As transações já cadastradas não serão deletadas.')">
                                🗑️ Excluir
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
        padding: 3rem 1.5rem;
    }

    .empty-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.3;
    }

    .empty-state h3 {
        color: #333;
        margin-bottom: 0.5rem;
        font-size: 1.25rem;
    }

    .empty-state p {
        color: #666;
        margin-bottom: 1.5rem;
        font-size: 0.95rem;
    }

    .cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(420px, 1fr));
        gap: 1.5rem;
        padding: 0.5rem;
    }

    .card-wrapper {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .credit-card {
        aspect-ratio: 1.586 / 1;
        /* Proporção real de cartão de crédito (85.6mm x 53.98mm) */
        border-radius: 16px;
        padding: 1.4rem;
        color: white;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.25);
        transition: transform 0.3s, box-shadow 0.3s;
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
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
        transform: translateY(-3px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.3);
    }

    .card-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        z-index: 1;
    }

    .card-middle {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
        z-index: 1;
    }

    .card-bottom {
        z-index: 1;
    }

    /* Chip do cartão */
    .card-chip {
        width: 45px;
        height: 35px;
    }

    .chip {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #e5c07b 0%, #daa520 100%);
        border-radius: 6px;
        position: relative;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .chip::before {
        content: '';
        position: absolute;
        top: 4px;
        left: 4px;
        right: 4px;
        bottom: 4px;
        background: repeating-linear-gradient(45deg,
                transparent,
                transparent 2px,
                rgba(0, 0, 0, 0.1) 2px,
                rgba(0, 0, 0, 0.1) 4px);
        border-radius: 3px;
    }

    .card-logo {
        width: 60px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card-logo img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    /* Só entra quando o banco pedir */
    .logo-white {
        filter: brightness(0) invert(1);
        opacity: 0.9;
    }


    .card-name {
        font-size: 1.05rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        margin-bottom: 0.3rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .card-number {
        font-family: 'Courier New', monospace;
        font-size: 1.15rem;
        letter-spacing: 3px;
        margin-bottom: 0.3rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        font-weight: 500;
    }

    .card-holder {
        font-family: 'Courier New', monospace;
        font-size: 0.8rem;
        letter-spacing: 1.5px;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        opacity: 0.9;
    }

    .card-info-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 0.7rem;
        padding: 0.85rem;
        background: rgba(0, 0, 0, 0.15);
        border-radius: 10px;
        backdrop-filter: blur(10px);
    }

    .card-details-row {
        display: flex;
        gap: 1.8rem;
    }

    .card-detail {
        display: flex;
        flex-direction: column;
        gap: 0.2rem;
    }

    .detail-label {
        font-size: 0.65rem;
        opacity: 0.8;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 500;
    }

    .detail-value {
        font-size: 0.9rem;
        font-weight: 700;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    }

    .card-invoice-compact {
        text-align: right;
    }

    .invoice-label {
        font-size: 0.65rem;
        opacity: 0.8;
        margin-bottom: 0.2rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .invoice-value {
        font-size: 1.3rem;
        font-weight: 800;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .limit-progress {
        margin-bottom: 0;
    }

    .progress-bar {
        width: 100%;
        height: 6px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 3px;
        overflow: hidden;
        margin-bottom: 0.4rem;
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
        font-weight: 600;
    }

    .available {
        font-weight: 700;
    }

    /* Ações ABAIXO do cartão */
    .card-actions {
        display: flex;
        gap: 0.75rem;
    }

    .btn-action {
        flex: 1;
        padding: 0.75rem 1rem;
        border: none;
        border-radius: 8px;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        transition: all 0.3s;
        font-size: 0.85rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        background: white;
    }

    .btn-primary-action {
        color: #667eea;
        border: 2px solid #667eea;
    }

    .btn-primary-action:hover {
        background: #667eea;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .btn-delete-action {
        background: white;
        color: #ef4444;
        border: 2px solid #ef4444;
    }

    .btn-delete-action:hover {
        background: #ef4444;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    @media (max-width: 768px) {
        .cards-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 480px) {
        .cards-grid {
            grid-template-columns: 1fr;
            padding: 0;
        }

        .credit-card {
            padding: 1.2rem;
        }

        .card-info-row {
            flex-direction: column;
            gap: 0.75rem;
            align-items: stretch;
        }

        .card-invoice-compact {
            text-align: left;
        }

        .card-actions {
            flex-direction: column;
        }

        .btn-action {
            width: 100%;
        }
    }
</style>

<?php include VIEWS . '/layouts/footer.php'; ?>