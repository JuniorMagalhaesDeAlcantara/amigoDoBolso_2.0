<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Amigo do Bolso 2.0' ?></title>
    <link rel="stylesheet" href="/css/style.css">
    <style>
        /* Reset de espaçamentos */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            margin: 0 !important;
            padding: 0 !important;
            padding-top: 0 !important;
        }

        /* NAVBAR MODERNA */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            margin: 0;
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
            height: 100px;
            width: auto;
        }

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
            color: #6b7280;
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
            width: 16px;
            height: 16px;
            flex-shrink: 0;
        }

        .navbar-menu li a:hover {
            background: #f3f4f6;
            color: #111827;
        }

        .navbar-menu li a.active {
            background: #4f46e5;
            color: white;
        }

        .btn-logout {
            background: transparent !important;
            color: #ef4444 !important;
        }

        .btn-logout:hover {
            background: #fef2f2 !important;
            color: #dc2626 !important;
        }

        /* MAIN CONTENT */
        .main-content {
            min-height: calc(100vh - 160px);
            padding-bottom: 2rem;
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
                width: 14px;
                height: 14px;
            }
        }

        @media (max-width: 768px) {
            .navbar .container {
                padding: 0.75rem 1rem;
            }

            .logo {
                height: 40px;
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
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                gap: 0.5rem;
            }

            .navbar-menu.mobile-open {
                display: flex;
            }

            .navbar-menu li a {
                width: 100%;
                justify-content: flex-start;
            }

            .mobile-toggle {
                display: flex;
                flex-direction: column;
                gap: 4px;
                cursor: pointer;
                padding: 0.5rem;
            }

            .mobile-toggle span {
                width: 24px;
                height: 2px;
                background: #6b7280;
                transition: all 0.3s;
            }

            .footer {
                padding: 1.5rem 0 1rem;
            }

            .footer .container {
                padding: 0 1rem;
            }
        }
    </style>
</head>

<body>
    <?php if (isset($_SESSION['user_id'])): ?>
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
                                <rect x="3" y="3" width="7" height="7"></rect>
                                <rect x="14" y="3" width="7" height="7"></rect>
                                <rect x="14" y="14" width="7" height="7"></rect>
                                <rect x="3" y="14" width="7" height="7"></rect>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="/transacoes" class="<?= strpos($_SERVER['REQUEST_URI'], '/transacoes') !== false ? 'active' : '' ?>">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="12" y1="1" x2="12" y2="23"></line>
                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                            </svg>
                            Transações
                        </a>
                    </li>
                    <li>
                        <a href="/cartoes" class="<?= strpos($_SERVER['REQUEST_URI'], '/cartoes') !== false ? 'active' : '' ?>">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                <line x1="1" y1="10" x2="23" y2="10"></line>
                            </svg>
                            Cartões
                        </a>
                    </li>
                    <li>
                        <a href="/beneficios" class="<?= strpos($_SERVER['REQUEST_URI'], '/beneficios') !== false ? 'active' : '' ?>">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                                <line x1="7" y1="7" x2="7.01" y2="7"></line>
                            </svg>
                            Benefícios
                        </a>
                    </li>
                    <li>
                        <a href="/metas" class="<?= strpos($_SERVER['REQUEST_URI'], '/metas') !== false ? 'active' : '' ?>">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <circle cx="12" cy="12" r="6"></circle>
                                <circle cx="12" cy="12" r="2"></circle>
                            </svg>
                            Metas
                        </a>
                    </li>
                    <li>
                        <a href="/grupos/detalhes" class="<?= strpos($_SERVER['REQUEST_URI'], '/grupos') !== false ? 'active' : '' ?>">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                            Grupo
                        </a>
                    </li>
                    <li>
                        <a href="/auth/logout" class="btn-logout">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" y1="12" x2="9" y2="12"></line>
                            </svg>
                            Sair
                        </a>
                    </li>
                </ul>

                <button class="mobile-toggle" onclick="toggleMobileMenu()" style="display: none;">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </nav>
    <?php endif; ?>

    <main class="main-content">