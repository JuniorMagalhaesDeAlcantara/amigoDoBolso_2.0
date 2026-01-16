<?php include VIEWS . '/layouts/header.php'; ?>

<style>
    :root {
        --primary: #667eea;
        --primary-hover: #5568d3;
        --secondary: #10b981;
        --danger: #ef4444;
        --warning: #f59e0b;
        --info: #3b82f6;
        --gray-50: #f9fafb;
        --gray-100: #f3f4f6;
        --gray-200: #e5e7eb;
        --gray-300: #d1d5db;
        --gray-400: #9ca3af;
        --gray-500: #6b7280;
        --gray-600: #4b5563;
        --gray-700: #374151;
        --gray-800: #1f2937;
        --gray-900: #111827;
        --shadow-sm: 0 1px 3px rgba(0,0,0,0.12);
        --shadow-md: 0 4px 6px rgba(0,0,0,0.1);
        --shadow-lg: 0 10px 25px rgba(0,0,0,0.15);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* ========== CONTAINER ========== */
    .container-small {
        max-width: 780px;
        margin: 0 auto;
        padding: 2rem;
    }

    /* ========== CARD ========== */
    .card {
        background: white;
        border-radius: 16px;
        padding: 2.5rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--gray-200);
        animation: fadeInUp 0.5s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card h2 {
        font-size: 1.875rem;
        font-weight: 700;
        color: var(--gray-900);
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        line-height: 1.2;
    }

    /* ========== ALERTS ========== */
    .alert {
        display: flex;
        align-items: flex-start;
        gap: 0.875rem;
        padding: 1.125rem 1.5rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        font-size: 0.9375rem;
        line-height: 1.5;
        animation: slideDown 0.3s ease-out;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .alert-error {
        background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
        border: 2px solid #fca5a5;
        color: #991b1b;
    }

    /* ========== FORM GROUPS ========== */
    .form-group {
        margin-bottom: 1.75rem;
    }

    .form-group:last-child {
        margin-bottom: 0;
    }

    .form-group label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9375rem;
        font-weight: 600;
        color: var(--gray-700);
        margin-bottom: 0.625rem;
        line-height: 1.4;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 0.875rem 1.125rem;
        border: 2px solid var(--gray-200);
        border-radius: 12px;
        font-size: 1rem;
        color: var(--gray-900);
        transition: var(--transition);
        background: white;
        font-family: inherit;
    }

    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.12);
        background: var(--gray-50);
    }

    .form-group input::placeholder {
        color: var(--gray-400);
    }

    .form-group small {
        display: block;
        margin-top: 0.625rem;
        color: var(--gray-500);
        font-size: 0.8125rem;
        line-height: 1.5;
    }

    /* ========== SPECIAL INPUTS ========== */
    #credit_limit_display {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--primary);
        text-align: right;
        font-family: 'Courier New', monospace;
        letter-spacing: 0.5px;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(102, 126, 234, 0.02) 100%);
    }

    #holder_name {
        text-transform: uppercase;
        font-family: 'Courier New', monospace;
        font-weight: 600;
        letter-spacing: 1px;
    }

    #last_digits {
        font-family: 'Courier New', monospace;
        font-size: 1.125rem;
        font-weight: 600;
        letter-spacing: 2px;
        text-align: center;
    }

    /* ========== FORM ROW ========== */
    .form-row-two {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.25rem;
        margin-bottom: 1.75rem;
    }

    /* ========== DIVIDER ========== */
    hr {
        border: none;
        border-top: 2px solid var(--gray-200);
        margin: 2rem 0;
    }

    /* ========== INFO BOX ========== */
    .info-box {
        display: flex;
        align-items: flex-start;
        gap: 1.125rem;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.08) 0%, rgba(102, 126, 234, 0.05) 100%);
        border: 2px solid rgba(102, 126, 234, 0.25);
        border-radius: 12px;
        padding: 1.25rem 1.5rem;
        margin: 2rem 0;
    }

    .info-icon {
        font-size: 1.75rem;
        flex-shrink: 0;
    }

    .info-box strong {
        color: var(--primary);
        font-size: 1rem;
        display: block;
        margin-bottom: 0.375rem;
        font-weight: 700;
    }

    .info-box p {
        color: var(--gray-700);
        font-size: 0.9375rem;
        margin: 0;
        line-height: 1.5;
    }

    /* ========== BUTTONS ========== */
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.875rem 1.75rem;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
        cursor: pointer;
        border: none;
        white-space: nowrap;
        font-family: inherit;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.25);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.35);
    }

    .btn-primary:active {
        transform: translateY(0);
    }

    .btn-secondary {
        background: white;
        color: var(--gray-700);
        border: 2px solid var(--gray-200);
    }

    .btn-secondary:hover {
        border-color: var(--gray-300);
        background: var(--gray-50);
    }

    /* ========== FORM ACTIONS ========== */
    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2.5rem;
        padding-top: 2rem;
        border-top: 2px solid var(--gray-200);
    }

    .form-actions .btn {
        flex: 1;
    }

    /* ========== RESPONSIVE - TABLET ========== */
    @media (max-width: 1024px) {
        .container-small {
            padding: 1.5rem;
        }

        .card {
            padding: 2rem;
        }

        .card h2 {
            font-size: 1.625rem;
        }
    }

    /* ========== RESPONSIVE - MOBILE ========== */
    @media (max-width: 768px) {
        .container-small {
            padding: 1rem;
        }

        .card {
            padding: 1.5rem;
            border-radius: 12px;
        }

        .card h2 {
            font-size: 1.5rem;
            gap: 0.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            font-size: 0.875rem;
        }

        .form-group input,
        .form-group select {
            padding: 0.75rem 1rem;
            font-size: 16px; /* Previne zoom no iOS */
            border-radius: 10px;
        }

        #credit_limit_display {
            font-size: 1.5rem;
        }

        #last_digits {
            font-size: 1rem;
        }

        .form-row-two {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .info-box {
            padding: 1rem;
            gap: 0.875rem;
        }

        .info-icon {
            font-size: 1.5rem;
        }

        .form-actions {
            flex-direction: column;
            gap: 0.75rem;
            margin-top: 2rem;
            padding-top: 1.5rem;
        }

        .form-actions .btn {
            width: 100%;
            padding: 1rem 1.5rem;
        }

        hr {
            margin: 1.5rem 0;
        }

        .alert {
            padding: 1rem;
            font-size: 0.875rem;
        }
    }

    /* ========== MOBILE PORTRAIT ========== */
    @media (max-width: 480px) {
        .container-small {
            padding: 0.875rem;
        }

        .card {
            padding: 1.25rem;
        }

        .card h2 {
            font-size: 1.375rem;
        }

        #credit_limit_display {
            font-size: 1.375rem;
        }
    }

    /* PWA/Standalone Mode */
    @media (display-mode: standalone) {
        .container-small {
            padding-top: calc(env(safe-area-inset-top) + 2rem);
            padding-bottom: calc(env(safe-area-inset-bottom) + 2rem);
        }
    }
</style>

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
                    placeholder="NOME SOBRENOME">
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

    // Previne zoom em iOS ao focar inputs
    if (/iPhone|iPad|iPod/i.test(navigator.userAgent)) {
        const inputs = document.querySelectorAll('input, select');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.style.fontSize = '16px';
            });
        });
    }
</script>

<?php include VIEWS . '/layouts/footer.php'; ?>