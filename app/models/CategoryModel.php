<?php

class CategoryModel extends Model {
    protected $table = 'categories';
    
    public function getByGroup($groupId, $type = null) {
        $sql = "SELECT * FROM {$this->table} WHERE group_id = ?";
        $params = [$groupId];
        
        if ($type) {
            $sql .= " AND type = ?";
            $params[] = $type;
        }
        
        $sql .= " ORDER BY name ASC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    
    public function createCategory($groupId, $name, $type, $icon = 'default', $color = '#6c757d') {
        return $this->create([
            'group_id' => $groupId,
            'name' => $name,
            'type' => $type,
            'icon' => $icon,
            'color' => $color
        ]);
    }
}
