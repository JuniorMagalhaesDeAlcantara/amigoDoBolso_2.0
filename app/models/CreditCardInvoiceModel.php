<?php

class CreditCardInvoiceModel extends Model
{
    protected $table = 'credit_card_invoices';

    /**
     * Registra pagamento de fatura
     */
    public function payInvoice($cardId, $month, $year, $totalAmount, $paidAmount, $userId)
    {
        $creditCardModel = new CreditCardModel();
        $card            = $creditCardModel->findById($cardId);

        $existing = $this->findInvoice($cardId, $month, $year);

        if ($existing) {
            $newPaidAmount      = round(floatval($existing['paid_amount']) + $paidAmount, 2);
            $newRemainingAmount = round($totalAmount - $newPaidAmount, 2);

            // FIX: tolerância de 1 centavo na comparação de float
            if ($newRemainingAmount <= 0.01 && $existing['overdue_moved_to_next']) {
                $this->removeOverdueDebt($cardId, $month, $year);
            }

            $sql = "UPDATE {$this->table}
                    SET total_amount     = ?,
                        paid_amount      = ?,
                        remaining_amount = ?,
                        paid_at          = NOW(),
                        paid_by          = ?,
                        is_overdue       = 0
                    WHERE id = ?";

            $stmt = $this->db->prepare($sql);
            $stmt->execute([$totalAmount, $newPaidAmount, $newRemainingAmount, $userId, $existing['id']]);

            $this->registerPaymentTransaction($card, $month, $year, $paidAmount, $userId);

            return $existing['id'];
        }

        // Novo registro
        $invoiceId = $this->create([
            'credit_card_id'       => $cardId,
            'month'                => $month,
            'year'                 => $year,
            'total_amount'         => $totalAmount,
            'paid_amount'          => $paidAmount,
            'remaining_amount'     => round($totalAmount - $paidAmount, 2),
            'paid_at'              => date('Y-m-d H:i:s'),
            'paid_by'              => $userId,
            'is_overdue'           => 0,
            'overdue_moved_to_next' => 0,
        ]);

        $this->registerPaymentTransaction($card, $month, $year, $paidAmount, $userId);

        return $invoiceId;
    }

    /**
     * Registra o pagamento da fatura como transação de despesa.
     *
     * REGRA: a transação NÃO é vinculada ao cartão (credit_card_id = null)
     * para não aparecer no extrato de compras do cartão.
     * Ela representa o débito na conta corrente ao quitar a fatura.
     *
     * FIX: data de pagamento usa vencimento real ou hoje se fatura passada,
     * mas NUNCA usa data futura para faturas históricas.
     */
    private function registerPaymentTransaction($card, $month, $year, $paidAmount, $userId)
    {
        $transactionModel = new TransactionModel();
        $categoryModel    = new CategoryModel();

        $category = $categoryModel->findByName($card['group_id'], 'Pagamento Cartão');
        if (!$category) {
            $categoryId = $categoryModel->create([
                'group_id' => $card['group_id'],
                'name'     => 'Pagamento Cartão',
                'type'     => 'despesa',
                'color'    => '#8b5cf6',
            ]);
        } else {
            $categoryId = $category['id'];
        }

        $creditCardModel = new CreditCardModel();
        $cardData        = $creditCardModel->findById($card['id']);

        // FIX: usa o vencimento da fatura como data do pagamento.
        // Se for fatura futura → usa hoje. Se for fatura passada → usa data do vencimento real.
        $dueTs       = mktime(0, 0, 0, $month, $cardData['due_day'], $year);
        $paymentDate = ($dueTs > time()) ? date('Y-m-d') : date('Y-m-d', $dueTs);

        $transactionModel->create([
            'group_id'         => $card['group_id'],
            'user_id'          => $userId,
            'category_id'      => $categoryId,
            'description'      => "💳 Pagamento fatura {$month}/{$year} - " . $card['name'],
            'amount'           => $paidAmount,
            'type'             => 'despesa',
            'transaction_date' => $paymentDate,
            'payment_method'   => 'debito',
            'credit_card_id'   => null,  // ← não vincular ao cartão; é saída da conta corrente
            'paid'             => 1,
        ]);
    }

    /**
     * Move saldo devedor para próxima fatura (chamado pelo CRON no vencimento).
     *
     * FIX: $userId pode vir null quando a fatura nunca teve pagamento (CRON).
     * Usa um fallback para o primeiro admin do grupo.
     */
    public function moveOverdueToNextInvoice($cardId, $month, $year, $amount, $userId)
    {
        $creditCardModel = new CreditCardModel();
        $card            = $creditCardModel->findById($cardId);

        // FIX: se não houver userId (fatura nunca paga), busca o criador do grupo
        if (!$userId) {
            $userId = $this->getGroupOwner($card['group_id']);
        }

        $nextMonth = $month + 1;
        $nextYear  = $year;
        if ($nextMonth > 12) {
            $nextMonth = 1;
            $nextYear++;
        }

        // Dia seguinte ao vencimento
        $debtTs       = mktime(0, 0, 0, $month, $card['due_day'] + 1, $year);
        $debtDate     = date('Y-m-d', $debtTs);

        $transactionModel = new TransactionModel();
        $categoryModel    = new CategoryModel();

        $debtCategory = $categoryModel->findByName($card['group_id'], 'Fatura Atrasada');
        if (!$debtCategory) {
            $categoryId = $categoryModel->create([
                'group_id' => $card['group_id'],
                'name'     => 'Fatura Atrasada',
                'type'     => 'despesa',
                'color'    => '#dc2626',
            ]);
        } else {
            $categoryId = $debtCategory['id'];
        }

        $transactionId = $transactionModel->create([
            'group_id'         => $card['group_id'],
            'user_id'          => $userId,
            'category_id'      => $categoryId,
            'description'      => "💳 Fatura vencida {$month}/{$year} - " . $card['name'],
            'amount'           => $amount,
            'type'             => 'despesa',
            'transaction_date' => $debtDate,
            'payment_method'   => 'debito',  // débito bancário, não crédito
            'credit_card_id'   => null,       // não vincula ao cartão para não dobrar o total
            'paid'             => 0,
        ]);

        $sql = "UPDATE {$this->table}
                SET is_overdue              = 1,
                    overdue_moved_to_next   = 1,
                    overdue_transaction_id  = ?
                WHERE credit_card_id = ? AND month = ? AND year = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$transactionId, $cardId, $month, $year]);

        return $transactionId;
    }

    /**
     * Remove saldo devedor quando paga atrasado
     */
    public function removeOverdueDebt($cardId, $month, $year)
    {
        $invoice = $this->findInvoice($cardId, $month, $year);

        if (!$invoice || !$invoice['overdue_transaction_id']) {
            return false;
        }

        $transactionModel = new TransactionModel();
        $transactionModel->delete($invoice['overdue_transaction_id']);

        $sql = "UPDATE {$this->table}
                SET overdue_moved_to_next   = 0,
                    overdue_transaction_id  = NULL
                WHERE credit_card_id = ? AND month = ? AND year = ?";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$cardId, $month, $year]);
    }

    /**
     * Verifica se fatura está TOTALMENTE paga (com tolerância de 1 centavo)
     */
    public function isInvoicePaid($cardId, $month, $year)
    {
        $invoice = $this->findInvoice($cardId, $month, $year);

        if (!$invoice) {
            return false;
        }

        // FIX: tolerância para evitar falso-negativo por arredondamento de float
        return floatval($invoice['paid_amount']) >= floatval($invoice['total_amount']) - 0.01;
    }

    /**
     * Busca fatura específica
     */
    public function findInvoice($cardId, $month, $year)
    {
        $sql = "SELECT * FROM {$this->table}
                WHERE credit_card_id = ? AND month = ? AND year = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$cardId, $month, $year]);
        return $stmt->fetch();
    }

    /**
     * Total de faturas pagas no mês (para cálculo de saldo)
     */
    public function getPaidInMonth($groupId, $month, $year)
    {
        $sql = "SELECT COALESCE(SUM(i.paid_amount), 0) AS total
                FROM {$this->table} i
                INNER JOIN credit_cards c ON i.credit_card_id = c.id
                WHERE c.group_id = ?
                  AND MONTH(i.paid_at) = ?
                  AND YEAR(i.paid_at)  = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$groupId, $month, $year]);
        $result = $stmt->fetch();

        return floatval($result['total'] ?? 0);
    }

    /**
     * Histórico de pagamentos do cartão
     */
    public function getCardHistory($cardId, $limit = 12)
    {
        $sql = "SELECT i.*, u.name AS paid_by_name
                FROM {$this->table} i
                LEFT JOIN users u ON i.paid_by = u.id
                WHERE i.credit_card_id = ?
                ORDER BY i.year DESC, i.month DESC
                LIMIT ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$cardId, $limit]);
        return $stmt->fetchAll();
    }

    /**
     * Cancela pagamento (em caso de erro)
     */
    public function cancelPayment($cardId, $month, $year)
    {
        $sql = "DELETE FROM {$this->table}
                WHERE credit_card_id = ? AND month = ? AND year = ?";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$cardId, $month, $year]);
    }

    /**
     * Processa faturas vencidas (chamado pelo CRON).
     * Verifica faturas que venceram e move saldo devedor para próxima fatura.
     *
     * FIX: usa LPAD para montar a data corretamente no MySQL.
     */
    public function processOverdueInvoices()
    {
        $sql = "SELECT i.*, c.due_day, c.group_id
                FROM {$this->table} i
                INNER JOIN credit_cards c ON i.credit_card_id = c.id
                WHERE i.remaining_amount > 0.01
                  AND i.overdue_moved_to_next = 0
                  AND STR_TO_DATE(
                        CONCAT(i.year, '-', LPAD(i.month, 2, '0'), '-', LPAD(c.due_day, 2, '0')),
                        '%Y-%m-%d'
                      ) < CURDATE()";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $overdueInvoices = $stmt->fetchAll();

        foreach ($overdueInvoices as $invoice) {
            // FIX: paid_by pode ser null (fatura nunca paga); moveOverdueToNextInvoice trata isso
            $this->moveOverdueToNextInvoice(
                $invoice['credit_card_id'],
                $invoice['month'],
                $invoice['year'],
                $invoice['remaining_amount'],
                $invoice['paid_by'] ?? null
            );
        }

        return count($overdueInvoices);
    }

    // -------------------------------------------------------------------------
    // Helpers privados
    // -------------------------------------------------------------------------

    /**
     * FIX: retorna o ID do dono/admin do grupo para usar quando paid_by é null
     */
    private function getGroupOwner($groupId)
    {
        $sql  = "SELECT user_id FROM group_members
                 WHERE group_id = ? AND role = 'owner'
                 LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$groupId]);
        $row = $stmt->fetch();

        // fallback: qualquer membro
        if (!$row) {
            $sql  = "SELECT user_id FROM group_members WHERE group_id = ? LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$groupId]);
            $row = $stmt->fetch();
        }

        return $row ? $row['user_id'] : null;
    }
}