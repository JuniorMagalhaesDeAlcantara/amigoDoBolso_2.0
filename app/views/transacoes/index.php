<?php include VIEWS . '/layouts/header.php'; ?>

<div class="container">
    <div class="page-header">
        <div class="header-content">
            <div class="header-title">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="2" y="4" width="20" height="16" rx="2" />
                    <path d="M2 10h20" />
                </svg>
                <div>
                    <h1>Transações</h1>
                    <p class="subtitle">Gerencie suas receitas e despesas</p>
                </div>
            </div>
            <a href="/transacoes/criar" class="btn btn-primary">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 5v14M5 12h14" />
                </svg>
                Nova Transação
            </a>
        </div>
    </div>

    <!-- Filtros -->
    <div class="filters-card">
        <form method="GET" action="/transacoes" class="filters-form">
            <div class="filter-group">
                <label for="month">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                        <path d="M16 2v4M8 2v4M3 10h18" />
                    </svg>
                    Mês
                </label>
                <select name="month" id="month" class="filter-select">
                    <?php
                    $meses = [
                        'Janeiro',
                        'Fevereiro',
                        'Março',
                        'Abril',
                        'Maio',
                        'Junho',
                        'Julho',
                        'Agosto',
                        'Setembro',
                        'Outubro',
                        'Novembro',
                        'Dezembro'
                    ];
                    for ($m = 1; $m <= 12; $m++):
                    ?>
                        <option value="<?= $m ?>" <?= $m == $month ? 'selected' : '' ?>>
                            <?= $meses[$m - 1] ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>

            <div class="filter-group">
                <label for="year">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                        <path d="M16 2v4M8 2v4M3 10h18" />
                    </svg>
                    Ano
                </label>
                <select name="year" id="year" class="filter-select">
                    <?php for ($y = date('Y') - 2; $y <= date('Y') + 1; $y++): ?>
                        <option value="<?= $y ?>" <?= $y == $year ? 'selected' : '' ?>>
                            <?= $y ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-filter">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 3H2l8 9.46V19l4 2v-8.54L22 3z" />
                </svg>
                Filtrar
            </button>
        </form>
    </div>

    <!-- Lista de Transações -->
    <div class="transactions-card">
        <?php if (empty($transactions)): ?>
            <div class="empty-state">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" opacity="0.3">
                    <circle cx="12" cy="12" r="10" />
                    <path d="M16 16s-1.5-2-4-2-4 2-4 2" />
                    <path d="M9 9h.01M15 9h.01" />
                </svg>
                <h3>Nenhuma transação encontrada</h3>
                <p>Não há transações neste período. Que tal adicionar uma?</p>
                <a href="/transacoes/criar" class="btn btn-primary btn-empty">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 5v14M5 12h14" />
                    </svg>
                    Criar primeira transação
                </a>
            </div>
        <?php else: ?>
            <div class="transactions-list">
                <?php foreach ($transactions as $transaction): ?>
                    <div class="transaction-item">
                        <!-- Ícone do Tipo -->
                        <div class="transaction-icon <?= $transaction['type'] ?>">
                            <?php if ($transaction['type'] === 'receita'): ?>
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <path d="M12 5v14M19 12l-7-7-7 7" />
                                </svg>
                            <?php else: ?>
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <path d="M12 19V5M5 12l7 7 7-7" />
                                </svg>
                            <?php endif; ?>
                        </div>

                        <!-- Conteúdo Principal -->
                        <div class="transaction-content">
                            <div class="transaction-main">
                                <!-- Título e Info -->
                                <div class="transaction-info">
                                    <h4><?= htmlspecialchars($transaction['description']) ?></h4>
                                    <div class="transaction-badges">
                                        <!-- Data -->
                                        <span class="badge badge-date">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                                <path d="M16 2v4M8 2v4M3 10h18" />
                                            </svg>
                                            <?= date('d/m', strtotime($transaction['transaction_date'])) ?>
                                        </span>

                                        <!-- Categoria -->
                                        <span class="badge badge-category" style="--cat-color: <?= $transaction['color'] ?>">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z" />
                                            </svg>
                                            <?= $transaction['category_name'] ?>
                                        </span>

                                        <!-- Forma de Pagamento -->
                                        <?php if ($transaction['payment_method'] === 'credito'): ?>
                                            <span class="badge badge-payment badge-credit">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <rect x="2" y="4" width="20" height="16" rx="2" />
                                                    <path d="M2 10h20" />
                                                </svg>

                                                <?php if (!empty($transaction['card_name'])): ?>
                                                    <?= $transaction['card_name'] ?>
                                                <?php else: ?>
                                                    Cartão de Crédito
                                                <?php endif; ?>

                                                <?php if ($transaction['installments'] > 1): ?>
                                                    <span class="installment-badge">
                                                        <?= $transaction['installment_number'] ?>/<?= $transaction['installments'] ?>x
                                                    </span>
                                                <?php endif; ?>
                                            </span>

                                        <?php elseif ($transaction['payment_method'] === 'va'): ?>
                                            <span class="badge badge-payment badge-va">
                                                🍽️ VA
                                            </span>

                                        <?php elseif ($transaction['payment_method'] === 'vr'): ?>
                                            <span class="badge badge-payment badge-vr">
                                                🛒 VR
                                            </span>

                                        <?php else: ?>
                                            <span class="badge badge-payment badge-cash">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                                                </svg>
                                                À vista
                                            </span>
                                        <?php endif; ?>


                                        <!-- Recorrente -->
                                        <?php if ($transaction['is_recurring']): ?>
                                            <span class="badge badge-recurring">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <path d="M21 2v6h-6M3 12a9 9 0 0 1 15-6.7L21 8M3 22v-6h6M21 12a9 9 0 0 1-15 6.7L3 16" />
                                                </svg>
                                                Recorrente
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Valor -->
                                <div class="transaction-value-wrapper">
                                    <span class="transaction-value <?= $transaction['type'] ?>">
                                        <?= $transaction['type'] === 'receita' ? '+' : '-' ?>
                                        R$ <?= number_format($transaction['amount'], 2, ',', '.') ?>
                                    </span>
                                </div>
                            </div>

                            <!-- Ações -->
                            <div class="transaction-actions">
                                <a href="/transacoes/editar/<?= $transaction['id'] ?>" class="btn-action btn-edit" title="Editar">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                    </svg>
                                </a>
                                <a href="/transacoes/deletar/<?= $transaction['id'] ?>"
                                    class="btn-action btn-delete"
                                    title="Deletar"
                                    onclick="return confirm('Tem certeza que deseja deletar esta transação?')">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <polyline points="3 6 5 6 21 6" />
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    :root {
        --primary: #667eea;
        --secondary: #10b981;
        --danger: #ef4444;
        --gray-50: #f9fafb;
        --gray-100: #f3f4f6;
        --gray-200: #e5e7eb;
        --gray-300: #d1d5db;
        --gray-400: #9ca3af;
        --gray-500: #6b7280;
        --gray-700: #374151;
        --gray-900: #111827;
    }

    /* PAGE HEADER */
    .page-header {
        margin-bottom: 1.5rem;
    }

    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
    }

    .header-title {
        display: flex;
        align-items: center;
        gap: 0.875rem;
    }

    .header-title svg {
        color: var(--primary);
    }

    .header-title h1 {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--gray-900);
        margin: 0;
    }

    .subtitle {
        font-size: 0.875rem;
        color: var(--gray-500);
        margin: 0.125rem 0 0 0;
    }

    /* FILTROS */
    .filters-card {
        background: white;
        border-radius: 10px;
        padding: 1.25rem;
        margin-bottom: 1.25rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
    }

    .filters-form {
        display: flex;
        gap: 0.875rem;
        align-items: flex-end;
    }

    .filter-group {
        flex: 1;
        min-width: 180px;
    }

    .filter-group label {
        display: flex;
        align-items: center;
        gap: 0.375rem;
        font-size: 0.8125rem;
        font-weight: 600;
        color: var(--gray-700);
        margin-bottom: 0.375rem;
    }

    .filter-select {
        width: 100%;
        padding: 0.625rem 0.875rem;
        border: 1px solid var(--gray-300);
        border-radius: 7px;
        font-size: 0.875rem;
        color: var(--gray-900);
        background: white;
        cursor: pointer;
    }

    .btn-filter {
        padding: 0.625rem 1.25rem;
        background: var(--gray-100);
        color: var(--gray-700);
        white-space: nowrap;
        font-size: 0.875rem;
    }

    /* TRANSACTIONS LIST */
    .transactions-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .transactions-list {
        display: flex;
        flex-direction: column;
    }

    .transaction-item {
        display: flex;
        align-items: center;
        gap: 0.875rem;
        padding: 0.875rem 1.25rem;
        border-bottom: 1px solid var(--gray-100);
        transition: background 0.15s;
    }

    .transaction-item:last-child {
        border-bottom: none;
    }

    .transaction-item:hover {
        background: var(--gray-50);
    }

    .transaction-icon {
        width: 36px;
        height: 36px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .transaction-icon.receita {
        background: rgba(16, 185, 129, 0.12);
        color: var(--secondary);
    }

    .transaction-icon.despesa {
        background: rgba(239, 68, 68, 0.12);
        color: var(--danger);
    }

    .transaction-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        min-width: 0;
    }

    .transaction-main {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
    }

    .transaction-info {
        flex: 1;
        min-width: 0;
    }

    .transaction-info h4 {
        font-size: 0.9375rem;
        font-weight: 600;
        color: var(--gray-900);
        margin: 0 0 0.375rem 0;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .transaction-badges {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.1875rem 0.5rem;
        border-radius: 5px;
        font-size: 0.75rem;
        font-weight: 500;
        white-space: nowrap;
    }

    .badge-date {
        background: var(--gray-100);
        color: var(--gray-600);
    }

    .badge-category {
        background: color-mix(in srgb, var(--cat-color) 12%, white);
        color: var(--cat-color);
    }

    .badge-payment {
        background: rgba(102, 126, 234, 0.12);
        color: var(--primary);
    }

    .badge-recurring {
        background: rgba(245, 158, 11, 0.12);
        color: #d97706;
    }

    .installment-badge {
        margin-left: 0.125rem;
        padding: 0 0.25rem;
        background: rgba(255, 255, 255, 0.5);
        border-radius: 3px;
        font-weight: 600;
    }

    .transaction-value {
        font-size: 1.125rem;
        font-weight: 700;
        white-space: nowrap;
    }

    .transaction-value.receita {
        color: var(--secondary);
    }

    .transaction-value.despesa {
        color: var(--danger);
    }

    .transaction-actions {
        display: flex;
        gap: 0.375rem;
    }

    .btn-action {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        transition: all 0.15s;
        flex-shrink: 0;
    }

    .btn-edit {
        background: var(--gray-100);
        color: var(--gray-600);
    }

    .btn-edit:hover {
        background: var(--gray-200);
        color: var(--gray-900);
    }

    .btn-delete {
        background: rgba(239, 68, 68, 0.1);
        color: var(--danger);
    }

    .btn-delete:hover {
        background: var(--danger);
        color: white;
    }

    /* EMPTY STATE */
    .empty-state {
        text-align: center;
        padding: 3.5rem 2rem;
    }

    .empty-state h3 {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--gray-900);
        margin: 1rem 0 0.375rem 0;
    }

    .empty-state p {
        font-size: 0.875rem;
        color: var(--gray-500);
        margin-bottom: 1.5rem;
    }

    .btn-empty {
        display: inline-flex;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .header-content {
            flex-direction: column;
            align-items: stretch;
        }

        .filters-form {
            flex-direction: column;
        }

        .filter-group {
            width: 100%;
        }

        .transaction-item {
            flex-wrap: wrap;
            gap: 0.75rem;
        }

        .transaction-main {
            width: 100%;
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }

        .transaction-value-wrapper {
            align-self: flex-end;
        }

        .transaction-actions {
            width: 100%;
            justify-content: flex-end;
        }
    }
</style>

<?php include VIEWS . '/layouts/footer.php'; ?>