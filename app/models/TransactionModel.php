<?php

class TransactionModel extends Model
{
    protected $table = 'transactions';

    public function createTransaction($data)
    {
        return $this->create($data);
    }

    public function getByGroup($groupId, $month = null, $year = null)
    {
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

    public function getMonthlyBalance($groupId, $month, $year)
    {
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

    public function getSpendingByCategory($groupId, $month, $year)
    {
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
     */
    private function calculateFirstInstallmentDate($purchaseDate, $closingDay)
    {
        $purchase = new DateTime($purchaseDate);
        $purchaseDay = (int)$purchase->format('d');

        // Se a compra foi ANTES do fechamento, entra na fatura deste mês
        if ($purchaseDay <= $closingDay) {
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
    public function createInstallments($data, $installments)
    {
        // Busca informações do cartão
        $creditCardModel = new CreditCardModel();
        $creditCard = $creditCardModel->findById($data['credit_card_id']);

        if (!$creditCard) {
            throw new Exception("Cartão de crédito não encontrado");
        }

        // APENAS CONVERTE PARA FLOAT, SEM REPLACE
        $data['amount'] = floatval($data['amount']);

        $this->db->beginTransaction();

        try {
            $closingDay = $creditCard['closing_day'];
            $amountPerInstallment = $data['amount'] / $installments;

            // Calcula a data da primeira parcela
            $firstInstallmentDate = $this->calculateFirstInstallmentDate($data['transaction_date'], $closingDay);

            // Cria a transação PAI (primeira parcela)
            $parentData = array_merge($data, [
                'amount' => $amountPerInstallment,
                'transaction_date' => $firstInstallmentDate,
                'installments' => $installments,
                'installment_number' => 1,
                'is_installment' => true,
                'parent_transaction_id' => null,
                'description' => $data['description'] . " (1/{$installments})"
            ]);

            $parentId = $this->create($parentData);

            // Cria as parcelas FILHAS
            for ($i = 1; $i < $installments; $i++) {
                $installmentDate = date('Y-m-d', strtotime($firstInstallmentDate . " +{$i} month"));

                $childData = array_merge($data, [
                    'amount' => $amountPerInstallment,
                    'transaction_date' => $installmentDate,
                    'installments' => $installments,
                    'installment_number' => $i + 1,
                    'is_installment' => true,
                    'parent_transaction_id' => $parentId,
                    'description' => $data['description'] . " (" . ($i + 1) . "/{$installments})"
                ]);

                $this->create($childData);
            }

            $this->db->commit();
            return $parentId;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    /**
     * Cria transações recorrentes
     */
    public function createRecurring($data, $months)
    {
        $this->db->beginTransaction();

        try {
            // Cria a transação PAI (primeira ocorrência)
            $parentData = array_merge($data, [
                'is_recurring' => true,
                'recurrence_type' => 'mensal',
                'recurrence_months' => $months,
                'parent_transaction_id' => null
            ]);

            $parentId = $this->create($parentData);

            // Cria as recorrências FILHAS
            for ($i = 1; $i < $months; $i++) {
                $recurringDate = date('Y-m-d', strtotime($data['transaction_date'] . " +{$i} month"));

                $childData = array_merge($data, [
                    'transaction_date' => $recurringDate,
                    'is_recurring' => true,
                    'recurrence_type' => 'mensal',
                    'recurrence_months' => $months,
                    'parent_transaction_id' => $parentId
                ]);

                $this->create($childData);
            }

            $this->db->commit();
            return $parentId;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    /**
     * Verifica se uma transação tem parcelas/recorrências relacionadas
     */
    public function hasRelatedTransactions($transactionId)
    {
        $transaction = $this->findById($transactionId);

        if (!$transaction) {
            return false;
        }

        // Se é PAI, verifica se tem filhos
        if ($transaction['parent_transaction_id'] === null) {
            $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM {$this->table} WHERE parent_transaction_id = ?");
            $stmt->execute([$transactionId]);
            $result = $stmt->fetch();
            return $result['total'] > 0;
        }

        // Se é FILHO, sempre tem relação com o pai
        return true;
    }

    /**
     * Busca todas transações relacionadas (pai + filhos)
     */
    public function getRelatedTransactions($transactionId)
    {
        $transaction = $this->findById($transactionId);

        if (!$transaction) {
            return [];
        }

        // Se é FILHO, busca pelo PAI
        $parentId = $transaction['parent_transaction_id'] ?? $transactionId;

        // Busca PAI + FILHOS
        $sql = "SELECT * FROM {$this->table} 
                WHERE id = ? OR parent_transaction_id = ?
                ORDER BY transaction_date ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$parentId, $parentId]);
        return $stmt->fetchAll();
    }

    /**
     * Deleta transação e opcionalmente as relacionadas
     */
    public function deleteWithRelated($transactionId, $deleteRelated = false)
    {
        if ($deleteRelated) {
            $related = $this->getRelatedTransactions($transactionId);

            $this->db->beginTransaction();
            try {
                foreach ($related as $t) {
                    $this->delete($t['id']);
                }
                $this->db->commit();
                return true;
            } catch (Exception $e) {
                $this->db->rollBack();
                throw $e;
            }
        } else {
            return $this->delete($transactionId);
        }
    }

    /**
     * Atualiza transação e opcionalmente as relacionadas
     */
    public function updateWithRelated($transactionId, $data, $updateRelated = false)
    {
        if ($updateRelated) {
            $related = $this->getRelatedTransactions($transactionId);

            $this->db->beginTransaction();
            try {
                foreach ($related as $t) {
                    // Para parcelas, mantém o valor individual
                    $updateData = $data;
                    if (isset($t['is_installment']) && $t['is_installment']) {
                        unset($updateData['amount']); // Não altera valor de parcelas
                    }

                    $this->update($t['id'], $updateData);
                }
                $this->db->commit();
                return true;
            } catch (Exception $e) {
                $this->db->rollBack();
                throw $e;
            }
        } else {
            return $this->update($transactionId, $data);
        }
    }

    /**
     * Busca transações de um cartão específico
     */
    public function getByCard($cardId, $month, $year)
    {
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
     * Calcula total da fatura
     */
    public function getCardInvoiceTotal($cardId, $month, $year)
    {
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
     * Próximas parcelas
     */
    public function getUpcomingInstallments($cardId, $limit = 3)
    {
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
