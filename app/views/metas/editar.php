<?php include VIEWS . '/layouts/header.php'; ?>

<div class="container-small">
    <div class="card">
        <div class="form-header">
            <h2>✏️ Editar Meta Financeira</h2>
            <p>Atualize as informações da sua meta</p>
        </div>

        <form method="POST" action="/metas/editar/<?= $goal['id'] ?>" id="goalEditForm">
            <div class="form-group">
                <label for="name">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                    </svg>
                    Nome da Meta *
                </label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="<?= htmlspecialchars($goal['name']) ?>"
                    required
                    autofocus>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="target_amount">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                        </svg>
                        Valor Total (R$) *
                    </label>
                    <input 
                        type="text" 
                        id="target_amount" 
                        name="target_amount" 
                        value="<?= number_format($goal['target_amount'], 2, ',', '.') ?>"
                        required>
                    <small>Valor total da meta</small>
                </div>

                <div class="form-group">
                    <label for="deadline">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                            <path d="M16 2v4M8 2v4M3 10h18"/>
                        </svg>
                        Prazo Final *
                    </label>
                    <input 
                        type="date" 
                        id="deadline" 
                        name="deadline" 
                        value="<?= $goal['deadline'] ?>"
                        required
                        min="<?= date('Y-m-d') ?>">
                </div>
            </div>

            <!-- Informações Atuais -->
            <div class="info-card">
                <h3>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <line x1="12" y1="16" x2="12" y2="12"/>
                        <line x1="12" y1="8" x2="12.01" y2="8"/>
                    </svg>
                    Progresso Atual
                </h3>
                
                <div class="info-stats">
                    <div class="info-stat">
                        <span class="info-label">Valor já depositado</span>
                        <span class="info-value">R$ <?= number_format($goal['current_amount'], 2, ',', '.') ?></span>
                    </div>
                    <div class="info-stat">
                        <span class="info-label">Percentual concluído</span>
                        <span class="info-value"><?= number_format(($goal['current_amount'] / $goal['target_amount']) * 100, 1) ?>%</span>
                    </div>
                </div>

                <div class="info-warning">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                        <line x1="12" y1="9" x2="12" y2="13"/>
                        <line x1="12" y1="17" x2="12.01" y2="17"/>
                    </svg>
                    <span>O valor já depositado não será alterado. Apenas as informações da meta.</span>
                </div>
            </div>

            <!-- Cálculo Atualizado -->
            <div class="calculation-card">
                <h3>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="4" y="2" width="16" height="20" rx="2" ry="2"/>
                        <line x1="8" y1="6" x2="16" y2="6"/>
                        <line x1="8" y1="10" x2="16" y2="10"/>
                        <line x1="8" y1="14" x2="16" y2="14"/>
                    </svg>
                    Novo Cálculo
                </h3>
                
                <div class="calculation-results">
                    <div class="calc-item">
                        <div class="calc-label">Falta depositar</div>
                        <div class="calc-value" id="remainingValue">-</div>
                    </div>
                    
                    <div class="calc-item">
                        <div class="calc-label">Meses restantes</div>
                        <div class="calc-value" id="monthsValue">-</div>
                    </div>
                    
                    <div class="calc-item highlight">
                        <div class="calc-label">Necessário por mês</div>
                        <div class="calc-value-large" id="monthlyValue">R$ 0,00</div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="/metas" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                        <polyline points="17 21 17 13 7 13 7 21"/>
                        <polyline points="7 3 7 8 15 8"/>
                    </svg>
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>
</div>

<script>
const currentAmount = <?= $goal['current_amount'] ?>;
const targetAmountInput = document.getElementById('target_amount');
const deadlineInput = document.getElementById('deadline');

// Máscara de dinheiro
targetAmountInput.addEventListener('input', function(e) {
    let value = e.target.value;
    value = value.replace(/\D/g, '');
    
    if (!value) {
        e.target.value = '';
        calculateGoal();
        return;
    }
    
    const numberValue = parseInt(value) / 100;
    const formatted = numberValue.toLocaleString('pt-BR', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
    
    e.target.value = formatted;
    calculateGoal();
});

deadlineInput.addEventListener('change', calculateGoal);

function calculateGoal() {
    const amountStr = targetAmountInput.value;
    const deadline = deadlineInput.value;
    
    if (!amountStr || !deadline) return;
    
    // Converte valor
    const targetAmount = parseFloat(amountStr.replace(/\./g, '').replace(',', '.'));
    const remaining = Math.max(0, targetAmount - currentAmount);
    
    // Calcula meses
    const today = new Date();
    const endDate = new Date(deadline);
    const diffTime = Math.abs(endDate - today);
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    const months = Math.max(1, Math.ceil(diffDays / 30));
    
    // Calcula valores
    const monthlyAmount = remaining / months;
    
    // Atualiza UI
    document.getElementById('remainingValue').textContent = 'R$ ' + remaining.toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    document.getElementById('monthsValue').textContent = months + (months === 1 ? ' mês' : ' meses');
    document.getElementById('monthlyValue').textContent = 'R$ ' + monthlyAmount.toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}

// Calcular ao carregar
calculateGoal();

// Converter formato antes de enviar
document.getElementById('goalEditForm').addEventListener('submit', function(e) {
    const value = targetAmountInput.value.replace(/\./g, '').replace(',', '.');
    targetAmountInput.value = value;
});
</script>

<style>
.container-small {
    max-width: 800px;
    margin: 2rem auto;
    padding: 0 1rem;
}

.card {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.form-header {
    margin-bottom: 2rem;
    text-align: center;
}

.form-header h2 {
    font-size: 1.75rem;
    font-weight: 700;
    color: var(--gray-900);
    margin-bottom: 0.5rem;
}

.form-header p {
    color: var(--gray-500);
    font-size: 1rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9375rem;
    font-weight: 600;
    color: var(--gray-700);
    margin-bottom: 0.5rem;
}

label svg {
    color: var(--primary);
}

input[type="text"],
input[type="date"] {
    width: 100%;
    padding: 0.875rem 1rem;
    border: 2px solid var(--gray-200);
    border-radius: 10px;
    font-size: 0.9375rem;
    transition: all 0.2s;
}

input:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
}

small {
    display: block;
    margin-top: 0.5rem;
    color: var(--gray-500);
    font-size: 0.8125rem;
}

/* Info Card */
.info-card {
    background: rgba(59, 130, 246, 0.05);
    border: 2px solid #3b82f6;
    border-radius: 12px;
    padding: 1.5rem;
    margin: 2rem 0;
}

.info-card h3 {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1.125rem;
    font-weight: 700;
    color: #3b82f6;
    margin-bottom: 1.25rem;
}

.info-stats {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    margin-bottom: 1rem;
}

.info-stat {
    background: white;
    padding: 1rem;
    border-radius: 8px;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.info-label {
    font-size: 0.75rem;
    color: var(--gray-500);
    font-weight: 500;
}

.info-value {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--gray-900);
}

.info-warning {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.875rem;
    background: white;
    border-radius: 8px;
    font-size: 0.875rem;
    color: var(--gray-600);
}

.info-warning svg {
    color: #3b82f6;
    flex-shrink: 0;
}

/* Calculation Card */
.calculation-card {
    background: linear-gradient(135deg, rgba(79, 70, 229, 0.05) 0%, rgba(139, 92, 246, 0.05) 100%);
    border: 2px solid var(--primary);
    border-radius: 12px;
    padding: 1.5rem;
    margin: 2rem 0;
}

.calculation-card h3 {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--primary);
    margin-bottom: 1.25rem;
}

.calculation-results {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
    gap: 1rem;
}

.calc-item {
    background: white;
    padding: 1rem;
    border-radius: 10px;
    text-align: center;
}

.calc-item.highlight {
    grid-column: 1 / -1;
    background: var(--primary);
    color: white;
}

.calc-label {
    font-size: 0.75rem;
    color: var(--gray-500);
    margin-bottom: 0.5rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 600;
}

.calc-item.highlight .calc-label {
    color: rgba(255, 255, 255, 0.9);
}

.calc-value {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--gray-900);
}

.calc-value-large {
    font-size: 1.75rem;
    font-weight: 800;
    color: white;
}

/* Actions */
.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
}

.btn {
    flex: 1;
    padding: 0.875rem 1.5rem;
    border: none;
    border-radius: 10px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: all 0.3s;
}

.btn-primary {
    background: var(--primary);
    color: white;
}

.btn-primary:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(79, 70, 229, 0.3);
}

.btn-secondary {
    background: var(--gray-100);
    color: var(--gray-700);
}

.btn-secondary:hover {
    background: var(--gray-200);
}

/* Responsive */
@media (max-width: 768px) {
    .form-row,
    .info-stats,
    .calculation-results {
        grid-template-columns: 1fr;
    }
    
    .calc-item.highlight {
        grid-column: 1;
    }
    
    .form-actions {
        flex-direction: column;
    }
}
</style>

<?php include VIEWS . '/layouts/footer.php'; ?>