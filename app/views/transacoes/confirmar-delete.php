<?php include VIEWS . '/layouts/header.php'; ?>

<style>
    :root {
        --primary: #667eea;
        --primary-hover: #5568d3;
        --secondary: #10b981;
        --danger: #ef4444;
        --danger-light: #fee2e2;
        --danger-medium: #fca5a5;
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
    .container {
        max-width: 780px;
        margin: 0 auto;
        padding: 2rem;
    }

    /* ========== CONFIRM DELETE CARD ========== */
    .confirm-delete-card {
        background: white;
        padding: 2.5rem;
        border-radius: 16px;
        box-shadow: var(--shadow-md);
        border: 1px solid var(--gray-200);
        animation: slideUp 0.4s ease-out;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* ========== WARNING ICON ========== */
    .warning-icon {
        font-size: 4rem;
        text-align: center;
        margin-bottom: 1.25rem;
        animation: pulse 2s ease-in-out infinite;
    }

    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.1);
        }
    }

    /* ========== HEADING ========== */
    .confirm-delete-card h1 {
        text-align: center;
        color: var(--danger);
        margin-bottom: 2rem;
        font-size: 1.75rem;
        font-weight: 700;
        line-height: 1.3;
    }

    /* ========== TRANSACTION INFO ========== */
    .transaction-info {
        background: linear-gradient(135deg, var(--gray-50) 0%, white 100%);
        padding: 1.75rem;
        border-radius: 12px;
        text-align: center;
        margin-bottom: 2rem;
        border: 2px solid var(--gray-200);
    }

    .transaction-info h3 {
        color: var(--gray-900);
        margin-bottom: 0.875rem;
        font-size: 1.25rem;
        font-weight: 600;
    }

    .amount {
        font-size: 2rem;
        font-weight: 700;
        color: var(--danger);
        margin: 0.875rem 0;
        font-family: 'Courier New', monospace;
        letter-spacing: 0.5px;
    }

    .date {
        color: var(--gray-600);
        font-size: 0.9375rem;
        font-weight: 500;
    }

    /* ========== RELATED INFO ========== */
    .related-info {
        margin-bottom: 2rem;
    }

    .related-info > p {
        margin-bottom: 1.125rem;
        font-size: 1.0625rem;
        color: var(--gray-900);
        font-weight: 500;
    }

    .related-info strong {
        color: var(--danger);
        font-weight: 700;
    }

    /* ========== RELATED LIST ========== */
    .related-list {
        background: var(--gray-50);
        padding: 1rem;
        border-radius: 12px;
        max-height: 320px;
        overflow-y: auto;
        border: 1px solid var(--gray-200);
    }

    .related-list::-webkit-scrollbar {
        width: 8px;
    }

    .related-list::-webkit-scrollbar-track {
        background: var(--gray-100);
        border-radius: 4px;
    }

    .related-list::-webkit-scrollbar-thumb {
        background: var(--gray-400);
        border-radius: 4px;
    }

    .related-list::-webkit-scrollbar-thumb:hover {
        background: var(--gray-500);
    }

    .related-item {
        display: grid;
        grid-template-columns: 100px 1fr auto;
        gap: 1rem;
        padding: 0.875rem 1rem;
        border-bottom: 1px solid var(--gray-200);
        align-items: center;
        background: white;
        border-radius: 8px;
        margin-bottom: 0.5rem;
        transition: var(--transition);
    }

    .related-item:hover {
        transform: translateX(4px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    }

    .related-item:last-child {
        margin-bottom: 0;
    }

    .related-date {
        font-weight: 600;
        color: var(--primary);
        font-size: 0.875rem;
    }

    .related-desc {
        color: var(--gray-900);
        font-size: 0.9375rem;
    }

    .related-value {
        font-weight: 700;
        color: var(--gray-700);
        text-align: right;
        font-size: 0.9375rem;
        font-family: 'Courier New', monospace;
    }

    /* ========== TOTAL INFO ========== */
    .total-info {
        background: linear-gradient(135deg, var(--danger-light) 0%, #fecaca 100%);
        padding: 1.25rem 1.5rem;
        border-radius: 12px;
        text-align: center;
        font-size: 1.125rem;
        margin-bottom: 2rem;
        border: 2px solid var(--danger-medium);
        font-weight: 600;
    }

    .total-info strong {
        color: var(--danger);
        font-weight: 700;
    }

    /* ========== OPTIONS ========== */
    .options {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .option-card {
        display: flex;
        gap: 1rem;
        padding: 1.25rem 1.5rem;
        border: 2px solid var(--gray-300);
        border-radius: 12px;
        cursor: pointer;
        transition: var(--transition);
        background: white;
    }

    .option-card:hover {
        border-color: var(--primary);
        background: var(--gray-50);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
    }

    .option-card.danger:hover {
        border-color: var(--danger);
        background: #fef2f2;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.15);
    }

    .option-card input[type="radio"] {
        margin-top: 0.25rem;
        width: 20px;
        height: 20px;
        cursor: pointer;
        flex-shrink: 0;
        accent-color: var(--primary);
    }

    .option-card.danger input[type="radio"] {
        accent-color: var(--danger);
    }

    .option-card input[type="radio"]:checked + .option-content {
        color: var(--primary);
    }

    .option-card.danger input[type="radio"]:checked + .option-content {
        color: var(--danger);
    }

    .option-content {
        flex: 1;
    }

    .option-title {
        font-weight: 700;
        font-size: 1.0625rem;
        margin-bottom: 0.375rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        line-height: 1.4;
    }

    .option-desc {
        font-size: 0.875rem;
        color: var(--gray-600);
        line-height: 1.5;
    }

    /* ========== BUTTONS ========== */
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.875rem 2rem;
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

    .btn-danger {
        background: linear-gradient(135deg, var(--danger) 0%, #dc2626 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.25);
    }

    .btn-danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(239, 68, 68, 0.35);
    }

    .btn-danger:active {
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

    /* ========== ACTIONS ========== */
    .actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
        padding-top: 0.5rem;
    }

    .actions .btn {
        flex: 1;
        max-width: 240px;
    }

    /* ========== RESPONSIVE - TABLET ========== */
    @media (max-width: 1024px) {
        .container {
            padding: 1.5rem;
        }

        .confirm-delete-card {
            padding: 2rem;
        }

        .confirm-delete-card h1 {
            font-size: 1.5rem;
        }
    }

    /* ========== RESPONSIVE - MOBILE ========== */
    @media (max-width: 768px) {
        .container {
            padding: 1rem;
        }

        .confirm-delete-card {
            padding: 1.5rem;
            border-radius: 12px;
        }

        .confirm-delete-card h1 {
            font-size: 1.375rem;
            margin-bottom: 1.5rem;
        }

        .warning-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .transaction-info {
            padding: 1.25rem;
        }

        .transaction-info h3 {
            font-size: 1.125rem;
        }

        .amount {
            font-size: 1.75rem;
        }

        .related-item {
            grid-template-columns: 1fr;
            gap: 0.5rem;
            padding: 0.875rem;
        }

        .related-value {
            text-align: left;
        }

        .option-card {
            padding: 1rem;
        }

        .option-title {
            font-size: 1rem;
        }

        .actions {
            flex-direction: column;
            gap: 0.75rem;
        }

        .actions .btn {
            width: 100%;
            max-width: 100%;
            padding: 1rem 1.5rem;
        }

        .total-info {
            font-size: 1rem;
            padding: 1rem;
        }

        .related-info > p {
            font-size: 1rem;
        }
    }

    /* ========== MOBILE PORTRAIT ========== */
    @media (max-width: 480px) {
        .container {
            padding: 0.875rem;
        }

        .confirm-delete-card {
            padding: 1.25rem;
        }

        .confirm-delete-card h1 {
            font-size: 1.25rem;
        }

        .amount {
            font-size: 1.5rem;
        }

        .warning-icon {
            font-size: 2.5rem;
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
    <div class="confirm-delete-card">
        <div class="warning-icon">⚠️</div>

        <h1>Atenção: Transação com Parcelas/Recorrências</h1>

        <div class="transaction-info">
            <h3><?= htmlspecialchars($transaction['description']) ?></h3>
            <p class="amount">R$ <?= number_format($transaction['amount'], 2, ',', '.') ?></p>
            <p class="date"><?= date('d/m/Y', strtotime($transaction['transaction_date'])) ?></p>
        </div>

        <div class="related-info">
            <p>Esta transação possui <strong><?= count($related) ?> lançamentos relacionados</strong>:</p>

            <div class="related-list">
                <?php foreach ($related as $r): ?>
                    <div class="related-item">
                        <span class="related-date"><?= date('d/m/Y', strtotime($r['transaction_date'])) ?></span>
                        <span class="related-desc"><?= htmlspecialchars($r['description']) ?></span>
                        <span class="related-value">R$ <?= number_format($r['amount'], 2, ',', '.') ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="total-info">
            <?php
            $total = array_sum(array_column($related, 'amount'));
            ?>
            <strong>Valor Total:</strong> R$ <?= number_format($total, 2, ',', '.') ?>
        </div>

        <form method="POST" action="/transacoes/deletar/<?= $transaction['id'] ?>">
            <div class="options">
                <label class="option-card">
                    <input type="radio" name="delete_related" value="0" checked>
                    <div class="option-content">
                        <div class="option-title">🔹 Deletar apenas esta transação</div>
                        <div class="option-desc">As outras <?= count($related) - 1 ?> parcelas/recorrências permanecerão</div>
                    </div>
                </label>

                <label class="option-card danger">
                    <input type="radio" name="delete_related" value="1">
                    <div class="option-content">
                        <div class="option-title">🔥 Deletar TODAS as parcelas/recorrências</div>
                        <div class="option-desc">Todas as <?= count($related) ?> transações relacionadas serão removidas</div>
                    </div>
                </label>
            </div>

            <div class="actions">
                <a href="/transacoes" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-danger">🗑️ Confirmar Exclusão</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Confirmação adicional ao deletar todas
    document.querySelector('form').addEventListener('submit', function(e) {
        const deleteAll = document.querySelector('input[name="delete_related"]:checked').value;
        
        if (deleteAll === '1') {
            if (!confirm('⚠️ ATENÇÃO!\n\nVocê está prestes a deletar TODAS as <?= count($related) ?> transações relacionadas.\n\nEsta ação NÃO pode ser desfeita!\n\nDeseja continuar?')) {
                e.preventDefault();
                return false;
            }
        }
    });

    // Previne zoom em iOS
    if (/iPhone|iPad|iPod/i.test(navigator.userAgent)) {
        const viewport = document.querySelector('meta[name="viewport"]');
        if (viewport) {
            viewport.content = 'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no';
        }
    }
</script>

<?php include VIEWS . '/layouts/footer.php'; ?>