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
                    // Define cores baseado no tipo e provider
                    $providerStyles = [
                        'sodexo' => [
                            'gradient' => 'linear-gradient(135deg, #E2001A 0%, #FF1744 100%)',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/b/b2/Sodexo_logo.svg'
                        ],
                        'caju' => [
                            'gradient' => 'linear-gradient(135deg, #FF6B35 0%, #FF8A5B 100%)',
                            'logo' => 'https://uploads-ssl.webflow.com/5f7f0c0e4d3c4c6e4d3c4c6e/logo-caju.svg'
                        ],
                        'swile' => [
                            'gradient' => 'linear-gradient(135deg, #6C5CE7 0%, #A29BFE 100%)',
                            'logo' => 'https://www.swile.co/hubfs/Logo.svg'
                        ],
                        'alelo' => [
                            'gradient' => 'linear-gradient(135deg, #00A859 0%, #00D26A 100%)',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/c/cc/Alelo_logo.svg'
                        ],
                        'ticket' => [
                            'gradient' => 'linear-gradient(135deg, #FF6B00 0%, #FF8500 100%)',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/8/8a/Ticket_logo.svg'
                        ],
                        'vr' => [
                            'gradient' => 'linear-gradient(135deg, #00A859 0%, #00C86F 100%)',
                            'logo' => 'https://upload.wikimedia.org/wikipedia/commons/b/b5/VR_Benef%C3%ADcios_logo.svg'
                        ],
                        'ben' => [
                            'gradient' => 'linear-gradient(135deg, #0066CC 0%, #0080FF 100%)',
                            'logo' => ''
                        ],
                        'outros' => [
                            'gradient' => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)',
                            'logo' => ''
                        ]
                    ];

                    $provider = $benefit['provider'] ?? 'outros';
                    $style = $providerStyles[$provider] ?? $providerStyles['outros'];
                    
                    // Define ícone baseado no tipo
                    $typeIcon = $benefit['type'] === 'vr' ? '🍔' : '🛒';
                    $typeName = $benefit['type'] === 'vr' ? 'Vale Refeição' : 'Vale Alimentação';
                    
                    // Calcula percentual usado
                    $percentUsed = $benefit['percent_used'];
                    $progressColor = $percentUsed > 90 ? '#ef4444' : ($percentUsed > 70 ? '#f59e0b' : '#10b981');
                ?>
                    <div class="benefit-card" style="background: <?= $style['gradient'] ?>">
                        <!-- Logo do Provider -->
                        <div class="benefit-logo">
                            <?php if ($style['logo']): ?>
                                <img src="<?= $style['logo'] ?>" alt="<?= $provider ?>" onerror="this.style.display='none'">
                            <?php endif; ?>
                        </div>

                        <!-- Tipo e Nome -->
                        <div class="benefit-type">
                            <span class="type-icon"><?= $typeIcon ?></span>
                            <span class="type-text"><?= $typeName ?></span>
                        </div>

                        <div class="benefit-name"><?= htmlspecialchars($benefit['name']) ?></div>

                        <!-- Saldo Atual (destaque) -->
                        <div class="benefit-balance">
                            <div class="balance-label">Saldo Disponível</div>
                            <div class="balance-value">R$ <?= number_format($benefit['current_balance'], 2, ',', '.') ?></div>
                        </div>

                        <!-- Divisor -->
                        <div class="card-divider"></div>

                        <!-- Estatísticas do Mês -->
                        <div class="benefit-stats">
                            <div class="stat-row">
                                <div class="stat-item">
                                    <span class="stat-label">Gasto no mês</span>
                                    <span class="stat-value">R$ <?= number_format($benefit['monthly_expense'], 2, ',', '.') ?></span>
                                </div>
                                <div class="stat-item">
                                    <span class="stat-label">Recarga mensal</span>
                                    <span class="stat-value">R$ <?= number_format($benefit['monthly_amount'], 2, ',', '.') ?></span>
                                </div>
                            </div>

                            <!-- Barra de Progresso -->
                            <div class="usage-progress">
                                <div class="progress-bar">
                                    <div class="progress-fill" style="width: <?= min($percentUsed, 100) ?>%; background: <?= $progressColor ?>"></div>
                                </div>
                                <div class="progress-text">
                                    <span><?= number_format($percentUsed, 1) ?>% usado</span>
                                    <span class="recharge-day">Recarga dia <?= $benefit['recharge_day'] ?></span>
                                </div>
                            </div>
                        </div>

                        <!-- Ações -->
                        <div class="benefit-actions">
                            <a href="/beneficios/detalhes/<?= $benefit['id'] ?>" class="btn-action btn-primary-action">
                                📊 Ver Detalhes
                            </a>
                            <a href="/beneficios/deletar/<?= $benefit['id'] ?>"
                                class="btn-action btn-delete-action"
                                onclick="return confirm('Tem certeza que deseja deletar este benefício?')">
                                🗑️
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

    .benefits-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
        gap: 2rem;
        padding: 1rem;
    }

    .benefit-card {
        min-height: 360px;
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
        transform: translateY(-10px);
        box-shadow: 0 30px 80px rgba(0, 0, 0, 0.4);
    }

    .benefit-logo {
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

    .benefit-logo img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        filter: brightness(0) invert(1);
        opacity: 0.9;
    }

    .benefit-type {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
        z-index: 1;
    }

    .type-icon {
        font-size: 1.5rem;
    }

    .type-text {
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        opacity: 0.9;
        font-weight: 600;
    }

    .benefit-name {
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        z-index: 1;
    }

    .benefit-balance {
        background: rgba(0, 0, 0, 0.25);
        padding: 1.5rem;
        border-radius: 12px;
        margin-bottom: 1rem;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        text-align: center;
        z-index: 1;
    }

    .balance-label {
        font-size: 0.8rem;
        opacity: 0.9;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .balance-value {
        font-size: 2.2rem;
        font-weight: 800;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .card-divider {
        height: 1px;
        background: linear-gradient(90deg,
                transparent 0%,
                rgba(255, 255, 255, 0.5) 50%,
                transparent 100%);
        margin: 1rem 0;
        z-index: 1;
    }

    .benefit-stats {
        background: rgba(0, 0, 0, 0.2);
        padding: 1.2rem;
        border-radius: 12px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        z-index: 1;
    }

    .stat-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .stat-item {
        display: flex;
        flex-direction: column;
        gap: 0.3rem;
    }

    .stat-label {
        font-size: 0.7rem;
        opacity: 0.9;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .stat-value {
        font-size: 1rem;
        font-weight: 700;
    }

    .usage-progress {
        margin-top: 1rem;
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

    .progress-text {
        display: flex;
        justify-content: space-between;
        font-size: 0.75rem;
        opacity: 0.95;
        font-weight: 500;
    }

    .recharge-day {
        font-weight: 700;
    }

    .benefit-actions {
        display: flex;
        gap: 0.75rem;
        margin-top: auto;
        padding-top: 1rem;
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

    .info-card {
        margin-top: 2rem;
        background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
        border-left: 4px solid #2196f3;
    }

    .info-card h3 {
        color: #1565c0;
        margin-bottom: 1rem;
    }

    .info-card ul {
        list-style: none;
        padding: 0;
    }

    .info-card li {
        padding: 0.5rem 0;
        color: #1976d2;
        line-height: 1.6;
    }

    @media (max-width: 768px) {
        .benefits-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<?php include VIEWS . '/layouts/footer.php'; ?>