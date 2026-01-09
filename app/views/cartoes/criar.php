<?php include VIEWS . '/layouts/header.php'; ?>

<div class="container-small">
    <div class="card">
        <h2>💳 Novo Cartão de Crédito</h2>
        <p class="subtitle">Cadastre seu cartão para controlar compras parceladas</p>

        <form method="POST" action="/cartoes/criar">
            <div class="form-group">
                <label for="bank">🏦 Banco *</label>
                <select name="bank" id="bank" required>
                    <option value="">Selecione o banco...</option>
                    <option value="nubank">Nubank</option>
                    <option value="inter">Inter</option>
                    <option value="c6">C6 Bank</option>
                    <option value="itau">Itaú</option>
                    <option value="bradesco">Bradesco</option>
                    <option value="santander">Santander</option>
                    <option value="bb">Banco do Brasil</option>
                    <option value="caixa">Caixa</option>
                    <option value="picpay">PicPay</option>
                    <option value="neon">Neon</option>
                    <option value="next">Next</option>
                    <option value="original">Banco Original</option>
                    <option value="outros">Outro</option>
                </select>
            </div>

            <div class="form-group">
                <label for="name">📝 Nome do Cartão *</label>
                <input type="text"
                    id="name"
                    name="name"
                    placeholder="Ex: Nubank Roxinho, Inter Gold, C6 Carbon"
                    required>
                <small>Um apelido para você identificar facilmente</small>
            </div>

            <div class="form-group">
                <label for="holder_name">👤 Nome do Titular (opcional)</label>
                <input type="text"
                    id="holder_name"
                    name="holder_name"
                    placeholder="NOME SOBRENOME"
                    style="text-transform: uppercase;">
                <small>Como aparece impresso no cartão</small>
            </div>

            <div class="form-group">
                <label for="last_digits">🔢 Últimos 4 dígitos *</label>
                <input type="text"
                    id="last_digits"
                    name="last_digits"
                    placeholder="1234"
                    maxlength="4"
                    pattern="[0-9]{4}"
                    required>
                <small>Apenas os 4 últimos números do cartão (para identificação)</small>
            </div>

            <div class="form-row-two">
                <div class="form-group">
                    <label for="closing_day">📅 Dia de Fechamento *</label>
                    <select name="closing_day" id="closing_day" required>
                        <option value="">Selecione...</option>
                        <?php for ($i = 1; $i <= 31; $i++): ?>
                            <option value="<?= $i ?>">Dia <?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                    <small>Quando a fatura fecha</small>
                </div>

                <div class="form-group">
                    <label for="due_day">💰 Dia de Vencimento *</label>
                    <select name="due_day" id="due_day" required>
                        <option value="">Selecione...</option>
                        <?php for ($i = 1; $i <= 31; $i++): ?>
                            <option value="<?= $i ?>">Dia <?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                    <small>Quando a fatura vence</small>
                </div>
            </div>

            <div class="form-group">
                <label for="credit_limit">💵 Limite do Cartão (opcional)</label>
                <input type="text"
                    id="credit_limit"
                    name="credit_limit"
                    placeholder="R$ 0,00">
                <small>Se informar, conseguirá acompanhar quanto ainda tem disponível</small>
            </div>

            <div class="info-box">
                <strong>💡 Dica:</strong> Compras feitas após o fechamento entram na próxima fatura!
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">💾 Salvar Cartão</button>
                <a href="/cartoes" class="btn btn-secondary">❌ Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
    // Formatação automática do limite - CORRIGIDA
    const limitInput = document.getElementById('credit_limit');
    
    limitInput.addEventListener('input', function(e) {
        let value = e.target.value;
        
        // Remove tudo que não é número
        value = value.replace(/\D/g, '');
        
        // Converte para número e formata
        if (value) {
            // Divide por 100 para ter os centavos
            const numValue = parseFloat(value) / 100;
            
            // Formata com 2 casas decimais
            value = numValue.toLocaleString('pt-BR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }
        
        e.target.value = value ? 'R$ ' + value : '';
    });

    // Nome do titular em maiúsculas
    document.getElementById('holder_name').addEventListener('input', function(e) {
        e.target.value = e.target.value.toUpperCase();
    });

    // Remove formatação antes de enviar - CORRIGIDO
    document.querySelector('form').addEventListener('submit', function(e) {
        if (limitInput.value) {
            // Remove R$ e formata para número decimal
            let value = limitInput.value
                .replace('R$ ', '')
                .replace(/\./g, '')
                .replace(',', '.');
            
            limitInput.value = value;
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

    @media (max-width: 768px) {
        .form-row-two {
            grid-template-columns: 1fr;
        }
    }
</style>

<?php include VIEWS . '/layouts/footer.php'; ?>