<?php

class TransactionModel extends Model {
    protected $table = 'transactions';
    
    public function createTransaction($data) {
        return $this->create($data);
    }
    
    public function getByGroup($groupId, $month = null, $year = null) {
        $sql = "SELECT t.*, c.name as category_name, c.color, u.name as user_name,
                cc.name as card_name
                FROM {$this->table} t
                INNER JOIN categories c ON t.category_id = c.id
                INNER JOIN users u ON t.user_id = u.id
                LEFT JOIN credit_cards cc ON t.credit_card_id = cc.id
                WHERE t.group_id = ?";
        
        $params = [$groupId];
        
        if ($month && $year) {
            $sql .= " AND MONTH(t.transaction_date) = ? AND YEAR(t.transaction_date) = ?";
            $params[] = $month;
            $params[] = $year;
        }
        
        $sql .= " ORDER BY t.transaction_date DESC, t.created_at DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    
    public function getMonthlyBalance($groupId, $month, $year) {
        $sql = "SELECT 
                    SUM(CASE WHEN type = 'receita' THEN amount ELSE 0 END) as total_income,
                    SUM(CASE WHEN type = 'despesa' THEN amount ELSE 0 END) as total_expense
                FROM {$this->table}
                WHERE group_id = ? 
                AND MONTH(transaction_date) = ? 
                AND YEAR(transaction_date) = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$groupId, $month, $year]);
        return $stmt->fetch();
    }
    
    public function getSpendingByCategory($groupId, $month, $year) {
        $sql = "SELECT 
                    c.name as category_name,
                    c.color,
                    SUM(t.amount) as total,
                    COUNT(t.id) as count
                FROM {$this->table} t
                INNER JOIN categories c ON t.category_id = c.id
                WHERE t.group_id = ? 
                AND t.type = 'despesa'
                AND MONTH(t.transaction_date) = ? 
                AND YEAR(t.transaction_date) = ?
                GROUP BY c.id, c.name, c.color
                ORDER BY total DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$groupId, $month, $year]);
        return $stmt->fetchAll();
    }
    
    /**
     * Calcula a data da primeira parcela baseado no fechamento do cartão
     * 
     * @param string $purchaseDate - Data da compra (Y-m-d)
     * @param int $closingDay - Dia de fechamento do cartão (1-31)
     * @return string - Data da primeira parcela (Y-m-d)
     */
    private function calculateFirstInstallmentDate($purchaseDate, $closingDay) {
        $purchase = new DateTime($purchaseDate);
        $purchaseDay = (int)$purchase->format('d');
        $purchaseMonth = (int)$purchase->format('m');
        $purchaseYear = (int)$purchase->format('Y');
        
        // Se a compra foi ANTES do fechamento, entra na fatura deste mês
        if ($purchaseDay <= $closingDay) {
            // Primeira parcela é neste mês
            return $purchaseDate;
        } else {
            // Se a compra foi DEPOIS do fechamento, entra na fatura do próximo mês
            $firstInstallment = clone $purchase;
            $firstInstallment->modify('+1 month');
            return $firstInstallment->format('Y-m-d');
        }
    }
    
    /**
     * Cria transações parceladas considerando o fechamento do cartão
     */
    public function createInstallments($data, $installments) {
        $results = [];
        $amountPerInstallment = $data['amount'] / $installments;
        
        // Busca informações do cartão para pegar o dia de fechamento
        $creditCardModel = new CreditCardModel();
        $creditCard = $creditCardModel->findById($data['credit_card_id']);
        
        if (!$creditCard) {
            throw new Exception("Cartão de crédito não encontrado");
        }
        
        $closingDay = $creditCard['closing_day'];
        
        // Calcula a data da primeira parcela
        $firstInstallmentDate = $this->calculateFirstInstallmentDate($data['transaction_date'], $closingDay);
        
        // Cria cada parcela
        for ($i = 0; $i < $installments; $i++) {
            // Soma os meses a partir da primeira parcela
            $installmentDate = date('Y-m-d', strtotime($firstInstallmentDate . " +{$i} month"));
            
            $installmentData = array_merge($data, [
                'amount' => $amountPerInstallment,
                'transaction_date' => $installmentDate,
                'installments' => $installments,
                'installment_number' => $i + 1,
                'description' => $data['description'] . " (" . ($i + 1) . "/{$installments})"
            ]);
            
            $results[] = $this->create($installmentData);
        }
        
        return $results;
    }
    
    /**
     * Cria transações recorrentes
     */
    public function createRecurring($data, $months) {
        $results = [];
        
        for ($i = 0; $i < $months; $i++) {
            $recurringDate = date('Y-m-d', strtotime($data['transaction_date'] . " +{$i} month"));
            
            $recurringData = array_merge($data, [
                'transaction_date' => $recurringDate,
                'is_recurring' => true,
                'recurrence_type' => 'mensal',
                'recurrence_months' => $months
            ]);
            
            $results[] = $this->create($recurringData);
        }
        
        return $results;
    }
    
    /**
     * Busca transações de um cartão específico em um mês/ano
     * Usado para montar o extrato/fatura do cartão
     */
    public function getByCard($cardId, $month, $year) {
        $sql = "SELECT t.*, c.name as category_name, c.color, u.name as user_name
                FROM {$this->table} t
                INNER JOIN categories c ON t.category_id = c.id
                INNER JOIN users u ON t.user_id = u.id
                WHERE t.credit_card_id = ?
                AND MONTH(t.transaction_date) = ? 
                AND YEAR(t.transaction_date) = ?
                ORDER BY t.transaction_date ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$cardId, $month, $year]);
        return $stmt->fetchAll();
    }
    
    /**
     * Calcula o total da fatura de um cartão em um período
     */
    public function getCardInvoiceTotal($cardId, $month, $year) {
        $sql = "SELECT SUM(amount) as total
                FROM {$this->table}
                WHERE credit_card_id = ?
                AND MONTH(transaction_date) = ? 
                AND YEAR(transaction_date) = ?
                AND type = 'despesa'";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$cardId, $month, $year]);
        $result = $stmt->fetch();
        
        return $result['total'] ?? 0;
    }
    
    /**
     * Busca transações futuras (próximas parcelas) de um cartão
     */
    public function getUpcomingInstallments($cardId, $limit = 3) {
        $sql = "SELECT t.*, c.name as category_name
                FROM {$this->table} t
                INNER JOIN categories c ON t.category_id = c.id
                WHERE t.credit_card_id = ?
                AND t.transaction_date > CURDATE()
                AND t.installments > 0
                ORDER BY t.transaction_date ASC
                LIMIT ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$cardId, $limit]);
        return $stmt->fetchAll();
    }
}