<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <!-- PWA Meta Tags -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#667eea">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Amigo do Bolso">

    <!-- Apple Touch Icons -->
    <link rel="apple-touch-icon" href="/assets/icons/icon-152.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/assets/icons/icon-72.png">
    <link rel="apple-touch-icon" sizes="96x96" href="/assets/icons/icon-96.png">
    <link rel="apple-touch-icon" sizes="128x128" href="/assets/icons/icon-128.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/assets/icons/icon-144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/assets/icons/icon-152.png">
    <link rel="apple-touch-icon" sizes="192x192" href="/assets/icons/icon-192.png">
    <link rel="apple-touch-icon" sizes="384x384" href="/assets/icons/icon-384.png">
    <link rel="apple-touch-icon" sizes="512x512" href="/assets/icons/icon-512.png">

    <!-- Registrar Service Worker -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/service-worker.js')
                    .then(reg => console.log('✅ PWA instalado!', reg))
                    .catch(err => console.log('❌ Erro PWA:', err));
            });
        }
    </script>
    <style>
        :root {
            --primary: #667eea;
            --primary-hover: #5568d3;
            --secondary: #764ba2;
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
            --success: #10b981;
            --error: #ef4444;
            --warning: #f59e0b;
            --info: #3b82f6;
            --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.12);
            --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.15);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            -webkit-tap-highlight-color: transparent;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: var(--gray-50);
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* ========== NAVBAR DESKTOP ========== */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: #ffffff;
            border-bottom: 1px solid var(--gray-200);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            transition: var(--transition);
        }

        .navbar .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem 2rem;
            gap: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Menu Desktop */
        .navbar-menu {
            display: flex;
            list-style: none;
            gap: 0.25rem;
            margin: 0;
            padding: 0;
            align-items: center;
            flex: 1;
        }

        .navbar-menu li {
            margin: 0;
        }

        .navbar-menu li a {
            color: var(--gray-600);
            text-decoration: none;
            padding: 0.625rem 1rem;
            border-radius: 10px;
            transition: var(--transition);
            font-weight: 500;
            font-size: 0.9375rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            white-space: nowrap;
        }

        .navbar-menu li a svg {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        .navbar-menu li a:hover {
            background: var(--gray-50);
            color: var(--gray-900);
        }

        .navbar-menu li a.active {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.25);
        }

        .btn-logout {
            color: var(--error) !important;
        }

        .btn-logout:hover {
            background: #fef2f2 !important;
            color: #dc2626 !important;
        }

        /* Navbar Right */
        .navbar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        /* Botão de Notificações */
        .notification-btn {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            background: white;
            border: 2px solid var(--gray-200);
            border-radius: 10px;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
            color: var(--gray-600);
        }

        .notification-btn:hover {
            border-color: var(--primary);
            background: var(--gray-50);
            color: var(--primary);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(102, 126, 234, 0.2);
        }

        .notification-btn svg {
            width: 20px;
            height: 20px;
        }

        .notification-badge {
            position: absolute;
            top: -6px;
            right: -6px;
            background: linear-gradient(135deg, var(--error) 0%, #dc2626 100%);
            color: white;
            font-size: 0.625rem;
            font-weight: 700;
            padding: 0.125rem 0.375rem;
            border-radius: 10px;
            min-width: 18px;
            height: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.4);
            border: 2px solid white;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        /* Group Selector */
        .group-selector {
            position: relative;
        }

        .group-selector-btn {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.625rem 1rem;
            background: white;
            border: 2px solid var(--gray-200);
            border-radius: 10px;
            cursor: pointer;
            transition: var(--transition);
            font-size: 0.9375rem;
            color: var(--gray-900);
            font-weight: 600;
            min-width: 200px;
        }

        .group-selector-btn:hover {
            border-color: var(--primary);
            box-shadow: 0 6px 16px rgba(102, 126, 234, 0.2);
            transform: translateY(-1px);
        }

        .group-selector-icon {
            width: 20px;
            height: 20px;
            color: var(--primary);
            flex-shrink: 0;
        }

        .group-selector-text {
            flex: 1;
            text-align: left;
            overflow: hidden;
        }

        .group-selector-text span {
            display: block;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .group-selector-btn .chevron {
            width: 18px;
            height: 18px;
            color: var(--gray-400);
            transition: transform 0.3s;
        }

        .group-selector-btn:hover .chevron {
            color: var(--primary);
        }

        .group-selector.open .chevron {
            transform: rotate(180deg);
        }

        /* Group Dropdown */
        .group-dropdown {
            position: absolute;
            top: calc(100% + 0.75rem);
            right: 0;
            background: white;
            border: 1px solid var(--gray-200);
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            min-width: 300px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1100;
        }

        .group-dropdown.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .group-dropdown-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--gray-100);
        }

        .group-dropdown-title {
            font-size: 0.75rem;
            font-weight: 700;
            color: var(--gray-500);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .group-count {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            padding: 0.25rem 0.625rem;
            border-radius: 10px;
            font-size: 0.6875rem;
            font-weight: 700;
        }

        .group-dropdown-list {
            max-height: 320px;
            overflow-y: auto;
            padding: 0.5rem;
        }

        .group-dropdown-item {
            display: flex;
            align-items: center;
            gap: 0.875rem;
            padding: 0.875rem 1rem;
            text-decoration: none;
            color: var(--gray-900);
            transition: var(--transition);
            border-radius: 10px;
            margin-bottom: 0.25rem;
        }

        .group-dropdown-item:hover {
            background: var(--gray-50);
        }

        .group-dropdown-item.active {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
        }

        .group-dropdown-item.active .group-dropdown-text small {
            color: rgba(255, 255, 255, 0.9);
        }

        .group-dropdown-avatar {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: var(--gray-200);
            color: var(--gray-700);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.875rem;
            flex-shrink: 0;
        }

        .group-dropdown-item.active .group-dropdown-avatar {
            background: rgba(255, 255, 255, 0.25);
            color: white;
        }

        .group-dropdown-text {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .group-dropdown-text strong {
            font-size: 0.9375rem;
            font-weight: 600;
        }

        .group-dropdown-text small {
            font-size: 0.75rem;
            color: var(--gray-500);
        }

        /* ========== MOBILE STYLES ========== */
        /* Mobile Toggle Button - Hidden by default */
        .mobile-toggle {
            display: none;
            flex-direction: column;
            gap: 4px;
            cursor: pointer;
            padding: 0.5rem;
            background: transparent;
            border: none;
            width: 40px;
            height: 40px;
            align-items: center;
            justify-content: center;
            position: relative;
            z-index: 1001;
        }

        .mobile-toggle span {
            width: 22px;
            height: 2.5px;
            background: var(--gray-700);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 2px;
        }

        .mobile-toggle.active span:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
            background: var(--primary);
        }

        .mobile-toggle.active span:nth-child(2) {
            opacity: 0;
        }

        .mobile-toggle.active span:nth-child(3) {
            transform: rotate(-45deg) translate(6px, -6px);
            background: var(--primary);
        }

        /* Mobile Menu Overlay */
        .mobile-menu-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 999;
            backdrop-filter: blur(4px);
            display: none;
        }

        .mobile-menu-overlay.active {
            opacity: 1;
            visibility: visible;
            display: block;
        }

        /* Mobile Menu Drawer */
        .mobile-menu-drawer {
            position: fixed;
            top: 0;
            left: -100%;
            width: 280px;
            height: 100vh;
            background: white;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .mobile-menu-drawer.active {
            left: 0;
        }

        /* Header do Menu Mobile */
        .mobile-menu-header {
            padding: 1.5rem 1.25rem;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .mobile-menu-title {
            font-size: 1.125rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .mobile-menu-subtitle {
            font-size: 0.8125rem;
            opacity: 0.9;
        }

        /* Navigation Items */
        .mobile-menu-nav {
            flex: 1;
            padding: 1rem 0.75rem;
        }

        .mobile-menu-nav a {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem 1rem;
            text-decoration: none;
            color: var(--gray-700);
            font-weight: 500;
            font-size: 0.9375rem;
            border-radius: 10px;
            margin-bottom: 0.375rem;
            transition: var(--transition);
        }

        .mobile-menu-nav a svg {
            width: 20px;
            height: 20px;
            flex-shrink: 0;
        }

        .mobile-menu-nav a:hover {
            background: var(--gray-50);
        }

        .mobile-menu-nav a.active {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.25);
        }

        /* Group Section Mobile */
        .mobile-menu-group {
            padding: 1rem;
            border-top: 1px solid var(--gray-200);
        }

        .mobile-menu-group-title {
            font-size: 0.6875rem;
            font-weight: 700;
            color: var(--gray-500);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.75rem;
            padding: 0 0.5rem;
        }

        .mobile-group-item {
            display: flex;
            align-items: center;
            gap: 0.875rem;
            padding: 0.875rem;
            text-decoration: none;
            color: var(--gray-900);
            transition: var(--transition);
            border-radius: 10px;
            margin-bottom: 0.375rem;
        }

        .mobile-group-item:hover {
            background: var(--gray-50);
        }

        .mobile-group-item.active {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
        }

        .mobile-group-item.active .mobile-group-text small {
            color: rgba(255, 255, 255, 0.9);
        }

        .mobile-group-avatar {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: var(--gray-200);
            color: var(--gray-700);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.875rem;
            flex-shrink: 0;
        }

        .mobile-group-item.active .mobile-group-avatar {
            background: rgba(255, 255, 255, 0.25);
            color: white;
        }

        .mobile-group-text {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .mobile-group-text strong {
            font-size: 0.9375rem;
            font-weight: 600;
        }

        .mobile-group-text small {
            font-size: 0.75rem;
            color: var(--gray-500);
        }

        /* Logout Mobile */
        .mobile-menu-footer {
            padding: 1rem;
            border-top: 1px solid var(--gray-200);
        }

        .mobile-btn-logout {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            width: 100%;
            padding: 1rem;
            background: #fef2f2;
            color: var(--error);
            text-decoration: none;
            font-weight: 600;
            border-radius: 10px;
            transition: var(--transition);
        }

        .mobile-btn-logout svg {
            width: 20px;
            height: 20px;
        }

        .mobile-btn-logout:hover {
            background: #fee2e2;
            color: #dc2626;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 768px) {
            .navbar .container {
                padding: 0.5rem 1rem;
                gap: 0.75rem;
            }

            /* Esconde menu desktop no mobile */
            .navbar-menu {
                display: none !important;
            }

            /* Mostra toggle button no mobile */
            .mobile-toggle {
                display: flex;
            }

            /* Ajusta navbar right no mobile */
            .navbar-right {
                gap: 0.5rem;
            }

            .notification-btn {
                width: 40px;
                height: 40px;
            }

            .notification-btn svg {
                width: 18px;
                height: 18px;
            }

            .notification-badge {
                top: -4px;
                right: -4px;
                min-width: 16px;
                height: 16px;
                font-size: 0.5625rem;
            }

            /* Esconde group selector no mobile */
            .group-selector {
                display: none;
            }

            /* Mostra mobile menu components quando ativos */
            .mobile-menu-overlay.active,
            .mobile-menu-drawer.active {
                display: block;
            }

            .mobile-menu-drawer.active {
                display: flex;
            }
        }

        /* Toast Notifications */
        .toast-container {
            position: fixed;
            top: 5rem;
            right: 2rem;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            pointer-events: none;
        }

        .toast {
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            padding: 1.25rem 1.5rem;
            min-width: 350px;
            max-width: 450px;
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            animation: slideInRight 0.4s ease-out forwards;
            pointer-events: auto;
            border-left: 4px solid;
            position: relative;
            overflow: hidden;
        }

        .toast.removing {
            animation: slideOutRight 0.3s ease-in forwards;
        }

        .toast-success {
            border-left-color: var(--success);
        }

        .toast-error {
            border-left-color: var(--error);
        }

        .toast-info {
            border-left-color: var(--info);
        }

        .toast-icon {
            width: 24px;
            height: 24px;
            flex-shrink: 0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .toast-success .toast-icon {
            background: #d1fae5;
            color: var(--success);
        }

        .toast-error .toast-icon {
            background: #fee2e2;
            color: var(--error);
        }

        .toast-info .toast-icon {
            background: #dbeafe;
            color: var(--info);
        }

        .toast-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .toast-title {
            font-weight: 700;
            font-size: 0.9375rem;
            color: var(--gray-900);
        }

        .toast-message {
            font-size: 0.875rem;
            color: var(--gray-600);
            line-height: 1.5;
        }

        .toast-close {
            background: transparent;
            border: none;
            color: var(--gray-400);
            cursor: pointer;
            padding: 0.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            transition: var(--transition);
            flex-shrink: 0;
        }

        .toast-close:hover {
            background: var(--gray-100);
            color: var(--gray-600);
        }

        .toast-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            background: currentColor;
            opacity: 0.3;
            animation: shrink 5s linear forwards;
        }

        .toast-success .toast-progress {
            color: var(--success);
        }

        .toast-error .toast-progress {
            color: var(--error);
        }

        .toast-info .toast-progress {
            color: var(--info);
        }

        @keyframes slideInRight {
            from {
                transform: translateX(400px);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }

            to {
                transform: translateX(400px);
                opacity: 0;
            }
        }

        @keyframes shrink {
            from {
                width: 100%;
            }

            to {
                width: 0%;
            }
        }

        @media (max-width: 768px) {
            .toast-container {
                top: 4rem;
                right: 1rem;
                left: 1rem;
            }

            .toast {
                min-width: auto;
                max-width: 100%;
                padding: 1rem 1.25rem;
            }
        }

        /* PWA/Standalone Mode */
        @media (display-mode: standalone) {
            body {
                padding-top: env(safe-area-inset-top);
            }

            .navbar {
                padding-top: env(safe-area-inset-top);
            }
        }

        /* Reduce Motion */
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
    <?php
    // Busca contador de notificações não lidas
    $unreadCount = 0;
    if (isset($_SESSION['user_id'])) {
        require_once APP . '/models/NotificationModel.php';
        $notificationModel = new NotificationModel();
        $unreadCount = $notificationModel->countUnread($_SESSION['user_id']);
    }

    // Buscar grupos do usuário para o seletor
    $userGroups = [];
    $currentGroup = null;
    if (isset($_SESSION['user_id'])) {
        require_once APP . '/models/GroupModel.php';
        $groupModel = new GroupModel();
        $userGroups = $groupModel->getUserGroups($_SESSION['user_id']);
        $currentGroupId = $_SESSION['current_group_id'] ?? null;

        if ($currentGroupId) {
            foreach ($userGroups as $group) {
                if ($group['id'] == $currentGroupId) {
                    $currentGroup = $group;
                    break;
                }
            }
        }
    }
    ?>

    <?php if (isset($_SESSION['user_id'])): ?>
        <nav class="navbar">
            <div class="container">
                <!-- Mobile Toggle Button -->
                <button class="mobile-toggle" id="mobileToggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

                <!-- Desktop Menu -->
                <ul class="navbar-menu" id="navMenu">
                    <li>
                        <a href="/dashboard" class="<?= $_SERVER['REQUEST_URI'] === '/dashboard' ? 'active' : '' ?>">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="3" width="7" height="7" />
                                <rect x="14" y="3" width="7" height="7" />
                                <rect x="14" y="14" width="7" height="7" />
                                <rect x="3" y="14" width="7" height="7" />
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="/transacoes" class="<?= strpos($_SERVER['REQUEST_URI'], '/transacoes') !== false ? 'active' : '' ?>">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="12" y1="1" x2="12" y2="23" />
                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                            </svg>
                            Transações
                        </a>
                    </li>
                    <li>
                        <a href="/cartoes" class="<?= strpos($_SERVER['REQUEST_URI'], '/cartoes') !== false ? 'active' : '' ?>">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="1" y="4" width="22" height="16" rx="2" ry="2" />
                                <line x1="1" y1="10" x2="23" y2="10" />
                            </svg>
                            Cartões
                        </a>
                    </li>
                    <li>
                        <a href="/beneficios" class="<?= strpos($_SERVER['REQUEST_URI'], '/beneficios') !== false ? 'active' : '' ?>">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z" />
                                <line x1="7" y1="7" x2="7.01" y2="7" />
                            </svg>
                            Benefícios
                        </a>
                    </li>
                    <li>
                        <a href="/metas" class="<?= strpos($_SERVER['REQUEST_URI'], '/metas') !== false ? 'active' : '' ?>">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10" />
                                <circle cx="12" cy="12" r="6" />
                                <circle cx="12" cy="12" r="2" />
                            </svg>
                            Metas
                        </a>
                    </li>
                    <li>
                        <a href="/grupos/detalhes" class="<?= strpos($_SERVER['REQUEST_URI'], '/grupos') !== false ? 'active' : '' ?>">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                            </svg>
                            Grupo
                        </a>
                    </li>
                    <li>
                        <a href="/auth/logout" class="btn-logout">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                <polyline points="16 17 21 12 16 7" />
                                <line x1="21" y1="12" x2="9" y2="12" />
                            </svg>
                            Sair
                        </a>
                    </li>
                </ul>

                <div class="navbar-right">
                    <a href="/notificacoes" class="notification-btn" title="Notificações">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9" />
                            <path d="M13.73 21a2 2 0 0 1-3.46 0" />
                        </svg>
                        <?php if ($unreadCount > 0): ?>
                            <span class="notification-badge" id="notificationCount">
                                <?= $unreadCount > 99 ? '99+' : $unreadCount ?>
                            </span>
                        <?php endif; ?>
                    </a>

                    <?php if (!empty($userGroups)): ?>
                        <div class="group-selector">
                            <button class="group-selector-btn" id="groupSelectorBtn">
                                <svg class="group-selector-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                    <circle cx="9" cy="7" r="4" />
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75" />
                                </svg>
                                <div class="group-selector-text">
                                    <span><?= $currentGroup ? htmlspecialchars($currentGroup['name']) : 'Selecionar grupo' ?></span>
                                </div>
                                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="6 9 12 15 18 9" />
                                </svg>
                            </button>

                            <div class="group-dropdown" id="groupDropdown">
                                <div class="group-dropdown-header">
                                    <span class="group-dropdown-title">Trocar de Grupo</span>
                                    <span class="group-count"><?= count($userGroups) ?></span>
                                </div>
                                <div class="group-dropdown-list">
                                    <?php foreach ($userGroups as $group): ?>
                                        <a href="/grupos/trocar/<?= $group['id'] ?>"
                                            class="group-dropdown-item <?= $group['id'] == ($currentGroupId ?? 0) ? 'active' : '' ?>">
                                            <div class="group-dropdown-avatar">
                                                <?= strtoupper(substr($group['name'], 0, 2)) ?>
                                            </div>
                                            <div class="group-dropdown-text">
                                                <strong><?= htmlspecialchars($group['name']) ?></strong>
                                                <small><?= $group['member_count'] ?? 0 ?> membro(s)</small>
                                            </div>
                                            <?php if ($group['id'] == ($currentGroupId ?? 0)): ?>
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                                    <polyline points="20 6 9 17 4 12" />
                                                </svg>
                                            <?php endif; ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </nav>

        <!-- Mobile Menu Overlay -->
        <div class="mobile-menu-overlay" id="mobileOverlay"></div>

        <!-- Mobile Menu Drawer -->
        <div class="mobile-menu-drawer" id="mobileDrawer">
            <div class="mobile-menu-header">
                <div class="mobile-menu-title">Amigo do Bolso</div>
            </div>

            <div class="mobile-menu-nav">
                <a href="/dashboard" class="<?= $_SERVER['REQUEST_URI'] === '/dashboard' ? 'active' : '' ?>">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7" />
                        <rect x="14" y="3" width="7" height="7" />
                        <rect x="14" y="14" width="7" height="7" />
                        <rect x="3" y="14" width="7" height="7" />
                    </svg>
                    Dashboard
                </a>
                <a href="/transacoes" class="<?= strpos($_SERVER['REQUEST_URI'], '/transacoes') !== false ? 'active' : '' ?>">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="1" x2="12" y2="23" />
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                    </svg>
                    Transações
                </a>
                <a href="/cartoes" class="<?= strpos($_SERVER['REQUEST_URI'], '/cartoes') !== false ? 'active' : '' ?>">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="1" y="4" width="22" height="16" rx="2" ry="2" />
                        <line x1="1" y1="10" x2="23" y2="10" />
                    </svg>
                    Cartões
                </a>
                <a href="/beneficios" class="<?= strpos($_SERVER['REQUEST_URI'], '/beneficios') !== false ? 'active' : '' ?>">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z" />
                        <line x1="7" y1="7" x2="7.01" y2="7" />
                    </svg>
                    Benefícios
                </a>
                <a href="/metas" class="<?= strpos($_SERVER['REQUEST_URI'], '/metas') !== false ? 'active' : '' ?>">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <circle cx="12" cy="12" r="6" />
                        <circle cx="12" cy="12" r="2" />
                    </svg>
                    Metas
                </a>
                <a href="/grupos/detalhes" class="<?= strpos($_SERVER['REQUEST_URI'], '/grupos') !== false ? 'active' : '' ?>">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                        <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    </svg>
                    Grupo
                </a>
            </div>

            <?php if (!empty($userGroups)): ?>
                <div class="mobile-menu-group">
                    <div class="mobile-menu-group-title">Meus Grupos (<?= count($userGroups) ?>)</div>
                    <?php foreach ($userGroups as $group): ?>
                        <a href="/grupos/trocar/<?= $group['id'] ?>"
                            class="mobile-group-item <?= $group['id'] == ($currentGroupId ?? 0) ? 'active' : '' ?>">
                            <div class="mobile-group-avatar">
                                <?= strtoupper(substr($group['name'], 0, 2)) ?>
                            </div>
                            <div class="mobile-group-text">
                                <strong><?= htmlspecialchars($group['name']) ?></strong>
                                <small><?= $group['member_count'] ?? 0 ?> membro(s)</small>
                            </div>
                            <?php if ($group['id'] == ($currentGroupId ?? 0)): ?>
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                    <polyline points="20 6 9 17 4 12" />
                                </svg>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="mobile-menu-footer">
                <a href="/auth/logout" class="mobile-btn-logout">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        <polyline points="16 17 21 12 16 7" />
                        <line x1="21" y1="12" x2="9" y2="12" />
                    </svg>
                    Sair
                </a>
            </div>
        </div>

        <script>
            // Mobile Menu Functions
            const mobileToggle = document.getElementById('mobileToggle');
            const mobileOverlay = document.getElementById('mobileOverlay');
            const mobileDrawer = document.getElementById('mobileDrawer');

            function toggleMobileMenu() {
                mobileToggle.classList.toggle('active');
                mobileOverlay.classList.toggle('active');
                mobileDrawer.classList.toggle('active');

                // Previne scroll do body quando menu está aberto
                if (mobileDrawer.classList.contains('active')) {
                    document.body.style.overflow = 'hidden';
                } else {
                    document.body.style.overflow = '';
                }
            }

            function closeMobileMenu() {
                mobileToggle.classList.remove('active');
                mobileOverlay.classList.remove('active');
                mobileDrawer.classList.remove('active');
                document.body.style.overflow = '';
            }

            // Group Dropdown Functions
            const groupSelectorBtn = document.getElementById('groupSelectorBtn');
            const groupDropdown = document.getElementById('groupDropdown');

            function toggleGroupDropdown(event) {
                event.stopPropagation();
                groupDropdown.classList.toggle('show');
            }

            // Event Listeners
            if (mobileToggle) {
                mobileToggle.addEventListener('click', toggleMobileMenu);
            }

            if (mobileOverlay) {
                mobileOverlay.addEventListener('click', closeMobileMenu);
            }

            if (groupSelectorBtn && groupDropdown) {
                groupSelectorBtn.addEventListener('click', toggleGroupDropdown);
            }

            // Fechar dropdown ao clicar fora
            window.addEventListener('click', function(e) {
                if (groupDropdown && !e.target.closest('.group-selector')) {
                    groupDropdown.classList.remove('show');
                }
            });

            // Fechar menu mobile ao navegar
            document.querySelectorAll('.mobile-menu-nav a, .mobile-group-item').forEach(link => {
                link.addEventListener('click', closeMobileMenu);
            });

            // Sistema de Toast Notifications
            function showToast(message, type = 'info') {
                const container = document.getElementById('toastContainer');
                if (!container) return;

                const toast = document.createElement('div');
                toast.className = `toast toast-${type}`;

                const icons = {
                    success: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>',
                    error: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>',
                    info: '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>'
                };

                const titles = {
                    success: 'Sucesso!',
                    error: 'Erro!',
                    info: 'Informação'
                };

                toast.innerHTML = `
                    <div class="toast-icon">
                        ${icons[type] || icons.info}
                    </div>
                    <div class="toast-content">
                        <div class="toast-title">${titles[type]}</div>
                        <div class="toast-message">${message}</div>
                    </div>
                    <button class="toast-close" onclick="removeToast(this)">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <line x1="18" y1="6" x2="6" y2="18"/>
                            <line x1="6" y1="6" x2="18" y2="18"/>
                        </svg>
                    </button>
                    <div class="toast-progress"></div>
                `;

                container.appendChild(toast);

                setTimeout(() => {
                    removeToast(toast);
                }, 5000);
            }

            function removeToast(element) {
                const toast = element.classList ? element : element.closest('.toast');
                if (!toast) return;

                toast.classList.add('removing');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }
        </script>
    <?php endif; ?>

    <!-- Toast Notifications Container -->
    <div id="toastContainer" class="toast-container"></div>

    <?php if (isset($_SESSION['success'])): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                showToast('<?= addslashes($_SESSION['success']) ?>', 'success');
            });
        </script>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                showToast('<?= addslashes($_SESSION['error']) ?>', 'error');
            });
        </script>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['info'])): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                showToast('<?= addslashes($_SESSION['info']) ?>', 'info');
            });
        </script>
        <?php unset($_SESSION['info']); ?>
    <?php endif; ?>

</body>

</html>