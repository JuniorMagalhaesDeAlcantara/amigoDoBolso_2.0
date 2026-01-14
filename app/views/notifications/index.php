<?php include VIEWS . '/layouts/header.php'; ?>

<div class="container">
    <div class="card-header">
        <h1>🔔 Notificações</h1>
        <div class="header-actions">
            <a href="/notificacoes/configuracoes" class="btn btn-secondary">⚙️ Configurações</a>
            <?php if ($unreadCount > 0): ?>
                <a href="/notificacoes/marcar-todas-lidas" class="btn btn-primary">✓ Marcar todas como lidas</a>
            <?php endif; ?>
        </div>
    </div>

    <?php if (empty($notifications)): ?>
        <div class="card">
            <div class="empty-state">
                <div class="empty-icon">🔔</div>
                <h3>Nenhuma notificação</h3>
                <p>Você está em dia! Quando houver avisos importantes, eles aparecerão aqui.</p>
            </div>
        </div>
    <?php else: ?>
        <div class="notifications-list">
            <?php foreach ($notifications as $notification):
                $priorityColors = [
                    'low' => '#10b981',
                    'medium' => '#3b82f6',
                    'high' => '#f59e0b',
                    'urgent' => '#ef4444'
                ];

                $priorityLabels = [
                    'low' => 'Informação',
                    'medium' => 'Aviso',
                    'high' => 'Importante',
                    'urgent' => 'Urgente'
                ];

                $priorityColor = $priorityColors[$notification['priority']] ?? '#3b82f6';
                $priorityLabel = $priorityLabels[$notification['priority']] ?? 'Aviso';

                $isUnread = !$notification['is_read'];
                $timeAgo = $this->getTimeAgo($notification['created_at']);
            ?>
                <div class="notification-card <?= $isUnread ? 'unread' : '' ?>"
                    style="border-left: 4px solid <?= $priorityColor ?>">
                    <div class="notification-header">
                        <div class="notification-priority" style="background: <?= $priorityColor ?>">
                            <?= $priorityLabel ?>
                        </div>
                        <div class="notification-time"><?= $timeAgo ?></div>
                    </div>

                    <div class="notification-content">
                        <h3 class="notification-title"><?= htmlspecialchars($notification['title']) ?></h3>
                        <p class="notification-message"><?= nl2br(htmlspecialchars($notification['message'])) ?></p>
                    </div>

                    <div class="notification-actions">
                        <?php if ($notification['related_type'] === 'card' && $notification['related_id']): ?>
                            <a href="/cartoes/extrato/<?= $notification['related_id'] ?>" class="btn-notification">
                                📊 Ver Cartão
                            </a>
                        <?php endif; ?>

                        <?php if ($notification['related_type'] === 'bill' && $notification['related_id']): ?>
                            <a href="/contas-recorrentes" class="btn-notification">
                                📄 Ver Boleto
                            </a>
                        <?php endif; ?>

                        <?php if ($isUnread): ?>
                            <a href="/notificacoes/marcar-lida/<?= $notification['id'] ?>" class="btn-notification btn-mark-read">
                                ✓ Marcar como lida
                            </a>
                        <?php endif; ?>

                        <a href="/notificacoes/deletar/<?= $notification['id'] ?>"
                            class="btn-notification btn-delete"
                            onclick="return confirm('Deseja deletar esta notificação?')">
                            🗑️
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<style>
    .header-actions {
        display: flex;
        gap: 0.75rem;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 1.5rem;
    }

    .empty-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.3;
    }

    .empty-state h3 {
        color: #333;
        margin-bottom: 0.5rem;
        font-size: 1.25rem;
    }

    .empty-state p {
        color: #666;
        font-size: 0.95rem;
    }

    .notifications-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .notification-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s;
    }

    .notification-card.unread {
        background: #f0f9ff;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
    }

    .notification-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
    }

    .notification-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .notification-priority {
        display: inline-block;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        color: white;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .notification-time {
        font-size: 0.875rem;
        color: #6b7280;
    }

    .notification-content {
        margin-bottom: 1rem;
    }

    .notification-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }

    .notification-message {
        font-size: 0.95rem;
        color: #4b5563;
        line-height: 1.6;
        margin: 0;
    }

    .notification-actions {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
    }

    .btn-notification {
        padding: 0.5rem 1rem;
        border: 2px solid #667eea;
        background: white;
        color: #667eea;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.875rem;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    .btn-notification:hover {
        background: #667eea;
        color: white;
        transform: translateY(-1px);
    }

    .btn-mark-read {
        border-color: #10b981;
        color: #10b981;
    }

    .btn-mark-read:hover {
        background: #10b981;
        color: white;
    }

    .btn-delete {
        border-color: #ef4444;
        color: #ef4444;
        padding: 0.5rem 0.75rem;
    }

    .btn-delete:hover {
        background: #ef4444;
        color: white;
    }

    @media (max-width: 768px) {
        .header-actions {
            flex-direction: column;
        }

        .notification-card {
            padding: 1rem;
        }

        .notification-actions {
            flex-direction: column;
        }

        .btn-notification {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<?php
// Helper function para tempo relativo
function getTimeAgo($datetime)
{
    $timestamp = strtotime($datetime);
    $diff = time() - $timestamp;

    if ($diff < 60) {
        return 'Agora há pouco';
    } elseif ($diff < 3600) {
        $minutes = floor($diff / 60);
        return "Há {$minutes} " . ($minutes == 1 ? 'minuto' : 'minutos');
    } elseif ($diff < 86400) {
        $hours = floor($diff / 3600);
        return "Há {$hours} " . ($hours == 1 ? 'hora' : 'horas');
    } elseif ($diff < 604800) {
        $days = floor($diff / 86400);
        return "Há {$days} " . ($days == 1 ? 'dia' : 'dias');
    } else {
        return date('d/m/Y H:i', $timestamp);
    }
}
?>

<?php include VIEWS . '/layouts/footer.php'; ?>