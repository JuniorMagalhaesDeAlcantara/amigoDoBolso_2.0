<?php include VIEWS . '/layouts/header.php'; ?>

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
                <button type="submit" class="btn btn-danger">Confirmar Exclusão</button>
            </div>
        </form>
    </div>
</div>

<style>
    .confirm-delete-card {
        max-width: 700px;
        margin: 2rem auto;
        background: white;
        padding: 2.5rem;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .warning-icon {
        font-size: 4rem;
        text-align: center;
        margin-bottom: 1.5rem;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.1);
        }
    }

    .confirm-delete-card h1 {
        text-align: center;
        color: var(--danger);
        margin-bottom: 2rem;
        font-size: 1.5rem;
        font-weight: 700;
    }

    .transaction-info {
        background: var(--gray-50);
        padding: 1.5rem;
        border-radius: 12px;
        text-align: center;
        margin-bottom: 2rem;
        border: 2px solid var(--gray-200);
    }

    .transaction-info h3 {
        color: var(--gray-900);
        margin-bottom: 0.75rem;
        font-size: 1.25rem;
        font-weight: 600;
    }

    .amount {
        font-size: 2rem;
        font-weight: 700;
        color: var(--danger);
        margin: 0.75rem 0;
    }

    .date {
        color: var(--gray-600);
        font-size: 0.9375rem;
    }

    .related-info {
        margin-bottom: 2rem;
    }

    .related-info>p {
        margin-bottom: 1rem;
        font-size: 1.0625rem;
        color: var(--gray-900);
    }

    .related-info strong {
        color: var(--danger);
    }

    .related-list {
        background: var(--gray-50);
        padding: 1rem;
        border-radius: 10px;
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
        padding: 0.875rem;
        border-bottom: 1px solid var(--gray-200);
        align-items: center;
        background: white;
        border-radius: 6px;
        margin-bottom: 0.5rem;
        transition: all 0.2s;
    }

    .related-item:hover {
        transform: translateX(4px);
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
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
        font-weight: 600;
        color: var(--gray-700);
        text-align: right;
        font-size: 0.9375rem;
    }

    .total-info {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        padding: 1.25rem;
        border-radius: 10px;
        text-align: center;
        font-size: 1.125rem;
        margin-bottom: 2rem;
        border: 2px solid #fca5a5;
    }

    .total-info strong {
        color: var(--danger);
    }

    .options {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .option-card {
        display: flex;
        gap: 1rem;
        padding: 1.25rem;
        border: 2px solid var(--gray-300);
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s;
        background: white;
    }

    .option-card:hover {
        border-color: var(--primary);
        background: var(--gray-50);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .option-card.danger:hover {
        border-color: var(--danger);
        background: #fef2f2;
    }

    .option-card input[type="radio"] {
        margin-top: 0.25rem;
        width: 20px;
        height: 20px;
        cursor: pointer;
        flex-shrink: 0;
    }

    .option-card input[type="radio"]:checked+.option-content {
        color: var(--primary);
    }

    .option-card.danger input[type="radio"]:checked+.option-content {
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
    }

    .option-desc {
        font-size: 0.875rem;
        color: var(--gray-600);
    }

    .actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
    }

    .actions .btn {
        padding: 0.875rem 2rem;
        font-size: 1rem;
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .confirm-delete-card {
            padding: 1.5rem;
            margin: 1rem;
        }

        .related-item {
            grid-template-columns: 1fr;
            gap: 0.5rem;
            padding: 1rem;
        }

        .related-value {
            text-align: left;
        }

        .actions {
            flex-direction: column;
        }

        .actions .btn {
            width: 100%;
        }

        .option-card {
            padding: 1rem;
        }
    }
</style>

<?php include VIEWS . '/layouts/footer.php'; ?>