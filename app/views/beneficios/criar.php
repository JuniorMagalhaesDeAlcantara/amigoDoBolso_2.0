<?php include VIEWS . '/layouts/header.php'; ?>

<div class="container-small">
    <div class="card">
        <h2>💼 Novo Benefício (VR / VA)</h2>
        <p class="subtitle">Cadastre seus vales para controlar gastos com alimentação</p>

        <form method="POST" action="/beneficios/criar" id="benefitForm">
            <div class="form-group">
                <label for="type">📋 Tipo de Benefício *</label>
                <select name="type" id="type" required>
                    <option value="">Selecione o tipo...</option>
                    <option value="vr">🍔 Vale Refeição (VR)</option>
                    <option value="va">🛒 Vale Alimentação (VA)</option>
                </select>
                <small>VR = Restaurantes | VA = Supermercados</small>
            </div>

            <div class="form-group">
                <label for="provider">🏢 Fornecedor *</label>
                <select name="provider" id="provider" required>
                    <option value="">Selecione o fornecedor...</option>
                    <option value="sodexo">Sodexo</option>
                    <option value="caju">Caju</option>
                    <option value="swile">Swile</option>
                    <option value="alelo">Alelo</option>
                    <option value="ticket">Ticket</option>
                    <option value="vr">VR Benefícios</option>
                    <option value="ben">Ben Benefícios</option>
                    <option value="outros">Outro</option>
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

            <div class="form-group">
                <label for="initial_balance">💰 Saldo Atual *</label>
                <input type="text"
                    id="initial_balance"
                    name="initial_balance"
                    placeholder="R$ 0,00"
                    required>
                <small>Saldo que o cartão tem hoje</small>
            </div>

            <div class="form-row-two">
                <div class="form-group">
                    <label for="monthly_amount">💵 Valor Mensal *</label>
                    <input type="text"
                        id="monthly_amount"
                        name="monthly_amount"
                        placeholder="R$ 0,00"
                        required>
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

            <div class="info-box">
                <strong>💡 Como funciona:</strong>
                <ul>
                    <li>O saldo é recarregado automaticamente todo mês no dia escolhido</li>
                    <li>Cada transação com VR/VA desconta do saldo disponível</li>
                    <li>Não gera dívida, não parcela, e não tem fatura</li>
                </ul>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">💾 Salvar Benefício</button>
                <a href="/beneficios" class="btn btn-secondary">❌ Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
    function formatCurrencyInput(input) {
        input.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');

            if (value) {
                const numValue = parseFloat(value) / 100;
                value = numValue.toLocaleString('pt-BR', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
                e.target.value = 'R$ ' + value;
            } else {
                e.target.value = '';
            }
        });
    }

    function unformatCurrencyInput(input) {
        if (input.value) {
            input.value = input.value
                .replace('R$ ', '')
                .replace(/\./g, '')
                .replace(',', '.');
        }
    }

    const monthlyAmountInput = document.getElementById('monthly_amount');
    const initialBalanceInput = document.getElementById('initial_balance');

    if (monthlyAmountInput) formatCurrencyInput(monthlyAmountInput);
    if (initialBalanceInput) formatCurrencyInput(initialBalanceInput);

    document.getElementById('benefitForm').addEventListener('submit', function() {
        if (monthlyAmountInput) unformatCurrencyInput(monthlyAmountInput);
        if (initialBalanceInput) unformatCurrencyInput(initialBalanceInput);
    });

    // Sugestão automática de nome
    const typeSelect = document.getElementById('type');
    const providerSelect = document.getElementById('provider');
    const nameInput = document.getElementById('name');

    function updateNameSuggestion() {
        if (!nameInput.value && typeSelect.value && providerSelect.value) {
            const typeLabel = typeSelect.value === 'vr' ? 'VR' : 'VA';
            const providerName = providerSelect.options[providerSelect.selectedIndex].text;
            nameInput.placeholder = `${typeLabel} ${providerName}`;
        }
    }

    typeSelect.addEventListener('change', updateNameSuggestion);
    providerSelect.addEventListener('change', updateNameSuggestion);
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