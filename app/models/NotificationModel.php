<?php
// app/models/NotificationModel.php

class NotificationModel extends Model
{
    protected $table = 'notifications';

    /**
     * Cria uma nova notificação
     */
    public function create($data)
    {
        $sql = "INSERT INTO {$this->table} 
                (user_id, type, title, message, priority, related_type, related_id)
                VALUES (:user_id, :type, :title, :message, :priority, :related_type, :related_id)";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'user_id' => $data['user_id'],
            'type' => $data['type'],
            'title' => $data['title'],
            'message' => $data['message'],
            'priority' => $data['priority'] ?? 'medium',
            'related_type' => $data['related_type'] ?? null,
            'related_id' => $data['related_id'] ?? null
        ]);
    }

    /**
     * Busca notificações não lidas
     */
    public function getUnreadByUser($userId)
    {
        $sql = "SELECT * FROM {$this->table}
                WHERE user_id = :user_id AND is_read = 0
                ORDER BY 
                    FIELD(priority, 'urgent', 'high', 'medium', 'low'),
                    created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Busca todas as notificações do usuário
     */
    public function getAllByUser($userId, $limit = 50, $offset = 0)
    {
        $sql = "SELECT * FROM {$this->table}
                WHERE user_id = :user_id
                ORDER BY is_read ASC, created_at DESC
                LIMIT :limit OFFSET :offset";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Conta notificações não lidas
     */
    public function countUnread($userId)
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}
                WHERE user_id = :user_id AND is_read = 0";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)($result['total'] ?? 0);
    }

    /**
     * Marca notificação como lida
     */
    public function markAsRead($notificationId, $userId)
    {
        $sql = "UPDATE {$this->table} 
                SET is_read = 1, read_at = NOW()
                WHERE id = :id AND user_id = :user_id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id' => $notificationId,
            'user_id' => $userId
        ]);
    }

    /**
     * Marca todas como lidas
     */
    public function markAllAsRead($userId)
    {
        $sql = "UPDATE {$this->table} 
                SET is_read = 1, read_at = NOW()
                WHERE user_id = :user_id AND is_read = 0";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['user_id' => $userId]);
    }

    /**
     * Deleta notificação
     */
    public function delete($id, $userId = null)
    {
        if ($userId) {
            $sql = "DELETE FROM {$this->table} WHERE id = :id AND user_id = :user_id";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute(['id' => $id, 'user_id' => $userId]);
        }

        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    /**
     * Verifica se existe notificação similar recente
     */
    public function existsRecent($userId, $type, $relatedType, $relatedId, $hours = 24)
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}
                WHERE user_id = :user_id
                  AND type = :type
                  AND related_type = :related_type
                  AND related_id = :related_id
                  AND created_at > DATE_SUB(NOW(), INTERVAL :hours HOUR)";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'user_id' => $userId,
            'type' => $type,
            'related_type' => $relatedType,
            'related_id' => $relatedId,
            'hours' => $hours
        ]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return ($result['total'] ?? 0) > 0;
    }

    /**
     * Remove notificações antigas
     */
    public function cleanOldNotifications($userId, $days = 30)
    {
        $sql = "DELETE FROM {$this->table}
                WHERE user_id = :user_id
                  AND is_read = 1
                  AND created_at < DATE_SUB(NOW(), INTERVAL :days DAY)";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'user_id' => $userId,
            'days' => $days
        ]);
    }

    // ========================================
    // CONFIGURAÇÕES DE NOTIFICAÇÃO
    // ========================================

    /**
     * Busca configurações do usuário
     */
    // app/models/NotificationModel.php

    public function getUserSettings(int $userId): array
    {
        $stmt = $this->db->prepare("
        SELECT
            enable_app_notifications,
            enable_email_notifications,
            email_notify_3days,
            email_notify_1day,
            email_notify_today,
            email_monthly_report
        FROM notification_settings
        WHERE user_id = :user_id
        LIMIT 1
    ");

        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();

        $settings = $stmt->fetch(PDO::FETCH_ASSOC);

        // fallback seguro
        return $settings ?: [
            'enable_app_notifications' => 1,
            'enable_email_notifications' => 0,
            'email_notify_3days' => 0,
            'email_notify_1day' => 0,
            'email_notify_today' => 0,
            'email_monthly_report' => 0,
        ];
    }


    /**
     * Cria configurações padrão
     */
    private function createDefaultSettings($userId)
    {
        $sql = "INSERT INTO notification_settings (user_id) VALUES (:user_id)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['user_id' => $userId]);
    }

    /**
     * Atualiza configurações
     */
    public function updateSettings($userId, $settings)
    {
        $sql = "UPDATE notification_settings SET
                enable_app_notifications = :enable_app_notifications,
                enable_email_notifications = :enable_email_notifications,
                email_notify_3days = :email_notify_3days,
                email_notify_1day = :email_notify_1day,
                email_notify_today = :email_notify_today,
                email_notify_overdue = :email_notify_overdue,
                email_monthly_report = :email_monthly_report,
                preferred_send_hour = :preferred_send_hour,
                updated_at = NOW()
                WHERE user_id = :user_id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'user_id' => $userId,
            'enable_app_notifications' => $settings['enable_app_notifications'] ?? 1,
            'enable_email_notifications' => $settings['enable_email_notifications'] ?? 1,
            'email_notify_3days' => $settings['email_notify_3days'] ?? 1,
            'email_notify_1day' => $settings['email_notify_1day'] ?? 1,
            'email_notify_today' => $settings['email_notify_today'] ?? 1,
            'email_notify_overdue' => $settings['email_notify_overdue'] ?? 1,
            'email_monthly_report' => $settings['email_monthly_report'] ?? 1,
            'preferred_send_hour' => $settings['preferred_send_hour'] ?? 9
        ]);
    }

    // ========================================
    // LOG DE E-MAILS
    // ========================================

    /**
     * Registra envio de e-mail
     */
    public function logEmail($userId, $notificationType, $relatedType = null, $relatedId = null, $referenceDate = null)
    {
        $referenceDate = $referenceDate ?? date('Y-m-d');

        $sql = "INSERT INTO notification_email_log
                (user_id, notification_type, related_type, related_id, reference_date)
                VALUES (:user_id, :notification_type, :related_type, :related_id, :reference_date)
                ON DUPLICATE KEY UPDATE sent_at = NOW()";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'user_id' => $userId,
            'notification_type' => $notificationType,
            'related_type' => $relatedType,
            'related_id' => $relatedId,
            'reference_date' => $referenceDate
        ]);
    }

    /**
     * Verifica se e-mail foi enviado hoje
     */
    public function wasEmailSentToday($userId, $notificationType, $relatedType = null, $relatedId = null)
    {
        $sql = "SELECT COUNT(*) as total FROM notification_email_log
                WHERE user_id = :user_id
                  AND notification_type = :notification_type
                  AND related_type = :related_type
                  AND related_id = :related_id
                  AND reference_date = CURDATE()";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            'user_id' => $userId,
            'notification_type' => $notificationType,
            'related_type' => $relatedType,
            'related_id' => $relatedId
        ]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return ($result['total'] ?? 0) > 0;
    }

    /**
     * Cria notificação E envia email se configurado
     */
    public function createAndNotify($userId, $type, $title, $message, $priority = 'medium', $relatedType = null, $relatedId = null, $emailData = null)
    {
        $settings = $this->getUserSettings($userId);

        // Criar notificação in-app
        if ($settings['enable_app_notifications']) {
            $this->create([
                'user_id' => $userId,
                'type' => $type,
                'title' => $title,
                'message' => $message,
                'priority' => $priority,
                'related_type' => $relatedType,
                'related_id' => $relatedId
            ]);
        }

        // Enviar email se habilitado
        if ($settings['enable_email_notifications'] && $emailData) {
            // Evita enviar email duplicado
            if (!$this->wasEmailSentToday($userId, $type, $relatedType, $relatedId)) {
                $this->sendNotificationEmail($userId, $type, $emailData);
                $this->logEmail($userId, $type, $relatedType, $relatedId);
            }
        }

        return true;
    }

    /**
     * Envia email baseado no tipo de notificação
     */
    private function sendNotificationEmail($userId, $type, $data)
    {
        require_once APP . '/helpers/EmailHelper.php';
        require_once APP . '/models/UserModel.php';

        $userModel = new UserModel();
        $user = $userModel->getById($userId);

        if (!$user || !$user['email']) {
            return false;
        }

        $to = $user['email'];
        $name = $user['name'];

        switch ($type) {
            case 'fatura_vencimento':
                return EmailHelper::sendCardInvoiceNotification(
                    $to,
                    $name,
                    $data['card_name'],
                    $data['amount'],
                    $data['due_date'],
                    $data['days_until_due']
                );

            case 'relatorio_mensal':
                return EmailHelper::sendMonthlyReport(
                    $to,
                    $name,
                    $data['group_name'],
                    $data['month'],
                    $data['year'],
                    $data['income'],
                    $data['expense'],
                    $data['balance']
                );

            case 'despesa_recorrente_vencida':
                return EmailHelper::sendRecurringExpenseNotification(
                    $to,
                    $name,
                    $data['description'],
                    $data['amount'],
                    $data['due_date'],
                    $data['is_overdue']
                );

            default:
                // Email genérico
                return EmailHelper::send($to, $data['title'] ?? 'Notificação', $data['message'] ?? '', $name);
        }
    }
}
