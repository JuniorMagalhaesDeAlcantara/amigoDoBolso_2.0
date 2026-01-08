<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Amigo do Bolso' ?></title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <?php if (isset($_SESSION['user_id'])): ?>
    <nav class="navbar">
        <div class="container">
            <div class="navbar-brand">
                <a href="/dashboard"> Amigo do Bolso</a>
            </div>
            <ul class="navbar-menu">
                <li><a href="/dashboard">Dashboard</a></li>
                <li><a href="/transacoes">Transações</a></li>
                <li><a href="/cartoes">Cartões</a></li>
                <li><a href="/metas">Metas</a></li>
                <li><a href="/grupos/detalhes">Grupo</a></li>
                <li><a href="/auth/logout" class="btn-logout">Sair</a></li>
            </ul>
            <div class="navbar-user">
                <span> <?= $_SESSION['user_name'] ?></span>
            </div>
        </div>
    </nav>
    <?php endif; ?>
    
    <main class="main-content">
