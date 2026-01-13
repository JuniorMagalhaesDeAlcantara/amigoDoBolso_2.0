<?php include VIEWS . '/layouts/header.php'; ?>

<div class="container-small">
    <div class="card">
        <h2>💰 Recarga Manual</h2>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                ⚠️ <?= $_SESSION['error'] ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <div class="benefit-info-box">
            <div class="benefit-header">
                <span class="benefit-icon"><?= $benefit['type'] === 'vr' ? '🍔' : '🛒' ?></span>
                <div>
                    <h3><?= htmlspecialchars($benefit['name']) ?></h3>
                    <p><?= $benefit['type'] === 'vr' ? 'Vale Refeição' : 'Vale Alimentação' ?></p>
                </div>
            </div>
            
            <div class="current-balance-display">
                <span class="balance-label">Saldo Atual</span>
                <span class="balance-amount">R$ <?= number_format($benefit['current_balance'], 2, ',', '.') ?></span>
            </div>
        </div>

        <form method="POST" action="/beneficios/recarregar/<?= $benefit['id'] ?>" id="rechargeForm">
            <div class="form-group">
                <label for="amount_display">💵 Valor da Recarga *</label>
                <input type="text"
                    id="amount_display"
                    placeholder="0,00"
                    required>
                <input type="hidden" id="amount" name="amount">
                <small>Digite o valor que deseja adicionar ao saldo</small>
            </div>

            <hr>

            <div class="preview-box">
                <div class="preview-row">
                    <span>Saldo atual:</span>
                    <span class="preview-current">R$ <?= number_format($benefit['current_balance'], 2, ',', '.') ?></span>
                </div>
                <div class="preview-row preview-add">
                    <span>+ Recarga:</span>
                    <span id="previewRecharge">R$ 0,00</span>
                </div>
                <div class="preview-divider"></div>
                <div class="preview-row preview-total">
                    <strong>Novo saldo:</strong>
                    <strong id="previewTotal">R$ <?= number_format($benefit['current_balance'], 2, ',', '.') ?></strong>
                </div>
            </div>

            <hr>

            <div class="info-box">
                <span class="info-icon">ℹ️</span>
                <div>
                    <strong>Sobre a Recarga Manual:</strong>
                    <ul>
                        <li>Use para adicionar saldo extra quando necessário</li>
                        <li>O valor será somado imediatamente ao saldo disponível</li>
                        <li>A recarga automática mensal não será afetada</li>
                        <li>Esta recarga será registrada no histórico</li>
                    </ul>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">💰 Confirmar Recarga</button>
                <a href="/beneficios/detalhes/<?= $benefit['id'] ?>" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
    const currentBalance = <?= $benefit['current_balance'] ?>;
    const amountDisplay = document.getElementById('amount_display');
    const amountHidden = document.getElementById('amount');
    const previewRecharge = document.getElementById('previewRecharge');
    const previewTotal = document.getElementById('previewTotal');

    // ===== MÁSCARA DE DINHEIRO =====
    amountDisplay.addEventListener('input', function(e) {
        let value = e.target.value;
        
        // Remove tudo que não é número
        value = value.replace(/\D/g, '');
        
        // Converte para número
        value = (parseInt(value || 0) / 100).toFixed(2);
        
        // Formata com ponto de milhar e vírgula decimal
        value = value.replace('.', ',');
        value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        
        // Atualiza os campos
        e.target.value = value;
        amountHidden.value = value.replace(/\./g, '').replace(',', '.');

        // Atualiza preview
        const rechargeValue = parseFloat(amountHidden.value || 0);
        
        const formattedRecharge = rechargeValue.toLocaleString('pt-BR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
        previewRecharge.textContent = 'R$ ' + formattedRecharge;
        
        const newTotal = currentBalance + rechargeValue;
        const formattedTotal = newTotal.toLocaleString('pt-BR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
        previewTotal.textContent = 'R$ ' + formattedTotal;
    });

    // Validação do formulário
    document.getElementById('rechargeForm').addEventListener('submit', function(e) {
        if (!amountHidden.value || parseFloat(amountHidden.value) <= 0) {
            e.preventDefault();
            alert('⚠️ Digite um valor válido para a recarga!');
            amountDisplay.focus();
            return;
        }
    });
</script>

<style>
    .alert {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem 1.25rem;
        border-radius: 10px;
        margin-bottom: 1.5rem;
        font-size: 0.9375rem;
    }

    .alert-error {
        background: #fee2e2;
        border: 1px solid #fca5a5;
        color: #991b1b;
    }

    .benefit-info-box {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 12px;
        padding: 1.5rem;
        color: white;
        margin-bottom: 2rem;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .benefit-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .benefit-icon {
        font-size: 2.5rem;
        width: 60px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 12px;
        backdrop-filter: blur(10px);
    }

    .benefit-header h3 {
        margin: 0;
        font-size: 1.3rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .benefit-header p {
        margin: 0.25rem 0 0 0;
        opacity: 0.9;
        font-size: 0.9rem;
    }

    .current-balance-display {
        background: rgba(0, 0, 0, 0.2);
        padding: 1rem;
        border-radius: 10px;
        text-align: center;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .balance-label {
        display: block;
        font-size: 0.7rem;
        opacity: 0.9;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 600;
    }

    .balance-amount {
        display: block;
        font-size: 2rem;
        font-weight: 800;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .preview-box {
        background: #f9fafb;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 1.5rem;
        margin: 1.5rem 0;
    }

    .preview-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        font-size: 1rem;
    }

    .preview-current {
        color: #6b7280;
        font-weight: 600;
    }

    .preview-add {
        color: #10b981;
        font-weight: 600;
    }

    .preview-divider {
        height: 2px;
        background: linear-gradient(90deg, transparent 0%, #e5e7eb 50%, transparent 100%);
        margin: 0.75rem 0;
    }

    .preview-total {
        font-size: 1.3rem;
        color: #667eea;
        padding-top: 0.75rem;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }

    hr {
        border: none;
        border-top: 2px solid var(--gray-200);
        margin: 2rem 0;
    }

    small {
        display: block;
        margin-top: 0.5rem;
        color: var(--gray-600);
        font-size: 0.8125rem;
    }

    .info-box {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        background: rgba(102, 126, 234, 0.1);
        border: 2px solid rgba(102, 126, 234, 0.3);
        border-radius: 10px;
        padding: 1rem 1.25rem;
        margin: 1.5rem 0;
    }

    .info-icon {
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .info-box strong {
        color: var(--primary);
        font-size: 0.95rem;
        display: block;
        margin-bottom: 0.5rem;
    }

    .info-box ul {
        margin: 0.5rem 0 0 0;
        padding-left: 1.25rem;
        color: var(--gray-700);
    }

    .info-box li {
        margin: 0.4rem 0;
        font-size: 0.875rem;
        line-height: 1.5;
    }

    #amount_display {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary);
        text-align: right;
        font-family: 'Courier New', monospace;
    }

    /* Melhorias nos form-groups */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group:last-child {
        margin-bottom: 0;
    }

    .form-group label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--gray-700);
        margin-bottom: 0.5rem;
    }

    .form-group input {
        width: 100%;
        padding: 0.75rem;
        border: 2px solid var(--gray-300);
        border-radius: 8px;
        font-size: 0.9375rem;
        color: var(--gray-900);
        transition: all 0.2s;
        background: white;
    }

    .form-group input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    /* Card container */
    .card {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
    }

    .card h2 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--gray-900);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Container small */
    .container-small {
        max-width: 700px;
        margin: 0 auto;
        padding: 2rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .container-small {
            padding: 1rem;
        }

        .card {
            padding: 1.5rem;
        }

        .benefit-header {
            flex-direction: column;
            text-align: center;
        }

        .form-actions {
            flex-direction: column;
        }

        .form-actions .btn {
            width: 100%;
        }
    }
</style>

<?php include VIEWS . '/layouts/footer.php'; ?>