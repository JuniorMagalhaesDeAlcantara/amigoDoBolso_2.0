<?php include VIEWS . '/layouts/header.php'; ?>

<div class="auth-container">
    <div class="auth-card">
        <h1> Amigo do Bolso</h1>
        <h2>Login</h2>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?= $error ?></div>
        <?php endif; ?>
        
        <form method="POST" action="/auth/login">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="password">Senha</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn btn-primary btn-block">Entrar</button>
        </form>
        
        <p class="auth-link">
            Não tem conta? <a href="/auth/register">Cadastre-se</a>
        </p>
    </div>
</div>

<?php include VIEWS . '/layouts/footer.php'; ?>
