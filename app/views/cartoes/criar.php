<?php include VIEWS . '/layouts/header.php'; ?>

<div class="container-small">
    <div class="card">
        <h2>💳 Novo Cartão de Crédito</h2>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                ⚠️ <?= $_SESSION['error'] ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form method="POST" action="/cartoes/criar" id="formCard">
            <div class="form-group">
                <label for="bank">🏦 Banco *</label>
                <select name="bank" id="bank" required>
                    <option value="">Selecione o banco...</option>
                    <option value="nubank">🟣 Nubank</option>
                    <option value="inter">🟠 Inter</option>
                    <option value="c6">⚫ C6 Bank</option>
                    <option value="itau">🟠 Itaú</option>
                    <option value="bradesco">🔴 Bradesco</option>
                    <option value="santander">🔴 Santander</option>
                    <option value="bb">🟡 Banco do Brasil</option>
                    <option value="caixa">🔵 Caixa</option>
                    <option value="picpay">🟢 PicPay</option>
                    <option value="neon">🟢 Neon</option>
                    <option value="next">🟢 Next</option>
                    <option value="original">🟢 Banco Original</option>
                    <option value="outros">⚪ Outro</option>
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
                <label for="holder_name">👤 Nome do Titular</label>
                <input type="text"
                    id="holder_name"
                    name="holder_name"
                    placeholder="NOME SOBRENOME"
                    style="text-transform: uppercase;">
                <small>Como aparece impresso no cartão (opcional)</small>
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
                <small>Apenas os 4 últimos números do cartão</small>
            </div>

            <hr>

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

            <hr>

            <div class="form-group">
                <label for="credit_limit_display">💵 Limite do Cartão</label>
                <input type="text"
                    id="credit_limit_display"
                    placeholder="0,00">
                <input type="hidden" id="credit_limit" name="credit_limit">
                <small>Se informar, poderá acompanhar o saldo disponível</small>
            </div>

            <div class="info-box">
                <span class="info-icon">💡</span>
                <div>
                    <strong>Dica Importante:</strong>
                    <p>Compras feitas após o fechamento entram na próxima fatura!</p>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">💾 Salvar Cartão</button>
                <a href="/cartoes" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
    // ===== MÁSCARA DE DINHEIRO =====
    const limitDisplay = document.getElementById('credit_limit_display');
    const limitHidden = document.getElementById('credit_limit');

    limitDisplay.addEventListener('input', function(e) {
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
        limitHidden.value = value.replace(/\./g, '').replace(',', '.');
    });

    // Nome do titular em maiúsculas
    document.getElementById('holder_name').addEventListener('input', function(e) {
        e.target.value = e.target.value.toUpperCase();
    });

    // Validação dos últimos dígitos
    document.getElementById('last_digits').addEventListener('input', function(e) {
        e.target.value = e.target.value.replace(/\D/g, '');
    });

    // Validação do formulário
    document.getElementById('formCard').addEventListener('submit', function(e) {
        const closingDay = parseInt(document.getElementById('closing_day').value);
        const dueDay = parseInt(document.getElementById('due_day').value);

        if (closingDay && dueDay && closingDay >= dueDay) {
            e.preventDefault();
            alert('⚠️ O dia de vencimento deve ser DEPOIS do dia de fechamento!');
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
        margin-bottom: 0.25rem;
    }

    .info-box p {
        color: var(--gray-700);
        font-size: 0.875rem;
        margin: 0;
    }

    #credit_limit_display {
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