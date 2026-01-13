<?php include VIEWS . '/layouts/header.php'; ?>

<div class="container">
    <div class="page-header">
        <div class="header-content">
            <div class="header-title">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                    <polyline points="22 4 12 14.01 9 11.01" />
                </svg>
                <div>
                    <h1>Metas Financeiras</h1>
                    <p class="subtitle">Planeje e acompanhe seus objetivos</p>
                </div>
            </div>
            <a href="/metas/criar" class="btn btn-primary">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 5v14M5 12h14" />
                </svg>
                Nova Meta
            </a>
        </div>
    </div>

    <?php if (empty($goals)): ?>
        <div class="card">
            <div class="empty-state">
                <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" opacity="0.3">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                    <polyline points="22 4 12 14.01 9 11.01" />
                </svg>
                <h3>Nenhuma meta cadastrada</h3>
                <p>Crie sua primeira meta financeira e comece a realizar seus sonhos!</p>
                <a href="/metas/criar" class="btn btn-primary btn-empty">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 5v14M5 12h14" />
                    </svg>
                    Criar primeira meta
                </a>
            </div>
        </div>
    <?php else: ?>
        <div class="goals-grid">
            <?php foreach ($goals as $goal):
                $progress = $goal['progress'];
                $percentage = $progress['percentage'];
                $remaining = $progress['remaining'];
                $daysRemaining = $progress['days_remaining'];
                $isOverdue = $progress['is_overdue'];

                // Calcula valor mensal necessário
                $monthsRemaining = max(1, ceil($daysRemaining / 30));
                $monthlyNeeded = $remaining / $monthsRemaining;

                // Define cor do progresso
                if ($percentage >= 100) {
                    $progressColor = '#10b981';
                    $statusClass = 'completed';
                    $statusText = 'Concluída';
                } elseif ($isOverdue) {
                    $progressColor = '#ef4444';
                    $statusClass = 'overdue';
                    $statusText = 'Atrasada';
                } elseif ($percentage >= 75) {
                    $progressColor = '#3b82f6';
                    $statusClass = 'on-track';
                    $statusText = 'No caminho';
                } else {
                    $progressColor = '#f59e0b';
                    $statusClass = 'in-progress';
                    $statusText = 'Em andamento';
                }
            ?>
                <div class="goal-card <?= $statusClass ?>">
                    <div class="goal-header">
                        <div class="goal-title-section">
                            <h3 class="goal-name"><?= htmlspecialchars($goal['name']) ?></h3>
                            <span class="goal-status" style="background: <?= $progressColor ?>">
                                <?= $statusText ?>
                            </span>
                        </div>

                        <div class="goal-amount">
                            <div class="amount-label">Meta</div>
                            <div class="amount-value">R$ <?= number_format($goal['target_amount'], 2, ',', '.') ?></div>
                        </div>
                    </div>

                    <div class="goal-progress-section">
                        <div class="progress-header">
                            <div class="progress-label">
                                <span class="current-amount">R$ <?= number_format($goal['current_amount'], 2, ',', '.') ?></span>
                                <span class="progress-text">de R$ <?= number_format($goal['target_amount'], 2, ',', '.') ?></span>
                            </div>
                            <span class="progress-percentage"><?= number_format($percentage, 1) ?>%</span>
                        </div>

                        <div class="progress-bar-wrapper">
                            <div class="progress-bar-bg">
                                <div class="progress-bar-fill" style="width: <?= min(100, $percentage) ?>%; background: <?= $progressColor ?>"></div>
                            </div>
                        </div>
                    </div>

                    <div class="goal-stats">
                        <div class="stat-card">
                            <div class="stat-icon" style="background: rgba(239, 68, 68, 0.1); color: #ef4444">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                                </svg>
                            </div>
                            <div class="stat-content">
                                <div class="stat-label">Falta</div>
                                <div class="stat-value">R$ <?= number_format($remaining, 2, ',', '.') ?></div>
                            </div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-icon" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                    <path d="M16 2v4M8 2v4M3 10h18" />
                                </svg>
                            </div>
                            <div class="stat-content">
                                <div class="stat-label">Prazo</div>
                                <div class="stat-value"><?= $daysRemaining ?> dias</div>
                            </div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                                </svg>
                            </div>
                            <div class="stat-content">
                                <div class="stat-label">Por mês</div>
                                <div class="stat-value">R$ <?= number_format($monthlyNeeded, 2, ',', '.') ?></div>
                            </div>
                        </div>
                    </div>

                    <?php if ($isOverdue && $percentage < 100): ?>
                        <div class="alert alert-warning">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                                <line x1="12" y1="9" x2="12" y2="13" />
                                <line x1="12" y1="17" x2="12.01" y2="17" />
                            </svg>
                            <span>Meta em atraso! O prazo expirou em <?= date('d/m/Y', strtotime($goal['deadline'])) ?></span>
                        </div>
                    <?php endif; ?>

                    <div class="goal-actions">
                        <button class="btn-action btn-deposit" onclick="openDepositModal(<?= $goal['id'] ?>, '<?= htmlspecialchars($goal['name']) ?>')">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 5v14M5 12h14" />
                            </svg>
                            Depositar
                        </button>
                        <button class="btn-action btn-withdraw" onclick="openWithdrawModal(<?= $goal['id'] ?>, '<?= htmlspecialchars($goal['name']) ?>', <?= $goal['current_amount'] ?>)">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14" />
                            </svg>
                            Retirar
                        </button>
                        <a href="/metas/editar/<?= $goal['id'] ?>" class="btn-action btn-edit">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                            </svg>
                            Editar
                        </a>
                        <a href="/metas/deletar/<?= $goal['id'] ?>"
                            class="btn-action btn-delete-action"
                            onclick="return confirm('Tem certeza que deseja deletar esta meta?')">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="3 6 5 6 21 6" />
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                            </svg>
                            Excluir
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Modal de Depósito -->
<div id="depositModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>💰 Depositar na Meta</h2>
            <button class="modal-close" onclick="closeDepositModal()">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                </svg>
            </button>
        </div>

        <form method="POST" id="depositForm">
            <p class="modal-description">Meta: <strong id="goalNameDeposit"></strong></p>

            <div class="form-group">
                <label for="depositAmount">Valor a depositar (R$)</label>
                <input
                    type="text"
                    id="depositAmount"
                    name="amount"
                    placeholder="R$ 0,00"
                    required>
                <small>Digite o valor que deseja adicionar à meta</small>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn btn-secondary" onclick="closeDepositModal()">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                    Cancelar
                </button>
                <button type="submit" class="btn btn-success">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                    Confirmar Depósito
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal de Retirada -->
<div id="withdrawModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>📤 Retirar da Meta</h2>
            <button class="modal-close" onclick="closeWithdrawModal()">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18" />
                    <line x1="6" y1="6" x2="18" y2="18" />
                </svg>
            </button>
        </div>

        <form method="POST" id="withdrawForm">
            <p class="modal-description">Meta: <strong id="goalNameWithdraw"></strong></p>
            <p class="modal-description">Saldo disponível: <strong id="availableBalance">R$ 0,00</strong></p>

            <div class="form-group">
                <label for="withdrawAmount">Valor a retirar (R$)</label>
                <input
                    type="text"
                    id="withdrawAmount"
                    name="amount"
                    placeholder="R$ 0,00"
                    required>
                <small>Digite o valor que deseja retirar da meta</small>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn btn-secondary" onclick="closeWithdrawModal()">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="18" y1="6" x2="6" y2="18" />
                        <line x1="6" y1="6" x2="18" y2="18" />
                    </svg>
                    Cancelar
                </button>
                <button type="submit" class="btn btn-warning">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                    Confirmar Retirada
                </button>
            </div>
        </form>
    </div>
</div>

<script>
let currentGoalId = null;
let currentBalance = 0;

function openDepositModal(goalId, goalName) {
    currentGoalId = goalId;
    document.getElementById('goalNameDeposit').textContent = goalName;
    document.getElementById('depositForm').action = '/metas/addProgress/' + goalId;
    document.getElementById('depositModal').style.display = 'flex';
    document.getElementById('depositAmount').value = '';
    document.getElementById('depositAmount').focus();
}

function closeDepositModal() {
    document.getElementById('depositModal').style.display = 'none';
    document.getElementById('depositAmount').value = '';
}

function openWithdrawModal(goalId, goalName, balance) {
    currentGoalId = goalId;
    currentBalance = balance;
    document.getElementById('goalNameWithdraw').textContent = goalName;
    document.getElementById('availableBalance').textContent = 'R$ ' + balance.toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    document.getElementById('withdrawForm').action = '/metas/removeProgress/' + goalId;
    document.getElementById('withdrawModal').style.display = 'flex';
    document.getElementById('withdrawAmount').value = '';
    document.getElementById('withdrawAmount').focus();
}

function closeWithdrawModal() {
    document.getElementById('withdrawModal').style.display = 'none';
    document.getElementById('withdrawAmount').value = '';
}

// Máscara de dinheiro simplificada
function formatMoney(input) {
    let value = input.value.replace(/\D/g, ''); // Remove tudo que não é número
    
    if (!value) {
        input.value = '';
        return;
    }
    
    // Converte centavos para reais
    value = (parseInt(value) / 100).toFixed(2);
    
    // Formata: 1.00 -> 1,00 -> R$ 1,00
    value = value.replace('.', ',');
    value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    
    input.value = 'R$ ' + value;
}

// Converte valor formatado para número
function parseMoneyValue(formattedValue) {
    // Remove "R$ ", pontos de milhar e substitui vírgula por ponto
    let value = formattedValue
        .replace('R$', '')
        .replace(/\s/g, '')
        .replace(/\./g, '')
        .replace(',', '.');
    
    return parseFloat(value);
}

// Eventos para os inputs
document.getElementById('depositAmount').addEventListener('input', function() {
    formatMoney(this);
});

document.getElementById('withdrawAmount').addEventListener('input', function() {
    formatMoney(this);
});

// Submit do formulário de depósito
document.getElementById('depositForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Previne envio padrão
    
    const input = document.getElementById('depositAmount');
    const displayValue = input.value;
    
    if (!displayValue || displayValue === 'R$ 0,00' || displayValue === '') {
        alert('Digite um valor válido!');
        return;
    }
    
    const numValue = parseMoneyValue(displayValue);
    
    if (isNaN(numValue) || numValue <= 0) {
        alert('Digite um valor válido!');
        return;
    }
    
    // Cria um formulário temporário com o valor correto
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = this.action;
    
    const amountInput = document.createElement('input');
    amountInput.type = 'hidden';
    amountInput.name = 'amount';
    amountInput.value = numValue.toFixed(2);
    
    form.appendChild(amountInput);
    document.body.appendChild(form);
    form.submit();
});

// Submit do formulário de retirada
document.getElementById('withdrawForm').addEventListener('submit', function(e) {
    e.preventDefault(); // Previne envio padrão
    
    const input = document.getElementById('withdrawAmount');
    const displayValue = input.value;
    
    if (!displayValue || displayValue === 'R$ 0,00' || displayValue === '') {
        alert('Digite um valor válido!');
        return;
    }
    
    const numValue = parseMoneyValue(displayValue);
    
    if (isNaN(numValue) || numValue <= 0) {
        alert('Digite um valor válido!');
        return;
    }
    
    // Valida se não excede o saldo
    if (numValue > currentBalance) {
        alert('Valor de retirada não pode ser maior que o saldo disponível!\n\nDisponível: R$ ' + currentBalance.toFixed(2).replace('.', ','));
        return;
    }
    
    // Cria um formulário temporário com o valor correto
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = this.action;
    
    const amountInput = document.createElement('input');
    amountInput.type = 'hidden';
    amountInput.name = 'amount';
    amountInput.value = numValue.toFixed(2);
    
    form.appendChild(amountInput);
    document.body.appendChild(form);
    form.submit();
});

// Fechar modal ao clicar fora
window.onclick = function(event) {
    const depositModal = document.getElementById('depositModal');
    const withdrawModal = document.getElementById('withdrawModal');
    
    if (event.target == depositModal) {
        closeDepositModal();
    }
    if (event.target == withdrawModal) {
        closeWithdrawModal();
    }
}
</script>

<style>
    /* Page Header */
    .page-header {
        margin-bottom: 2rem;
    }

    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1.5rem;
    }

    .header-title {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .header-title svg {
        color: var(--primary);
        flex-shrink: 0;
    }

    .header-title h1 {
        font-size: 2rem;
        font-weight: 700;
        color: var(--gray-900);
        margin: 0;
    }

    .subtitle {
        font-size: 0.9375rem;
        color: var(--gray-500);
        margin: 0.25rem 0 0 0;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-state svg {
        margin-bottom: 1.5rem;
    }

    .empty-state h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--gray-900);
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        font-size: 0.9375rem;
        color: var(--gray-500);
        margin-bottom: 2rem;
    }

    .btn-empty {
        display: inline-flex;
    }

    /* Goals Grid */
    .goals-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
        gap: 1.5rem;
    }

    .goal-card {
        background: white;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        transition: all 0.3s;
        border-left: 4px solid var(--primary);
    }

    .goal-card.completed {
        border-left-color: #10b981;
    }

    .goal-card.overdue {
        border-left-color: #ef4444;
    }

    .goal-card.on-track {
        border-left-color: #3b82f6;
    }

    .goal-card:hover {
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        transform: translateY(-2px);
    }

    .goal-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1.5rem;
        gap: 1rem;
    }

    .goal-title-section {
        flex: 1;
    }

    .goal-name {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--gray-900);
        margin: 0 0 0.5rem 0;
    }

    .goal-status {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
        color: white;
    }

    .goal-amount {
        text-align: right;
    }

    .amount-label {
        font-size: 0.75rem;
        color: var(--gray-500);
        margin-bottom: 0.25rem;
    }

    .amount-value {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--primary);
    }

    /* Progress Section */
    .goal-progress-section {
        margin-bottom: 1.5rem;
    }

    .progress-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 0.75rem;
    }

    .progress-label {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .current-amount {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--gray-900);
    }

    .progress-text {
        font-size: 0.875rem;
        color: var(--gray-500);
    }

    .progress-percentage {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--primary);
    }

    .progress-bar-wrapper {
        margin-bottom: 0.5rem;
    }

    .progress-bar-bg {
        width: 100%;
        height: 12px;
        background: var(--gray-200);
        border-radius: 6px;
        overflow: hidden;
    }

    .progress-bar-fill {
        height: 100%;
        transition: width 0.5s ease;
        border-radius: 6px;
    }

    /* Stats */
    .goal-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }

    .stat-card {
        background: var(--gray-50);
        padding: 0.875rem;
        border-radius: 10px;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .stat-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        margin-bottom: 0.25rem;
    }

    .stat-content {
        flex: 1;
        min-width: 0;
    }

    .stat-label {
        font-size: 0.6875rem;
        color: var(--gray-500);
        margin-bottom: 0.25rem;
        font-weight: 500;
    }

    .stat-value {
        font-size: 0.875rem;
        font-weight: 700;
        color: var(--gray-900);
        word-break: break-word;
        line-height: 1.3;
    }

    /* Alert */
    .alert-warning {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.875rem 1rem;
        background: #fef3c7;
        border: 1px solid #fbbf24;
        border-radius: 8px;
        color: #92400e;
        font-size: 0.875rem;
        margin-bottom: 1rem;
    }

    .alert-warning svg {
        flex-shrink: 0;
    }

    /* Actions */
    .goal-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.625rem;
    }

    .btn-action {
        padding: 0.75rem 1rem;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.8125rem;
        cursor: pointer;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.2s;
    }

    .btn-deposit {
        background: #10b981;
        color: white;
        border: 2px solid #10b981;
    }

    .btn-deposit:hover {
        background: #059669;
        border-color: #059669;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
    }

    .btn-withdraw {
        background: white;
        color: #f59e0b;
        border: 2px solid #f59e0b;
    }

    .btn-withdraw:hover {
        background: #f59e0b;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
    }

    .btn-edit {
        background: white;
        color: #3b82f6;
        border: 2px solid #3b82f6;
    }

    .btn-edit:hover {
        background: #3b82f6;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }

    .btn-delete-action {
        background: white;
        color: #ef4444;
        border: 2px solid #ef4444;
    }

    .btn-delete-action:hover {
        background: #ef4444;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    /* Modal */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }

    .modal-content {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        max-width: 480px;
        width: 100%;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .modal-header h2 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--gray-900);
        margin: 0;
    }

    .modal-close {
        background: none;
        border: none;
        color: var(--gray-400);
        cursor: pointer;
        padding: 0.5rem;
        display: flex;
        transition: color 0.2s;
    }

    .modal-close:hover {
        color: var(--gray-600);
    }

    .modal-description {
        color: var(--gray-600);
        margin-bottom: 1.5rem;
    }

    .modal-actions {
        display: flex;
        gap: 0.75rem;
        margin-top: 1.5rem;
    }

    .modal-actions .btn {
        flex: 1;
        padding: 0.875rem 1.5rem;
    }

    .btn-success {
        background: #10b981;
        color: white;
    }

    .btn-success:hover {
        background: #059669;
    }

    .btn-warning {
        background: #f59e0b;
        color: white;
    }

    .btn-warning:hover {
        background: #d97706;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .header-content {
            flex-direction: column;
            align-items: stretch;
        }

        .goals-grid {
            grid-template-columns: 1fr;
        }

        .goal-stats {
            grid-template-columns: 1fr;
        }

        .goal-actions {
            flex-direction: column;
        }
    }
</style>

<?php include VIEWS . '/layouts/footer.php'; ?>