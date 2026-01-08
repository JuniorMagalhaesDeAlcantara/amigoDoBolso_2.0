<?php

class GoalModel extends Model {
    protected $table = 'goals';
    
    public function getByGroup($groupId, $status = null) {
        $sql = "SELECT * FROM {$this->table} WHERE group_id = ?";
        $params = [$groupId];
        
        if ($status) {
            $sql .= " AND status = ?";
            $params[] = $status;
        }
        
        $sql .= " ORDER BY deadline ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    
    public function createGoal($groupId, $name, $targetAmount, $deadline) {
        return $this->create([
            'group_id' => $groupId,
            'name' => $name,
            'target_amount' => $targetAmount,
            'current_amount' => 0,
            'deadline' => $deadline,
            'status' => 'em_andamento'
        ]);
    }
    
    public function addProgress($goalId, $amount) {
        $sql = "UPDATE {$this->table} 
                SET current_amount = current_amount + ? 
                WHERE id = ?";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$amount, $goalId]);
    }
    
    public function getProgress($goalId) {
        $goal = $this->findById($goalId);
        
        if (!$goal) return null;
        
        $percentage = ($goal['current_amount'] / $goal['target_amount']) * 100;
        $remaining = $goal['target_amount'] - $goal['current_amount'];
        
        $today = new DateTime();
        $deadline = new DateTime($goal['deadline']);
        $daysRemaining = $today->diff($deadline)->days;
        
        return [
            'percentage' => min(100, $percentage),
            'remaining' => max(0, $remaining),
            'days_remaining' => $daysRemaining,
            'is_overdue' => $today > $deadline
        ];
    }
}
