<?php include VIEWS . '/layouts/header.php'; ?>

<style>
    :root {
        --primary: #667eea;
        --primary-hover: #5568d3;
        --secondary: #764ba2;
        --success: #10b981;
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

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
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

    /* ========== BENEFIT INFO BOX ========== */
    .benefit-info-box {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        border-radius: 16px;
        padding: 1.75rem;
        color: white;
        margin-bottom: 2rem;
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        animation: fadeInUp 0.5s ease-out 0.2s both;
    }

    .benefit-header {
        display: flex;
        align-items: center;
        gap: 1.25rem;
        margin-bottom: 1.75rem;
    }

    .benefit-icon {
        font-size: 2.75rem;
        width: 68px;
        height: 68px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 14px;
        backdrop-filter: blur(10px);
        flex-shrink: 0;
    }

    .benefit-header div {
        flex: 1;
    }

    .benefit-header h3 {
        margin: 0;
        font-size: 1.375rem;
        font-weight: 700;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        line-height: 1.3;
    }

    .benefit-header p {
        margin: 0.375rem 0 0 0;
        opacity: 0.95;
        font-size: 0.9375rem;
        font-weight: 500;
    }

    .current-balance-display {
        background: rgba(0, 0, 0, 0.2);
        padding: 1.25rem;
        border-radius: 12px;
        text-align: center;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.15);
    }

    .balance-label {
        display: block;
        font-size: 0.6875rem;
        opacity: 0.9;
        margin-bottom: 0.625rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-weight: 700;
    }

    .balance-amount {
        display: block;
        font-size: 2.25rem;
        font-weight: 800;
        text-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        letter-spacing: -0.5px;
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

    .form-group input {
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

    .form-group input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        transform: translateY(-1px);
    }

    .form-group input:hover {
        border-color: var(--gray-400);
    }

    small {
        display: block;
        margin-top: 0.625rem;
        color: var(--gray-500);
        font-size: 0.8125rem;
        line-height: 1.4;
    }

    /* ========== CURRENCY INPUT ========== */
    #amount_display {
        font-size: 1.625rem;
        font-weight: 700;
        color: var(--primary);
        text-align: right;
        font-family: 'Courier New', monospace;
        letter-spacing: 0.5px;
    }

    /* ========== PREVIEW BOX ========== */
    .preview-box {
        background: linear-gradient(135deg, var(--gray-50) 0%, white 100%);
        border: 2px solid var(--gray-200);
        border-radius: 14px;
        padding: 1.75rem;
        margin: 1.75rem 0;
        animation: fadeInUp 0.5s ease-out 0.3s both;
    }

    .preview-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.875rem 0;
        font-size: 1.0625rem;
    }

    .preview-current {
        color: var(--gray-600);
        font-weight: 600;
    }

    .preview-add {
        color: var(--success);
        font-weight: 600;
    }

    .preview-add span {
        font-size: 1.125rem;
    }

    .preview-divider {
        height: 2px;
        background: linear-gradient(90deg, transparent 0%, var(--gray-300) 50%, transparent 100%);
        margin: 1rem 0;
    }

    .preview-total {
        font-size: 1.5rem;
        color: var(--primary);
        padding-top: 1rem;
        font-weight: 700;
    }

    #previewTotal {
        animation: pulse 2s ease-in-out infinite;
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
        animation: fadeInUp 0.5s ease-out 0.4s both;
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
        animation: fadeInUp 0.5s ease-out 0.5s both;
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
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
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

        .benefit-info-box {
            padding: 1.5rem;
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

        .benefit-info-box {
            padding: 1.25rem;
            border-radius: 12px;
        }

        .benefit-header {
            gap: 1rem;
        }

        .benefit-icon {
            width: 56px;
            height: 56px;
            font-size: 2.25rem;
        }

        .benefit-header h3 {
            font-size: 1.1875rem;
        }

        .benefit-header p {
            font-size: 0.875rem;
        }

        .balance-amount {
            font-size: 1.875rem;
        }

        .preview-box {
            padding: 1.25rem;
        }

        .preview-row {
            font-size: 0.9375rem;
            padding: 0.625rem 0;
        }

        .preview-total {
            font-size: 1.25rem;
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

        #amount_display {
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

        .benefit-info-box {
            padding: 1rem;
        }

        .benefit-header {
            flex-direction: column;
            text-align: center;
            gap: 0.875rem;
        }

        .benefit-icon {
            margin: 0 auto;
        }

        .current-balance-display {
            padding: 1rem;
        }

        .balance-amount {
            font-size: 1.625rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group input {
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

        #amount_display {
            font-size: 1.25rem;
        }

        .preview-row {
            font-size: 0.875rem;
        }

        .preview-total {
            font-size: 1.125rem;
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
    .form-group input:invalid:not(:placeholder-shown) {
        border-color: var(--danger);
    }

    .form-group input:valid {
        border-color: var(--gray-300);
    }

    .form-group input:focus:valid {
        border-color: var(--primary);
    }

    /* ========== SHAKE ANIMATION ========== */
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }

    /* ========== ACCESSIBILITY ========== */
    @media (prefers-reduced-motion: reduce) {
        *,
        *::before,
        *::after {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }

        #previewTotal {
            animation: none !important;
        }
    }

    /* ========== DARK MODE SUPPORT (OPCIONAL) ========== */
    @media (prefers-color-scheme: dark) {
        /* Pode ser implementado futuramente */
    }
</style>

<div class="container-small">
    <div class="card">
        <h2>💰 Recarga Manual</h2>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                ⚠️ <?= $_SESSION['error'] ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <div class="benefit-info-box">
            <div class="benefit-header">
                <span class="benefit-icon"><?= $benefit['type'] === 'vr' ? '🍔' : '🛒' ?></span>
                <div>
                    <h3><?= htmlspecialchars($benefit['name']) ?></h3>
                    <p><?= $benefit['type'] === 'vr' ? 'Vale Refeição' : 'Vale Alimentação' ?></p>
                </div>
            </div>
            
            <div class="current-balance-display">
                <span class="balance-label">Saldo Atual</span>
                <span class="balance-amount">R$ <?= number_format($benefit['current_balance'], 2, ',', '.') ?></span>
            </div>
        </div>

        <form method="POST" action="/beneficios/recarregar/<?= $benefit['id'] ?>" id="rechargeForm">
            <div class="form-group">
                <label for="amount_display">💵 Valor da Recarga *</label>
                <input type="text"
                    id="amount_display"
                    placeholder="0,00"
                    required>
                <input type="hidden" id="amount" name="amount">
                <small>Digite o valor que deseja adicionar ao saldo</small>
            </div>

            <hr>

            <div class="preview-box">
                <div class="preview-row">
                    <span>Saldo atual:</span>
                    <span class="preview-current">R$ <?= number_format($benefit['current_balance'], 2, ',', '.') ?></span>
                </div>
                <div class="preview-row preview-add">
                    <span>+ Recarga:</span>
                    <span id="previewRecharge">R$ 0,00</span>
                </div>
                <div class="preview-divider"></div>
                <div class="preview-row preview-total">
                    <strong>Novo saldo:</strong>
                    <strong id="previewTotal">R$ <?= number_format($benefit['current_balance'], 2, ',', '.') ?></strong>
                </div>
            </div>

            <hr>

            <div class="info-box">
                <span class="info-icon">ℹ️</span>
                <div>
                    <strong>Sobre a Recarga Manual:</strong>
                    <ul>
                        <li>Use para adicionar saldo extra quando necessário</li>
                        <li>O valor será somado imediatamente ao saldo disponível</li>
                        <li>A recarga automática mensal não será afetada</li>
                        <li>Esta recarga será registrada no histórico</li>
                    </ul>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">💰 Confirmar Recarga</button>
                <a href="/beneficios/detalhes/<?= $benefit['id'] ?>" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
    const currentBalance = <?= $benefit['current_balance'] ?>;
    const amountDisplay = document.getElementById('amount_display');
    const amountHidden = document.getElementById('amount');
    const previewRecharge = document.getElementById('previewRecharge');
    const previewTotal = document.getElementById('previewTotal');
    const form = document.getElementById('rechargeForm');
    const submitBtn = form.querySelector('.btn-primary');

    // ===== MÁSCARA DE DINHEIRO =====
    amountDisplay.addEventListener('input', function(e) {
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
        amountHidden.value = value.replace(/\./g, '').replace(',', '.');

        // Atualiza preview
        updatePreview();
    });

    // ===== ATUALIZAR PREVIEW =====
    function updatePreview() {
        const rechargeValue = parseFloat(amountHidden.value || 0);
        
        const formattedRecharge = rechargeValue.toLocaleString('pt-BR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
        previewRecharge.textContent = 'R$ ' + formattedRecharge;
        
        const newTotal = currentBalance + rechargeValue;
        const formattedTotal = newTotal.toLocaleString('pt-BR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
        previewTotal.textContent = 'R$ ' + formattedTotal;
    }

    // ===== FEEDBACK VISUAL AO FOCAR =====
    amountDisplay.addEventListener('focus', function() {
        this.parentElement.style.transform = 'scale(1.01)';
    });

    amountDisplay.addEventListener('blur', function() {
        this.parentElement.style.transform = 'scale(1)';
    });

    // ===== VALIDAÇÃO DO FORMULÁRIO =====
    form.addEventListener('submit', function(e) {
        if (!amountHidden.value || parseFloat(amountHidden.value) <= 0) {
            e.preventDefault();
            alert('⚠️ Digite um valor válido para a recarga!');
            amountDisplay.focus();
            amountDisplay.style.borderColor = 'var(--danger)';
            amountDisplay.style.animation = 'shake 0.5s';
            
            setTimeout(() => {
                amountDisplay.style.borderColor = '';
                amountDisplay.style.animation = '';
            }, 500);
            return;
        }

        // Feedback visual de loading
        submitBtn.disabled = true;
        submitBtn.innerHTML = '⏳ Processando...';
    });

    // ===== FEEDBACK VISUAL NOS INPUTS =====
    amountDisplay.addEventListener('invalid', function(e) {
        e.preventDefault();
        this.style.borderColor = 'var(--danger)';
        this.style.animation = 'shake 0.5s';
    });

    amountDisplay.addEventListener('input', function() {
        this.style.borderColor = '';
        this.style.animation = '';
    });

    // ===== PREVINE ZOOM EM iOS =====
    if (/iPhone|iPad|iPod/i.test(navigator.userAgent)) {
        const viewport = document.querySelector('meta[name="viewport"]');
        if (viewport) {
            viewport.content = 'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no';
        }
    }

    // ===== ADICIONA CLASSE AO BODY QUANDO EM MODO PWA =====
    if (window.matchMedia('(display-mode: standalone)').matches) {
        document.body.classList.add('pwa-mode');
    }

    // ===== FOCUS AUTOMÁTICO NO CAMPO DE VALOR =====
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(() => {
            amountDisplay.focus();
        }, 300);
    });
</script>

<?php include VIEWS . '/layouts/footer.php'; ?>