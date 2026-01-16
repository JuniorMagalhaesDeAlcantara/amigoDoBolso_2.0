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

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.02); }
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

    /* ========== COLOR INPUT ========== */
    .form-group input[type="color"] {
        height: 56px;
        cursor: pointer;
        padding: 0.375rem;
        transition: var(--transition);
    }

    .form-group input[type="color"]::-webkit-color-swatch-wrapper {
        padding: 0;
    }

    .form-group input[type="color"]::-webkit-color-swatch {
        border: 3px solid white;
        border-radius: 8px;
        box-shadow: 0 0 0 1px var(--gray-300);
    }

    .form-group input[type="color"]:hover::-webkit-color-swatch {
        box-shadow: 0 0 0 2px var(--primary);
    }

    .form-group input[type="color"]:focus {
        transform: scale(1.02);
    }

    /* ========== COLOR PREVIEW ========== */
    .color-preview-wrapper {
        position: relative;
    }

    .color-preview-label {
        position: absolute;
        top: 50%;
        right: 1rem;
        transform: translateY(-50%);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        background: white;
        padding: 0.375rem 0.75rem;
        border-radius: 8px;
        font-size: 0.8125rem;
        font-weight: 600;
        color: var(--gray-600);
        pointer-events: none;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .color-preview-dot {
        width: 20px;
        height: 20px;
        border-radius: 6px;
        border: 2px solid white;
        box-shadow: 0 0 0 1px var(--gray-300);
        transition: var(--transition);
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

        .form-actions {
            flex-direction: column;
        }

        .form-actions .btn {
            width: 100%;
        }

        .info-box {
            padding: 1rem 1.25rem;
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

        .form-group input[type="color"] {
            height: 50px;
        }

        .color-preview-label {
            font-size: 0.75rem;
            padding: 0.25rem 0.625rem;
        }

        .color-preview-dot {
            width: 16px;
            height: 16px;
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
        *,
        *::before,
        *::after {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
    }
</style>

<div class="container-small">
    <div class="card">
        <h2>🏷️ Nova Categoria</h2>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                ⚠️ <?= $_SESSION['error'] ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form method="POST" action="/categorias/criar" id="categoryForm">
            <div class="form-group">
                <label for="name">📝 Nome da Categoria *</label>
                <input type="text" 
                    id="name" 
                    name="name" 
                    placeholder="Ex: Delivery, Pets, Transporte" 
                    required
                    maxlength="50">
            </div>

            <div class="form-group">
                <label for="type">💰 Tipo *</label>
                <select name="type" id="type" required>
                    <option value="despesa">💸 Despesa</option>
                    <option value="receita">💚 Receita</option>
                </select>
            </div>

            <div class="form-group">
                <label for="color">🎨 Cor</label>
                <div class="color-preview-wrapper">
                    <input type="color" 
                        id="color" 
                        name="color" 
                        value="#667eea">
                    <div class="color-preview-label">
                        <div class="color-preview-dot" id="colorPreview"></div>
                        <span id="colorHex">#667eea</span>
                    </div>
                </div>
            </div>

            <hr>

            <div class="info-box">
                <span class="info-icon">💡</span>
                <div>
                    <strong>Dica:</strong>
                    <ul>
                        <li>Use nomes curtos e descritivos para facilitar a identificação</li>
                        <li>Escolha cores que ajudem a diferenciar visualmente as categorias</li>
                        <li>Você pode editar ou excluir categorias personalizadas a qualquer momento</li>
                    </ul>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">💾 Salvar Categoria</button>
                <a href="/transacoes/criar" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<script>
    const form = document.getElementById('categoryForm');
    const submitBtn = form.querySelector('.btn-primary');
    const nameInput = document.getElementById('name');
    const typeSelect = document.getElementById('type');
    const colorInput = document.getElementById('color');
    const colorPreview = document.getElementById('colorPreview');
    const colorHex = document.getElementById('colorHex');

    // ===== ATUALIZAÇÃO DO PREVIEW DE COR =====
    function updateColorPreview() {
        const color = colorInput.value;
        colorPreview.style.backgroundColor = color;
        colorHex.textContent = color.toUpperCase();
    }

    colorInput.addEventListener('input', updateColorPreview);
    
    // Inicializa preview
    updateColorPreview();

    // ===== VALIDAÇÃO DO FORMULÁRIO =====
    form.addEventListener('submit', function(e) {
        const name = nameInput.value.trim();
        
        if (!name) {
            e.preventDefault();
            alert('⚠️ Digite um nome para a categoria!');
            nameInput.focus();
            nameInput.style.borderColor = 'var(--danger)';
            nameInput.style.animation = 'shake 0.5s';
            
            setTimeout(() => {
                nameInput.style.borderColor = '';
                nameInput.style.animation = '';
            }, 500);
            return;
        }

        if (name.length < 2) {
            e.preventDefault();
            alert('⚠️ O nome deve ter pelo menos 2 caracteres!');
            nameInput.focus();
            nameInput.style.borderColor = 'var(--danger)';
            nameInput.style.animation = 'shake 0.5s';
            
            setTimeout(() => {
                nameInput.style.borderColor = '';
                nameInput.style.animation = '';
            }, 500);
            return;
        }

        // Feedback visual de loading
        submitBtn.disabled = true;
        submitBtn.innerHTML = '⏳ Salvando...';
    });

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

    // ===== CAPITALIZA PRIMEIRA LETRA AO DIGITAR =====
    nameInput.addEventListener('blur', function() {
        const value = this.value.trim();
        if (value) {
            this.value = value.charAt(0).toUpperCase() + value.slice(1);
        }
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

    // ===== SUGESTÕES DE CORES POR TIPO =====
    const colorSuggestions = {
        despesa: ['#ef4444', '#f59e0b', '#ec4899', '#8b5cf6', '#667eea'],
        receita: ['#10b981', '#14b8a6', '#06b6d4', '#3b82f6', '#6366f1']
    };

    typeSelect.addEventListener('change', function() {
        const type = this.value;
        const suggestions = colorSuggestions[type];
        
        if (suggestions && colorInput.value === '#667eea') {
            // Seleciona cor aleatória das sugestões
            const randomColor = suggestions[Math.floor(Math.random() * suggestions.length)];
            colorInput.value = randomColor;
            updateColorPreview();
            
            // Pequena animação
            colorInput.style.animation = 'pulse 0.5s';
            setTimeout(() => {
                colorInput.style.animation = '';
            }, 500);
        }
    });

    // ===== ADICIONA CLASSE AO BODY QUANDO EM MODO PWA =====
    if (window.matchMedia('(display-mode: standalone)').matches) {
        document.body.classList.add('pwa-mode');
    }

    // ===== AUTO-FOCUS NO PRIMEIRO CAMPO =====
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(() => {
            nameInput.focus();
        }, 300);
    });
</script>

<?php include VIEWS . '/layouts/footer.php'; ?>