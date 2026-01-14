<?php
// app/controllers/NotificationController.php

class NotificationController extends Controller
{
    private $notificationModel;

    public function __construct()
    {
        $this->requireLogin();
        $this->notificationModel = new NotificationModel();
    }

    /**
     * Página principal de notificações
     */
    public function index()
    {
        $userId = $_SESSION['user_id'];

        $notifications = $this->notificationModel->getAllByUser($userId, 100);
        $unreadCount = $this->notificationModel->countUnread($userId);

        $this->view('notifications/index', [
            'title' => 'Notificações',
            'notifications' => $notifications,
            'unreadCount' => $unreadCount
        ]);
    }

    /**
     * API: Retorna contador de não lidas (AJAX)
     */
    public function contador()
    {
        header('Content-Type: application/json');

        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            echo json_encode(['count' => 0]);
            exit;
        }

        $count = $this->notificationModel->countUnread($userId);
        echo json_encode(['count' => $count]);
        exit;
    }

    /**
     * API: Retorna notificações não lidas (AJAX)
     */
    public function naoLidas()
    {
        header('Content-Type: application/json');

        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            echo json_encode([]);
            exit;
        }

        $notifications = $this->notificationModel->getUnreadByUser($userId);
        echo json_encode($notifications);
        exit;
    }

    /**
     * Marca notificação como lida
     */
    public function marcarLida($id)
    {
        $userId = $_SESSION['user_id'];

        if (!$id || !is_numeric($id)) {
            $_SESSION['error'] = 'ID inválido';
            $this->redirect('/notificacoes');
            return;
        }

        $success = $this->notificationModel->markAsRead($id, $userId);

        if ($success) {
            $_SESSION['success'] = 'Notificação marcada como lida';
        }

        // Redireciona para a página anterior ou para notificações
        $referer = $_SERVER['HTTP_REFERER'] ?? '/notificacoes';
        $this->redirect($referer);
    }

    /**
     * Marca todas como lidas
     */
    public function marcarTodasLidas()
    {
        $userId = $_SESSION['user_id'];

        $success = $this->notificationModel->markAllAsRead($userId);

        if ($success) {
            $_SESSION['success'] = 'Todas as notificações foram marcadas como lidas';
        } else {
            $_SESSION['error'] = 'Erro ao marcar notificações';
        }

        $referer = $_SERVER['HTTP_REFERER'] ?? '/notificacoes';
        $this->redirect($referer);
    }

    /**
     * Deleta notificação
     */
    public function deletar($id)
    {
        $userId = $_SESSION['user_id'];

        if (!$id || !is_numeric($id)) {
            $_SESSION['error'] = 'ID inválido';
            $this->redirect('/notificacoes');
            return;
        }

        $success = $this->notificationModel->delete($id, $userId);

        if ($success) {
            $_SESSION['success'] = 'Notificação deletada com sucesso';
        } else {
            $_SESSION['error'] = 'Erro ao deletar notificação';
        }

        $this->redirect('/notificacoes');
    }

    /**
     * Página de configurações
     */
    public function configuracoes()
    {
        $userId = $_SESSION['user_id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->salvarConfiguracoes($userId);
            return;
        }

        // Valores padrão para evitar warnings
        $defaultSettings = [
            'enable_app_notifications' => 0,
            'enable_email_notifications' => 0,
            'email_notify_3days' => 0,
            'email_notify_1day' => 0,
            'email_notify_today' => 0,
            'email_notify_overdue' => 0,
            'email_monthly_report' => 0,
            'preferred_send_hour' => 9
        ];

        // Busca as configurações do usuário
        $userSettings = $this->notificationModel->getUserSettings($userId);

        // Garante que todas as chaves existam
        $settings = array_merge($defaultSettings, $userSettings ?: []);

        $this->view('notifications/settings', [
            'title' => 'Configurações de Notificações',
            'settings' => $settings
        ]);
    }


    /**
     * Salva configurações de notificações
     */
    private function salvarConfiguracoes($userId)
    {
        $settings = [
            'enable_app_notifications' => isset($_POST['enable_app_notifications']) ? 1 : 0,
            'enable_email_notifications' => isset($_POST['enable_email_notifications']) ? 1 : 0,
            'email_notify_3days' => isset($_POST['email_notify_3days']) ? 1 : 0,
            'email_notify_1day' => isset($_POST['email_notify_1day']) ? 1 : 0,
            'email_notify_today' => isset($_POST['email_notify_today']) ? 1 : 0,
            'email_notify_overdue' => isset($_POST['email_notify_overdue']) ? 1 : 0,
            'email_monthly_report' => isset($_POST['email_monthly_report']) ? 1 : 0,
            'preferred_send_hour' => filter_input(INPUT_POST, 'preferred_send_hour', FILTER_VALIDATE_INT) ?? 9
        ];

        // Validação do horário
        if ($settings['preferred_send_hour'] < 0 || $settings['preferred_send_hour'] > 23) {
            $_SESSION['error'] = 'Horário inválido. Escolha entre 0 e 23.';
            $this->redirect('/notificacoes/configuracoes');
            return;
        }

        $success = $this->notificationModel->updateSettings($userId, $settings);

        if ($success) {
            $_SESSION['success'] = 'Configurações atualizadas com sucesso!';
        } else {
            $_SESSION['error'] = 'Erro ao atualizar configurações';
        }

        $this->redirect('/notificacoes/configuracoes');
    }

    protected function getTimeAgo(string $datetime): string
    {
        $time = strtotime($datetime);
        $diff = time() - $time;

        if ($diff < 60) {
            return 'agora mesmo';
        }

        $minutes = floor($diff / 60);
        if ($minutes < 60) {
            return $minutes . ' min atrás';
        }

        $hours = floor($minutes / 60);
        if ($hours < 24) {
            return $hours . ' h atrás';
        }

        $days = floor($hours / 24);
        if ($days < 7) {
            return $days . ' dias atrás';
        }

        return date('d/m/Y H:i', $time);
    }
}
