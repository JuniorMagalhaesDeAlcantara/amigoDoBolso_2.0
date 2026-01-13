<?php include VIEWS . '/layouts/header.php'; ?>

<div class="container">
    <div class="card-header">
        <h1>💼 Meus Benefícios (VR / VA)</h1>
        <a href="/beneficios/criar" class="btn btn-primary">+ Novo Benefício</a>
    </div>

    <div class="card">
        <?php if (empty($benefits)): ?>
            <div class="empty-state">
                <div class="empty-icon">🍔</div>
                <h3>Nenhum benefício cadastrado</h3>
                <p>Cadastre seus vales (VR/VA) para controlar seus gastos com alimentação</p>
                <a href="/beneficios/criar" class="btn btn-primary">Cadastrar Primeiro Benefício</a>
            </div>
        <?php else: ?>
            <div class="benefits-grid">
                <?php foreach ($benefits as $benefit):
                    // Define cores e logos baseado no provider
                    $providerStyles = [
                        'sodexo' => [
                            'gradient' => 'linear-gradient(135deg, #E8E8E8 0%, #FFFFFF 100%)',
                            'textColor' => '#1a1a1a'
                        ],
                        'caju' => [
                            'gradient' => 'linear-gradient(135deg, #FF6B35 0%, #FF8C5A 100%)',
                            'textColor' => '#ffffff'
                        ],
                        'swile' => [
                            'gradient' => 'linear-gradient(135deg, #1A1A1A 0%, #2D2D2D 100%)',
                            'textColor' => '#ffffff'
                        ],
                        'alelo' => [
                            'gradient' => 'linear-gradient(135deg, #00A859 0%, #00C569 100%)',
                            'textColor' => '#ffffff'
                        ],
                        'ticket' => [
                            'gradient' => 'linear-gradient(135deg, #E63027 0%, #F04438 100%)',
                            'textColor' => '#ffffff'
                        ],
                        'vr' => [
                            'gradient' => 'linear-gradient(135deg, #00A859 0%, #00C569 100%)',
                            'textColor' => '#ffffff'
                        ],
                        'pluxee' => [
                            'gradient' => 'linear-gradient(135deg, #00A859 0%, #0088CC 100%)',
                            'textColor' => '#ffffff'
                        ],
                        'ifood' => [
                            'gradient' => 'linear-gradient(135deg, #EA1D2C 0%, #F03D3D 100%)',
                            'textColor' => '#ffffff'
                        ],
                        'flash' => [
                            'gradient' => 'linear-gradient(135deg, #FF6B9D 0%, #FFA3C0 100%)',
                            'textColor' => '#ffffff'
                        ],
                        'outros' => [
                            'gradient' => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                            'textColor' => '#ffffff'
                        ]
                    ];

                    $provider = strtolower($benefit['provider'] ?? 'outros');
                    $style = $providerStyles[$provider] ?? $providerStyles['outros'];

                    // Define ícone baseado no tipo
                    $typeIcon = $benefit['type'] === 'vr' ? '🍽️' : '🛒';
                    $typeName = $benefit['type'] === 'vr' ? 'Vale Refeição' : 'Vale Alimentação';

                    // Calcula percentual usado
                    $percentUsed = $benefit['percent_used'];
                    $progressColor = $percentUsed > 90 ? '#ef4444' : ($percentUsed > 70 ? '#f59e0b' : '#10b981');
                ?>
                    <div class="benefit-wrapper">
                        <div class="benefit-card" style="background: <?= $style['gradient'] ?>; color: <?= $style['textColor'] ?>">
                            <!-- Topo do Cartão -->
                            <div class="card-header-section">
                                <!-- Chip -->
                                <div class="card-chip">
                                    <div class="chip"></div>
                                </div>

                                <!-- Provedor -->
                                <div class="card-provider">
                                    <?= ucfirst($provider) ?>
                                </div>
                            </div>

                            <!-- Informações do Cartão -->
                            <div class="card-content">
                                <!-- Tipo -->
                                <div class="benefit-type">
                                    <span class="type-icon"><?= $typeIcon ?></span>
                                    <span class="type-text"><?= $typeName ?></span>
                                </div>

                                <!-- Nome -->
                                <div class="benefit-name"><?= htmlspecialchars($benefit['name']) ?></div>
                            </div>

                            <!-- Rodapé com Informações -->
                            <div class="card-footer-section">
                                <!-- Saldo em Destaque -->
                                <div class="balance-section">
                                    <div class="balance-label">Saldo Disponível</div>
                                    <div class="balance-value">R$ <?= number_format($benefit['current_balance'], 2, ',', '.') ?></div>
                                </div>

                                <!-- Stats em linha -->
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

                                <!-- Progresso -->
                                <div class="progress-section">
                                    <div class="progress-bar">
                                        <div class="progress-fill" style="width: <?= min($percentUsed, 100) ?>%; background: <?= $progressColor ?>"></div>
                                    </div>
                                    <div class="progress-info">
                                        <span><?= number_format($percentUsed, 1) ?>% usado</span>
                                        <span>Recarga dia <?= $benefit['recharge_day'] ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Ações ABAIXO do cartão -->
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

    <!-- Card Informativo -->
    <div class="card info-card">
        <h3>ℹ️ Como funcionam os benefícios?</h3>
        <ul>
            <li><strong>🍔 Vale Refeição (VR):</strong> Para uso em restaurantes, lanchonetes e delivery</li>
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
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 1.5rem;
        padding: 0.5rem;
    }

    .benefit-wrapper {
        display: flex;
        flex-direction: column;
        gap: 0.625rem;
    }

    .benefit-card {
        border-radius: 14px;
        padding: 1.125rem;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s, box-shadow 0.3s;
        position: relative;
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
        overflow: hidden;
        min-height: 210px;
    }

    /* Textura de cartão */
    .benefit-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg,
                rgba(255, 255, 255, 0.08) 0%,
                rgba(255, 255, 255, 0) 50%,
                rgba(0, 0, 0, 0.08) 100%);
        pointer-events: none;
    }

    .benefit-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
    }

    /* Header do Cartão */
    .card-header-section {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        z-index: 1;
    }

    .card-chip {
        width: 38px;
        height: 28px;
    }

    .chip {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #e5c07b 0%, #daa520 100%);
        border-radius: 5px;
        position: relative;
        box-shadow: inset 0 2px 3px rgba(0, 0, 0, 0.3);
    }

    .chip::before {
        content: '';
        position: absolute;
        top: 3px;
        left: 3px;
        right: 3px;
        bottom: 3px;
        background: repeating-linear-gradient(45deg,
                transparent,
                transparent 1.5px,
                rgba(0, 0, 0, 0.1) 1.5px,
                rgba(0, 0, 0, 0.1) 3px);
        border-radius: 3px;
    }

    .card-provider {
        font-size: 0.625rem;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        opacity: 0.85;
        font-weight: 700;
        padding: 0.25rem 0.5rem;
        background: rgba(0, 0, 0, 0.15);
        border-radius: 4px;
    }

    .benefit-type {
        display: flex;
        align-items: center;
        gap: 0.375rem;
        margin-bottom: 0.375rem;
    }

    .type-icon {
        font-size: 1rem;
    }

    .type-text {
        font-size: 0.625rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        opacity: 0.85;
        font-weight: 600;
    }

    .benefit-name {
        font-size: 1.0625rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.25);
        line-height: 1.25;
    }

    /* Footer do Cartão */
    .card-footer-section {
        background: rgba(0, 0, 0, 0.18);
        padding: 0.75rem;
        border-radius: 10px;
        backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.08);
        z-index: 1;
        display: flex;
        flex-direction: column;
        gap: 0.625rem;
    }

    .balance-section {
        text-align: center;
        padding-bottom: 0.625rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.15);
    }

    .balance-label {
        font-size: 0.5625rem;
        opacity: 0.85;
        margin-bottom: 0.25rem;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        font-weight: 600;
    }

    .balance-value {
        font-size: 1.375rem;
        font-weight: 800;
        text-shadow: 0 2px 3px rgba(0, 0, 0, 0.3);
    }

    .stats-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.75rem;
    }

    .stat-item {
        display: flex;
        flex-direction: column;
        gap: 0.1875rem;
    }

    .stat-label {
        font-size: 0.5625rem;
        opacity: 0.8;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 500;
    }

    .stat-value {
        font-size: 0.8125rem;
        font-weight: 700;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    }

    .progress-section {
        padding-top: 0.375rem;
        border-top: 1px solid rgba(255, 255, 255, 0.08);
    }

    .progress-bar {
        width: 100%;
        height: 5px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 2.5px;
        overflow: hidden;
        margin-bottom: 0.3rem;
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.2);
    }

    .progress-fill {
        height: 100%;
        transition: width 0.3s;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
    }

    .progress-info {
        display: flex;
        justify-content: space-between;
        font-size: 0.5625rem;
        opacity: 0.9;
        font-weight: 600;
    }

    /* Ações ABAIXO do cartão */
    .benefit-actions {
        display: flex;
        gap: 0.5rem;
    }

    .btn-action {
        flex: 1;
        padding: 0.5625rem 0.75rem;
        border: none;
        border-radius: 7px;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.3rem;
        transition: all 0.3s;
        font-size: 0.75rem;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
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
        box-shadow: 0 4px 10px rgba(102, 126, 234, 0.3);
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
        box-shadow: 0 4px 10px rgba(239, 68, 68, 0.3);
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
        font-size: 1.0625rem;
    }

    .info-card ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .info-card li {
        padding: 0.625rem 0;
        color: #4b5563;
        line-height: 1.6;
        font-size: 0.875rem;
        border-bottom: 1px solid #f3f4f6;
    }

    .info-card li:last-child {
        border-bottom: none;
    }

    /* Responsividade */
    @media (max-width: 1200px) {
        .benefits-grid {
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        }
    }

    @media (max-width: 768px) {
        .benefits-grid {
            grid-template-columns: 1fr;
            padding: 0;
            gap: 1.25rem;
        }

        .benefit-card {
            min-height: 195px;
        }

        .benefit-actions {
            flex-direction: column;
        }

        .btn-action {
            width: 100%;
        }
    }
</style>

<?php include VIEWS . '/layouts/footer.php'; ?>
