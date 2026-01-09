<?php

class BenefitCardModel extends Model
{
    protected $table = 'benefit_cards';

    /**
     * Busca todos os benefícios de um grupo
     */
    public function getByGroup($groupId)
    {
        $sql = "SELECT * FROM {$this->table} WHERE group_id = ? AND active = 1 ORDER BY type, name";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$groupId]);
        return $stmt->fetchAll();
    }

    /**
     * Busca benefícios por tipo (VR ou VA)
     */
    public function getByType($groupId, $type)
    {
        $sql = "SELECT * FROM {$this->table} WHERE group_id = ? AND type = ? AND active = 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$groupId, $type]);
        return $stmt->fetch();
    }

    /**
     * Atualiza o saldo de um benefício
     */
    public function updateBalance($id, $newBalance)
    {
        $sql = "UPDATE {$this->table} SET current_balance = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$newBalance, $id]);
    }

    /**
     * Debita valor do saldo (quando faz um gasto)
     */
    public function debit($id, $amount)
    {
        $sql = "UPDATE {$this->table} 
                SET current_balance = current_balance - ? 
                WHERE id = ? AND current_balance >= ?";
        $stmt = $this->db->prepare($sql);
        $success = $stmt->execute([$amount, $id, $amount]);

        // Retorna false se não tinha saldo suficiente
        return $stmt->rowCount() > 0;
    }

    /**
     * Credita valor ao saldo (recarga mensal)
     */
    public function credit($id, $amount)
    {
        $sql = "UPDATE {$this->table} 
                SET current_balance = current_balance + ?,
                    last_recharge_date = CURRENT_DATE
                WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$amount, $id]);
    }

    /**
     * Registra uma recarga no histórico
     */
    public function recordRecharge($benefitCardId, $amount)
    {
        $sql = "INSERT INTO benefit_recharges (benefit_card_id, amount, recharge_date) 
                VALUES (?, ?, CURRENT_DATE)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$benefitCardId, $amount]);
    }

    /**
     * Processa recarga mensal automática
     */
    public function processMonthlyRecharge($id)
    {
        // Busca o benefício
        $benefit = $this->findById($id);
        
        if (!$benefit) {
            return false;
        }

        $today = date('j'); // Dia do mês (1-31)
        $rechargeDay = $benefit['recharge_day'];
        $lastRecharge = $benefit['last_recharge_date'];
        
        // Verifica se já recebeu recarga este mês
        if ($lastRecharge && date('Y-m', strtotime($lastRecharge)) === date('Y-m')) {
            return false; // Já recarregou este mês
        }

        // Verifica se hoje é o dia da recarga
        if ($today >= $rechargeDay) {
            // Credita o valor mensal
            $this->credit($id, $benefit['monthly_amount']);
            
            // Registra no histórico
            $this->recordRecharge($id, $benefit['monthly_amount']);
            
            return true;
        }

        return false;
    }

    /**
     * Calcula o gasto do mês atual
     */
    public function getMonthlyExpense($benefitCardId, $month = null, $year = null)
    {
        if (!$month) $month = date('n');
        if (!$year) $year = date('Y');
        
        $sql = "SELECT COALESCE(SUM(amount), 0) as total
                FROM transactions 
                WHERE benefit_card_id = ? 
                AND MONTH(transaction_date) = ?
                AND YEAR(transaction_date) = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$benefitCardId, $month, $year]);
        $result = $stmt->fetch();
        
        return $result['total'] ?? 0;
    }

    /**
     * Verifica todos os benefícios que precisam de recarga hoje
     */
    public function checkPendingRecharges($groupId)
    {
        $benefits = $this->getByGroup($groupId);
        $recharged = [];

        foreach ($benefits as $benefit) {
            if ($this->processMonthlyRecharge($benefit['id'])) {
                $recharged[] = $benefit;
            }
        }

        return $recharged;
    }

    /**
     * Busca histórico de recargas
     */
    public function getRechargeHistory($benefitCardId, $limit = 12)
    {
        $sql = "SELECT * FROM benefit_recharges 
                WHERE benefit_card_id = ? 
                ORDER BY recharge_date DESC 
                LIMIT ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$benefitCardId, $limit]);
        return $stmt->fetchAll();
    }
}