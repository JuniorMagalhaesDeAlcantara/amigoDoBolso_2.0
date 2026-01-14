<?php

class GroupModel extends Model
{
    protected $table = 'groups';

    public function createGroup($name, $ownerId)
    {
        $inviteCode = $this->generateInviteCode();

        $groupId = $this->create([
            'name' => $name,
            'invite_code' => $inviteCode,
            'owner_id' => $ownerId
        ]);

        // Adiciona o criador como membro
        if ($groupId) {
            $this->addMember($groupId, $ownerId);
            $this->createDefaultCategories($groupId);
        }

        return $groupId;
    }

    public function addMember($groupId, $userId)
    {
        $sql = "INSERT INTO group_members (group_id, user_id) VALUES (?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$groupId, $userId]);
    }

    public function findByInviteCode($inviteCode)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE invite_code = ?");
        $stmt->execute([$inviteCode]);
        return $stmt->fetch();
    }

    public function getMembers($groupId)
    {
        $sql = "SELECT u.id, u.name, u.email, gm.joined_at 
                FROM users u
                INNER JOIN group_members gm ON u.id = gm.user_id
                WHERE gm.group_id = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$groupId]);
        return $stmt->fetchAll();
    }

    public function isMember($groupId, $userId)
    {
        $sql = "SELECT COUNT(*) as count FROM group_members WHERE group_id = ? AND user_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$groupId, $userId]);
        $result = $stmt->fetch();
        return $result['count'] > 0;
    }

    private function generateInviteCode($length = 8)
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $code = '';

        do {
            $code = '';
            for ($i = 0; $i < $length; $i++) {
                $code .= $characters[random_int(0, strlen($characters) - 1)];
            }

            // Verifica se o código já existe
            $existing = $this->findByInviteCode($code);
        } while ($existing);

        return $code;
    }

    public function getUserGroups($userId)
    {
        $sql = "
        SELECT g.*
        FROM groups g
        INNER JOIN group_members gm ON gm.group_id = g.id
        WHERE gm.user_id = ?
    ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);

        return $stmt->fetchAll();
    }

    private function createDefaultCategories($groupId)
    {
        $categories = [
            // Despesas
            ['name' => 'Alimentação', 'type' => 'despesa', 'icon' => 'utensils', 'color' => '#e74c3c'],
            ['name' => 'Transporte', 'type' => 'despesa', 'icon' => 'car', 'color' => '#3498db'],
            ['name' => 'Moradia', 'type' => 'despesa', 'icon' => 'home', 'color' => '#9b59b6'],
            ['name' => 'Saúde', 'type' => 'despesa', 'icon' => 'heart', 'color' => '#e67e22'],
            ['name' => 'Lazer', 'type' => 'despesa', 'icon' => 'gamepad', 'color' => '#1abc9c'],
            ['name' => 'Educação', 'type' => 'despesa', 'icon' => 'book', 'color' => '#f39c12'],
            ['name' => 'Outros', 'type' => 'despesa', 'icon' => 'ellipsis', 'color' => '#95a5a6'],

            // Receitas
            ['name' => 'Salário', 'type' => 'receita', 'icon' => 'dollar-sign', 'color' => '#27ae60'],
            ['name' => 'Freelance', 'type' => 'receita', 'icon' => 'briefcase', 'color' => '#2ecc71'],
            ['name' => 'Investimentos', 'type' => 'receita', 'icon' => 'chart-line', 'color' => '#16a085'],
            ['name' => 'Outros', 'type' => 'receita', 'icon' => 'plus-circle', 'color' => '#27ae60'],
        ];

        $sql = "INSERT INTO categories (group_id, name, type, icon, color) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);

        foreach ($categories as $category) {
            $stmt->execute([
                $groupId,
                $category['name'],
                $category['type'],
                $category['icon'],
                $category['color']
            ]);
        }
    }

    public function getAllActive()
    {
        $sql = "SELECT DISTINCT g.id, g.name, g.owner_id
                FROM {$this->table} g
                INNER JOIN group_members gm ON g.id = gm.group_id
                ORDER BY g.name ASC";

        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
