<?php include VIEWS . '/layouts/header.php'; ?>

<style>
    :root {
        --primary: #667eea;
        --primary-hover: #5568d3;
        --secondary: #10b981;
        --danger: #ef4444;
        --warning: #f59e0b;
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

    /* ========== ANIMATIONS ========== */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
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

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-10px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* ========== CONTAINER ========== */
    .container-small {
        max-width: 700px;
        margin: 0 auto;
        padding: 2rem;
        animation: fadeIn 0.5s ease-out;
    }

    /* ========== CARD ========== */
    .card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--gray-200);
        animation: fadeInUp 0.5s ease-out;
    }

    .card h2 {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--gray-900);
        margin-bottom: 1.75rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        animation: fadeInDown 0.5s ease-out 0.1s both;
    }

    /* ========== ALERTS ========== */
    .alert {
        display: flex;
        align-items: center;
        gap: 0.875rem;
        padding: 1.125rem 1.5rem;
        border-radius: 12px;
        margin-bottom: 1.75rem;
        font-size: 0.9375rem;
        font-weight: 500;
        animation: slideIn 0.5s ease-out;
    }

    .alert-error {
        background: #fee2e2;
        border: 2px solid #fca5a5;
        color: #991b1b;
    }

    /* ========== FORM ELEMENTS ========== */
    .form-group {
        margin-bottom: 1.75rem;
        animation: fadeInUp 0.5s ease-out;
    }

    .form-group:last-child {
        margin-bottom: 0;
    }

    .form-group label {
        display: flex;
        align-items: center;
        gap: 0.625rem;
        font-size: 0.9375rem;
        font-weight: 600;
        color: var(--gray-700);
        margin-bottom: 0.625rem;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 0.875rem 1rem;
        border: 2px solid var(--gray-300);
        border-radius: 10px;
        font-size: 0.9375rem;
        color: var(--gray-900);
        transition: var(--transition);
        background: white;
        font-family: inherit;
    }

    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        transform: translateY(-1px);
    }

    .form-group input:hover,
    .form-group select:hover {
        border-color: var(--gray-400);
    }

    .form-group select {
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%234b5563' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        padding-right: 3rem;
    }

    .form-group input::placeholder {
        color: var(--gray-400);
    }

    small {
        display: block;
        margin-top: 0.625rem;
        color: var(--gray-500);
        font-size: 0.8125rem;
        line-height: 1.4;
    }

    /* ========== FORM ROW ========== */
    .form-row-two {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.25rem;
    }

    /* ========== CURRENCY INPUTS ========== */
    #initial_balance_display,
    #monthly_amount_display {
        font-size: 1.625rem;
        font-weight: 700;
        color: var(--primary);
        text-align: right;
        font-family: 'Courier New', monospace;
        letter-spacing: 0.5px;
    }

    /* ========== DIVIDER ========== */
    hr {
        border: none;
        border-top: 2px solid var(--gray-200);
        margin: 2rem 0;
        opacity: 0.6;
    }

    /* ========== INFO BOX ========== */
    .info-box {
        display: flex;
        align-items: flex-start;
        gap: 1.125rem;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.08) 0%, rgba(102, 126, 234, 0.03) 100%);
        border: 2px solid rgba(102, 126, 234, 0.25);
        border-radius: 12px;
        padding: 1.25rem 1.5rem;
        margin: 1.75rem 0;
        animation: fadeInUp 0.5s ease-out 0.3s both;
    }

    .info-icon {
        font-size: 1.75rem;
        flex-shrink: 0;
        line-height: 1;
    }

    .info-box strong {
        color: var(--primary);
        font-size: 1rem;
        display: block;
        margin-bottom: 0.75rem;
        font-weight: 700;
    }

    .info-box ul {
        margin: 0;
        padding-left: 1.5rem;
        color: var(--gray-700);
    }

    .info-box li {
        margin: 0.5rem 0;
        font-size: 0.875rem;
        line-height: 1.6;
    }

    /* ========== FORM ACTIONS ========== */
    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2.25rem;
        animation: fadeInUp 0.5s ease-out 0.4s both;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.9375rem 1.875rem;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
        cursor: pointer;
        border: none;
        white-space: nowrap;
        font-family: inherit;
        flex: 1;
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
        border: 2px solid var(--gray-300);
    }

    .btn-secondary:hover {
        background: var(--gray-50);
        border-color: var(--gray-400);
        transform: translateY(-2px);
        box-shadow: var(--shadow-sm);
    }

    .btn-secondary:active {
        transform: translateY(0);
    }

    /* ========== RESPONSIVE - TABLET ========== */
    @media (max-width: 1024px) {
        .container-small {
            padding: 1.5rem;
        }

        .card {
            padding: 1.75rem;
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
        }

        .form-row-two {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .form-actions {
            flex-direction: column;
        }

        .form-actions .btn {
            width: 100%;
        }

        .info-box {
            padding: 1rem 1.25rem;
        }

        #initial_balance_display,
        #monthly_amount_display {
            font-size: 1.375rem;
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

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group input,
        .form-group select {
            padding: 0.75rem 0.875rem;
            font-size: 0.875rem;
        }

        .alert {
            padding: 1rem 1.25rem;
            font-size: 0.875rem;
        }

        .info-box {
            flex-direction: column;
            gap: 0.75rem;
        }

        .info-icon {
            font-size: 1.5rem;
        }

        #initial_balance_display,
        #monthly_amount_display {
            font-size: 1.25rem;
        }
    }

    /* ========== PWA/STANDALONE MODE ========== */
    @media (display-mode: standalone) {
        .container-small {
            padding-top: calc(env(safe-area-inset-top) + 2rem);
            padding-bottom: calc(env(safe-area-inset-bottom) + 2rem);
        }
    }

    /* ========== LOADING STATE ========== */
    .btn-primary:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none !important;
    }

    /* ========== FORM VALIDATION ========== */
    .form-group input:invalid:not(:placeholder-shown),
    .form-group select:invalid:not(:placeholder-shown) {
        border-color: var(--danger);
    }

    .form-group input:valid,
    .form-group select:valid {
        border-color: var(--gray-300);
    }

    .form-group input:focus:valid,
    .form-group select:focus:valid {
        border-color: var(--primary);
    }

    /* ========== ACCESSIBILITY ========== */
    @media (prefers-reduced-motion: reduce) {
        * {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
    }
</style>

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

        // Feedback visual ao focar
        displayInput.addEventListener('focus', function() {
            this.parentElement.style.transform = 'scale(1.01)';
        });

        displayInput.addEventListener('blur', function() {
            this.parentElement.style.transform = 'scale(1)';
        });
    }

    setupCurrencyMask(initialBalanceDisplay, initialBalanceHidden);
    setupCurrencyMask(monthlyAmountDisplay, monthlyAmountHidden);

    // ===== SUGESTÃO AUTOMÁTICA DE NOME =====
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

    // ===== VALIDAÇÃO DO FORMULÁRIO =====
    const form = document.getElementById('benefitForm');
    const submitBtn = form.querySelector('.btn-primary');

    form.addEventListener('submit', function(e) {
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

        // Feedback visual de loading
        submitBtn.disabled = true;
        submitBtn.innerHTML = '⏳ Salvando...';
    });

    // ===== PREVINE ZOOM EM iOS =====
    if (/iPhone|iPad|iPod/i.test(navigator.userAgent)) {
        const viewport = document.querySelector('meta[name="viewport"]');
        if (viewport) {
            viewport.content = 'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no';
        }
    }

    // ===== ANIMAÇÃO DOS FORM GROUPS =====
    document.addEventListener('DOMContentLoaded', function() {
        const formGroups = document.querySelectorAll('.form-group');
        
        formGroups.forEach((group, index) => {
            group.style.animationDelay = `${0.1 + (index * 0.05)}s`;
        });
    });

    // ===== AUTO-SAVE NO LOCAL STORAGE (DRAFT) =====
    const formInputs = form.querySelectorAll('input, select');
    const DRAFT_KEY = 'benefit_form_draft';

    // Carrega draft ao carregar a página
    function loadDraft() {
        try {
            const draft = localStorage.getItem(DRAFT_KEY);
            if (draft) {
                const data = JSON.parse(draft);
                Object.keys(data).forEach(key => {
                    const input = form.querySelector(`[name="${key}"]`);
                    if (input && !input.value) {
                        input.value = data[key];
                        
                        // Trigger para máscaras de dinheiro
                        if (key === 'initial_balance') {
                            initialBalanceDisplay.value = data.initial_balance_display || '';
                        }
                        if (key === 'monthly_amount') {
                            monthlyAmountDisplay.value = data.monthly_amount_display || '';
                        }
                    }
                });
            }
        } catch (e) {
            console.log('Erro ao carregar rascunho:', e);
        }
    }

    // Salva draft ao digitar
    function saveDraft() {
        try {
            const data = {};
            formInputs.forEach(input => {
                if (input.name && input.value) {
                    data[input.name] = input.value;
                }
            });
            data.initial_balance_display = initialBalanceDisplay.value;
            data.monthly_amount_display = monthlyAmountDisplay.value;
            
            localStorage.setItem(DRAFT_KEY, JSON.stringify(data));
        } catch (e) {
            console.log('Erro ao salvar rascunho:', e);
        }
    }

    // Limpa draft ao enviar
    form.addEventListener('submit', function() {
        try {
            localStorage.removeItem(DRAFT_KEY);
        } catch (e) {
            console.log('Erro ao limpar rascunho:', e);
        }
    });

    // Eventos de auto-save
    formInputs.forEach(input => {
        input.addEventListener('change', saveDraft);
        input.addEventListener('blur', saveDraft);
    });

    // Carrega draft na inicialização
    loadDraft();

    // ===== ADICIONA CLASSE AO BODY QUANDO EM MODO PWA =====
    if (window.matchMedia('(display-mode: standalone)').matches) {
        document.body.classList.add('pwa-mode');
    }

    // ===== FEEDBACK VISUAL NOS INPUTS =====
    const allInputs = form.querySelectorAll('input, select');
    allInputs.forEach(input => {
        input.addEventListener('invalid', function(e) {
            e.preventDefault();
            this.style.borderColor = 'var(--danger)';
            this.style.animation = 'shake 0.5s';
        });

        input.addEventListener('input', function() {
            this.style.borderColor = '';
            this.style.animation = '';
        });
    });

    // Animação de shake
    const style = document.createElement('style');
    style.textContent = `
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }
    `;
    document.head.appendChild(style);
</script>

<?php include VIEWS . '/layouts/footer.php'; ?>