<?php include VIEWS . '/layouts/header.php'; ?>

<style>
    .confirm-container {
        max-width: 600px;
        margin: 3rem auto;
        padding: 2rem;
    }

    .confirm-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        border: 1px solid #e5e7eb;
    }

    .confirm-icon {
        font-size: 4rem;
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .confirm-card h2 {
        text-align: center;
        color: #111827;
        margin-bottom: 1rem;
    }

    .invoice-details {
        background: #f9fafb;
        border-radius: 12px;
        padding: 1.5rem;
        margin: 2rem 0;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        padding: 0.75rem 0;
        border-bottom: 1px solid #e5e7eb;
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-row.total {
        font-size: 1.5rem;
        font-weight: 800;
        color: #ef4444;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 2px solid #e5e7eb;
    }

    .detail-row.highlight {
        background: #fef3c7;
        padding: 0.875rem;
        margin: 0.5rem -0.5rem;
        border-radius: 8px;
        border: none;
    }

    .warning-box {
        background: #fef3c7;
        border-left: 4px solid #f59e0b;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 2rem;
    }
    
    .success-box {
        background: #d1fae5;
        border-left: 4px solid #10b981;
        padding: 1rem;
        border-radius: 8px;
        margin-bottom: 2rem;
        color: #065f46;
    }

    .payment-options {
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        padding: 1.5rem;
        margin: 1.5rem 0;
    }

    .payment-options h3 {
        margin: 0 0 1rem 0;
        color: #374151;
        font-size: 1rem;
        font-weight: 600;
    }

    .payment-option {
        display: flex;
        align-items: center;
        padding: 1rem;
        margin-bottom: 0.75rem;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s;
        border: 2px solid transparent;
    }

    .payment-option:hover {
        background: #f9fafb;
    }

    .payment-option.active {
        background: #eff6ff;
        border-color: #3b82f6;
    }

    .payment-option input[type="radio"] {
        margin-right: 0.75rem;
        width: 20px;
        height: 20px;
        cursor: pointer;
    }

    .payment-option label {
        cursor: pointer;
        flex: 1;
        font-weight: 500;
        color: #374151;
    }

    .payment-option .amount {
        font-weight: 700;
        color: #10b981;
        font-size: 1.125rem;
    }

    .custom-amount-box {
        margin-top: 1rem;
        padding: 1rem;
        background: #f9fafb;
        border-radius: 8px;
        display: none;
    }

    .custom-amount-box.active {
        display: block;
    }

    .custom-amount-box label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: #374151;
    }

    .custom-amount-box input {
        width: 100%;
        padding: 0.875rem;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        font-size: 1.125rem;
        font-weight: 600;
        font-family: 'Courier New', monospace;
        transition: all 0.3s;
    }

    .custom-amount-box input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .remaining-alert {
        margin-top: 0.75rem;
        padding: 0.75rem;
        background: #fef3c7;
        border-left: 3px solid #f59e0b;
        border-radius: 6px;
        font-size: 0.875rem;
        color: #92400e;
        display: none;
    }

    .remaining-alert.show {
        display: block;
    }

    .remaining-alert strong {
        color: #ef4444;
        font-size: 1rem;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }

    .btn {
        flex: 1;
        padding: 1rem 2rem;
        border-radius: 10px;
        font-weight: 600;
        text-align: center;
        text-decoration: none;
        transition: all 0.3s;
        border: none;
        cursor: pointer;
        font-size: 1rem;
    }

    .btn-confirm {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }

    .btn-confirm:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.3);
    }

    .btn-confirm:disabled {
        opacity: 0.5;
        cursor: not-allowed;
        transform: none;
    }

    .btn-cancel {
        background: white;
        color: #6b7280;
        border: 2px solid #e5e7eb;
    }

    .btn-cancel:hover {
        background: #f9fafb;
    }

    @media (max-width: 768px) {
        .confirm-container {
            padding: 1rem;
            margin: 1rem auto;
        }

        .confirm-card {
            padding: 1.5rem;
        }

        .action-buttons {
            flex-direction: column;
        }

        .payment-option {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
    }
</style>

<div class="confirm-container">
    <div class="confirm-card">
        <div class="confirm-icon">💳</div>
        <h2>Confirmar Pagamento da Fatura</h2>

        <?php if ($alreadyPaid > 0): ?>
            <div class="success-box">
                ✓ <strong>Pagamento parcial já registrado:</strong> R$ <?= number_format($alreadyPaid, 2, ',', '.') ?>
            </div>
        <?php else: ?>
            <div class="warning-box">
                ⚠️ <strong>Atenção:</strong> Esta ação registrará o pagamento e criará uma transação de despesa no seu extrato.
            </div>
        <?php endif; ?>

        <div class="invoice-details">
            <div class="detail-row">
                <span>Cartão:</span>
                <strong><?= htmlspecialchars($card['name']) ?></strong>
            </div>
            <div class="detail-row">
                <span>Final:</span>
                <strong><?= $card['last_digits'] ?></strong>
            </div>
            <div class="detail-row">
                <span>Período:</span>
                <strong><?= $monthName ?>/<?= $year ?></strong>
            </div>
            
            <?php if ($alreadyPaid > 0): ?>
                <div class="detail-row">
                    <span>Valor Total da Fatura:</span>
                    <strong>R$ <?= number_format($invoiceTotal, 2, ',', '.') ?></strong>
                </div>
                <div class="detail-row highlight">
                    <span>Já Pago:</span>
                    <strong style="color: #10b981;">- R$ <?= number_format($alreadyPaid, 2, ',', '.') ?></strong>
                </div>
            <?php endif; ?>
            
            <div class="detail-row total">
                <span><?= $alreadyPaid > 0 ? 'Saldo Devedor:' : 'Valor Total:' ?></span>
                <strong>R$ <?= number_format($remainingAmount, 2, ',', '.') ?></strong>
            </div>
        </div>

        <form method="POST" id="paymentForm">
            <div class="payment-options">
                <h3>💰 Como deseja pagar?</h3>

                <div class="payment-option active" onclick="selectPaymentType('total')">
                    <input type="radio" name="payment_type" value="total" id="payment_total" checked>
                    <label for="payment_total">
                        <?= $alreadyPaid > 0 ? 'Pagar saldo restante' : 'Pagar valor total' ?>
                    </label>
                    <span class="amount">R$ <?= number_format($remainingAmount, 2, ',', '.') ?></span>
                </div>

                <div class="payment-option" onclick="selectPaymentType('custom')">
                    <input type="radio" name="payment_type" value="custom" id="payment_custom">
                    <label for="payment_custom">Pagar valor personalizado</label>
                </div>

                <div class="custom-amount-box" id="customAmountBox">
                    <label for="custom_amount">Valor a pagar:</label>
                    <input 
                        type="number" 
                        step="0.01" 
                        name="custom_amount" 
                        id="custom_amount"
                        min="0.01" 
                        max="<?= $remainingAmount ?>" 
                        placeholder="R$ 0,00"
                        oninput="calculateRemaining()">
                    
                    <div class="remaining-alert" id="remainingAlert">
                        ⚠️ Ainda faltará pagar <strong id="remainingValue">R$ 0,00</strong>. Este valor poderá ser pago antes do vencimento ou será movido para a próxima fatura automaticamente.
                    </div>
                </div>
            </div>

            <div class="action-buttons">
                <button type="submit" class="btn btn-confirm" id="confirmBtn">
                    ✓ Confirmar Pagamento
                </button>
                <a href="/cartoes/extrato/<?= $card['id'] ?>?month=<?= $month ?>&year=<?= $year ?>" 
                   class="btn btn-cancel">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<script>
// ✅ CORREÇÃO: Usa o saldo devedor (remainingAmount), não o total
const remainingAmount = <?= $remainingAmount ?>;

function selectPaymentType(type) {
    // Remove active de todos
    document.querySelectorAll('.payment-option').forEach(opt => {
        opt.classList.remove('active');
    });

    // Ativa o selecionado
    const selectedOption = document.querySelector(`#payment_${type}`).closest('.payment-option');
    selectedOption.classList.add('active');

    // Marca o radio
    document.getElementById(`payment_${type}`).checked = true;

    // Mostra/esconde campo customizado
    const customBox = document.getElementById('customAmountBox');
    const customInput = document.getElementById('custom_amount');
    
    if (type === 'custom') {
        customBox.classList.add('active');
        customInput.focus();
    } else {
        customBox.classList.remove('active');
        customInput.value = '';
        document.getElementById('remainingAlert').classList.remove('show');
    }
}

function calculateRemaining() {
    const customAmount = parseFloat(document.getElementById('custom_amount').value) || 0;
    const stillRemaining = remainingAmount - customAmount;
    const remainingAlert = document.getElementById('remainingAlert');
    const confirmBtn = document.getElementById('confirmBtn');

    if (customAmount > 0 && customAmount < remainingAmount) {
        remainingAlert.classList.add('show');
        document.getElementById('remainingValue').textContent = 
            'R$ ' + stillRemaining.toFixed(2).replace('.', ',');
        confirmBtn.disabled = false;
    } else if (customAmount >= remainingAmount) {
        remainingAlert.classList.remove('show');
        confirmBtn.disabled = false;
    } else {
        remainingAlert.classList.remove('show');
        confirmBtn.disabled = true;
    }
}

// Validação antes de enviar
document.getElementById('paymentForm').addEventListener('submit', function(e) {
    const paymentType = document.querySelector('input[name="payment_type"]:checked').value;
    
    if (paymentType === 'custom') {
        const customAmount = parseFloat(document.getElementById('custom_amount').value) || 0;
        
        if (customAmount <= 0) {
            e.preventDefault();
            alert('Por favor, informe um valor válido para pagamento.');
            document.getElementById('custom_amount').focus();
            return false;
        }
        
        if (customAmount > remainingAmount) {
            e.preventDefault();
            alert(`O valor informado não pode ser maior que o saldo devedor de R$ ${remainingAmount.toFixed(2).replace('.', ',')}.`);
            document.getElementById('custom_amount').focus();
            return false;
        }

        // Confirmação extra para pagamento parcial
        if (customAmount < remainingAmount) {
            const stillRemaining = remainingAmount - customAmount;
            const confirm = window.confirm(
                `Você está pagando apenas R$ ${customAmount.toFixed(2).replace('.', ',')} de R$ ${remainingAmount.toFixed(2).replace('.', ',')}.\n\n` +
                `Ainda faltará pagar R$ ${stillRemaining.toFixed(2).replace('.', ',')}.\n\n` +
                `Deseja continuar?`
            );
            
            if (!confirm) {
                e.preventDefault();
                return false;
            }
        }
    }
});
</script>

<?php include VIEWS . '/layouts/footer.php'; ?>