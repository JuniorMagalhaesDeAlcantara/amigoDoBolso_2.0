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
                    <li><a href="/dashboard"><span>📊</span> Dashboard</a></li>
                    <li><a href="/transacoes"><span>💸</span> Transações</a></li>
                    <li><a href="/cartoes"><span>💳</span> Cartões</a></li>
                    <li><a href="/beneficios"><span>🍔</span> Benefícios</a></li>
                    <li><a href="/metas"><span>🎯</span> Metas</a></li>
                    <li><a href="/grupos/detalhes"><span>👥</span> Grupo</a></li>
                    <li><a href="/auth/logout" class="btn-logout"><span>🚪</span> Sair</a></li>
                </ul>
                <div class="navbar-user">
                    <span>👤 <?= $_SESSION['user_name'] ?? 'Usuário' ?></span>
                </div>
            </div>
        </nav>
    <?php endif; ?>

    <main class="main-content">