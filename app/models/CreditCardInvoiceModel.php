<?php

class CreditCardInvoiceModel extends Model
{
    protected $table = 'credit_card_invoices';

    /**
     * Registra pagamento de fatura
     */
    public function payInvoice($cardId, $month, $year, $totalAmount, $paidAmount, $userId)
    {
        $creditCardModel = new CreditCardModel();
        $card = $creditCardModel->findById($cardId);
        
        $existing = $this->findInvoice($cardId, $month, $year);

        // Se já existe
        if ($existing) {
            $newPaidAmount = $existing['paid_amount'] + $paidAmount;
            $newRemainingAmount = $totalAmount - $newPaidAmount;
            
            // Se quitou totalmente E tinha saldo devedor movido
            if ($newRemainingAmount <= 0 && $existing['overdue_moved_to_next']) {
                $this->removeOverdueDebt($cardId, $month, $year);
            }
            
            $sql = "UPDATE {$this->table} 
                    SET total_amount = ?,
                        paid_amount = ?, 
                        remaining_amount = ?,
                        paid_at = NOW(),
                        is_overdue = 0
                    WHERE id = ?";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$totalAmount, $newPaidAmount, $newRemainingAmount, $existing['id']]);
            
            // REGISTRA O PAGAMENTO COMO TRANSAÇÃO DE DESPESA
            $this->registerPaymentTransaction($card, $month, $year, $paidAmount, $userId);
            
            return $existing['id'];
        }

        // Se não existe, cria novo registro
        $data = [
            'credit_card_id' => $cardId,
            'month' => $month,
            'year' => $year,
            'total_amount' => $totalAmount,
            'paid_amount' => $paidAmount,
            'remaining_amount' => $totalAmount - $paidAmount,
            'paid_at' => date('Y-m-d H:i:s'),
            'paid_by' => $userId,
            'is_overdue' => 0,
            'overdue_moved_to_next' => 0
        ];

        $invoiceId = $this->create($data);

        // REGISTRA O PAGAMENTO COMO TRANSAÇÃO DE DESPESA
        $this->registerPaymentTransaction($card, $month, $year, $paidAmount, $userId);

        // ❌ REMOVIDO: NÃO cria débito imediatamente
        // O débito só será criado pelo CRON quando a fatura vencer sem pagamento total

        return $invoiceId;
    }
    
    /**
     * Registra o pagamento da fatura como transação de despesa
     */
    private function registerPaymentTransaction($card, $month, $year, $paidAmount, $userId)
    {
        $transactionModel = new TransactionModel();
        $categoryModel = new CategoryModel();
        
        // Busca ou cria categoria "Pagamento Cartão"
        $paymentCategory = $categoryModel->findByName($card['group_id'], 'Pagamento Cartão');
        
        if (!$paymentCategory) {
            $categoryId = $categoryModel->create([
                'group_id' => $card['group_id'],
                'name' => 'Pagamento Cartão',
                'type' => 'despesa',
                'color' => '#8b5cf6'
            ]);
        } else {
            $categoryId = $paymentCategory['id'];
        }
        
        // ✅ CORREÇÃO: Data do pagamento deve ser dentro do período da fatura
        // para aparecer no extrato do cartão
        $creditCardModel = new CreditCardModel();
        $cardData = $creditCardModel->findById($card['id']);
        
        // Define a data como o dia de vencimento da fatura sendo paga
        $paymentDate = sprintf('%04d-%02d-%02d', $year, $month, $cardData['due_day']);
        
        // Se a data de vencimento já passou, usa a data de hoje
        if (strtotime($paymentDate) > time()) {
            $paymentDate = date('Y-m-d');
        }
        
        // Cria transação (NEGATIVA porque é pagamento que SAI do seu saldo)
        $transactionModel->create([
            'group_id' => $card['group_id'],
            'user_id' => $userId,
            'category_id' => $categoryId,
            'description' => "💳 Pagamento fatura {$month}/{$year} - " . $card['name'],
            'amount' => $paidAmount,
            'type' => 'despesa',
            'transaction_date' => $paymentDate,
            'payment_method' => 'debito',
            'credit_card_id' => $card['id'], // ✅ IMPORTANTE: Vincula ao cartão
            'paid' => 1
        ]);
    }

    /**
     * Cria débito de saldo devedor na próxima fatura (pagamento parcial)
     * ⚠️ ESTE MÉTODO AGORA SÓ DEVE SER CHAMADO PELO CRON NO VENCIMENTO
     */
    private function createRemainingDebt($cardId, $month, $year, $amount, $userId)
    {
        $creditCardModel = new CreditCardModel();
        $card = $creditCardModel->findById($cardId);

        // Próximo mês
        $nextMonth = $month + 1;
        $nextYear = $year;
        if ($nextMonth > 12) {
            $nextMonth = 1;
            $nextYear++;
        }

        // Data da transação: dia de vencimento do mês atual + 1
        $debtDate = sprintf('%04d-%02d-%02d', $year, $month, $card['due_day']);
        $debtDateTime = new DateTime($debtDate);
        $debtDateTime->modify('+1 day');

        $transactionModel = new TransactionModel();
        $categoryModel = new CategoryModel();
        
        // Busca ou cria categoria "Pagamento Parcial Cartão"
        $debtCategory = $categoryModel->findByName($card['group_id'], 'Pagamento Parcial Cartão');
        
        if (!$debtCategory) {
            $categoryId = $categoryModel->create([
                'group_id' => $card['group_id'],
                'name' => 'Pagamento Parcial Cartão',
                'type' => 'despesa',
                'color' => '#f59e0b'
            ]);
        } else {
            $categoryId = $debtCategory['id'];
        }
        
        $transactionModel->create([
            'group_id' => $card['group_id'],
            'user_id' => $userId,
            'category_id' => $categoryId,
            'description' => "💳 Saldo devedor fatura {$month}/{$year} - " . $card['name'],
            'amount' => $amount,
            'type' => 'despesa',
            'transaction_date' => $debtDateTime->format('Y-m-d'),
            'payment_method' => 'credito',
            'credit_card_id' => $cardId,
            'paid' => 0
        ]);
    }

    /**
     * Move saldo devedor para próxima fatura (quando vence sem pagar)
     */
    public function moveOverdueToNextInvoice($cardId, $month, $year, $amount, $userId)
    {
        $creditCardModel = new CreditCardModel();
        $card = $creditCardModel->findById($cardId);
        
        // Próximo mês
        $nextMonth = $month + 1;
        $nextYear = $year;
        if ($nextMonth > 12) {
            $nextMonth = 1;
            $nextYear++;
        }
        
        // Data: dia seguinte ao vencimento
        $debtDate = sprintf('%04d-%02d-%02d', $year, $month, $card['due_day']);
        $debtDateTime = new DateTime($debtDate);
        $debtDateTime->modify('+1 day');
        
        $transactionModel = new TransactionModel();
        $categoryModel = new CategoryModel();
        
        // Busca ou cria categoria "Fatura Atrasada"
        $debtCategory = $categoryModel->findByName($card['group_id'], 'Fatura Atrasada');
        
        if (!$debtCategory) {
            $categoryId = $categoryModel->create([
                'group_id' => $card['group_id'],
                'name' => 'Fatura Atrasada',
                'type' => 'despesa',
                'color' => '#dc2626'
            ]);
        } else {
            $categoryId = $debtCategory['id'];
        }
        
        // Cria transação de débito
        $transactionId = $transactionModel->create([
            'group_id' => $card['group_id'],
            'user_id' => $userId,
            'category_id' => $categoryId,
            'description' => "💳 Fatura vencida {$month}/{$year} - " . $card['name'],
            'amount' => $amount,
            'type' => 'despesa',
            'transaction_date' => $debtDateTime->format('Y-m-d'),
            'payment_method' => 'credito',
            'credit_card_id' => $cardId,
            'paid' => 0
        ]);
        
        // Marca a fatura como tendo movido o saldo
        $sql = "UPDATE {$this->table} 
                SET is_overdue = 1,
                    overdue_moved_to_next = 1,
                    overdue_transaction_id = ?
                WHERE credit_card_id = ? AND month = ? AND year = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$transactionId, $cardId, $month, $year]);
        
        return $transactionId;
    }

    /**
     * Remove saldo devedor quando paga atrasado
     */
    public function removeOverdueDebt($cardId, $month, $year)
    {
        $invoice = $this->findInvoice($cardId, $month, $year);
        
        if (!$invoice || !$invoice['overdue_transaction_id']) {
            return false;
        }
        
        // Deleta a transação de débito que foi criada
        $transactionModel = new TransactionModel();
        $transactionModel->delete($invoice['overdue_transaction_id']);
        
        // Atualiza a fatura
        $sql = "UPDATE {$this->table} 
                SET overdue_moved_to_next = 0,
                    overdue_transaction_id = NULL
                WHERE credit_card_id = ? AND month = ? AND year = ?";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$cardId, $month, $year]);
    }

    /**
     * Verifica se fatura está TOTALMENTE paga
     * ✅ CORRIGIDO: Compara paid_amount com total_amount
     */
    public function isInvoicePaid($cardId, $month, $year)
    {
        $invoice = $this->findInvoice($cardId, $month, $year);
        
        if (!$invoice) {
            return false;
        }
        
        // Fatura está paga se paid_amount >= total_amount
        return $invoice['paid_amount'] >= $invoice['total_amount'];
    }

    /**
     * Busca fatura específica
     */
    public function findInvoice($cardId, $month, $year)
    {
        $sql = "SELECT * FROM {$this->table} 
                WHERE credit_card_id = ? AND month = ? AND year = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$cardId, $month, $year]);
        return $stmt->fetch();
    }

    /**
     * Total de faturas pagas no mês (para cálculo de saldo)
     */
    public function getPaidInMonth($groupId, $month, $year)
    {
        $sql = "SELECT COALESCE(SUM(i.paid_amount), 0) as total
                FROM {$this->table} i
                INNER JOIN credit_cards c ON i.credit_card_id = c.id
                WHERE c.group_id = ?
                AND MONTH(i.paid_at) = ?
                AND YEAR(i.paid_at) = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$groupId, $month, $year]);
        $result = $stmt->fetch();

        return floatval($result['total'] ?? 0);
    }

    /**
     * Histórico de pagamentos do cartão
     */
    public function getCardHistory($cardId, $limit = 12)
    {
        $sql = "SELECT i.*, u.name as paid_by_name
                FROM {$this->table} i
                INNER JOIN users u ON i.paid_by = u.id
                WHERE i.credit_card_id = ?
                ORDER BY i.year DESC, i.month DESC
                LIMIT ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$cardId, $limit]);
        return $stmt->fetchAll();
    }

    /**
     * Cancela pagamento (em caso de erro)
     */
    public function cancelPayment($cardId, $month, $year)
    {
        $sql = "DELETE FROM {$this->table} 
                WHERE credit_card_id = ? AND month = ? AND year = ?";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$cardId, $month, $year]);
    }
    
    /**
     * ✅ NOVO: Processa faturas vencidas (chamado pelo CRON)
     * Verifica faturas que venceram e move saldo devedor para próxima fatura
     */
    public function processOverdueInvoices()
    {
        // Busca todas as faturas que:
        // 1. Têm saldo devedor (remaining_amount > 0)
        // 2. Venceram (data de vencimento já passou)
        // 3. Ainda não tiveram o saldo movido
        
        $sql = "SELECT i.*, c.due_day, c.group_id
                FROM {$this->table} i
                INNER JOIN credit_cards c ON i.credit_card_id = c.id
                WHERE i.remaining_amount > 0
                AND i.overdue_moved_to_next = 0
                AND CONCAT(i.year, '-', LPAD(i.month, 2, '0'), '-', LPAD(c.due_day, 2, '0')) < CURDATE()";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $overdueInvoices = $stmt->fetchAll();
        
        foreach ($overdueInvoices as $invoice) {
            // Move o saldo devedor para a próxima fatura
            $this->moveOverdueToNextInvoice(
                $invoice['credit_card_id'],
                $invoice['month'],
                $invoice['year'],
                $invoice['remaining_amount'],
                $invoice['paid_by'] // Usa o mesmo usuário que fez o último pagamento
            );
        }
        
        return count($overdueInvoices);
    }
}