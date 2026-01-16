<?php include VIEWS . '/layouts/header.php'; ?>

<style>
    :root {
        --primary: #667eea;
        --primary-hover: #5568d3;
        --secondary: #10b981;
        --danger: #ef4444;
        --warning: #f59e0b;
        --orange: #ff9800;
        --orange-dark: #e65100;
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

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.7; }
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

    /* ========== CURRENCY INPUT ========== */
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

    .info-box-current {
        background: linear-gradient(135deg, rgba(255, 152, 0, 0.08) 0%, rgba(255, 152, 0, 0.03) 100%);
        border-color: rgba(255, 152, 0, 0.3);
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

    .info-box-current strong {
        color: var(--orange-dark);
    }

    .info-box ul {
        margin: 0.625rem 0;
        padding-left: 1.5rem;
        color: var(--gray-700);
    }

    .info-box li {
        margin: 0.5rem 0;
        font-size: 0.875rem;
        line-height: 1.6;
    }

    .info-box li strong {
        color: var(--gray-900);
        font-size: 0.875rem;
        display: inline;
        margin: 0;
    }

    .warning-text {
        color: var(--orange-dark) !important;
        font-weight: 600 !important;
        margin-top: 0.875rem !important;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.8125rem !important;
        padding: 0.625rem;
        background: rgba(255, 152, 0, 0.1);
        border-radius: 6px;
        border-left: 3px solid var(--orange);
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

    /* ========== LOADING STATE ========== */
    .btn-primary:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none !important;
    }

    .btn-primary.loading {
        animation: pulse 1.5s ease-in-out infinite;
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

        #monthly_amount_display {
            font-size: 1.25rem;
        }

        .warning-text {
            font-size: 0.75rem !important;
        }
    }

    /* ========== PWA/STANDALONE MODE ========== */
    @media (display-mode: standalone) {
        .container-small {
            padding-top: calc(env(safe-area-inset-top) + 2rem);
            padding-bottom: calc(env(safe-area-inset-bottom) + 2rem);
        }
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

    /* ========== SHAKE ANIMATION ========== */
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        50% { transform: translateX(5px); }
        75% { transform: translateX(-5px); }
    }

    .shake {
        animation: shake 0.5s;
    }
</style>

<div class="container-small">
    <div class="card">
        <h2>✏️ Editar Benefício</h2>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                ⚠️ <?= $_SESSION['error'] ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form method="POST" action="/beneficios/editar/<?= $benefit['id'] ?>" id="benefitForm">
            <div class="form-group">
                <label for="type">📋 Tipo de Benefício *</label>
                <select name="type" id="type" required>
                    <option value="">Selecione o tipo...</option>
                    <option value="vr" <?= $benefit['type'] === 'vr' ? 'selected' : '' ?>>🍽️ Vale Refeição (VR)</option>
                    <option value="va" <?= $benefit['type'] === 'va' ? 'selected' : '' ?>>🛒 Vale Alimentação (VA)</option>
                </select>
                <small>VR = Restaurantes e Delivery | VA = Supermercados</small>
            </div>

            <div class="form-group">
                <label for="provider">🏢 Fornecedor *</label>
                <select name="provider" id="provider" required>
                    <option value="">Selecione o fornecedor...</option>
                    <option value="sodexo" <?= $benefit['provider'] === 'sodexo' ? 'selected' : '' ?>>🔴 Sodexo</option>
                    <option value="caju" <?= $benefit['provider'] === 'caju' ? 'selected' : '' ?>>🟠 Caju</option>
                    <option value="swile" <?= $benefit['provider'] === 'swile' ? 'selected' : '' ?>>🟣 Swile</option>
                    <option value="alelo" <?= $benefit['provider'] === 'alelo' ? 'selected' : '' ?>>🟢 Alelo</option>
                    <option value="ticket" <?= $benefit['provider'] === 'ticket' ? 'selected' : '' ?>>🟠 Ticket</option>
                    <option value="vr" <?= $benefit['provider'] === 'vr' ? 'selected' : '' ?>>🟢 VR Benefícios</option>
                    <option value="ben" <?= $benefit['provider'] === 'ben' ? 'selected' : '' ?>>🔵 Ben Benefícios</option>
                    <option value="ifood" <?= $benefit['provider'] === 'ifood' ? 'selected' : '' ?>>🔴 iFood Benefícios</option>
                    <option value="flash" <?= $benefit['provider'] === 'flash' ? 'selected' : '' ?>>🟠 Flash Benefícios</option>
                    <option value="outros" <?= $benefit['provider'] === 'outros' ? 'selected' : '' ?>>⚪ Outro</option>
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

            <hr>

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
                            <option value="<?= $i ?>" <?= $benefit['recharge_day'] == $i ? 'selected' : '' ?>>Dia <?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                    <small>Quando o valor entra</small>
                </div>
            </div>

            <hr>

            <div class="info-box info-box-current">
                <span class="info-icon">📊</span>
                <div>
                    <strong>Informações Atuais:</strong>
                    <ul>
                        <li><strong>Saldo disponível:</strong> R$ <?= number_format($benefit['current_balance'], 2, ',', '.') ?></li>
                        <li><strong>Última recarga:</strong> <?= $benefit['last_recharge_date'] ? date('d/m/Y', strtotime($benefit['last_recharge_date'])) : 'Nunca' ?></li>
                    </ul>
                    <small class="warning-text">⚠️ Alterar o valor mensal não afeta o saldo atual, apenas as próximas recargas</small>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">💾 Salvar Alterações</button>
                <a href="/beneficios/detalhes/<?= $benefit['id'] ?>" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
    // ===== MÁSCARA DE DINHEIRO =====
    const monthlyAmountDisplay = document.getElementById('monthly_amount_display');
    const monthlyAmountHidden = document.getElementById('monthly_amount');

    // Formata o valor inicial ao carregar
    window.addEventListener('load', function() {
        const initialValue = <?= $benefit['monthly_amount'] ?>;
        const formatted = initialValue.toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        monthlyAmountDisplay.value = formatted;
        monthlyAmountHidden.value = initialValue.toFixed(2);
    });

    monthlyAmountDisplay.addEventListener('input', function(e) {
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
        monthlyAmountHidden.value = value.replace(/\./g, '').replace(',', '.');
    });

    // Feedback visual ao focar
    monthlyAmountDisplay.addEventListener('focus', function() {
        this.parentElement.style.transform = 'scale(1.01)';
    });

    monthlyAmountDisplay.addEventListener('blur', function() {
        this.parentElement.style.transform = 'scale(1)';
    });

    // ===== VALIDAÇÃO DO FORMULÁRIO =====
    const form = document.getElementById('benefitForm');
    const submitBtn = form.querySelector('.btn-primary');

    form.addEventListener('submit', function(e) {
        if (!monthlyAmountHidden.value || parseFloat(monthlyAmountHidden.value) <= 0) {
            e.preventDefault();
            alert('⚠️ Valor mensal inválido!');
            monthlyAmountDisplay.focus();
            monthlyAmountDisplay.classList.add('shake');
            setTimeout(() => monthlyAmountDisplay.classList.remove('shake'), 500);
            return;
        }

        // Feedback visual de loading
        submitBtn.disabled = true;
        submitBtn.classList.add('loading');
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

    // ===== DETECÇÃO DE MUDANÇAS =====
    const originalValues = {
        type: document.getElementById('type').value,
        provider: document.getElementById('provider').value,
        name: document.getElementById('name').value,
        monthly_amount: monthlyAmountHidden.value,
        recharge_day: document.getElementById('recharge_day').value
    };

    function hasChanges() {
        return (
            document.getElementById('type').value !== originalValues.type ||
            document.getElementById('provider').value !== originalValues.provider ||
            document.getElementById('name').value !== originalValues.name ||
            monthlyAmountHidden.value !== originalValues.monthly_amount ||
            document.getElementById('recharge_day').value !== originalValues.recharge_day
        );
    }

    // Aviso ao sair sem salvar
    window.addEventListener('beforeunload', function(e) {
        if (hasChanges() && !submitBtn.disabled) {
            e.preventDefault();
            e.returnValue = '';
        }
    });

    // ===== FEEDBACK VISUAL NOS INPUTS =====
    const allInputs = form.querySelectorAll('input, select');
    allInputs.forEach(input => {
        input.addEventListener('invalid', function(e) {
            e.preventDefault();
            this.style.borderColor = 'var(--danger)';
            this.classList.add('shake');
            setTimeout(() => this.classList.remove('shake'), 500);
        });

        input.addEventListener('input', function() {
            this.style.borderColor = '';
        });

        // Marca campos alterados
        input.addEventListener('change', function() {
            if (hasChanges()) {
                submitBtn.style.boxShadow = '0 4px 12px rgba(102, 126, 234, 0.4)';
                submitBtn.style.animation = 'pulse 2s ease-in-out infinite';
            }
        });
    });

    // ===== ADICIONA CLASSE AO BODY QUANDO EM MODO PWA =====
    if (window.matchMedia('(display-mode: standalone)').matches) {
        document.body.classList.add('pwa-mode');
    }

    // ===== ATALHOS DE TECLADO =====
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + S para salvar
        if ((e.ctrlKey || e.metaKey) && e.key === 's') {
            e.preventDefault();
            if (!submitBtn.disabled && hasChanges()) {
                form.submit();
            }
        }
        
        // ESC para cancelar
        if (e.key === 'Escape') {
            const cancelBtn = document.querySelector('.btn-secondary');
            if (cancelBtn && confirm('Deseja cancelar as alterações?')) {
                window.location.href = cancelBtn.href;
            }
        }
    });

    // ===== HIGHLIGHT DE MUDANÇAS =====
    function highlightChangedFields() {
        if (document.getElementById('type').value !== originalValues.type) {
            document.getElementById('type').style.background = 'rgba(102, 126, 234, 0.05)';
        }
        if (document.getElementById('provider').value !== originalValues.provider) {
            document.getElementById('provider').style.background = 'rgba(102, 126, 234, 0.05)';
        }
        if (document.getElementById('name').value !== originalValues.name) {
            document.getElementById('name').style.background = 'rgba(102, 126, 234, 0.05)';
        }
        if (monthlyAmountHidden.value !== originalValues.monthly_amount) {
            monthlyAmountDisplay.style.background = 'rgba(102, 126, 234, 0.05)';
        }
        if (document.getElementById('recharge_day').value !== originalValues.recharge_day) {
            document.getElementById('recharge_day').style.background = 'rgba(102, 126, 234, 0.05)';
        }
    }

    // Verifica mudanças a cada alteração
    allInputs.forEach(input => {
        input.addEventListener('change', highlightChangedFields);
        input.addEventListener('input', highlightChangedFields);
    });
</script>

<?php include VIEWS . '/layouts/footer.php'; ?>