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
        --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.12);
        --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.15);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 2rem;
    }

    /* ========== PAGE HEADER ========== */
    .page-header {
        margin-bottom: 2rem;
    }

    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
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
        line-height: 1.2;
    }

    .subtitle {
        font-size: 0.9375rem;
        color: var(--gray-500);
        margin: 0.25rem 0 0 0;
        line-height: 1.4;
    }

    .header-actions {
        display: flex;
        gap: 0.75rem;
        flex-shrink: 0;
    }

    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.25rem;
        border-radius: 10px;
        font-size: 0.9375rem;
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
        cursor: pointer;
        border: none;
        white-space: nowrap;
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

    .btn-secondary {
        background: white;
        color: var(--gray-700);
        border: 2px solid var(--gray-200);
    }

    .btn-secondary:hover {
        border-color: var(--gray-300);
        background: var(--gray-50);
    }

    /* ========== FILTROS ========== */
    .filters-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--gray-200);
    }

    .filters-form {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1rem;
        align-items: flex-end;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .filter-group label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--gray-700);
    }

    .filter-group label svg {
        color: var(--gray-400);
        flex-shrink: 0;
    }

    .filter-select {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid var(--gray-200);
        border-radius: 10px;
        font-size: 0.9375rem;
        color: var(--gray-900);
        background: white;
        cursor: pointer;
        transition: var(--transition);
        font-family: inherit;
    }

    .filter-select:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.12);
    }

    .btn-filter {
        background: var(--primary);
        color: white;
        padding: 0.75rem 1.5rem;
        justify-content: center;
    }

    .btn-filter:hover {
        background: var(--primary-hover);
        transform: translateY(-2px);
    }

    /* ========== SUMMARY CARDS ========== */
    .summary-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 1.25rem;
        margin-bottom: 1.5rem;
    }

    .summary-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: var(--shadow-sm);
        display: flex;
        align-items: center;
        gap: 1.25rem;
        transition: var(--transition);
        border: 1px solid var(--gray-200);
    }

    .summary-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-md);
    }

    .card-icon {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .income-card .card-icon {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(16, 185, 129, 0.05) 100%);
        color: var(--secondary);
    }

    .expense-card .card-icon {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.15) 0%, rgba(239, 68, 68, 0.05) 100%);
        color: var(--danger);
    }

    .balance-card .card-icon {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.15) 0%, rgba(102, 126, 234, 0.05) 100%);
        color: var(--primary);
    }

    .card-content {
        display: flex;
        flex-direction: column;
        gap: 0.375rem;
        flex: 1;
        min-width: 0;
    }

    .card-label {
        font-size: 0.875rem;
        color: var(--gray-600);
        font-weight: 500;
    }

    .card-value {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--gray-900);
        line-height: 1;
    }

    .card-value.positive {
        color: var(--secondary);
    }

    .card-value.negative {
        color: var(--danger);
    }

    /* ========== TRANSACTIONS LIST ========== */
    .transactions-card {
        background: white;
        border-radius: 12px;
        box-shadow: var(--shadow-sm);
        overflow: hidden;
        border: 1px solid var(--gray-200);
    }

    .transactions-list {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        padding: 0.5rem;
    }

    .transaction-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1.25rem 1.5rem;
        border-bottom: none;
        transition: var(--transition);
        position: relative;
        background: white;
        border-radius: 10px;
        border: 1px solid var(--gray-100);
    }

    .transaction-item.pending {
        background: linear-gradient(90deg, rgba(245, 158, 11, 0.05) 0%, transparent 100%);
        border-left: 4px solid var(--warning);
        padding-left: calc(1.5rem - 4px);
    }

    .transaction-item:last-child {
        border-bottom: none;
    }

    .transaction-item:hover {
        background: var(--gray-50);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transform: translateY(-1px);
    }

    .transaction-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .transaction-icon.receita {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.15) 0%, rgba(16, 185, 129, 0.05) 100%);
        color: var(--secondary);
    }

    .transaction-icon.despesa {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.15) 0%, rgba(239, 68, 68, 0.05) 100%);
        color: var(--danger);
    }

    .transaction-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 0.625rem;
        min-width: 0;
    }

    .transaction-main {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1.5rem;
    }

    .transaction-info {
        flex: 1;
        min-width: 0;
    }

    .transaction-info h4 {
        font-size: 1rem;
        font-weight: 600;
        color: var(--gray-900);
        margin: 0 0 0.5rem 0;
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
        gap: 0.375rem;
        padding: 0.25rem 0.625rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        white-space: nowrap;
    }

    .badge svg {
        flex-shrink: 0;
    }

    .badge-pending {
        background: rgba(245, 158, 11, 0.15);
        color: #d97706;
    }

    .badge-date {
        background: var(--gray-100);
        color: var(--gray-600);
    }

    .badge-category {
        background: color-mix(in srgb, var(--cat-color) 15%, white);
        color: var(--cat-color);
        border: 1px solid color-mix(in srgb, var(--cat-color) 30%, white);
    }

    .badge-payment {
        background: rgba(102, 126, 234, 0.12);
        color: var(--primary);
    }

    .badge-credit {
        background: rgba(102, 126, 234, 0.12);
        color: var(--primary);
    }

    .badge-va {
        background: rgba(16, 185, 129, 0.12);
        color: var(--secondary);
    }

    .badge-vr {
        background: rgba(245, 158, 11, 0.12);
        color: var(--warning);
    }

    .badge-cash {
        background: var(--gray-100);
        color: var(--gray-700);
    }

    .badge-recurring {
        background: rgba(245, 158, 11, 0.12);
        color: #d97706;
    }

    .installment-badge {
        margin-left: 0.25rem;
        padding: 0 0.375rem;
        background: rgba(255, 255, 255, 0.6);
        border-radius: 4px;
        font-weight: 700;
    }

    /* Payment Toggle */
    .payment-toggle {
        display: flex;
        align-items: center;
        gap: 0.625rem;
        flex-shrink: 0;
    }

    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 48px;
        height: 26px;
        cursor: pointer;
    }

    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .toggle-slider {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: var(--gray-300);
        transition: 0.3s;
        border-radius: 26px;
    }

    .toggle-slider:before {
        position: absolute;
        content: "";
        height: 20px;
        width: 20px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: 0.3s;
        border-radius: 50%;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    input:checked+.toggle-slider {
        background-color: var(--secondary);
    }

    input:checked+.toggle-slider:before {
        transform: translateX(22px);
    }

    .toggle-label {
        font-size: 0.8125rem;
        font-weight: 600;
        color: var(--gray-600);
        white-space: nowrap;
    }

    input:checked~.toggle-label {
        color: var(--secondary);
    }

    .transaction-value-wrapper {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .transaction-value {
        font-size: 1.25rem;
        font-weight: 800;
        white-space: nowrap;
    }

    .transaction-value.receita {
        color: var(--secondary);
    }

    .transaction-value.despesa {
        color: var(--danger);
    }

    .transaction-item.pending .transaction-value {
        opacity: 0.7;
    }

    .transaction-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: 0.5rem;
    }

    .btn-action {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        transition: var(--transition);
        flex-shrink: 0;
        text-decoration: none;
    }

    .btn-edit {
        background: var(--gray-100);
        color: var(--gray-600);
    }

    .btn-edit:hover {
        background: var(--gray-200);
        color: var(--gray-900);
        transform: translateY(-2px);
    }

    .btn-delete {
        background: rgba(239, 68, 68, 0.1);
        color: var(--danger);
    }

    .btn-delete:hover {
        background: var(--danger);
        color: white;
        transform: translateY(-2px);
    }

    /* ========== EMPTY STATE ========== */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-state svg {
        margin-bottom: 1.5rem;
        color: var(--gray-300);
    }

    .empty-state h3 {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--gray-900);
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        font-size: 0.9375rem;
        color: var(--gray-500);
        margin-bottom: 2rem;
        line-height: 1.6;
    }

    /* ========== OVERDUE ========== */
    .overdue-card {
        background: white;
        border-radius: 12px;
        border: 1px solid rgba(239, 68, 68, 0.25);
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.05);
        margin-bottom: 1.5rem;
        overflow: hidden;
    }

    .overdue-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 1.5rem;
        background: linear-gradient(90deg, rgba(239, 68, 68, 0.08) 0%, transparent 100%);
        border-bottom: 1px solid rgba(239, 68, 68, 0.15);
    }

    .overdue-title {
        display: flex;
        align-items: center;
        gap: 0.625rem;
        font-size: 0.9375rem;
        font-weight: 700;
        color: var(--danger);
    }

    .overdue-count {
        background: var(--danger);
        color: white;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 0.125rem 0.5rem;
        border-radius: 20px;
        min-width: 20px;
        text-align: center;
    }

    .overdue-toggle {
        background: none;
        border: none;
        cursor: pointer;
        color: var(--danger);
        padding: 0.25rem;
        border-radius: 6px;
        display: flex;
        align-items: center;
        transition: var(--transition);
    }

    .overdue-toggle:hover {
        background: rgba(239, 68, 68, 0.1);
    }

    .overdue-toggle.collapsed svg {
        transform: rotate(-90deg);
    }

    .overdue-list {
        display: flex;
        flex-direction: column;
    }

    .overdue-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid var(--gray-100);
        transition: var(--transition);
    }

    .overdue-item:last-child {
        border-bottom: none;
    }

    .overdue-item:hover {
        background: var(--gray-50);
    }

    .overdue-item-info {
        display: flex;
        flex-direction: column;
        gap: 0.375rem;
        flex: 1;
        min-width: 0;
    }

    .overdue-item-desc {
        font-size: 0.9375rem;
        font-weight: 600;
        color: var(--gray-900);
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .overdue-item-meta {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .badge-overdue-days {
        background: rgba(239, 68, 68, 0.1);
        color: var(--danger);
        padding: 0.25rem 0.625rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .overdue-item-right {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-shrink: 0;
    }

    .overdue-value {
        font-size: 1.125rem;
        font-weight: 800;
        color: var(--danger);
        white-space: nowrap;
    }

    @media (max-width: 768px) {
        .overdue-item {
            flex-wrap: wrap;
            padding: 0.875rem 1rem;
        }

        .overdue-item-right {
            width: 100%;
            justify-content: space-between;
        }
    }

    /* ========== RESPONSIVE - TABLET ========== */
    @media (max-width: 1024px) {
        .container {
            padding: 1.5rem;
        }

        .header-title h1 {
            font-size: 1.75rem;
        }

        .summary-cards {
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        }

        .card-value {
            font-size: 1.5rem;
        }
    }

    /* ========== RESPONSIVE - MOBILE ========== */
    @media (max-width: 768px) {
        .container {
            padding: 1rem;
        }

        .page-header {
            margin-bottom: 1.5rem;
        }

        .header-content {
            flex-direction: column;
            align-items: stretch;
            gap: 1rem;
        }

        .header-title {
            gap: 0.75rem;
        }

        .header-title svg {
            width: 24px;
            height: 24px;
        }

        .header-title h1 {
            font-size: 1.5rem;
        }

        .subtitle {
            font-size: 0.875rem;
        }

        .header-actions {
            width: 100%;
            gap: 0.625rem;
        }

        .btn {
            flex: 1;
            justify-content: center;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
        }

        /* Filtros Mobile */
        .filters-card {
            padding: 1.25rem;
            margin-bottom: 1.25rem;
        }

        .filters-form {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .filter-group label {
            font-size: 0.8125rem;
        }

        .filter-select {
            padding: 0.75rem 0.875rem;
            font-size: 0.875rem;
        }

        /* Summary Cards Mobile */
        .summary-cards {
            grid-template-columns: 1fr;
            gap: 1rem;
            margin-bottom: 1.25rem;
        }

        .summary-card {
            padding: 1.25rem;
        }

        .card-icon {
            width: 48px;
            height: 48px;
        }

        .card-value {
            font-size: 1.5rem;
        }

        /* Transactions Mobile */
        .transactions-card {
            border-radius: 10px;
        }

        .transaction-item {
            flex-wrap: wrap;
            padding: 1rem;
            gap: 0.875rem;
        }

        .transaction-item.pending {
            padding-left: calc(1rem - 4px);
        }

        .transaction-icon {
            width: 40px;
            height: 40px;
        }

        .transaction-content {
            width: 100%;
        }

        .transaction-main {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .transaction-info h4 {
            font-size: 0.9375rem;
        }

        .transaction-badges {
            gap: 0.375rem;
        }

        .badge {
            font-size: 0.6875rem;
            padding: 0.1875rem 0.5rem;
        }

        .badge svg {
            width: 10px;
            height: 10px;
        }

        .payment-toggle {
            display: none !important;
        }

        .toggle-switch {
            width: 44px;
            height: 24px;
        }

        .toggle-slider:before {
            height: 18px;
            width: 18px;
        }

        input:checked+.toggle-slider:before {
            transform: translateX(20px);
        }

        .toggle-label {
            font-size: 0.75rem;
        }

        .transaction-value-wrapper {
            align-self: flex-start;
            width: 100%;
            justify-content: space-between;
        }

        .transaction-value {
            font-size: 1.125rem;
        }

        .transaction-actions {
            width: 100%;
            justify-content: flex-end;
            margin-top: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Toggle dentro das actions no mobile */
        .transaction-actions .payment-toggle {
            display: flex !important;
            margin-right: auto;
        }

        .btn-action {
            width: 34px;
            height: 34px;
        }

        /* Empty State Mobile */
        .empty-state {
            padding: 3rem 1.5rem;
        }

        .empty-state svg {
            width: 56px;
            height: 56px;
        }

        .empty-state h3 {
            font-size: 1.125rem;
        }

        .empty-state p {
            font-size: 0.875rem;
        }
    }

    /* ========== MOBILE PORTRAIT ========== */
    @media (max-width: 480px) {
        .container {
            padding: 0.875rem;
        }

        .header-title h1 {
            font-size: 1.375rem;
        }

        .btn {
            padding: 0.625rem 0.875rem;
            font-size: 0.8125rem;
        }

        .filters-card,
        .transactions-card {
            border-radius: 8px;
        }

        .transaction-item {
            padding: 0.875rem;
        }

        .card-value {
            font-size: 1.375rem;
        }
    }

    /* PWA/Standalone Mode */
    @media (display-mode: standalone) {
        .container {
            padding-top: calc(env(safe-area-inset-top) + 2rem);
            padding-bottom: calc(env(safe-area-inset-bottom) + 2rem);
        }
    }
</style>

<div class="container">
    <div class="page-header">
        <div class="header-content">
            <div class="header-title">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="4" width="20" height="16" rx="2" />
                    <path d="M2 10h20" />
                </svg>
                <div>
                    <h1>Transações</h1>
                    <p class="subtitle">Gerencie suas receitas e despesas</p>
                </div>
            </div>
            <div class="header-actions">
                <button onclick="generateReport()" class="btn btn-secondary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                        <line x1="16" y1="13" x2="8" y2="13" />
                        <line x1="16" y1="17" x2="8" y2="17" />
                    </svg>
                    Relatório
                </button>
                <a href="/transacoes/criar" class="btn btn-primary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 5v14M5 12h14" />
                    </svg>
                    Nova Transação
                </a>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="filters-card">
        <form method="GET" action="/transacoes" class="filters-form">
            <div class="filter-group">
                <label for="month">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                        <path d="M16 2v4M8 2v4M3 10h18" />
                    </svg>
                    Mês
                </label>
                <select name="month" id="month" class="filter-select">
                    <?php
                    $meses = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];
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
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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

            <div class="filter-group">
                <label for="status">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                    Status
                </label>
                <select name="status" id="status" class="filter-select">
                    <option value="all" <?= ($status ?? 'all') == 'all' ? 'selected' : '' ?>>Todas</option>
                    <option value="paid" <?= ($status ?? '') == 'paid' ? 'selected' : '' ?>>Pagas</option>
                    <option value="pending" <?= ($status ?? '') == 'pending' ? 'selected' : '' ?>>Pendentes</option>
                </select>
            </div>

            <button type="submit" class="btn btn-filter">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 3H2l8 9.46V19l4 2v-8.54L22 3z" />
                </svg>
                Filtrar
            </button>
        </form>
    </div>

    <!-- Cards de Resumo -->
    <div class="summary-cards">
        <div class="summary-card income-card">
            <div class="card-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 5v14M19 12l-7-7-7 7" />
                </svg>
            </div>
            <div class="card-content">
                <span class="card-label">Receitas</span>
                <span class="card-value">R$ <?= number_format($balance['total_income'] ?? 0, 2, ',', '.') ?></span>
            </div>
        </div>

        <div class="summary-card expense-card">
            <div class="card-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 19V5M5 12l7 7 7-7" />
                </svg>
            </div>
            <div class="card-content">
                <span class="card-label">Despesas</span>
                <span class="card-value">R$ <?= number_format($balance['total_expense'] ?? 0, 2, ',', '.') ?></span>
            </div>
        </div>

        <div class="summary-card balance-card">
            <div class="card-icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                </svg>
            </div>
            <div class="card-content">
                <span class="card-label">Saldo</span>
                <?php
                $saldo = ($balance['total_income'] ?? 0) - ($balance['total_expense'] ?? 0);
                $saldoClass = $saldo >= 0 ? 'positive' : 'negative';
                ?>
                <span class="card-value <?= $saldoClass ?>">R$ <?= number_format($saldo, 2, ',', '.') ?></span>
            </div>
        </div>
    </div>

    <?php if (!empty($overdueTransactions)): ?>
        <div class="overdue-card">
            <div class="overdue-header">
                <div class="overdue-title">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" y1="8" x2="12" y2="12" />
                        <line x1="12" y1="16" x2="12.01" y2="16" />
                    </svg>
                    Despesas em atraso
                    <span class="overdue-count"><?= count($overdueTransactions) ?></span>
                </div>
                <button class="overdue-toggle" onclick="toggleOverdue(this)">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9" />
                    </svg>
                </button>
            </div>

            <div class="overdue-list">
                <?php foreach ($overdueTransactions as $t): ?>
                    <div class="overdue-item" id="overdue-item-<?= $t['id'] ?>">
                        <div class="overdue-item-info">
                            <span class="overdue-item-desc"><?= htmlspecialchars($t['description']) ?></span>
                            <div class="overdue-item-meta">
                                <span class="badge badge-date">
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <rect x="3" y="4" width="18" height="18" rx="2" />
                                        <path d="M16 2v4M8 2v4M3 10h18" />
                                    </svg>
                                    <?= date('d/m/Y', strtotime($t['transaction_date'])) ?>
                                </span>
                                <span class="badge badge-category" style="--cat-color: <?= $t['color'] ?>">
                                    <?= $t['category_name'] ?>
                                </span>
                                <?php
                                $diasAtraso = (int) floor((time() - strtotime($t['transaction_date'])) / 86400);
                                ?>
                                <span class="badge badge-overdue-days">
                                    <?= $diasAtraso ?> dia<?= $diasAtraso !== 1 ? 's' : '' ?> em atraso
                                </span>
                            </div>
                        </div>
                        <div class="overdue-item-right">
                            <span class="overdue-value">R$ <?= number_format($t['amount'], 2, ',', '.') ?></span>
                            <label class="toggle-switch" title="Marcar como paga">
                                <input type="checkbox"
                                    onchange="toggleOverduePaid(<?= $t['id'] ?>, this)">
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- Lista de Transações -->
    <div class="transactions-card">
        <?php if (empty($transactions)): ?>
            <div class="empty-state">
                <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <circle cx="12" cy="12" r="10" />
                    <path d="M16 16s-1.5-2-4-2-4 2-4 2" />
                    <path d="M9 9h.01M15 9h.01" />
                </svg>
                <h3>Nenhuma transação encontrada</h3>
                <p>Não há transações neste período. Que tal adicionar uma?</p>
                <a href="/transacoes/criar" class="btn btn-primary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 5v14M5 12h14" />
                    </svg>
                    Criar primeira transação
                </a>
            </div>
        <?php else: ?>
            <div class="transactions-list">
                <?php foreach ($transactions as $transaction): ?>
                    <div class="transaction-item <?= (!$transaction['paid'] && $transaction['is_recurring'] && $transaction['type'] === 'despesa') ? 'pending' : '' ?>">
                        <!-- Ícone do Tipo -->
                        <div class="transaction-icon <?= $transaction['type'] ?>">
                            <?php if ($transaction['type'] === 'receita'): ?>
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 5v14M19 12l-7-7-7 7" />
                                </svg>
                            <?php else: ?>
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
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
                                        <!-- Status de Pagamento -->
                                        <?php if (!$transaction['paid']): ?>
                                            <span class="badge badge-pending">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="12" cy="12" r="10" />
                                                    <polyline points="12 6 12 12 16 14" />
                                                </svg>
                                                Pendente
                                            </span>
                                        <?php endif; ?>

                                        <!-- Data -->
                                        <span class="badge badge-date">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                                <path d="M16 2v4M8 2v4M3 10h18" />
                                            </svg>
                                            <?= date('d/m', strtotime($transaction['transaction_date'])) ?>
                                        </span>

                                        <!-- Categoria -->
                                        <span class="badge badge-category" style="--cat-color: <?= $transaction['color'] ?>">
                                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z" />
                                            </svg>
                                            <?= $transaction['category_name'] ?>
                                        </span>

                                        <!-- Forma de Pagamento -->
                                        <?php if ($transaction['payment_method'] === 'credito'): ?>
                                            <span class="badge badge-payment badge-credit">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
                                            <span class="badge badge-payment badge-va">🍽️ VA</span>
                                        <?php elseif ($transaction['payment_method'] === 'vr'): ?>
                                            <span class="badge badge-payment badge-vr">🛒 VR</span>
                                        <?php else: ?>
                                            <span class="badge badge-payment badge-cash">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                                                </svg>
                                                À vista
                                            </span>
                                        <?php endif; ?>

                                        <!-- Recorrente -->
                                        <?php if ($transaction['is_recurring']): ?>
                                            <span class="badge badge-recurring">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
                                <!-- Toggle de Pagamento -->
                                <?php if ($transaction['is_recurring'] && $transaction['type'] === 'despesa'): ?>
                                    <div class="payment-toggle">
                                        <label class="toggle-switch" title="<?= $transaction['paid'] ? 'Marcar como pendente' : 'Marcar como paga' ?>">
                                            <input
                                                type="checkbox"
                                                <?= $transaction['paid'] ? 'checked' : '' ?>
                                                onchange="togglePaymentStatus(<?= $transaction['id'] ?>, this.checked, this)">
                                            <span class="toggle-slider"></span>
                                        </label>
                                        <span class="toggle-label"><?= $transaction['paid'] ? 'Pago' : 'Pendente' ?></span>
                                    </div>
                                <?php endif; ?>

                                <a href="/transacoes/editar/<?= $transaction['id'] ?>" class="btn-action btn-edit" title="Editar">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                    </svg>
                                </a>
                                <a href="/transacoes/deletar/<?= $transaction['id'] ?>"
                                    class="btn-action btn-delete"
                                    title="Deletar"
                                    onclick="return confirm('Tem certeza que deseja deletar esta transação?')">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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

<script>
    function togglePaymentStatus(transactionId, isPaid, checkboxEl) {
        const formData = new FormData();
        formData.append('transaction_id', transactionId);
        formData.append('paid', isPaid ? '1' : '0');

        fetch('/transacoes/togglePaid', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(text => {
                // Extrai apenas o JSON ignorando qualquer output antes/depois
                const match = text.match(/\{.*\}/s);
                if (!match) throw new Error('Resposta inválida');

                const data = JSON.parse(match[0]);

                if (data.success) {
                    showToast(isPaid ? 'Transação marcada como paga!' : 'Transação marcada como pendente', 'success');

                    const item = checkboxEl.closest('.transaction-item');
                    if (isPaid) {
                        item.classList.remove('pending');
                    } else {
                        item.classList.add('pending');
                    }
                    updatePendingBadge(item, isPaid);
                } else {
                    showToast('Erro ao atualizar status', 'error');
                    checkboxEl.checked = !isPaid;
                }
            })
            .catch(() => {
                showToast('Erro ao atualizar status', 'error');
                checkboxEl.checked = !isPaid;
            });
    }

    function updatePendingBadge(item, isPaid) {
        const badges = item.querySelector('.transaction-badges');
        const existingBadge = badges.querySelector('.badge-pending');

        if (!isPaid && !existingBadge) {
            const badge = document.createElement('span');
            badge.className = 'badge badge-pending';
            badge.innerHTML = `
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
                <polyline points="12 6 12 12 16 14"/>
            </svg>
            Pendente
        `;
            badges.insertBefore(badge, badges.firstChild);
        } else if (isPaid && existingBadge) {
            existingBadge.remove();
        }
    }

    // Substitua a função generateReport() existente por esta:

    function generateReport() {
        const month = document.getElementById('month').value;
        const year = document.getElementById('year').value;

        // Redirecionar para a página de relatório com IA
        window.location.href = `/relatorios/gerar?month=${month}&year=${year}`;
    }

    // OU, se preferir manter o relatório simples e adicionar um novo botão para IA:

    // Adicione este botão no header-actions:
    /*
    <button onclick="generateAIReport()" class="btn btn-secondary">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"></path>
        </svg>
        Análise IA
    </button>
    */

    function generateAIReport() {
        const month = document.getElementById('month').value;
        const year = document.getElementById('year').value;
        window.location.href = `/relatorios/gerar?month=${month}&year=${year}`;
    }

    function toggleOverdueToggle(btn) {
        const list = btn.closest('.overdue-card').querySelector('.overdue-list');
        const isCollapsed = list.style.display === 'none';
        list.style.display = isCollapsed ? 'flex' : 'none';
        btn.classList.toggle('collapsed', !isCollapsed);
    }

    function toggleOverduePaid(transactionId, checkbox) {
        const formData = new FormData();
        formData.append('transaction_id', transactionId);
        formData.append('paid', '1');

        fetch('/transacoes/togglePaid', {
                method: 'POST',
                body: formData
            })
            .then(r => r.text())
            .then(text => {
                const data = JSON.parse(text.replace(/^\uFEFF/, '').trim());
                if (data.success) {
                    const item = document.getElementById('overdue-item-' + transactionId);
                    item.style.transition = 'all 0.4s ease';
                    item.style.opacity = '0';
                    item.style.transform = 'translateX(20px)';
                    setTimeout(() => {
                        item.remove();
                        // Atualiza o contador
                        const card = document.querySelector('.overdue-card');
                        const remaining = card.querySelectorAll('.overdue-item').length;
                        if (remaining === 0) {
                            card.remove();
                        } else {
                            card.querySelector('.overdue-count').textContent = remaining;
                        }
                    }, 400);
                    showToast('Despesa marcada como paga!', 'success');
                } else {
                    checkbox.checked = false;
                    showToast('Erro ao atualizar', 'error');
                }
            })
            .catch(() => {
                checkbox.checked = false;
                showToast('Erro ao atualizar', 'error');
            });
    }
</script>

<?php include VIEWS . '/layouts/footer.php'; ?>