<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="theme-color" content="#667eea">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <title>Selecionar Grupo - Amigo do Bolso</title>
    <link rel="stylesheet" href="/css/styles.css">
    <style>
        /* ==================== RESET ==================== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent;
        }

        :root {
            --primary: #667eea;
            --primary-dark: #5568d3;
            --secondary: #764ba2;
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-400: #94a3b8;
            --gray-500: #64748b;
            --gray-600: #475569;
            --gray-900: #0f172a;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            min-height: 100vh;
            min-height: -webkit-fill-available;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem;
            -webkit-font-smoothing: antialiased;
            position: relative;
            overflow-x: hidden;
        }

        html {
            height: -webkit-fill-available;
        }

        /* Efeito decorativo */
        body::before,
        body::after {
            content: '';
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            pointer-events: none;
        }

        body::before {
            width: 500px;
            height: 500px;
            top: -150px;
            right: -150px;
        }

        body::after {
            width: 350px;
            height: 350px;
            bottom: -100px;
            left: -100px;
        }

        /* ==================== LOGO NO TOPO ==================== */
        .top-logo {
            position: absolute;
            top: 2rem;
            left: 50%;
            transform: translateX(-50%);
            z-index: 10;
            animation: fadeInDown 0.6s ease-out;
        }

        .top-logo img {
            height: 60px;
            width: auto;
            filter: brightness(0) invert(1) drop-shadow(0 4px 8px rgba(0, 0, 0, 0.15));
        }

        /* ==================== CONTAINER PRINCIPAL ==================== */
        .container-small {
            width: 100%;
            max-width: 900px;
            position: relative;
            z-index: 1;
            animation: fadeInUp 0.6s ease-out 0.2s both;
        }

        .welcome-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.25);
            overflow: hidden;
        }

        /* ==================== HEADER ==================== */
        .welcome-header {
            text-align: center;
            padding: 2.5rem 2rem 2rem;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
            border-bottom: 1px solid var(--gray-200);
        }

        .welcome-header h2 {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            color: var(--gray-900);
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        .welcome-header p {
            color: var(--gray-500);
            font-size: 1.0625rem;
            line-height: 1.5;
        }

        /* ==================== EMPTY STATE ==================== */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }

        .empty-state svg {
            margin-bottom: 1.5rem;
            opacity: 0.3;
        }

        .empty-state h3 {
            font-size: 1.5rem;
            margin-bottom: 0.75rem;
            color: var(--gray-900);
            font-weight: 600;
        }

        .empty-state p {
            color: var(--gray-500);
            margin-bottom: 2rem;
            line-height: 1.6;
            max-width: 480px;
            margin-left: auto;
            margin-right: auto;
        }

        .empty-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        /* ==================== GROUPS GRID ==================== */
        .groups-grid {
            display: grid;
            gap: 1rem;
            padding: 2rem;
        }

        .group-card-link {
            text-decoration: none;
        }

        .group-card {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            padding: 1.5rem;
            background: white;
            border: 2px solid var(--gray-200);
            border-radius: 16px;
            transition: var(--transition);
            cursor: pointer;
        }

        .group-card:hover {
            border-color: var(--primary);
            box-shadow: 0 8px 24px rgba(102, 126, 234, 0.15);
            transform: translateX(8px);
        }

        .group-card-icon {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 700;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .group-card-content {
            flex: 1;
            min-width: 0;
        }

        .group-card-content h3 {
            font-size: 1.25rem;
            margin: 0 0 0.75rem 0;
            color: var(--gray-900);
            font-weight: 600;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .group-card-meta {
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--gray-500);
            font-size: 0.875rem;
        }

        .meta-item svg {
            color: var(--gray-400);
            flex-shrink: 0;
        }

        .arrow-icon {
            color: var(--gray-300);
            flex-shrink: 0;
            transition: var(--transition);
        }

        .group-card:hover .arrow-icon {
            color: var(--primary);
            transform: translateX(4px);
        }

        /* ==================== ADDITIONAL ACTIONS ==================== */
        .additional-actions {
            display: flex;
            justify-content: center;
            gap: 2rem;
            padding: 1.5rem 2rem 2rem;
            border-top: 1px solid var(--gray-200);
            flex-wrap: wrap;
            background: var(--gray-50);
        }

        .action-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9375rem;
            transition: var(--transition);
            padding: 0.5rem;
            border-radius: 8px;
        }

        .action-link:hover {
            gap: 0.75rem;
            color: var(--secondary);
            background: rgba(102, 126, 234, 0.08);
        }

        .action-link svg {
            transition: transform 0.2s;
            flex-shrink: 0;
        }

        .action-link:hover svg {
            transform: scale(1.1);
        }

        /* ==================== BUTTONS ==================== */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.875rem 1.5rem;
            border: none;
            border-radius: 10px;
            font-size: 0.9375rem;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: var(--transition);
            font-family: inherit;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: white;
            color: var(--primary);
            border: 2px solid var(--primary);
        }

        .btn-secondary:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-2px);
        }

        /* ==================== ANIMATIONS ==================== */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateX(-50%) translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateX(-50%) translateY(0);
            }
        }

        /* ==================== TABLET ==================== */
        @media (max-width: 968px) {

            body::before,
            body::after {
                display: none;
            }

            .top-logo {
                top: 1.5rem;
            }

            .top-logo img {
                height: 50px;
            }

            .welcome-header {
                padding: 2rem 1.5rem 1.5rem;
            }

            .welcome-header h2 {
                font-size: 1.75rem;
            }

            .groups-grid {
                padding: 1.5rem;
            }
        }

        /* ==================== MOBILE ==================== */
        @media (max-width: 640px) {
            body {
                padding: 1rem;
                align-items: flex-start;
                padding-top: 5rem;
            }

            .top-logo {
                top: 1rem;
            }

            .top-logo img {
                height: 45px;
            }

            .welcome-card {
                border-radius: 16px;
            }

            .welcome-header {
                padding: 1.75rem 1.25rem 1.25rem;
            }

            .welcome-header h2 {
                font-size: 1.5rem;
            }

            .welcome-header p {
                font-size: 0.9375rem;
            }

            .groups-grid {
                padding: 1.25rem;
                gap: 0.875rem;
            }

            .group-card {
                flex-direction: column;
                text-align: center;
                padding: 1.25rem;
            }

            .group-card:hover {
                transform: translateY(-4px);
            }

            .group-card-icon {
                width: 56px;
                height: 56px;
                font-size: 1.375rem;
            }

            .group-card-content h3 {
                font-size: 1.125rem;
                white-space: normal;
            }

            .group-card-meta {
                justify-content: center;
                gap: 1rem;
            }

            .meta-item {
                font-size: 0.8125rem;
            }

            .arrow-icon {
                transform: rotate(90deg);
            }

            .group-card:hover .arrow-icon {
                transform: rotate(90deg) translateX(4px);
            }

            .empty-state {
                padding: 3rem 1.5rem;
            }

            .empty-state h3 {
                font-size: 1.25rem;
            }

            .empty-state p {
                font-size: 0.9375rem;
            }

            .empty-actions {
                flex-direction: column;
                gap: 0.75rem;
            }

            .btn {
                width: 100%;
                justify-content: center;
                padding: 0.875rem 1.25rem;
            }

            .additional-actions {
                flex-direction: column;
                gap: 0.75rem;
                padding: 1.25rem;
            }

            .action-link {
                width: 100%;
                justify-content: center;
                padding: 0.75rem;
            }
        }

        /* ==================== EXTRA SMALL ==================== */
        @media (max-width: 375px) {
            body {
                padding: 0.75rem;
                padding-top: 4.5rem;
            }

            .top-logo img {
                height: 40px;
            }

            .welcome-header h2 {
                font-size: 1.375rem;
            }

            .group-card {
                padding: 1rem;
            }

            .group-card-icon {
                width: 50px;
                height: 50px;
                font-size: 1.25rem;
            }
        }

        /* ==================== PWA STANDALONE ==================== */
        @media (display-mode: standalone) {
            body {
                padding-top: calc(env(safe-area-inset-top) + 1.5rem);
            }

            .top-logo {
                top: calc(env(safe-area-inset-top) + 1rem);
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
    </style>
</head>

<body>
    <div class="container-small">
        <div class="card welcome-card">
            <div class="welcome-header">
                <h2>👋 Bem-vindo de volta!</h2>
                <p>Selecione o grupo que deseja acessar</p>
            </div>

            <?php if (empty($groups)): ?>
                <div class="empty-state">
                    <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" opacity="0.3">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                    <h3>Nenhum grupo encontrado</h3>
                    <p>Você ainda não faz parte de nenhum grupo. Crie seu primeiro grupo ou entre em um existente!</p>

                    <div class="empty-actions">
                        <a href="/grupos/criar" class="btn btn-primary">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M12 5v14M5 12h14" />
                            </svg>
                            Criar Grupo
                        </a>
                        <a href="/grupos/entrar" class="btn btn-secondary">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M13.8 12H3" />
                            </svg>
                            Entrar em Grupo
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <div class="groups-grid">
                    <?php foreach ($groups as $group): ?>
                        <a href="/grupos/trocar/<?= $group['id'] ?>" class="group-card-link">
                            <div class="group-card">
                                <div class="group-card-icon">
                                    <?= strtoupper(substr($group['name'], 0, 2)) ?>
                                </div>
                                <div class="group-card-content">
                                    <h3><?= htmlspecialchars($group['name']) ?></h3>
                                    <div class="group-card-meta">
                                        <span class="meta-item">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                                <circle cx="9" cy="7" r="4" />
                                                <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75" />
                                            </svg>
                                            <?= $group['member_count'] ?? 0 ?> membro(s)
                                        </span>
                                        <span class="meta-item">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                                                <path d="M16 2v4M8 2v4M3 10h18" />
                                            </svg>
                                            <?= date('d/m/Y', strtotime($group['created_at'])) ?>
                                        </span>
                                    </div>
                                </div>
                                <svg class="arrow-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="9 18 15 12 9 6" />
                                </svg>
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>

                <div class="additional-actions">
                    <a href="/grupos/criar" class="action-link">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 5v14M5 12h14" />
                        </svg>
                        Criar novo grupo
                    </a>
                    <a href="/grupos/entrar" class="action-link">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M13.8 12H3" />
                        </svg>
                        Entrar em grupo existente
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>


</body>

</html>