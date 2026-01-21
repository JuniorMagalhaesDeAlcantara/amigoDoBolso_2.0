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
    /* ==================== NOTIFICAÇÕES - CSS RESPONSIVO PROFISSIONAL ==================== */

    /* Card Header */
    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        gap: 1.5rem;
        flex-wrap: wrap;
    }

    .card-header h1 {
        font-size: 2rem;
        font-weight: 700;
        color: var(--gray-900);
        margin: 0;
        letter-spacing: -0.02em;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .header-actions {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    /* Botões do Header */
    .btn-secondary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        background: white;
        color: var(--gray-700);
        border: 2px solid var(--gray-300);
        border-radius: 10px;
        font-size: 0.9375rem;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: var(--transition);
        font-family: inherit;
        white-space: nowrap;
    }

    .btn-secondary:hover {
        border-color: var(--gray-400);
        background: var(--gray-50);
        transform: translateY(-1px);
    }

    .btn-secondary:active {
        transform: translateY(0);
    }

    .btn-primary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        background: linear-gradient(135deg, var(--primary) 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 0.9375rem;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: var(--transition);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.25);
        font-family: inherit;
        white-space: nowrap;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.35);
    }

    .btn-primary:active {
        transform: translateY(0);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-icon {
        font-size: 4rem;
        margin-bottom: 1.5rem;
        opacity: 0.3;
        animation: pulse 2s ease-in-out infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            opacity: 0.3;
        }

        50% {
            opacity: 0.5;
        }
    }

    .empty-state h3 {
        color: var(--gray-900);
        margin-bottom: 0.75rem;
        font-size: 1.5rem;
        font-weight: 600;
    }

    .empty-state p {
        color: var(--gray-500);
        font-size: 1rem;
        line-height: 1.6;
        max-width: 480px;
        margin: 0 auto;
    }

    /* Notifications List */
    .notifications-list {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
    }

    .notification-card {
        background: white;
        border-radius: 14px;
        padding: 1.75rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }

    .notification-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 100px;
        height: 100px;
        background: radial-gradient(circle, rgba(102, 126, 234, 0.05) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .notification-card.unread {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.03) 0%, rgba(255, 255, 255, 1) 100%);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.12);
        border: 1px solid rgba(102, 126, 234, 0.1);
    }

    .notification-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
    }

    .notification-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.25rem;
        gap: 1rem;
    }

    .notification-priority {
        display: inline-flex;
        align-items: center;
        padding: 0.375rem 0.875rem;
        border-radius: 20px;
        color: white;
        font-size: 0.6875rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
    }

    .notification-time {
        font-size: 0.8125rem;
        color: var(--gray-500);
        font-weight: 500;
    }

    .notification-content {
        margin-bottom: 1.25rem;
    }

    .notification-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--gray-900);
        margin-bottom: 0.625rem;
        line-height: 1.4;
    }

    .notification-message {
        font-size: 0.9375rem;
        color: var(--gray-600);
        line-height: 1.6;
        margin: 0;
    }

    .notification-actions {
        display: flex;
        gap: 0.625rem;
        flex-wrap: wrap;
        padding-top: 0.75rem;
        border-top: 1px solid var(--gray-200);
    }

    .btn-notification {
        padding: 0.625rem 1.125rem;
        border: 2px solid var(--primary);
        background: white;
        color: var(--primary);
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.8125rem;
        cursor: pointer;
        text-decoration: none;
        transition: var(--transition);
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        font-family: inherit;
    }

    .btn-notification:hover {
        background: var(--primary);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .btn-notification:active {
        transform: translateY(0);
    }

    .btn-mark-read {
        border-color: #10b981;
        color: #10b981;
    }

    .btn-mark-read:hover {
        background: #10b981;
        color: white;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .btn-delete {
        border-color: #ef4444;
        color: #ef4444;
        padding: 0.625rem 0.875rem;
    }

    .btn-delete:hover {
        background: #ef4444;
        color: white;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    /* ==================== TABLET RESPONSIVO ==================== */
    @media (max-width: 1024px) {
        .notification-card {
            padding: 1.5rem;
        }

        .notifications-list {
            gap: 1rem;
        }
    }

    /* ==================== MOBILE RESPONSIVO ==================== */
    @media (max-width: 768px) {
        .card-header {
            flex-direction: column;
            align-items: stretch;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .card-header h1 {
            font-size: 1.5rem;
        }

        .header-actions {
            flex-direction: column;
            gap: 0.625rem;
        }

        .btn-primary,
        .btn-secondary {
            width: 100%;
            justify-content: center;
            padding: 0.875rem 1.25rem;
        }

        .notifications-list {
            gap: 1rem;
        }

        .notification-card {
            padding: 1.25rem;
        }

        .notification-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }

        .notification-priority {
            font-size: 0.625rem;
            padding: 0.3125rem 0.75rem;
        }

        .notification-time {
            font-size: 0.75rem;
        }

        .notification-title {
            font-size: 1rem;
        }

        .notification-message {
            font-size: 0.875rem;
        }

        .notification-actions {
            flex-direction: column;
            gap: 0.5rem;
        }

        .btn-notification {
            width: 100%;
            justify-content: center;
            padding: 0.75rem 1rem;
        }

        .empty-state {
            padding: 3rem 1.5rem;
        }

        .empty-icon {
            font-size: 3rem;
        }

        .empty-state h3 {
            font-size: 1.25rem;
        }

        .empty-state p {
            font-size: 0.9375rem;
        }
    }

    /* ==================== MOBILE SMALL ==================== */
    @media (max-width: 640px) {
        .card-header h1 {
            font-size: 1.375rem;
        }

        .notification-card {
            padding: 1rem;
        }

        .notification-title {
            font-size: 0.9375rem;
        }

        .notification-message {
            font-size: 0.8125rem;
        }

        .btn-notification {
            font-size: 0.75rem;
            padding: 0.625rem 0.875rem;
        }
    }

    /* ==================== EXTRA SMALL ==================== */
    @media (max-width: 375px) {
        .card-header h1 {
            font-size: 1.25rem;
        }

        .notification-priority {
            font-size: 0.5625rem;
        }
    }

    /* ==================== PWA STANDALONE ==================== */
    @media (display-mode: standalone) {
        .card-header {
            padding-top: env(safe-area-inset-top);
        }
    }

    /* ==================== REDUCE MOTION ==================== */
    @media (prefers-reduced-motion: reduce) {

        *,
        *::before,
        *::after {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
    }

    /* ==================== HIGH CONTRAST ==================== */
    @media (prefers-contrast: high) {
        .notification-card {
            border: 2px solid currentColor;
        }

        .btn-notification {
            border-width: 3px;
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