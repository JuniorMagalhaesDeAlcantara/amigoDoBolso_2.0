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
        max-width: 820px;
        margin: 0 auto;
        padding: 2rem;
    }

    /* ========== CARD ========== */
    .card {
        background: white;
        border-radius: 16px;
        padding: 2.5rem;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--gray-200);
    }

    /* ========== FORM HEADER ========== */
    .form-header {
        margin-bottom: 2.5rem;
        text-align: center;
        padding-bottom: 1.5rem;
        border-bottom: 2px solid var(--gray-100);
    }

    .form-header h2 {
        font-size: 2rem;
        font-weight: 700;
        color: var(--gray-900);
        margin-bottom: 0.625rem;
        line-height: 1.2;
    }

    .form-header p {
        color: var(--gray-500);
        font-size: 1rem;
        line-height: 1.5;
    }

    /* ========== FORM GROUPS ========== */
    .form-group {
        margin-bottom: 1.75rem;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.25rem;
        margin-bottom: 1.75rem;
    }

    label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9375rem;
        font-weight: 600;
        color: var(--gray-700);
        margin-bottom: 0.625rem;
        line-height: 1.4;
    }

    label svg {
        color: var(--primary);
        flex-shrink: 0;
    }

    input[type="text"],
    input[type="date"] {
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

    input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.12);
        background: var(--gray-50);
    }

    input::placeholder {
        color: var(--gray-400);
    }

    small {
        display: block;
        margin-top: 0.625rem;
        color: var(--gray-500);
        font-size: 0.8125rem;
        line-height: 1.5;
    }

    /* ========== CALCULATION CARD ========== */
    .calculation-card {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.08) 0%, rgba(139, 92, 246, 0.05) 100%);
        border: 2px solid var(--primary);
        border-radius: 16px;
        padding: 2rem;
        margin: 2rem 0;
        animation: fadeIn 0.4s ease-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .calculation-card h3 {
        display: flex;
        align-items: center;
        gap: 0.625rem;
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 1.5rem;
    }

    .calculation-card h3 svg {
        flex-shrink: 0;
    }

    .calculation-results {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.25rem;
        margin-bottom: 1.25rem;
    }

    .calc-item {
        background: white;
        padding: 1.25rem;
        border-radius: 12px;
        text-align: center;
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
    }

    .calc-item:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .calc-item.highlight {
        grid-column: 1 / -1;
        background: linear-gradient(135deg, var(--primary) 0%, #764ba2 100%);
        color: white;
        padding: 1.75rem;
        box-shadow: 0 8px 24px rgba(102, 126, 234, 0.3);
    }

    .calc-label {
        font-size: 0.75rem;
        color: var(--gray-500);
        margin-bottom: 0.625rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 700;
    }

    .calc-item.highlight .calc-label {
        color: rgba(255, 255, 255, 0.95);
        font-size: 0.8125rem;
    }

    .calc-value {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--gray-900);
        line-height: 1;
    }

    .calc-value-large {
        font-size: 2.25rem;
        font-weight: 900;
        color: white;
        line-height: 1;
    }

    .calc-tip {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem 1.25rem;
        background: white;
        border-radius: 10px;
        font-size: 0.875rem;
        color: var(--gray-600);
        line-height: 1.5;
        box-shadow: var(--shadow-sm);
    }

    .calc-tip svg {
        color: var(--info);
        flex-shrink: 0;
    }

    /* ========== EXAMPLES CARD ========== */
    .examples-card {
        background: linear-gradient(135deg, var(--gray-50) 0%, white 100%);
        padding: 1.75rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        border: 1px solid var(--gray-200);
    }

    .examples-card h4 {
        font-size: 1rem;
        font-weight: 700;
        color: var(--gray-700);
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .examples-list {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 0.875rem;
    }

    .example-btn {
        padding: 0.875rem 1.25rem;
        background: white;
        border: 2px solid var(--gray-200);
        border-radius: 10px;
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--gray-700);
        cursor: pointer;
        transition: var(--transition);
        font-family: inherit;
        text-align: left;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .example-btn:hover {
        border-color: var(--primary);
        color: var(--primary);
        background: rgba(102, 126, 234, 0.05);
        transform: translateY(-2px);
        box-shadow: var(--shadow-sm);
    }

    .example-btn:active {
        transform: translateY(0);
    }

    /* ========== BUTTONS ========== */
    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2.5rem;
        padding-top: 2rem;
        border-top: 2px solid var(--gray-100);
    }

    .btn {
        flex: 1;
        padding: 1rem 1.75rem;
        border: none;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.625rem;
        transition: var(--transition);
        font-family: inherit;
    }

    .btn svg {
        flex-shrink: 0;
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
        background: var(--gray-50);
        border-color: var(--gray-300);
    }

    /* ========== RESPONSIVE - TABLET ========== */
    @media (max-width: 1024px) {
        .container-small {
            padding: 1.5rem;
        }

        .card {
            padding: 2rem;
        }

        .form-header h2 {
            font-size: 1.75rem;
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

        .form-header {
            margin-bottom: 2rem;
            padding-bottom: 1.25rem;
        }

        .form-header h2 {
            font-size: 1.5rem;
        }

        .form-header p {
            font-size: 0.9375rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-row {
            grid-template-columns: 1fr;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
        }

        label {
            font-size: 0.875rem;
        }

        input[type="text"],
        input[type="date"] {
            padding: 0.75rem 1rem;
            font-size: 16px; /* Previne zoom no iOS */
            border-radius: 10px;
        }

        .calculation-card {
            padding: 1.5rem;
            margin: 1.5rem 0;
            border-radius: 12px;
        }

        .calculation-card h3 {
            font-size: 1.125rem;
            margin-bottom: 1.25rem;
        }

        .calculation-results {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .calc-item {
            padding: 1rem;
        }

        .calc-item.highlight {
            grid-column: 1;
            padding: 1.5rem;
        }

        .calc-value {
            font-size: 1.375rem;
        }

        .calc-value-large {
            font-size: 2rem;
        }

        .calc-tip {
            padding: 0.875rem 1rem;
            font-size: 0.8125rem;
        }

        .examples-card {
            padding: 1.5rem;
        }

        .examples-card h4 {
            font-size: 0.9375rem;
        }

        .examples-list {
            grid-template-columns: 1fr;
            gap: 0.75rem;
        }

        .example-btn {
            padding: 0.75rem 1rem;
            font-size: 0.8125rem;
        }

        .form-actions {
            flex-direction: column;
            gap: 0.75rem;
            margin-top: 2rem;
            padding-top: 1.5rem;
        }

        .btn {
            width: 100%;
            padding: 1rem 1.5rem;
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

        .form-header h2 {
            font-size: 1.375rem;
        }

        .calculation-card h3 {
            font-size: 1rem;
        }

        .calc-value-large {
            font-size: 1.75rem;
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
        <div class="form-header">
            <h2>🎯 Nova Meta Financeira</h2>
            <p>Defina seu objetivo e acompanhe seu progresso</p>
        </div>

        <form method="POST" action="/metas/criar" id="goalForm">
            <div class="form-group">
                <label for="name">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                    </svg>
                    Nome da Meta *
                </label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    placeholder="Ex: Comprar um carro, Viajar para Europa, Entrada de apartamento"
                    required
                    autofocus>
                <small>Descreva seu objetivo de forma clara</small>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="target_amount">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                        </svg>
                        Valor Total (R$) *
                    </label>
                    <input 
                        type="text" 
                        id="target_amount" 
                        name="target_amount" 
                        placeholder="0,00"
                        required>
                    <small>Quanto você precisa juntar?</small>
                </div>

                <div class="form-group">
                    <label for="deadline">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                            <path d="M16 2v4M8 2v4M3 10h18"/>
                        </svg>
                        Prazo Final *
                    </label>
                    <input 
                        type="date" 
                        id="deadline" 
                        name="deadline" 
                        required
                        min="<?= date('Y-m-d', strtotime('+1 day')) ?>">
                    <small>Quando você quer atingir a meta?</small>
                </div>
            </div>

            <!-- Cálculo Automático -->
            <div class="calculation-card">
                <h3>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="4" y="2" width="16" height="20" rx="2" ry="2"/>
                        <line x1="8" y1="6" x2="16" y2="6"/>
                        <line x1="8" y1="10" x2="16" y2="10"/>
                        <line x1="8" y1="14" x2="16" y2="14"/>
                        <line x1="8" y1="18" x2="10" y2="18"/>
                    </svg>
                    Cálculo Automático
                </h3>
                
                <div class="calculation-results">
                    <div class="calc-item">
                        <div class="calc-label">Meses para atingir</div>
                        <div class="calc-value" id="monthsValue">-</div>
                    </div>
                    
                    <div class="calc-item highlight">
                        <div class="calc-label">Você precisa juntar por mês</div>
                        <div class="calc-value-large" id="monthlyValue">R$ 0,00</div>
                    </div>
                    
                    <div class="calc-item">
                        <div class="calc-label">Por dia (aproximado)</div>
                        <div class="calc-value" id="dailyValue">R$ 0,00</div>
                    </div>
                </div>

                <div class="calc-tip">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="16" x2="12" y2="12"/>
                        <line x1="12" y1="8" x2="12.01" y2="8"/>
                    </svg>
                    <span>Preencha o valor e o prazo para ver o cálculo automático</span>
                </div>
            </div>

            <!-- Exemplos -->
            <div class="examples-card">
                <h4>💡 Exemplos de metas:</h4>
                <div class="examples-list">
                    <button type="button" class="example-btn" onclick="fillExample(50000, 24, 'Comprar um carro')">
                        🚗 Carro R$ 50.000 em 24 meses
                    </button>
                    <button type="button" class="example-btn" onclick="fillExample(30000, 12, 'Viagem internacional')">
                        ✈️ Viagem R$ 30.000 em 12 meses
                    </button>
                    <button type="button" class="example-btn" onclick="fillExample(100000, 36, 'Entrada apartamento')">
                        🏠 Casa R$ 100.000 em 36 meses
                    </button>
                </div>
            </div>

            <div class="form-actions">
                <a href="/metas" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                        <polyline points="17 21 17 13 7 13 7 21"/>
                        <polyline points="7 3 7 8 15 8"/>
                    </svg>
                    Criar Meta
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Máscara de dinheiro
const targetAmountInput = document.getElementById('target_amount');

targetAmountInput.addEventListener('input', function(e) {
    let value = e.target.value;
    value = value.replace(/\D/g, '');
    value = (parseInt(value) / 100).toFixed(2);
    value = value.replace('.', ',');
    value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    e.target.value = value;
    
    calculateGoal();
});

document.getElementById('deadline').addEventListener('change', calculateGoal);

function calculateGoal() {
    const amountStr = targetAmountInput.value;
    const deadline = document.getElementById('deadline').value;
    
    if (!amountStr || !deadline) return;
    
    // Converte valor
    const amount = parseFloat(amountStr.replace(/\./g, '').replace(',', '.'));
    
    // Calcula meses
    const today = new Date();
    const endDate = new Date(deadline);
    const diffTime = Math.abs(endDate - today);
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    const months = Math.ceil(diffDays / 30);
    
    // Calcula valores
    const monthlyAmount = amount / months;
    const dailyAmount = amount / diffDays;
    
    // Atualiza UI
    document.getElementById('monthsValue').textContent = months + (months === 1 ? ' mês' : ' meses');
    document.getElementById('monthlyValue').textContent = 'R$ ' + monthlyAmount.toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    document.getElementById('dailyValue').textContent = 'R$ ' + dailyAmount.toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}

function fillExample(amount, months, name) {
    document.getElementById('name').value = name;
    
    // Formata e preenche o valor
    const formatted = amount.toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    targetAmountInput.value = formatted;
    
    // Calcula data
    const deadline = new Date();
    deadline.setMonth(deadline.getMonth() + months);
    document.getElementById('deadline').value = deadline.toISOString().split('T')[0];
    
    calculateGoal();
}

// Converter formato antes de enviar
document.getElementById('goalForm').addEventListener('submit', function(e) {
    const value = targetAmountInput.value.replace(/\./g, '').replace(',', '.');
    targetAmountInput.value = value;
});

// Previne zoom em iOS ao focar inputs
if (/iPhone|iPad|iPod/i.test(navigator.userAgent)) {
    const inputs = document.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.style.fontSize = '16px';
        });
    });
}
</script>

<?php include VIEWS . '/layouts/footer.php'; ?>