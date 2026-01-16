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
        max-width: 780px;
        margin: 0 auto;
        padding: 2rem;
    }

    /* ========== CARD ========== */
    .card {
        background: white;
        border-radius: 16px;
        padding: 2.5rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--gray-200);
    }

    .card h1 {
        font-size: 1.875rem;
        font-weight: 700;
        color: var(--gray-900);
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        line-height: 1.2;
    }

    /* ========== ALERTS ========== */
    .alert {
        display: flex;
        align-items: flex-start;
        gap: 0.875rem;
        padding: 1.125rem 1.5rem;
        border-radius: 12px;
        margin-bottom: 2rem;
        font-size: 0.9375rem;
        line-height: 1.5;
        animation: slideDown 0.3s ease-out;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .alert-warning {
        background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
        border: 2px solid #fbbf24;
        color: #92400e;
    }

    .alert strong {
        font-weight: 700;
        color: var(--gray-900);
    }

    /* ========== FORM ========== */
    .form {
        max-width: 100%;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.25rem;
        margin-bottom: 1.75rem;
    }

    .form-group {
        margin-bottom: 1.75rem;
    }

    .form-group:last-child {
        margin-bottom: 0;
    }

    .form-group label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9375rem;
        font-weight: 600;
        color: var(--gray-700);
        margin-bottom: 0.625rem;
        line-height: 1.4;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
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

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.12);
        background: var(--gray-50);
    }

    .form-group input:disabled,
    .form-group select:disabled {
        background: var(--gray-100);
        cursor: not-allowed;
        color: var(--gray-500);
        border-color: var(--gray-200);
    }

    .form-group input::placeholder {
        color: var(--gray-400);
    }

    /* ========== HELP TEXT ========== */
    .help-text {
        display: block;
        margin-top: 0.625rem;
        color: var(--gray-500);
        font-size: 0.8125rem;
        line-height: 1.5;
    }

    /* ========== MONEY INPUT ========== */
    .money-input {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary);
        text-align: right;
        font-family: 'Courier New', monospace;
        letter-spacing: 0.5px;
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(102, 126, 234, 0.02) 100%);
    }

    .money-input:disabled {
        color: var(--gray-500);
        background: var(--gray-100);
    }

    /* ========== RELATED SECTION ========== */
    .related-section {
        background: linear-gradient(135deg, var(--gray-50) 0%, white 100%);
        padding: 1.75rem;
        border-radius: 12px;
        margin: 2rem 0;
        border: 2px solid var(--gray-200);
    }

    .related-section h3 {
        color: var(--gray-900);
        font-size: 1.125rem;
        font-weight: 600;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .related-preview {
        background: white;
        padding: 1rem;
        border-radius: 10px;
        margin-bottom: 1.25rem;
        border: 1px solid var(--gray-200);
    }

    .related-item-preview {
        display: grid;
        grid-template-columns: 100px 1fr auto;
        gap: 1rem;
        padding: 0.875rem;
        border-bottom: 1px solid var(--gray-100);
        font-size: 0.875rem;
        align-items: center;
    }

    .related-item-preview:last-child {
        border-bottom: none;
    }

    .related-item-preview span:first-child {
        font-weight: 600;
        color: var(--primary);
    }

    .related-item-preview span:nth-child(2) {
        color: var(--gray-700);
    }

    .related-item-preview span:last-child {
        font-weight: 700;
        color: var(--gray-900);
        text-align: right;
        font-family: 'Courier New', monospace;
    }

    .more-items {
        text-align: center;
        color: var(--gray-500);
        font-style: italic;
        margin-top: 0.75rem;
        font-size: 0.875rem;
    }

    /* ========== CHECKBOX LABEL ========== */
    .checkbox-label {
        display: flex;
        align-items: center;
        gap: 0.875rem;
        padding: 1.125rem 1.25rem;
        background: white;
        border: 2px solid var(--gray-300);
        border-radius: 12px;
        cursor: pointer;
        transition: var(--transition);
        margin-bottom: 1.25rem;
    }

    .checkbox-label:hover {
        background: var(--gray-50);
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.08);
    }

    .checkbox-label input[type="checkbox"] {
        width: 20px;
        height: 20px;
        cursor: pointer;
        margin: 0;
        flex-shrink: 0;
        accent-color: var(--primary);
    }

    .checkbox-label span {
        font-weight: 600;
        color: var(--gray-900);
        font-size: 0.9375rem;
    }

    /* ========== HELP NOTE ========== */
    .help-note {
        background: #dbeafe;
        padding: 1.125rem;
        border-radius: 10px;
        font-size: 0.875rem;
        color: #1e40af;
        border: 1px solid #bfdbfe;
        line-height: 1.6;
    }

    .help-note strong {
        font-weight: 700;
    }

    /* ========== BUTTONS ========== */
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.875rem 1.75rem;
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
        border-color: var(--gray-300);
        background: var(--gray-50);
    }

    /* ========== FORM ACTIONS ========== */
    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2.5rem;
        padding-top: 2rem;
        border-top: 2px solid var(--gray-200);
    }

    .form-actions .btn {
        flex: 1;
    }

    /* ========== RESPONSIVE - TABLET ========== */
    @media (max-width: 1024px) {
        .container-small {
            padding: 1.5rem;
        }

        .card {
            padding: 2rem;
        }

        .card h1 {
            font-size: 1.625rem;
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

        .card h1 {
            font-size: 1.5rem;
            gap: 0.5rem;
        }

        .form-row {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            font-size: 0.875rem;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            padding: 0.75rem 1rem;
            font-size: 16px; /* Previne zoom no iOS */
            border-radius: 10px;
        }

        .money-input {
            font-size: 1.25rem;
        }

        .related-section {
            padding: 1.25rem;
        }

        .related-item-preview {
            grid-template-columns: 1fr;
            gap: 0.5rem;
            padding: 0.75rem;
        }

        .related-item-preview span {
            text-align: left !important;
        }

        .checkbox-label {
            padding: 1rem;
            gap: 0.75rem;
        }

        .checkbox-label span {
            font-size: 0.875rem;
        }

        .form-actions {
            flex-direction: column;
            gap: 0.75rem;
            margin-top: 2rem;
            padding-top: 1.5rem;
        }

        .form-actions .btn {
            width: 100%;
            padding: 1rem 1.5rem;
        }

        .alert {
            padding: 1rem;
            font-size: 0.875rem;
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

        .card h1 {
            font-size: 1.375rem;
        }

        .money-input {
            font-size: 1.125rem;
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
        <h1>✏️ Editar Transação</h1>

        <?php if ($hasRelated): ?>
            <div class="alert alert-warning">
              <a> ⚠️ Esta transação possui: 
                <strong><?= count($related) ?> lançamentos relacionados</strong> (parcelas/recorrências).
                Você pode optar por editar apenas esta ou todas as relacionadas.</a>
            </div>
        <?php endif; ?>

        <form method="POST" action="/transacoes/editar/<?= $transaction['id'] ?>" class="form">
            <div class="form-row">
                <div class="form-group">
                    <label for="tipo">💰 Tipo *</label>
                    <select id="tipo" name="tipo" required disabled>
                        <option value="despesa" <?= $transaction['type'] === 'despesa' ? 'selected' : '' ?>>Despesa</option>
                        <option value="receita" <?= $transaction['type'] === 'receita' ? 'selected' : '' ?>>Receita</option>
                    </select>
                    <small class="help-text">Tipo não pode ser alterado</small>
                </div>

                <div class="form-group">
                    <label for="valor">💵 Valor (R$) *</label>
                    <input
                        type="text"
                        id="valor"
                        name="amount"
                        value="<?= number_format($transaction['amount'], 2, ',', '.') ?>"
                        class="money-input"
                        <?= $transaction['is_installment'] ? 'disabled' : '' ?>
                        required>
                    <?php if ($transaction['is_installment']): ?>
                        <small class="help-text">⚠️ Valor de parcelas não pode ser alterado</small>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-group">
                <label for="descricao">📝 Descrição *</label>
                <input
                    type="text"
                    id="descricao"
                    name="description"
                    value="<?= htmlspecialchars($transaction['description']) ?>"
                    required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="categoria_id">🏷️ Categoria *</label>
                    <select id="categoria_id" name="category_id">
                        <option value="">Sem categoria</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= $cat['id'] == $transaction['category_id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="data_transacao">📅 Data *</label>
                    <input
                        type="date"
                        id="data_transacao"
                        name="transaction_date"
                        value="<?= $transaction['transaction_date'] ?>"
                        <?= $transaction['is_installment'] ? 'disabled' : '' ?>
                        required>
                    <?php if ($transaction['is_installment']): ?>
                        <small class="help-text">⚠️ Data de parcelas não pode ser alterada</small>
                    <?php endif; ?>
                </div>
            </div>

            <?php if ($hasRelated): ?>
                <div class="related-section">
                    <h3>🔗 Transações Relacionadas</h3>
                    <div class="related-preview">
                        <?php foreach (array_slice($related, 0, 3) as $r): ?>
                            <div class="related-item-preview">
                                <span><?= date('d/m/Y', strtotime($r['transaction_date'])) ?></span>
                                <span><?= htmlspecialchars($r['description']) ?></span>
                                <span>R$ <?= number_format($r['amount'], 2, ',', '.') ?></span>
                            </div>
                        <?php endforeach; ?>

                        <?php if (count($related) > 3): ?>
                            <p class="more-items">... e mais <?= count($related) - 3 ?> transações</p>
                        <?php endif; ?>
                    </div>

                    <label class="checkbox-label">
                        <input type="checkbox" name="update_related" value="1" id="update_related">
                        <span>Aplicar alterações em <strong>TODAS</strong> as <?= count($related) ?> transações relacionadas</span>
                    </label>

                    <div class="help-note">
                        💡 <strong>Dica:</strong> Se marcar esta opção, categoria e descrição serão atualizadas em todas as parcelas/recorrências.
                        <?php if ($transaction['is_installment']): ?>
                            O <strong>valor e a data</strong> não serão alterados em compras parceladas para manter a integridade de cada parcela.
                        <?php else: ?>
                            O valor será aplicado em todas as recorrências.
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="form-actions">
                <a href="/transacoes" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">💾 Salvar Alterações</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Máscara de dinheiro no input
    document.getElementById('valor').addEventListener('input', function(e) {
        let value = e.target.value;

        // Remove tudo que não é número
        value = value.replace(/\D/g, '');

        // Converte para centavos
        value = (parseInt(value) / 100).toFixed(2);

        // Formata para BR
        value = value.replace('.', ',');
        value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

        e.target.value = value;
    });

    // Aviso ao marcar checkbox
    document.getElementById('update_related')?.addEventListener('change', function() {
        if (this.checked) {
            if (!confirm('Tem certeza que deseja aplicar as alterações em TODAS as transações relacionadas?')) {
                this.checked = false;
            }
        }
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