<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Amigo do Bolso 2.0' ?></title>
    <link rel="stylesheet" href="/css/style.css">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
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
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            margin: 0 !important;
            padding: 0 !important;
        }

        /* NAVBAR MODERNA */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: #ffffff;
            border-bottom: 1px solid var(--gray-200);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .navbar .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.875rem 2rem;
            gap: 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .navbar-brand {
            flex-shrink: 0;
        }

        .navbar-brand a {
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: opacity 0.2s;
        }

        .navbar-brand a:hover {
            opacity: 0.85;
        }

        .logo {
            height: auto;
            width: auto;
            max-height: 120px;
        }

        /* NAVBAR MENU */
        .navbar-menu {
            display: flex;
            list-style: none;
            gap: 0.25rem;
            margin: 0;
            padding: 0;
            align-items: center;
            flex: 1;
            justify-content: center;
        }

        .navbar-menu li {
            margin: 0;
        }

        .navbar-menu li a {
            color: var(--gray-600);
            text-decoration: none;
            padding: 0.625rem 1rem;
            border-radius: 8px;
            transition: all 0.2s;
            font-weight: 500;
            font-size: 0.875rem;
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
            background: var(--primary);
            color: white;
        }

        .btn-logout {
            color: #ef4444 !important;
        }

        .btn-logout:hover {
            background: #fef2f2 !important;
            color: #dc2626 !important;
        }

        /* Group Selector - Superior Direito */
        .navbar-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .group-selector {
            position: relative;
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .group-selector-label {
            font-size: 0.6875rem;
            font-weight: 600;
            color: var(--gray-500);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding-left: 0.5rem;
        }

        .group-selector-btn {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            padding: 0.625rem 1rem;
            background: white;
            border: 2px solid var(--gray-200);
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 0.9375rem;
            color: var(--gray-900);
            font-weight: 600;
            min-width: 180px;
        }

        .group-selector-btn:hover {
            border-color: var(--primary);
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.15);
            transform: translateY(-1px);
        }

        .group-selector-icon {
            width: 22px;
            height: 22px;
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
            transition: transform 0.2s;
        }

        .group-selector-btn:hover .chevron {
            color: var(--primary);
            transform: translateY(2px);
        }

        .group-dropdown {
            position: absolute;
            top: calc(100% + 0.5rem);
            right: 0;
            background: white;
            border: 1px solid var(--gray-200);
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            min-width: 280px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.2s;
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
            font-weight: 600;
            color: var(--gray-500);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .group-count {
            background: var(--primary);
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 10px;
            font-size: 0.6875rem;
            font-weight: 600;
        }

        .group-dropdown-list {
            max-height: 320px;
            overflow-y: auto;
        }

        .group-dropdown-item {
            display: flex;
            align-items: center;
            gap: 0.875rem;
            padding: 0.875rem 1.25rem;
            text-decoration: none;
            color: var(--gray-900);
            transition: all 0.2s;
            border-bottom: 1px solid var(--gray-50);
        }

        .group-dropdown-item:hover {
            background: var(--gray-50);
        }

        .group-dropdown-item.active {
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
            color: white;
        }

        .group-dropdown-item.active .group-dropdown-text small {
            color: rgba(255, 255, 255, 0.9);
        }

        .group-dropdown-avatar {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            background: var(--gray-200);
            color: var(--gray-700);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.75rem;
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
            gap: 0.125rem;
        }

        .group-dropdown-text strong {
            font-size: 0.875rem;
        }

        .group-dropdown-text small {
            font-size: 0.75rem;
            color: var(--gray-500);
        }

        /* MAIN CONTENT */
        .main-content {
            min-height: calc(100vh - 160px);
            padding-bottom: 2rem;
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
            min-width: 320px;
            max-width: 450px;
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            animation: slideInRight 0.3s ease-out forwards;
            pointer-events: auto;
            border-left: 4px solid;
            position: relative;
            overflow: hidden;
        }

        .toast.removing {
            animation: slideOutRight 0.3s ease-in forwards;
        }

        .toast-success {
            border-left-color: #10b981;
        }

        .toast-error {
            border-left-color: #ef4444;
        }

        .toast-info {
            border-left-color: #3b82f6;
        }

        .toast-icon {
            width: 24px;
            height: 24px;
            flex-shrink: 0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 0.125rem;
        }

        .toast-success .toast-icon {
            background: #d1fae5;
            color: #10b981;
        }

        .toast-error .toast-icon {
            background: #fee2e2;
            color: #ef4444;
        }

        .toast-info .toast-icon {
            background: #dbeafe;
            color: #3b82f6;
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
            border-radius: 4px;
            transition: all 0.2s;
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
            color: #10b981;
        }

        .toast-error .toast-progress {
            color: #ef4444;
        }

        .toast-info .toast-progress {
            color: #3b82f6;
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

        /* Mobile Toggle */
        .mobile-toggle {
            display: none;
            flex-direction: column;
            gap: 4px;
            cursor: pointer;
            padding: 0.5rem;
            background: transparent;
            border: none;
        }

        .mobile-toggle span {
            width: 24px;
            height: 2px;
            background: var(--gray-600);
            transition: all 0.3s;
            border-radius: 2px;
        }

        /* RESPONSIVE */
        @media (max-width: 1024px) {
            .navbar-menu {
                gap: 0.125rem;
            }

            .navbar-menu li a {
                padding: 0.5rem 0.75rem;
                font-size: 0.8125rem;
            }

            .navbar-menu li a svg {
                width: 16px;
                height: 16px;
            }
        }

        @media (max-width: 768px) {
            .navbar .container {
                padding: 0.75rem 1rem;
                gap: 1rem;
            }

            .logo {
                max-height: 60px;
            }

            .group-selector-label {
                display: none;
            }

            .group-selector-btn {
                min-width: auto;
                padding: 0.5rem 0.75rem;
            }

            .group-selector-text span {
                max-width: 90px;
            }

            .navbar-menu {
                display: none;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: white;
                flex-direction: column;
                padding: 1rem;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                gap: 0.5rem;
                border-top: 1px solid var(--gray-200);
            }

            .navbar-menu.mobile-open {
                display: flex;
            }

            .navbar-menu li a {
                width: 100%;
                justify-content: flex-start;
                padding: 0.75rem 1rem;
            }

            .mobile-toggle {
                display: flex;
            }

            .group-dropdown {
                right: 1rem;
                left: auto;
                min-width: 240px;
            }

            .navbar-right {
                gap: 0.5rem;
            }

            /* Toast mobile */
            .toast-container {
                top: 4rem;
                right: 1rem;
                left: 1rem;
            }

            .toast {
                min-width: auto;
                max-width: 100%;
            }
        }
    </style>
</head>

<body>
    <?php if (isset($_SESSION['user_id'])): ?>
        <?php
        // Buscar todos os grupos do usuário
        $groupModel = new GroupModel();
        $userGroups = $groupModel->getUserGroups($_SESSION['user_id']);
        $currentGroupId = $_SESSION['current_group_id'] ?? null;
        $currentGroup = null;

        if ($currentGroupId) {
            foreach ($userGroups as $group) {
                if ($group['id'] == $currentGroupId) {
                    $currentGroup = $group;
                    break;
                }
            }
        }
        ?>

        <nav class="navbar">
            <div class="container">
                <div class="navbar-brand">
                    <a href="/dashboard">
                        <img src="/assets/images/logoOficial.png"
                            alt="Amigo do Bolso"
                            class="logo">
                    </a>
                </div>

                <ul class="navbar-menu" id="navMenu">
                    <li>
                        <a href="/dashboard" class="<?= $_SERVER['REQUEST_URI'] === '/dashboard' ? 'active' : '' ?>">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="3" width="7" height="7"/>
                                <rect x="14" y="3" width="7" height="7"/>
                                <rect x="14" y="14" width="7" height="7"/>
                                <rect x="3" y="14" width="7" height="7"/>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="/transacoes" class="<?= strpos($_SERVER['REQUEST_URI'], '/transacoes') !== false ? 'active' : '' ?>">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="12" y1="1" x2="12" y2="23"/>
                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                            </svg>
                            Transações
                        </a>
                    </li>
                    <li>
                        <a href="/cartoes" class="<?= strpos($_SERVER['REQUEST_URI'], '/cartoes') !== false ? 'active' : '' ?>">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
                                <line x1="1" y1="10" x2="23" y2="10"/>
                            </svg>
                            Cartões
                        </a>
                    </li>
                    <li>
                        <a href="/beneficios" class="<?= strpos($_SERVER['REQUEST_URI'], '/beneficios') !== false ? 'active' : '' ?>">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/>
                                <line x1="7" y1="7" x2="7.01" y2="7"/>
                            </svg>
                            Benefícios
                        </a>
                    </li>
                    <li>
                        <a href="/metas" class="<?= strpos($_SERVER['REQUEST_URI'], '/metas') !== false ? 'active' : '' ?>">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"/>
                                <circle cx="12" cy="12" r="6"/>
                                <circle cx="12" cy="12" r="2"/>
                            </svg>
                            Metas
                        </a>
                    </li>
                    <li>
                        <a href="/grupos/detalhes" class="<?= strpos($_SERVER['REQUEST_URI'], '/grupos') !== false ? 'active' : '' ?>">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                <circle cx="9" cy="7" r="4"/>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                            </svg>
                            Grupo
                        </a>
                    </li>
                    <li>
                        <a href="/auth/logout" class="btn-logout">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                                <polyline points="16 17 21 12 16 7"/>
                                <line x1="21" y1="12" x2="9" y2="12"/>
                            </svg>
                            Sair
                        </a>
                    </li>
                </ul>

                <div class="navbar-right">
                    <?php if (!empty($userGroups)): ?>
                        <div class="group-selector">
                            <label class="group-selector-label">Grupo Ativo</label>
                            <button class="group-selector-btn" onclick="toggleGroupDropdown(event)">
                                <svg class="group-selector-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                    <circle cx="9" cy="7" r="4"/>
                                    <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                                </svg>
                                <div class="group-selector-text">
                                    <span><?= $currentGroup ? htmlspecialchars($currentGroup['name']) : 'Selecionar grupo' ?></span>
                                </div>
                                <svg class="chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <polyline points="6 9 12 15 18 9"/>
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
                                           class="group-dropdown-item <?= $group['id'] == $currentGroupId ? 'active' : '' ?>">
                                            <div class="group-dropdown-avatar">
                                                <?= strtoupper(substr($group['name'], 0, 2)) ?>
                                            </div>
                                            <div class="group-dropdown-text">
                                                <strong><?= htmlspecialchars($group['name']) ?></strong>
                                                <small><?= $group['member_count'] ?? 0 ?> membro(s)</small>
                                            </div>
                                            <?php if ($group['id'] == $currentGroupId): ?>
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                                    <polyline points="20 6 9 17 4 12"/>
                                                </svg>
                                            <?php endif; ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <button class="mobile-toggle" onclick="toggleMobileMenu()">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>
            </div>
        </nav>

        <script>
        function toggleGroupDropdown(event) {
            event.stopPropagation();
            const dropdown = document.getElementById('groupDropdown');
            dropdown.classList.toggle('show');
        }

        function toggleMobileMenu() {
            const menu = document.getElementById('navMenu');
            menu.classList.toggle('mobile-open');
        }

        // Fechar dropdown ao clicar fora
        window.addEventListener('click', function(e) {
            if (!e.target.closest('.group-selector')) {
                const dropdown = document.getElementById('groupDropdown');
                if (dropdown) {
                    dropdown.classList.remove('show');
                }
            }
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

            // Auto remover após 5 segundos
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

    <main class="main-content">
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