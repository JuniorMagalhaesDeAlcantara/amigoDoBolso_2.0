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
            <div class="header-actions">
                <button onclick="generateReport()" class="btn btn-secondary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                        <line x1="16" y1="13" x2="8" y2="13" />
                        <line x1="16" y1="17" x2="8" y2="17" />
                        <polyline points="10 9 9 9 8 9" />
                    </svg>
                    Relatório
                </button>
                <a href="/transacoes/criar" class="btn btn-primary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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

            <div class="filter-group">
                <label for="status">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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
                    <div class="transaction-item <?= (!$transaction['paid'] && $transaction['is_recurring'] && $transaction['type'] === 'despesa') ? 'pending' : '' ?>">
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
                                        <!-- Status de Pagamento -->
                                        <?php if (!$transaction['paid']): ?>
                                            <span class="badge badge-pending">
                                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                    <circle cx="12" cy="12" r="10" />
                                                    <polyline points="12 6 12 12 16 14" />
                                                </svg>
                                                Pendente
                                            </span>
                                        <?php endif; ?>

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
                                            <span class="badge badge-payment badge-va">🍽️ VA</span>
                                        <?php elseif ($transaction['payment_method'] === 'vr'): ?>
                                            <span class="badge badge-payment badge-vr">🛒 VR</span>
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


                                <!-- Toggle de Pagamento (só para despesas recorrentes) -->
                                <?php if ($transaction['is_recurring'] && $transaction['type'] === 'despesa'): ?>
                                    <div class="payment-toggle">
                                        <label class="toggle-switch" title="<?= $transaction['paid'] ? 'Marcar como pendente' : 'Marcar como paga' ?>">
                                            <input
                                                type="checkbox"
                                                <?= $transaction['paid'] ? 'checked' : '' ?>
                                                onchange="togglePaymentStatus(<?= $transaction['id'] ?>, this.checked)">
                                            <span class="toggle-slider"></span>
                                        </label>
                                        <span class="toggle-label"><?= $transaction['paid'] ? 'Pago' : 'Pendente' ?></span>
                                    </div>
                                <?php endif; ?>

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

<script>
    function togglePaymentStatus(transactionId, isPaid) {
        const formData = new FormData();
        formData.append('transaction_id', transactionId);
        formData.append('paid', isPaid ? '1' : '0');

        fetch('/transacoes/togglePaid', { // CORRIGIDO: adicionar / no início
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(text => {
                const cleanText = text.replace(/^\uFEFF/, '').trim();
                const data = JSON.parse(cleanText);

                if (data.success) {
                    showToast(
                        isPaid ? 'Transação marcada como paga!' : 'Transação marcada como pendente',
                        'success'
                    );

                    const item = event.target.closest('.transaction-item');
                    if (isPaid) {
                        item.classList.remove('pending');
                    } else {
                        item.classList.add('pending');
                    }

                    updatePendingBadge(item, isPaid);
                } else {
                    showToast('Erro ao atualizar status', 'error');
                    event.target.checked = !isPaid;
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                showToast('Erro ao atualizar status', 'error');
                event.target.checked = !isPaid;
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

    function generateReport() {
        const month = document.getElementById('month').value;
        const year = document.getElementById('year').value;
        const monthNames = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
            'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
        ];

        // Coleta dados dos cards
        const cards = document.querySelectorAll('.summary-card .card-value');
        const receitas = cards[0]?.textContent.replace('R$ ', '') || '0,00';
        const despesas = cards[1]?.textContent.replace('R$ ', '') || '0,00';
        const saldo = cards[2]?.textContent.replace('R$ ', '') || '0,00';
        const totalTransacoes = cards[3]?.textContent || '0';

        const printWindow = window.open('', '', 'width=900,height=700');

        printWindow.document.write(`
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório - ${monthNames[month-1]}/${year}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Segoe UI', Arial, sans-serif; 
            padding: 2rem; 
            color: #333;
            line-height: 1.6;
        }
        .header { 
            text-align: center; 
            margin-bottom: 2.5rem; 
            border-bottom: 4px solid #667eea; 
            padding-bottom: 1.5rem; 
        }
        .header h1 { 
            color: #667eea; 
            font-size: 2.5rem; 
            margin-bottom: 0.5rem;
            font-weight: 700;
        }
        .header .period { 
            color: #374151; 
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        .header .generated { 
            color: #6b7280; 
            font-size: 0.875rem; 
        }
        
        .summary { 
            display: grid; 
            grid-template-columns: repeat(4, 1fr); 
            gap: 1.5rem; 
            margin-bottom: 3rem; 
        }
        .summary-item { 
            background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
            padding: 1.5rem; 
            border-radius: 12px; 
            border-left: 5px solid #667eea;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .summary-item.income { 
            border-left-color: #10b981;
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
        }
        .summary-item.expense { 
            border-left-color: #ef4444;
            background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
        }
        .summary-item.balance { 
            border-left-color: #667eea;
            background: linear-gradient(135deg, #eef2ff 0%, #e0e7ff 100%);
        }
        .summary-item.total { 
            border-left-color: #f59e0b;
            background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
        }
        .summary-label { 
            display: block; 
            font-size: 0.875rem; 
            color: #6b7280; 
            margin-bottom: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .summary-value { 
            display: block; 
            font-size: 1.75rem; 
            font-weight: 800; 
            color: #1f2937; 
        }
        
        .actions { 
            text-align: center; 
            margin: 2rem 0 3rem; 
        }
        .btn { 
            padding: 0.875rem 2rem; 
            margin: 0 0.5rem; 
            border: none; 
            border-radius: 8px; 
            cursor: pointer; 
            font-size: 0.9375rem; 
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transition: all 0.3s;
        }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 6px 16px rgba(0,0,0,0.2); }
        .btn-print { background: #667eea; color: white; }
        .btn-download { background: #10b981; color: white; }
        
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 1rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            border-radius: 8px;
            overflow: hidden;
        }
        th { 
            background: #667eea; 
            color: white; 
            padding: 1rem; 
            text-align: left; 
            font-size: 0.875rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        td { 
            padding: 0.875rem 1rem; 
            border-bottom: 1px solid #e5e7eb; 
            font-size: 0.9375rem; 
        }
        tr:nth-child(even) { background: #f9fafb; }
        tr:hover { background: #f3f4f6; }
        .receita { color: #10b981; font-weight: 700; }
        .despesa { color: #ef4444; font-weight: 700; }
        
        .footer { 
            margin-top: 3rem; 
            padding-top: 1.5rem; 
            border-top: 3px solid #e5e7eb; 
            text-align: center; 
            color: #6b7280; 
            font-size: 0.875rem; 
        }
        
        @media print {
            .no-print { display: none; }
            body { padding: 1rem; }
            .btn { display: none; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📊 Relatório Financeiro</h1>
        <p class="period">${monthNames[month-1]} de ${year}</p>
        <p class="generated">Gerado em ${new Date().toLocaleDateString('pt-BR')} às ${new Date().toLocaleTimeString('pt-BR')}</p>
    </div>
    
    <div class="summary">
        <div class="summary-item income">
            <span class="summary-label">💚 Receitas</span>
            <span class="summary-value">R$ ${receitas}</span>
        </div>
        <div class="summary-item expense">
            <span class="summary-label">💸 Despesas</span>
            <span class="summary-value">R$ ${despesas}</span>
        </div>
        <div class="summary-item balance">
            <span class="summary-label">💰 Saldo</span>
            <span class="summary-value">${saldo}</span>
        </div>
        <div class="summary-item total">
            <span class="summary-label">📋 Transações</span>
            <span class="summary-value">${totalTransacoes}</span>
        </div>
    </div>
    
    <div class="actions no-print">
        <button class="btn btn-print" onclick="window.print()">🖨️ Imprimir</button>
        <button class="btn btn-download" onclick="alert('Para salvar em PDF, use Ctrl+P e selecione \\'Salvar como PDF\\' no destino.'); window.print();">📥 Salvar PDF</button>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Descrição</th>
                <th>Categoria</th>
                <th>Tipo</th>
                <th style="text-align: right;">Valor</th>
            </tr>
        </thead>
        <tbody>
            ${Array.from(document.querySelectorAll('.transaction-item')).map(item => {
                const dateElement = item.querySelector('.badge-date');
                const date = dateElement ? dateElement.textContent.trim().replace(/\s+/g, ' ') : '';
                const description = item.querySelector('.transaction-info h4')?.textContent.trim() || '';
                const categoryElement = item.querySelector('.badge-category');
                const category = categoryElement ? categoryElement.textContent.trim().replace(/\s+/g, ' ') : '';
                const value = item.querySelector('.transaction-value')?.textContent.trim() || '';
                const type = value.startsWith('+') ? 'Receita' : 'Despesa';
                const typeClass = value.startsWith('+') ? 'receita' : 'despesa';
                
                return `
                    <tr>
                        <td>${date}</td>
                        <td>${description}</td>
                        <td>${category}</td>
                        <td>${type}</td>
                        <td class="${typeClass}" style="text-align: right; font-weight: bold;">${value}</td>
                    </tr>
                `;
            }).join('')}
        </tbody>
    </table>
    
    <div class="footer">
        <p><strong>Sistema de Gestão Financeira</strong></p>
        <p>Relatório gerado automaticamente • Todos os valores em Reais (R$)</p>
    </div>
</body>
</html>
        `);

        printWindow.document.close();
    }
</script>

</script>

<style>
    :root {
        --primary: #667eea;
        --secondary: #10b981;
        --danger: #ef4444;
        --warning: #f59e0b;
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
        min-width: 150px;
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
        transition: all 0.15s;
    }

    .transaction-item.pending {
        background: rgba(245, 158, 11, 0.03);
        border-left: 3px solid var(--warning);
    }

    .transaction-item:last-child {
        border-bottom: none;
    }

    .transaction-item:hover {
        background: var(--gray-50);
    }

    /* TOGGLE DE PAGAMENTO */
    .payment-toggle {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-shrink: 0;
    }

    .toggle-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--gray-600);
        white-space: nowrap;
    }

    input:checked~.toggle-slider+.toggle-label {
        color: var(--secondary);
    }

    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 44px;
        height: 24px;
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
        border-radius: 24px;
    }

    .toggle-slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
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
        transform: translateX(20px);
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
        gap: 1.5rem;
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

    .badge-pending {
        background: rgba(245, 158, 11, 0.15);
        color: #d97706;
        font-weight: 600;
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

    .transaction-item.pending .transaction-value {
        opacity: 0.7;
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

    /* SUMMARY CARDS */
    .summary-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1rem;
        margin-bottom: 1.25rem;
    }

    .summary-card {
        background: white;
        border-radius: 10px;
        padding: 1.25rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: transform 0.2s;
    }

    .summary-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .summary-card .card-icon {
        width: 48px;
        height: 48px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .income-card .card-icon {
        background: rgba(16, 185, 129, 0.12);
        color: var(--secondary);
    }

    .expense-card .card-icon {
        background: rgba(239, 68, 68, 0.12);
        color: var(--danger);
    }

    .balance-card .card-icon {
        background: rgba(102, 126, 234, 0.12);
        color: var(--primary);
    }

    .invoice-card .card-icon {
        background: rgba(245, 158, 11, 0.12);
        color: var(--warning);
    }

    .card-content {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .card-label {
        font-size: 0.8125rem;
        color: var(--gray-600);
        font-weight: 500;
    }

    .card-value {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--gray-900);
    }

    .card-value.positive {
        color: var(--secondary);
    }

    .card-value.negative {
        color: var(--danger);
    }

    .header-actions {
        display: flex;
        gap: 0.75rem;
    }

    @media (max-width: 768px) {
        .summary-cards {
            grid-template-columns: 1fr;
        }

        .header-actions {
            flex-direction: column;
        }
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

        .payment-toggle {
            order: 1;
        }

        .transaction-icon {
            order: 2;
        }

        .transaction-content {
            order: 3;
            width: 100%;
        }

        .transaction-main {
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