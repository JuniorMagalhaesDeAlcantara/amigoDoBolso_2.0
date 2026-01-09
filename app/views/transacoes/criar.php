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
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1.5rem;
}

.alert-error {
    background: #fee;
    border: 1px solid #fcc;
    color: #c33;
}

.input-with-button {
    display: flex;
    gap: 0.5rem;
}

.input-with-button select {
    flex: 1;
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
}

.checkbox-label input[type="checkbox"] {
    width: auto;
    cursor: pointer;
}

.text-warning {
    color: #f39c12;
}

hr {
    border: none;
    border-top: 2px solid #e1e8ed;
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
    color: #666;
    font-size: 0.85rem;
}

#amount_display {
    font-size: 1.3rem;
    font-weight: bold;
    color: #667eea;
}

#benefitBalanceInfo {
    font-weight: 600;
}
</style>

<?php include VIEWS . '/layouts/footer.php'; ?>