<?php include VIEWS . '/layouts/header.php'; ?>

<div class="container-small">
    <div class="card">
        <h2>💼 Novo Benefício (VR / VA)</h2>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                ⚠️ <?= $_SESSION['error'] ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form method="POST" action="/beneficios/criar" id="benefitForm">
            <div class="form-group">
                <label for="type">📋 Tipo de Benefício *</label>
                <select name="type" id="type" required>
                    <option value="">Selecione o tipo...</option>
                    <option value="vr">🍽️ Vale Refeição (VR)</option>
                    <option value="va">🛒 Vale Alimentação (VA)</option>
                </select>
                <small>VR = Restaurantes e Delivery | VA = Supermercados</small>
            </div>

            <div class="form-group">
                <label for="provider">🏢 Fornecedor *</label>
                <select name="provider" id="provider" required>
                    <option value="">Selecione o fornecedor...</option>
                    <option value="sodexo">🔴 Sodexo</option>
                    <option value="caju">🟠 Caju</option>
                    <option value="swile">🟣 Swile</option>
                    <option value="alelo">🟢 Alelo</option>
                    <option value="ticket">🟠 Ticket</option>
                    <option value="vr">🟢 VR Benefícios</option>
                    <option value="ben">🔵 Ben Benefícios</option>
                    <option value="ifood">🔴 iFood Benefícios</option>
                    <option value="flash">🟠 Flash Benefícios</option>
                    <option value="outros">⚪ Outro</option>
                </select>
            </div>

            <div class="form-group">
                <label for="name">📝 Nome Personalizado *</label>
                <input type="text"
                    id="name"
                    name="name"
                    placeholder="Ex: VR Sodexo, VA Caju, Swile Alimentação"
                    required>
                <small>Um nome para você identificar facilmente</small>
            </div>

            <hr>

            <div class="form-group">
                <label for="initial_balance_display">💰 Saldo Atual *</label>
                <input type="text"
                    id="initial_balance_display"
                    placeholder="0,00"
                    required>
                <input type="hidden" id="initial_balance" name="initial_balance">
                <small>Saldo que o cartão tem hoje</small>
            </div>

            <div class="form-row-two">
                <div class="form-group">
                    <label for="monthly_amount_display">💵 Valor Mensal *</label>
                    <input type="text"
                        id="monthly_amount_display"
                        placeholder="0,00"
                        required>
                    <input type="hidden" id="monthly_amount" name="monthly_amount">
                    <small>Quanto entra todo mês</small>
                </div>

                <div class="form-group">
                    <label for="recharge_day">📅 Dia da Recarga *</label>
                    <select name="recharge_day" id="recharge_day" required>
                        <option value="">Selecione...</option>
                        <?php for ($i = 1; $i <= 31; $i++): ?>
                            <option value="<?= $i ?>">Dia <?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                    <small>Quando o valor entra</small>
                </div>
            </div>

            <hr>

            <div class="info-box">
                <span class="info-icon">💡</span>
                <div>
                    <strong>Como funciona:</strong>
                    <ul>
                        <li>O saldo é recarregado automaticamente todo mês no dia escolhido</li>
                        <li>Cada transação com VR/VA desconta do saldo disponível</li>
                        <li>Não gera dívida, não parcela, e não tem fatura</li>
                    </ul>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">💾 Salvar Benefício</button>
                <a href="/beneficios" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
    // ===== MÁSCARAS DE DINHEIRO =====
    const initialBalanceDisplay = document.getElementById('initial_balance_display');
    const initialBalanceHidden = document.getElementById('initial_balance');
    const monthlyAmountDisplay = document.getElementById('monthly_amount_display');
    const monthlyAmountHidden = document.getElementById('monthly_amount');

    function setupCurrencyMask(displayInput, hiddenInput) {
        displayInput.addEventListener('input', function(e) {
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
            hiddenInput.value = value.replace(/\./g, '').replace(',', '.');
        });
    }

    setupCurrencyMask(initialBalanceDisplay, initialBalanceHidden);
    setupCurrencyMask(monthlyAmountDisplay, monthlyAmountHidden);

    // Sugestão automática de nome
    const typeSelect = document.getElementById('type');
    const providerSelect = document.getElementById('provider');
    const nameInput = document.getElementById('name');

    function updateNameSuggestion() {
        if (!nameInput.value && typeSelect.value && providerSelect.value) {
            const typeLabel = typeSelect.value === 'vr' ? 'VR' : 'VA';
            const providerName = providerSelect.options[providerSelect.selectedIndex].text;
            // Remove emoji do providerName
            const cleanProviderName = providerName.replace(/[🔴🟠🟣🟢🔵⚪]\s/, '');
            nameInput.placeholder = `${typeLabel} ${cleanProviderName}`;
        }
    }

    typeSelect.addEventListener('change', updateNameSuggestion);
    providerSelect.addEventListener('change', updateNameSuggestion);

    // Validação do formulário
    document.getElementById('benefitForm').addEventListener('submit', function(e) {
        if (!initialBalanceHidden.value || parseFloat(initialBalanceHidden.value) < 0) {
            e.preventDefault();
            alert('⚠️ Saldo atual inválido!');
            initialBalanceDisplay.focus();
            return;
        }

        if (!monthlyAmountHidden.value || parseFloat(monthlyAmountHidden.value) <= 0) {
            e.preventDefault();
            alert('⚠️ Valor mensal inválido!');
            monthlyAmountDisplay.focus();
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
        margin: 0;
        padding-left: 1.25rem;
        color: var(--gray-700);
    }

    .info-box li {
        margin: 0.4rem 0;
        font-size: 0.875rem;
        line-height: 1.5;
    }

    #initial_balance_display,
    #monthly_amount_display {
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

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 0.75rem;
        border: 2px solid var(--gray-300);
        border-radius: 8px;
        font-size: 0.9375rem;
        color: var(--gray-900);
        transition: all 0.2s;
        background: white;
    }

    .form-group input:focus,
    .form-group select:focus {
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

        .form-row-two {
            grid-template-columns: 1fr;
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