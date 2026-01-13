<?php include VIEWS . '/layouts/header.php'; ?>

<div class="container">
    <div class="card-header">
        <h1>💼 Meus Benefícios (VR / VA)</h1>
        <a href="/beneficios/criar" class="btn btn-primary">+ Novo Benefício</a>
    </div>

    <div class="card">
        <?php if (empty($benefits)): ?>
            <div class="empty-state">
                <div class="empty-icon">🍽️</div>
                <h3>Nenhum benefício cadastrado</h3>
                <p>Cadastre seus vales (VR/VA) para controlar seus gastos com alimentação</p>
                <a href="/beneficios/criar" class="btn btn-primary">Cadastrar Primeiro Benefício</a>
            </div>
        <?php else: ?>
            <div class="benefits-grid">
                <?php foreach ($benefits as $benefit):
                    // Cores oficiais das empresas
                    $providerStyles = [
                        'sodexo' => [
                            'gradient' => 'linear-gradient(135deg, #E4032E 0%, #C50229 100%)',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/7/7e/Sodexo.png'
                        ],
                        'caju' => [
                            'gradient' => 'linear-gradient(135deg, #FF6B35 0%, #E85A2A 100%)',
                            'logo' => 'https://assets-global.website-files.com/5f7a5e0f79d7896e66d6b3e8/5f8f5e3d8f8e5e0f79d789b8_caju-logo.svg'
                        ],
                        'swile' => [
                            'gradient' => 'linear-gradient(135deg, #6C5CE7 0%, #5847D0 100%)',
                            'logo' => 'https://www.swile.co/hubfs/Logo.svg'
                        ],
                        'alelo' => [
                            'gradient' => 'linear-gradient(135deg, #00A859 0%, #008C4A 100%)',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/c/cc/Alelo_logo.svg'
                        ],
                        'ticket' => [
                            'gradient' => 'linear-gradient(135deg, #FF6B00 0%, #E05A00 100%)',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/8/8a/Ticket_logo.svg'
                        ],
                        'vr' => [
                            'gradient' => 'linear-gradient(135deg, #00A859 0%, #00924D 100%)',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/b/b5/VR_Benef%C3%ADcios_logo.svg'
                        ],
                        'ben' => [
                            'gradient' => 'linear-gradient(135deg, #0066CC 0%, #0052A3 100%)',
                            'logo' => ''
                        ],
                        'ifood' => [
                            'gradient' => 'linear-gradient(135deg, #EA1D2C 0%, #C41723 100%)',
                            'logo' => 'https://static-images.ifood.com.br/image/upload/t_thumbnail/logosgde/logo_ifood.png'
                        ],
                        'flash' => [
                            'gradient' => 'linear-gradient(135deg, #FF5722 0%, #E64A19 100%)',
                            'logo' => ''
                        ],
                        'outros' => [
                            'gradient' => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                            'logo' => ''
                        ]
                    ];

                    $provider = $benefit['provider'] ?? 'outros';
                    $style = $providerStyles[$provider] ?? $providerStyles['outros'];

                    $typeIcon = $benefit['type'] === 'vr' ? '🍽️' : '🛒';
                    $typeName = $benefit['type'] === 'vr' ? 'Vale Refeição' : 'Vale Alimentação';

                    $percentUsed = $benefit['percent_used'];
                    $progressColor = $percentUsed > 90 ? '#ef4444' : ($percentUsed > 70 ? '#f59e0b' : '#10b981');
                ?>
                    <div class="benefit-wrapper">
                        <div class="benefit-card" style="background: <?= $style['gradient'] ?>">
                            <div class="card-top">
                                <div class="card-chip">
                                    <div class="chip"></div>
                                </div>
                                <div class="card-logo">
                                    <?php if (!empty($style['logo'])): ?>
                                        <img src="<?= $style['logo'] ?>" alt="<?= ucfirst($provider) ?>" onerror="this.style.display='none'">
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="card-middle">
                                <div class="benefit-type">
                                    <span class="type-icon"><?= $typeIcon ?></span>
                                    <span class="type-text"><?= $typeName ?></span>
                                </div>
                                <div class="benefit-name"><?= htmlspecialchars($benefit['name']) ?></div>
                            </div>

                            <div class="card-bottom">
                                <div class="card-info-row">
                                    <div class="balance-section">
                                        <div class="balance-label">Saldo</div>
                                        <div class="balance-value">R$ <?= number_format($benefit['current_balance'], 2, ',', '.') ?></div>
                                    </div>
                                </div>

                                <div class="stats-row">
                                    <div class="stat-item">
                                        <span class="stat-label">Gasto</span>
                                        <span class="stat-value">R$ <?= number_format($benefit['monthly_expense'], 2, ',', '.') ?></span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-label">Recarga</span>
                                        <span class="stat-value">R$ <?= number_format($benefit['monthly_amount'], 2, ',', '.') ?></span>
                                    </div>
                                </div>

                                <div class="limit-progress">
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: <?= min($percentUsed, 100) ?>%; background: <?= $progressColor ?>"></div>
                                    </div>
                                    <div class="limit-text">
                                        <span><?= number_format($percentUsed, 1) ?>% usado</span>
                                        <span>Recarga dia <?= $benefit['recharge_day'] ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="benefit-actions">
                            <a href="/beneficios/detalhes/<?= $benefit['id'] ?>" class="btn-action btn-primary-action">
                                📊 Detalhes
                            </a>
                            <a href="/beneficios/deletar/<?= $benefit['id'] ?>"
                                class="btn-action btn-delete-action"
                                onclick="return confirm('Tem certeza que deseja deletar este benefício?')">
                                🗑️ Excluir
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="card info-card">
        <h3>ℹ️ Como funcionam os benefícios?</h3>
        <ul>
            <li><strong>🍽️ Vale Refeição (VR):</strong> Para uso em restaurantes, lanchonetes e delivery</li>
            <li><strong>🛒 Vale Alimentação (VA):</strong> Para compras em mercados e supermercados</li>
            <li><strong>💰 Recarga automática:</strong> Todo mês no dia configurado, seu saldo é recarregado</li>
            <li><strong>📊 Controle de gastos:</strong> Acompanhe quanto gastou e quanto ainda tem disponível</li>
        </ul>
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

    .benefits-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(420px, 1fr));
        gap: 1.5rem;
        padding: 0.5rem;
    }

    .benefit-wrapper {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .benefit-card {
        aspect-ratio: 1.586 / 1;
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

    .benefit-card::before {
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

    .benefit-card:hover {
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
        filter: brightness(0) invert(1);
        opacity: 0.95;
    }

    .benefit-type {
        display: flex;
        align-items: center;
        gap: 0.4rem;
        margin-bottom: 0.3rem;
    }

    .type-icon {
        font-size: 1.1rem;
    }

    .type-text {
        font-size: 0.65rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        opacity: 0.9;
        font-weight: 600;
    }

    .benefit-name {
        font-size: 1.05rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        line-height: 1.3;
    }

    .card-info-row {
        background: rgba(0, 0, 0, 0.15);
        padding: 0.85rem;
        border-radius: 10px;
        backdrop-filter: blur(10px);
        margin-bottom: 0.7rem;
    }

    .balance-section {
        text-align: center;
    }

    .balance-label {
        font-size: 0.65rem;
        opacity: 0.8;
        margin-bottom: 0.2rem;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        font-weight: 600;
    }

    .balance-value {
        font-size: 1.3rem;
        font-weight: 800;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .stats-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 0.7rem;
    }

    .stat-item {
        display: flex;
        flex-direction: column;
        gap: 0.2rem;
    }

    .stat-label {
        font-size: 0.65rem;
        opacity: 0.8;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 500;
    }

    .stat-value {
        font-size: 0.9rem;
        font-weight: 700;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
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

    .benefit-actions {
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

    .info-card {
        margin-top: 2rem;
        background: white;
        border-left: 4px solid #667eea;
        padding: 1.5rem;
    }

    .info-card h3 {
        color: #667eea;
        margin-bottom: 1rem;
        font-size: 1.1rem;
    }

    .info-card ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .info-card li {
        padding: 0.75rem 0;
        color: #4b5563;
        line-height: 1.6;
        font-size: 0.95rem;
        border-bottom: 1px solid #f3f4f6;
    }

    .info-card li:last-child {
        border-bottom: none;
    }

    @media (max-width: 768px) {
        .benefits-grid {
            grid-template-columns: 1fr;
        }

        .benefit-actions {
            flex-direction: column;
        }

        .btn-action {
            width: 100%;
        }
    }

    @media (max-width: 480px) {
        .benefits-grid {
            padding: 0;
        }

        .benefit-card {
            padding: 1.2rem;
        }
    }
</style>

<?php include VIEWS . '/layouts/footer.php'; ?>