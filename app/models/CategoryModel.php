<?php

class CategoryModel extends Model
{
    protected $table = 'categories';

    public function getByGroup($groupId, $type = null)
    {
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

    public function createCategory($groupId, $name, $type, $icon = 'default', $color = '#6c757d')
    {
        return $this->create([
            'group_id' => $groupId,
            'name' => $name,
            'type' => $type,
            'icon' => $icon,
            'color' => $color
        ]);
    }

    public function findByName($groupId, $name)
    {
        $sql = "SELECT * FROM categories WHERE group_id = ? AND name = ? LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$groupId, $name]);
        return $stmt->fetch();
    }

    /**
     * Busca ou cria uma categoria de sistema para o grupo.
     * Categorias de sistema têm is_system=1 e não aparecem no formulário de criação.
     */
    public function getOrCreateSystemCategory($groupId, $name, $color = '#6B7280')
    {
        // Tenta buscar existente
        $sql = "SELECT * FROM categories 
            WHERE group_id = ? AND name = ? AND is_system = 1 
            LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$groupId, $name]);
        $category = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($category) {
            return $category;
        }

        // Cria se não existir
        $id = $this->create([
            'group_id'  => $groupId,
            'name'      => $name,
            'color'     => $color,
            'is_system' => 1
        ]);

        return $this->findById($id);
    }
}
