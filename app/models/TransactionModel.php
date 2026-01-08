<?php

class TransactionModel extends Model {
    protected $table = 'transactions';
    
    public function createTransaction($data) {
        return $this->create($data);
    }
    
    public function getByGroup($groupId, $month = null, $year = null) {
        $sql = "SELECT t.*, c.name as category_name, c.color, u.name as user_name
                FROM {$this->table} t
                INNER JOIN categories c ON t.category_id = c.id
                INNER JOIN users u ON t.user_id = u.id
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
    
    public function createInstallments($data, $installments) {
        $results = [];
        $amountPerInstallment = $data['amount'] / $installments;
        
        for ($i = 1; $i <= $installments; $i++) {
            $installmentDate = date('Y-m-d', strtotime($data['transaction_date'] . " +{$i} month"));
            
            $installmentData = array_merge($data, [
                'amount' => $amountPerInstallment,
                'transaction_date' => $installmentDate,
                'installments' => $installments,
                'installment_number' => $i
            ]);
            
            $results[] = $this->create($installmentData);
        }
        
        return $results;
    }
}
