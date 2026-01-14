<?php include VIEWS . '/layouts/header.php'; ?>

<div class="container-small">
    <div class="card">
        <h2>➕ Nova Transação</h2>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                ⚠️ <?= $_SESSION['error'] ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        
        <form method="POST" action="/transacoes/criar" id="formTransaction">
            <!-- TIPO -->
            <div class="form-group">
                <label for="type">💰 Tipo *</label>
                <select name="type" id="type" required>
                    <option value="">Selecione...</option>
                    <option value="receita">💚 Receita</option>
                    <option value="despesa">💸 Despesa</option>
                </select>
            </div>
            
            <!-- CATEGORIA -->
            <div class="form-group">
                <label for="category_id">🏷️ Categoria *</label>
                <div class="input-with-button">
                    <select name="category_id" id="category_id" required>
                        <option value="">Selecione...</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'] ?>" 
                                    data-type="<?= $category['type'] ?>"
                                    data-color="<?= $category['color'] ?>">
                                <?= $category['name'] ?> (<?= ucfirst($category['type']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <a href="/categorias/criar" class="btn btn-secondary btn-sm" target="_blank">
                        + Nova
                    </a>
                </div>
            </div>
            
            <!-- DESCRIÇÃO -->
            <div class="form-group">
                <label for="description">📝 Descrição *</label>
                <input type="text" 
                       id="description" 
                       name="description" 
                       placeholder="Ex: Compra no supermercado" 
                       required>
            </div>
            
            <!-- VALOR COM MÁSCARA -->
            <div class="form-group">
                <label for="amount_display">💵 Valor (R$) *</label>
                <input type="text" 
                       id="amount_display" 
                       placeholder="0,00" 
                       required>
                <input type="hidden" id="amount" name="amount">
            </div>
            
            <!-- DATA -->
            <div class="form-group">
                <label for="transaction_date">📅 Data *</label>
                <input type="date" 
                       id="transaction_date" 
                       name="transaction_date" 
                       value="<?= date('Y-m-d') ?>" 
                       required>
            </div>
            
            <hr>
            
            <!-- FORMA DE PAGAMENTO -->
            <div class="form-group">
                <label for="payment_method">💳 Forma de Pagamento *</label>
                <select name="payment_method" id="payment_method" required>
                    <option value="dinheiro">💵 À Vista (Dinheiro/Pix/Débito)</option>
                    <option value="credito">💳 Cartão de Crédito</option>
                    <option value="vr">🍔 Vale Refeição (VR)</option>
                    <option value="va">🛒 Vale Alimentação (VA)</option>
                </select>
            </div>
            
            <!-- CAMPO DE CARTÃO DE CRÉDITO -->
            <div id="cardFields" style="display: none;">
                <div class="form-group">
                    <label for="credit_card_id">💳 Selecione o Cartão *</label>
                    <select name="credit_card_id" id="credit_card_id">
                        <option value="">Selecione...</option>
                        <?php foreach ($creditCards as $card): ?>
                            <option value="<?= $card['id'] ?>">
                                <?= $card['name'] ?> (•••• <?= $card['last_digits'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (empty($creditCards)): ?>
                        <small class="text-warning">
                            ⚠️ Você ainda não tem cartões cadastrados. 
                            <a href="/cartoes/criar" target="_blank">Cadastrar agora</a>
                        </small>
                    <?php endif; ?>
                </div>
                
                <div class="form-group">
                    <label for="installments">🔢 Parcelamento</label>
                    <select name="installments" id="installments">
                        <option value="1">À vista</option>
                        <?php for ($i = 2; $i <= 12; $i++): ?>
                            <option value="<?= $i ?>"><?= $i ?>x sem juros</option>
                        <?php endfor; ?>
                    </select>
                    <small>Se parcelar, será criada uma transação para cada mês</small>
                </div>
            </div>

            <!-- CAMPO DE BENEFÍCIOS (VR/VA) -->
            <div id="benefitFields" style="display: none;">
                <div class="form-group">
                    <label for="benefit_card_id">
                        <span id="benefitLabel">🍔 Selecione o Benefício *</span>
                    </label>
                    <select name="benefit_card_id" id="benefit_card_id">
                        <option value="">Selecione...</option>
                        <?php foreach ($benefitCards as $benefit): ?>
                            <option value="<?= $benefit['id'] ?>" 
                                    data-type="<?= $benefit['type'] ?>"
                                    data-balance="<?= $benefit['current_balance'] ?>">
                                <?= $benefit['name'] ?> - 
                                Saldo: R$ <?= number_format($benefit['current_balance'], 2, ',', '.') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (empty($benefitCards)): ?>
                        <small class="text-warning">
                            ⚠️ Você ainda não tem benefícios cadastrados. 
                            <a href="/beneficios/criar" target="_blank">Cadastrar agora</a>
                        </small>
                    <?php endif; ?>
                    <small id="benefitBalanceInfo"></small>
                </div>
            </div>
            
            <hr>
            
            <!-- DESPESA RECORRENTE -->
            <div class="form-group">
                <label class="checkbox-label">
                    <input type="checkbox" name="is_recurring" id="is_recurring" value="1">
                    <span>🔄 Despesa Recorrente (se repete todo mês)</span>
                </label>
                <small>Ex: Aluguel, seguro, academia, streaming...</small>
            </div>
            
            <!-- QUANTIDADE DE MESES (aparece se marcar recorrente) -->
            <div id="recurringFields" style="display: none;">
                <div class="form-group">
                    <label for="recurrence_months">🔢 Por quantos meses?</label>
                    <input type="number" 
                           name="recurrence_months" 
                           id="recurrence_months" 
                           min="1" 
                           max="60"
                           value="12"
                           placeholder="Ex: 12 meses">
                    <small>Será criada uma transação para cada mês automaticamente</small>
                </div>
            </div>
            
            <!-- BOTÕES -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">💾 Salvar Transação</button>
                <a href="/transacoes" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
// ===== MÁSCARA DE DINHEIRO =====
const amountDisplay = document.getElementById('amount_display');
const amountHidden = document.getElementById('amount');

amountDisplay.addEventListener('input', function(e) {
    let value = e.target.value;
    
    // Remove tudo que não é número
    value = value.replace(/\D/g, '');
    
    // Converte para número
    value = (parseInt(value) / 100).toFixed(2);
    
    // Formata com ponto de milhar e vírgula decimal
    value = value.replace('.', ',');
    value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    
    // Atualiza os campos
    e.target.value = value;
    amountHidden.value = value.replace(/\./g, '').replace(',', '.');
});

// Validação do formulário
document.getElementById('formTransaction').addEventListener('submit', function(e) {
    if (!amountHidden.value || parseFloat(amountHidden.value) <= 0) {
        e.preventDefault();
        alert('Valor inválido!');
        amountDisplay.focus();
        return;
    }

    // Validação de saldo para VR/VA
    const paymentMethod = document.getElementById('payment_method').value;
    if (paymentMethod === 'vr' || paymentMethod === 'va') {
        const benefitSelect = document.getElementById('benefit_card_id');
        const selectedOption = benefitSelect.options[benefitSelect.selectedIndex];
        
        if (!benefitSelect.value) {
            e.preventDefault();
            alert('Selecione um benefício!');
            return;
        }

        const balance = parseFloat(selectedOption.getAttribute('data-balance'));
        const amount = parseFloat(amountHidden.value);

        if (amount > balance) {
            e.preventDefault();
            alert('Saldo insuficiente no benefício!\n\nDisponível: R$ ' + balance.toFixed(2).replace('.', ','));
            return;
        }
    }
});

// ===== FILTRAR CATEGORIAS POR TIPO =====
document.getElementById('type').addEventListener('change', function() {
    const selectedType = this.value;
    const categorySelect = document.getElementById('category_id');
    const options = categorySelect.querySelectorAll('option');
    
    options.forEach(option => {
        if (option.value === '') return;
        
        const optionType = option.getAttribute('data-type');
        if (selectedType === '' || optionType === selectedType) {
            option.style.display = 'block';
        } else {
            option.style.display = 'none';
        }
    });
    
    categorySelect.value = '';
});

// ===== MOSTRAR/OCULTAR CAMPOS BASEADO NA FORMA DE PAGAMENTO =====
document.getElementById('payment_method').addEventListener('change', function() {
    const cardFields = document.getElementById('cardFields');
    const benefitFields = document.getElementById('benefitFields');
    const creditCardSelect = document.getElementById('credit_card_id');
    const benefitCardSelect = document.getElementById('benefit_card_id');
    const benefitLabel = document.getElementById('benefitLabel');
    const benefitOptions = benefitCardSelect.querySelectorAll('option[data-type]');
    
    // Esconde todos primeiro
    cardFields.style.display = 'none';
    benefitFields.style.display = 'none';
    creditCardSelect.required = false;
    benefitCardSelect.required = false;
    
    if (this.value === 'credito') {
        cardFields.style.display = 'block';
        creditCardSelect.required = true;
    } else if (this.value === 'vr' || this.value === 'va') {
        benefitFields.style.display = 'block';
        benefitCardSelect.required = true;
        
        // Atualiza label e filtra opções
        if (this.value === 'vr') {
            benefitLabel.textContent = '🍔 Selecione o Vale Refeição *';
        } else {
            benefitLabel.textContent = '🛒 Selecione o Vale Alimentação *';
        }
        
        // Filtra benefícios por tipo
        benefitOptions.forEach(option => {
            const optionType = option.getAttribute('data-type');
            option.style.display = optionType === this.value ? 'block' : 'none';
        });
        
        benefitCardSelect.value = '';
    }
});

// Mostra info de saldo quando seleciona benefício
document.getElementById('benefit_card_id').addEventListener('change', function() {
    const balanceInfo = document.getElementById('benefitBalanceInfo');
    const selectedOption = this.options[this.selectedIndex];
    
    if (this.value) {
        const balance = parseFloat(selectedOption.getAttribute('data-balance'));
        balanceInfo.textContent = `✅ Saldo disponível: R$ ${balance.toFixed(2).replace('.', ',')}`;
        balanceInfo.style.color = '#10b981';
    } else {
        balanceInfo.textContent = '';
    }
});

// ===== MOSTRAR/OCULTAR CAMPOS DE RECORRÊNCIA =====
document.getElementById('is_recurring').addEventListener('change', function() {
    const recurringFields = document.getElementById('recurringFields');
    const recurrenceMonths = document.getElementById('recurrence_months');
    
    if (this.checked) {
        recurringFields.style.display = 'block';
        recurrenceMonths.required = true;
    } else {
        recurringFields.style.display = 'none';
        recurrenceMonths.required = false;
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

.input-with-button {
    display: flex;
    gap: 0.5rem;
}

.input-with-button select {
    flex: 1;
}

.btn-sm {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem;
    background: var(--gray-50);
    border: 2px solid var(--gray-300);
    border-radius: 10px;
    cursor: pointer;
    transition: all 0.2s;
}

.checkbox-label:hover {
    background: white;
    border-color: var(--primary);
}

.checkbox-label input[type="checkbox"] {
    width: 20px;
    height: 20px;
    cursor: pointer;
    margin: 0;
}

.checkbox-label span {
    font-weight: 600;
    color: var(--gray-900);
}

.text-warning {
    color: var(--warning);
}

hr {
    border: none;
    border-top: 2px solid var(--gray-200);
    margin: 2rem 0;
}

.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
}

small {
    display: block;
    margin-top: 0.5rem;
    color: var(--gray-600);
    font-size: 0.8125rem;
}

#amount_display {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--primary);
    text-align: right;
    font-family: 'Courier New', monospace;
}

#benefitBalanceInfo {
    font-weight: 600;
    color: var(--secondary);
}

/* Campos condicionais */
#cardFields,
#benefitFields,
#recurringFields {
    margin-top: 1.5rem;
    padding: 1.5rem;
    background: var(--gray-50);
    border: 2px dashed var(--gray-300);
    border-radius: 10px;
}

#cardFields .form-group:first-child,
#benefitFields .form-group:first-child {
    margin-top: 0;
}

/* Info boxes */
.info-message {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.875rem;
    background: rgba(102, 126, 234, 0.1);
    border-radius: 8px;
    color: var(--primary);
    font-size: 0.875rem;
    margin-bottom: 1rem;
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

    .form-actions {
        flex-direction: column;
    }

    .form-actions .btn {
        width: 100%;
    }

    .input-with-button {
        flex-direction: column;
    }

    .input-with-button select,
    .input-with-button .btn {
        width: 100%;
    }
}
</style>

<?php include VIEWS . '/layouts/footer.php'; ?>