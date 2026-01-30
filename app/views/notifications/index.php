<?php include VIEWS . '/layouts/header.php'; ?>

<style>
    :root {
        --primary: #667eea;
        --primary-hover: #5568d3;
        --secondary: #764ba2;
        --success: #10b981;
        --danger: #ef4444;
        --warning: #f59e0b;
        --gray-50: #f9fafb;
        --gray-100: #f3f4f6;
        --gray-200: #e5e7eb;
        --gray-300: #d1d5db;
        --gray-400: #9ca3af;
        --gray-500: #6b7280;
        --gray-600: #4b5563;
        --gray-700: #374151;
        --gray-800: #1f2937;
        --gray-900: #111827;
        --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.12);
        --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.15);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* ========== ANIMATIONS ========== */
    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes pulse {

        0%,
        100% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.05);
        }
    }

    @keyframes shimmer {
        0% {
            background-position: -200% 0;
        }

        100% {
            background-position: 200% 0;
        }
    }

    /* ========== CONTAINER ========== */
    .container-small {
        max-width: 900px;
        margin: 0 auto;
        padding: 2rem;
        animation: fadeIn 0.5s ease-out;
    }

    /* ========== CARD ========== */
    .card {
        background: white;
        border-radius: 16px;
        padding: 2.5rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--gray-200);
        animation: fadeInUp 0.5s ease-out;
    }

    /* ========== PAGE HEADER ========== */
    .page-header-section {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 2.5rem;
        gap: 1.5rem;
        animation: fadeInDown 0.5s ease-out 0.1s both;
    }

    .page-header-section h2 {
        margin: 0 0 0.5rem 0;
        font-size: 1.875rem;
        font-weight: 700;
        color: var(--gray-900);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .subtitle {
        color: var(--gray-600);
        margin: 0;
        font-size: 1rem;
        line-height: 1.5;
    }

    .header-actions {
        display: flex;
        gap: 0.75rem;
        flex-shrink: 0;
        flex-wrap: wrap;
    }

    /* ========== BUTTONS ========== */
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.75rem 1.25rem;
        border-radius: 10px;
        font-size: 0.9375rem;
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
        cursor: pointer;
        border: none;
        white-space: nowrap;
        font-family: inherit;
    }

    .btn-secondary {
        background: white;
        color: var(--gray-700);
        border: 2px solid var(--gray-300);
    }

    .btn-secondary:hover {
        background: var(--gray-50);
        border-color: var(--gray-400);
        transform: translateY(-2px);
        box-shadow: var(--shadow-sm);
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.25);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.35);
    }

    .btn-primary:active,
    .btn-secondary:active {
        transform: translateY(0);
    }

    /* ========== EMPTY STATE ========== */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        animation: fadeInUp 0.5s ease-out 0.2s both;
    }

    .empty-icon {
        font-size: 4rem;
        margin-bottom: 1.5rem;
        opacity: 0.3;
        animation: pulse 2s ease-in-out infinite;
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

    /* ========== NOTIFICATIONS LIST ========== */
    .notifications-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        animation: fadeInUp 0.5s ease-out 0.3s both;
    }

    .notification-card {
        background: white;
        border: 2px solid var(--gray-200);
        border-radius: 12px;
        padding: 1.5rem;
        transition: var(--transition);
        position: relative;
    }

    .notification-card.unread {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.03) 0%, rgba(255, 255, 255, 1) 100%);
        border-color: var(--primary);
    }

    .notification-card:hover {
        border-color: var(--primary);
        box-shadow: 0 6px 16px rgba(102, 126, 234, 0.15);
        transform: translateY(-3px);
    }

    .notification-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
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
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .notification-content {
        margin-bottom: 1rem;
    }

    .notification-title {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--gray-900);
        margin-bottom: 0.5rem;
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
        gap: 0.5rem;
        flex-wrap: wrap;
        padding-top: 1rem;
        border-top: 1px solid var(--gray-200);
    }

    .btn-notification {
        padding: 0.625rem 1rem;
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
    }

    .btn-delete:hover {
        background: #ef4444;
        color: white;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    /* ========== RESPONSIVE - TABLET ========== */
    @media (max-width: 1024px) {
        .container-small {
            padding: 1.5rem;
        }

        .card {
            padding: 2rem;
        }
    }

    /* ========== RESPONSIVE - MOBILE ========== */
    @media (max-width: 768px) {
        .container-small {
            padding: 1rem;
        }

        .card {
            padding: 1.5rem;
            border-radius: 12px;
        }

        .page-header-section {
            flex-direction: column;
            align-items: stretch;
            gap: 1.25rem;
        }

        .page-header-section h2 {
            font-size: 1.5rem;
        }

        .header-actions {
            flex-direction: column;
        }

        .header-actions .btn {
            width: 100%;
        }

        .notification-card {
            padding: 1.25rem;
        }

        .notification-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }

        .notification-actions {
            flex-direction: column;
        }

        .btn-notification {
            width: 100%;
            justify-content: center;
        }

        .empty-state {
            padding: 3rem 1.5rem;
        }
    }

    /* ========== MOBILE PORTRAIT ========== */
    @media (max-width: 480px) {
        .container-small {
            padding: 0.875rem;
        }

        .card {
            padding: 1.25rem;
        }

        .page-header-section h2 {
            font-size: 1.375rem;
        }

        .subtitle {
            font-size: 0.875rem;
        }

        .notification-title {
            font-size: 1rem;
        }

        .notification-message {
            font-size: 0.875rem;
        }
    }

    /* ========== PWA/STANDALONE MODE ========== */
    @media (display-mode: standalone) {
        .container-small {
            padding-top: calc(env(safe-area-inset-top) + 2rem);
            padding-bottom: calc(env(safe-area-inset-bottom) + 2rem);
        }
    }

    /* ========== ACCESSIBILITY ========== */
    @media (prefers-reduced-motion: reduce) {

        *,
        *::before,
        *::after {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
    }
</style>

<div class="container-small">
    <div class="card">
        <div class="page-header-section">
            <div>
                <h2>🔔 Notificações</h2>
                <p class="subtitle">Acompanhe seus alertas e avisos importantes</p>
            </div>
            <div class="header-actions">
                <a href="/notificacoes/configuracoes" class="btn btn-secondary">⚙️ Configurações</a>
                <?php if ($unreadCount > 0): ?>
                    <a href="/notificacoes/marcar-todas-lidas" class="btn btn-primary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="20 6 9 17 4 12" />
                        </svg>
                        Marcar todas como lidas
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <?php if (empty($notifications)): ?>
            <div class="empty-state">
                <div class="empty-icon">🔔</div>
                <h3>Nenhuma notificação</h3>
                <p>Você está em dia! Quando houver avisos importantes, eles aparecerão aqui.</p>
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
                            <div class="notification-time">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10" />
                                    <polyline points="12 6 12 12 16 14" />
                                </svg>
                                <?= $timeAgo ?>
                            </div>
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
</div>

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