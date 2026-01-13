<?php include VIEWS . '/layouts/header.php'; ?>

<div class="container-small">
    <div class="card">
        <h1>Editar Transação</h1>


        <?php if ($hasRelated): ?>
            <div class="alert alert-warning">
                ⚠️ Esta transação possui:
                <strong><?= count($related) ?> lançamentos relacionados</strong> (parcelas/recorrências).
                Você pode optar por editar apenas esta ou todas as relacionadas.
            </div>
        <?php endif; ?>

        <div class="card">
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

                    <div class="form-row">
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

                        <div class="form-row">
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
                    </div>

                    <?php if ($hasRelated): ?>
                        <div class="related-section">
                            <h3>Transações Relacionadas</h3>
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
                        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                    </div>
            </form>
        </div>
    </div>

    <style>
        /* Substituir o <style> da página editar.php por este CSS */

        .page-header {
            margin-bottom: 2rem;
        }

        .page-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--gray-900);
        }

        .alert {
            padding: 16px 18px;
            border-radius: 10px;
            font-size: 14px;
            line-height: 1.5;
            margin-bottom: 20px;
        }

        .alert-warning {
            background-color: #fff4cc;
            border: 1px solid #f5c16c;
            color: #8a5a00;
        }

        /* Primeira linha */
        .alert-warning {
            text-align: left;
        }

        /* Centraliza apenas a primeira frase */
        .alert-warning::first-line {
            display: block;
            text-align: center;
            font-weight: 600;
        }

        /* Destaque do número */
        .alert-warning strong {
            color: #6b4500;
            font-weight: 600;
        }

        .help-text {
            display: block;
            font-size: 0.8125rem;
            color: var(--gray-600);
            margin-top: 0.375rem;
        }

        .related-section {
            background: var(--gray-50);
            padding: 1.5rem;
            border-radius: 12px;
            margin: 2rem 0;
            border: 2px solid var(--gray-200);
        }

        .related-section h3 {
            color: var(--gray-900);
            font-size: 1.125rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .related-preview {
            background: white;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            border: 1px solid var(--gray-200);
        }

        .related-item-preview {
            display: grid;
            grid-template-columns: 100px 1fr auto;
            gap: 1rem;
            padding: 0.75rem;
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

        .related-item-preview span:last-child {
            font-weight: 600;
            color: var(--gray-900);
            text-align: right;
        }

        .more-items {
            text-align: center;
            color: var(--gray-500);
            font-style: italic;
            margin-top: 0.75rem;
            font-size: 0.875rem;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem;
            background: white;
            border: 2px solid var(--gray-300);
            border-radius: 10px;
            cursor: pointer;
            margin-bottom: 1rem;
            transition: all 0.2s;
        }

        .checkbox-label:hover {
            background: var(--gray-50);
            border-color: var(--primary);
        }

        .checkbox-label input[type="checkbox"] {
            width: 20px;
            height: 20px;
            cursor: pointer;
            margin: 0;
        }

        .checkbox-label span {
            font-size: 0.9375rem;
        }

        .help-note {
            background: #dbeafe;
            padding: 1rem;
            border-radius: 8px;
            font-size: 0.875rem;
            color: #1e40af;
            border: 1px solid #bfdbfe;
        }

        .help-note strong {
            font-weight: 600;
        }

        /* Máscara de dinheiro */
        .money-input {
            text-align: right;
            font-family: 'Courier New', monospace;
            font-weight: 600;
            font-size: 1.125rem;
            color: var(--primary);
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.25rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group:last-child {
            margin-bottom: 0;
        }

        .form-group label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 0.5rem;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid var(--gray-300);
            border-radius: 8px;
            font-size: 0.9375rem;
            color: var(--gray-900);
            transition: all 0.2s;
            background: white;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-group input:disabled,
        .form-group select:disabled {
            background: var(--gray-100);
            cursor: not-allowed;
            color: var(--gray-500);
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 2px solid var(--gray-200);
        }

        .card {
            background: white;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        }

        .form {
            max-width: 100%;
        }

        /* Container small */
        .container-small {
            max-width: 700px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container-small {
                padding: 1rem;
            }

            .card {
                padding: 1.5rem;
            }

            .form-actions {
                flex-direction: column;
            }

            .form-actions .btn {
                width: 100%;
            }

            .input-with-button {
                flex-direction: column;
            }

            .input-with-button select,
            .input-with-button .btn {
                width: 100%;
            }
        }
    </style>

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
    </script>

    <?php include VIEWS . '/layouts/footer.php'; ?>