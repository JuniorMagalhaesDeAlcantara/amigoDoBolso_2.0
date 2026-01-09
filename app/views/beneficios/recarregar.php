<?php include VIEWS . '/layouts/header.php'; ?>

<div class="container-small">
    <div class="card">
        <h2>💰 Recarga Manual</h2>
        <p class="subtitle">Adicione saldo extra ao seu benefício</p>

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
                <label for="amount">💵 Valor da Recarga *</label>
                <input type="text"
                    id="amount"
                    name="amount"
                    placeholder="R$ 0,00"
                    required>
                <small>Digite o valor que deseja adicionar ao saldo</small>
            </div>

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

            <div class="info-box">
                <strong>ℹ️ Sobre a Recarga Manual:</strong>
                <ul>
                    <li>Use para adicionar saldo extra quando necessário</li>
                    <li>O valor será somado imediatamente ao saldo disponível</li>
                    <li>A recarga automática mensal não será afetada</li>
                    <li>Esta recarga será registrada no histórico</li>
                </ul>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">💰 Confirmar Recarga</button>
                <a href="/beneficios/detalhes/<?= $benefit['id'] ?>" class="btn btn-secondary">❌ Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
    const currentBalance = <?= $benefit['current_balance'] ?>;
    const amountInput = document.getElementById('amount');
    const previewRecharge = document.getElementById('previewRecharge');
    const previewTotal = document.getElementById('previewTotal');

    // Formatação automática do valor
    amountInput.addEventListener('input', function(e) {
        let value = e.target.value;
        value = value.replace(/\D/g, '');

        if (value) {
            const numValue = parseFloat(value) / 100;
            value = numValue.toLocaleString('pt-BR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });

            // Atualiza preview
            const rechargeValue = parseFloat(value.replace(/\./g, '').replace(',', '.'));
            previewRecharge.textContent = 'R$ ' + value;
            
            const newTotal = currentBalance + rechargeValue;
            previewTotal.textContent = 'R$ ' + newTotal.toLocaleString('pt-BR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        } else {
            previewRecharge.textContent = 'R$ 0,00';
            previewTotal.textContent = 'R$ ' + currentBalance.toLocaleString('pt-BR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        e.target.value = value ? 'R$ ' + value : '';
    });

    // Remove formatação antes de enviar
    document.getElementById('rechargeForm').addEventListener('submit', function(e) {
        if (amountInput.value) {
            let value = amountInput.value
                .replace('R$ ', '')
                .replace(/\./g, '')
                .replace(',', '.');

            const numValue = parseFloat(value);
            
            if (numValue <= 0) {
                e.preventDefault();
                alert('Digite um valor válido para a recarga!');
                return;
            }

            amountInput.value = value;
        } else {
            e.preventDefault();
            alert('Digite o valor da recarga!');
        }
    });
</script>

<style>
    .subtitle {
        color: #666;
        margin-bottom: 2rem;
    }

    .benefit-info-box {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        padding: 1.5rem;
        color: white;
        margin-bottom: 2rem;
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
    }

    .balance-label {
        display: block;
        font-size: 0.85rem;
        opacity: 0.9;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .balance-amount {
        display: block;
        font-size: 2rem;
        font-weight: 800;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }

    .preview-box {
        background: #f8f9fa;
        border: 2px solid #e9ecef;
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
        color: #666;
        font-weight: 600;
    }

    .preview-add {
        color: #10b981;
        font-weight: 600;
    }

    .preview-divider {
        height: 2px;
        background: linear-gradient(90deg, transparent 0%, #dee2e6 50%, transparent 100%);
        margin: 0.75rem 0;
    }

    .preview-total {
        font-size: 1.3rem;
        color: #667eea;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }

    small {
        display: block;
        margin-top: 0.5rem;
        color: #666;
        font-size: 0.85rem;
    }

    .info-box {
        background: #e3f2fd;
        border-left: 4px solid #2196f3;
        padding: 1rem;
        margin: 1.5rem 0;
        border-radius: 5px;
        color: #1565c0;
    }

    .info-box ul {
        margin: 0.5rem 0 0 1.5rem;
        padding: 0;
    }

    .info-box li {
        margin: 0.3rem 0;
    }

    #amount {
        font-size: 1.5rem;
        font-weight: 700;
        text-align: center;
        color: #667eea;
    }

    @media (max-width: 768px) {
        .benefit-header {
            flex-direction: column;
            text-align: center;
        }

        .form-actions {
            flex-direction: column;
        }
    }
</style>

<?php include VIEWS . '/layouts/footer.php'; ?>