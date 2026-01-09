<?php include VIEWS . '/layouts/header.php'; ?>

<div class="container-small">
    <div class="card">
        <h2>✏️ Editar Benefício</h2>
        <p class="subtitle">Atualize as informações do seu benefício</p>

        <form method="POST" action="/beneficios/editar/<?= $benefit['id'] ?>" id="benefitForm">
            <div class="form-group">
                <label for="type">📋 Tipo de Benefício *</label>
                <select name="type" id="type" required>
                    <option value="">Selecione o tipo...</option>
                    <option value="vr" <?= $benefit['type'] === 'vr' ? 'selected' : '' ?>>🍔 Vale Refeição (VR)</option>
                    <option value="va" <?= $benefit['type'] === 'va' ? 'selected' : '' ?>>🛒 Vale Alimentação (VA)</option>
                </select>
                <small>VR = Restaurantes | VA = Supermercados</small>
            </div>

            <div class="form-group">
                <label for="provider">🏢 Fornecedor *</label>
                <select name="provider" id="provider" required>
                    <option value="">Selecione o fornecedor...</option>
                    <option value="sodexo" <?= $benefit['provider'] === 'sodexo' ? 'selected' : '' ?>>Sodexo</option>
                    <option value="caju" <?= $benefit['provider'] === 'caju' ? 'selected' : '' ?>>Caju</option>
                    <option value="swile" <?= $benefit['provider'] === 'swile' ? 'selected' : '' ?>>Swile</option>
                    <option value="alelo" <?= $benefit['provider'] === 'alelo' ? 'selected' : '' ?>>Alelo</option>
                    <option value="ticket" <?= $benefit['provider'] === 'ticket' ? 'selected' : '' ?>>Ticket</option>
                    <option value="vr" <?= $benefit['provider'] === 'vr' ? 'selected' : '' ?>>VR Benefícios</option>
                    <option value="ben" <?= $benefit['provider'] === 'ben' ? 'selected' : '' ?>>Ben Benefícios</option>
                    <option value="outros" <?= $benefit['provider'] === 'outros' ? 'selected' : '' ?>>Outro</option>
                </select>
            </div>

            <div class="form-group">
                <label for="name">📝 Nome Personalizado *</label>
                <input type="text"
                    id="name"
                    name="name"
                    value="<?= htmlspecialchars($benefit['name']) ?>"
                    placeholder="Ex: VR Sodexo, VA Caju, Swile Alimentação"
                    required>
                <small>Um nome para você identificar facilmente</small>
            </div>

            <div class="form-row-two">
                <div class="form-group">
                    <label for="monthly_amount">💵 Valor Mensal *</label>
                    <input type="text"
                        id="monthly_amount"
                        name="monthly_amount"
                        value="<?= number_format($benefit['monthly_amount'], 2, ',', '.') ?>"
                        placeholder="R$ 0,00"
                        required>
                    <small>Quanto entra todo mês</small>
                </div>

                <div class="form-group">
                    <label for="recharge_day">📅 Dia da Recarga *</label>
                    <select name="recharge_day" id="recharge_day" required>
                        <option value="">Selecione...</option>
                        <?php for ($i = 1; $i <= 31; $i++): ?>
                            <option value="<?= $i ?>" <?= $benefit['recharge_day'] == $i ? 'selected' : '' ?>>Dia <?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                    <small>Quando o valor entra</small>
                </div>
            </div>

            <div class="info-box info-box-current">
                <strong>📊 Informações Atuais:</strong>
                <ul>
                    <li><strong>Saldo disponível:</strong> R$ <?= number_format($benefit['current_balance'], 2, ',', '.') ?></li>
                    <li><strong>Última recarga:</strong> <?= $benefit['last_recharge_date'] ? date('d/m/Y', strtotime($benefit['last_recharge_date'])) : 'Nunca' ?></li>
                </ul>
                <small>⚠️ Alterar o valor mensal não afeta o saldo atual, apenas as próximas recargas</small>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">💾 Salvar Alterações</button>
                <a href="/beneficios/detalhes/<?= $benefit['id'] ?>" class="btn btn-secondary">❌ Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
    // Formatação automática do valor mensal
    const amountInput = document.getElementById('monthly_amount');

    amountInput.addEventListener('input', function(e) {
        let value = e.target.value;
        value = value.replace(/\D/g, '');

        if (value) {
            const numValue = parseFloat(value) / 100;
            value = numValue.toLocaleString('pt-BR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        e.target.value = value ? 'R$ ' + value : '';
    });

    // Remove formatação antes de enviar
    document.getElementById('benefitForm').addEventListener('submit', function(e) {
        if (amountInput.value) {
            let value = amountInput.value
                .replace('R$ ', '')
                .replace(/\./g, '')
                .replace(',', '.');

            amountInput.value = value;
        }
    });

    // Formata o valor inicial ao carregar a página
    window.addEventListener('load', function() {
        const currentValue = amountInput.value;
        if (currentValue && !currentValue.startsWith('R$')) {
            // Se o valor não está formatado, formata
            const numValue = parseFloat(currentValue.replace(',', '.'));
            amountInput.value = 'R$ ' + numValue.toLocaleString('pt-BR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }
    });
</script>

<style>
    .subtitle {
        color: #666;
        margin-bottom: 2rem;
    }

    .form-row-two {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
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

    .info-box-current {
        background: #fff3e0;
        border-left-color: #ff9800;
        color: #e65100;
    }

    .info-box ul {
        margin: 0.5rem 0 0 1.5rem;
        padding: 0;
    }

    .info-box li {
        margin: 0.3rem 0;
    }

    @media (max-width: 768px) {
        .form-row-two {
            grid-template-columns: 1fr;
        }
    }
</style>

<?php include VIEWS . '/layouts/footer.php'; ?>