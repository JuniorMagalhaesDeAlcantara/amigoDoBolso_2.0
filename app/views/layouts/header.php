<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Amigo do Bolso 2.0' ?></title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 200'%3E%3Cdefs%3E%3ClinearGradient id='grad1' x1='0%25' y1='0%25' x2='100%25' y2='100%25'%3E%3Cstop offset='0%25' style='stop-color:%2367b26f;stop-opacity:1' /%3E%3Cstop offset='100%25' style='stop-color:%234ca2cd;stop-opacity:1' /%3E%3C/linearGradient%3E%3C/defs%3E%3Crect width='200' height='200' rx='30' fill='url(%23grad1)'/%3E%3Cpath d='M100 50 Q120 60 120 80 L120 120 Q120 140 100 150 Q80 140 80 120 L80 80 Q80 60 100 50 Z' fill='%23fff' opacity='0.9'/%3E%3Ccircle cx='100' cy='70' r='15' fill='%23ffd700'/%3E%3Cpath d='M70 100 Q100 110 130 100' stroke='%23333' stroke-width='4' fill='none' stroke-linecap='round'/%3E%3Ccircle cx='85' cy='85' r='5' fill='%23333'/%3E%3Ccircle cx='115' cy='85' r='5' fill='%23333'/%3E%3C/svg%3E">
</head>

<body>
    <?php if (isset($_SESSION['user_id'])): ?>
        <nav class="navbar">
            <div class="container">
                <div class="navbar-brand">
                    <a href="/dashboard">
                        <img src="/assets/images/logoOficial.png" 
                             alt="Logo Amigo do Bolso" 
                             class="logo">
                    </a>
                </div>
                <ul class="navbar-menu">
                    <li>
                        <a href="/dashboard">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="7" height="7"></rect>
                                <rect x="14" y="3" width="7" height="7"></rect>
                                <rect x="14" y="14" width="7" height="7"></rect>
                                <rect x="3" y="14" width="7" height="7"></rect>
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="/transacoes">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="12" y1="1" x2="12" y2="23"></line>
                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                            </svg>
                            Transações
                        </a>
                    </li>
                    <li>
                        <a href="/cartoes">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                <line x1="1" y1="10" x2="23" y2="10"></line>
                            </svg>
                            Cartões
                        </a>
                    </li>
                    <li>
                        <a href="/beneficios">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"></path>
                                <line x1="7" y1="7" x2="7.01" y2="7"></line>
                            </svg>
                            Benefícios
                        </a>
                    </li>
                    <li>
                        <a href="/metas">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10"></circle>
                                <circle cx="12" cy="12" r="6"></circle>
                                <circle cx="12" cy="12" r="2"></circle>
                            </svg>
                            Metas
                        </a>
                    </li>
                    <li>
                        <a href="/grupos/detalhes">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                <polyline points="16 17 21 12 16 7"></polyline>
                                <line x1="21" y1="12" x2="9" y2="12"></line>
                            </svg>
                            Sair
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
    <?php endif; ?>

    <main class="main-content">