<?php

class CreditCardModel extends Model
{
    protected $table = 'credit_cards';

    public function getByGroup($groupId)
    {
        $sql = "SELECT * FROM {$this->table} WHERE group_id = ? ORDER BY name ASC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$groupId]);
        return $stmt->fetchAll();
    }

   public function getCurrentMonthTotal($groupId, $month, $year)
{
    $sql = "
        SELECT COALESCE(SUM(t.amount), 0) AS total
        FROM transactions t
        WHERE t.group_id = :group_id
        AND t.credit_card_id IS NOT NULL
        AND MONTH(t.transaction_date) = :month
        AND YEAR(t.transaction_date) = :year
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->execute([
        'group_id' => $groupId,
        'month' => $month,
        'year' => $year
    ]);

    return $stmt->fetchColumn() ?? 0;
}


    /**
     * Buscar cartões com fatura do mês atual
     */
    public function getCardsWithCurrentBill($groupId, $month, $year)
    {
        $sql = "SELECT 
                    cc.*,
                    COALESCE(SUM(t.amount), 0) as current_bill
                FROM credit_cards cc
                LEFT JOIN transactions t ON cc.id = t.credit_card_id
                    AND MONTH(t.transaction_date) = :month
                    AND YEAR(t.transaction_date) = :year
                WHERE cc.group_id = :group_id
                GROUP BY cc.id
                ORDER BY cc.name";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'group_id' => $groupId,
            'month' => $month,
            'year' => $year
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
