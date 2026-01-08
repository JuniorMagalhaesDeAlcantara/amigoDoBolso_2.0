<?php

class CreditCardModel extends Model {
    protected $table = 'credit_cards';
    
    public function getByGroup($groupId) {
        $sql = "SELECT * FROM {$this->table} WHERE group_id = ? ORDER BY name ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$groupId]);
        return $stmt->fetchAll();
    }
}
