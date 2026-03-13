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

    /**
     * Calcula total de todos os cartões do grupo no mês (considerando ciclo)
     */
    public function getCurrentMonthTotal($groupId, $month, $year)
    {
        $cards = $this->getByGroup($groupId);
        $total = 0;

        foreach ($cards as $card) {
            // Usa a mesma lógica do getCardInvoiceTotal
            $transactionModel = new TransactionModel();
            $cardTotal = $transactionModel->getCardInvoiceTotal($card['id'], $month, $year);
            $total += $cardTotal;
        }

        return $total;
    }

    /**
     * Retorna cartões com fatura do mês atual (considerando ciclo)
     */
    public function getCardsWithCurrentBill($groupId, $month, $year)
    {
        $cards = $this->getByGroup($groupId);
        $transactionModel = new TransactionModel();

        foreach ($cards as &$card) {
            // Calcula o total da fatura considerando o ciclo
            $card['current_bill'] = $transactionModel->getCardInvoiceTotal($card['id'], $month, $year);

            // Calcula percentual de uso
            if (isset($card['credit_limit']) && $card['credit_limit'] > 0) {
                $card['usage_percent'] = ($card['current_bill'] / $card['credit_limit']) * 100;
            } else {
                $card['usage_percent'] = 0;
            }
        }

        return $cards;
    }
}
