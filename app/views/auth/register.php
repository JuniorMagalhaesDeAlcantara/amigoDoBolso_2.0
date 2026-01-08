<?php include VIEWS . '/layouts/header.php'; ?>

<div class="auth-container">
    <div class="auth-card">
        <h1> Amigo do Bolso</h1>
        <h2>Criar Conta</h2>
        
        <?php if (isset($errors) && !empty($errors)): ?>
            <div class="alert alert-error">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="/auth/register">
            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" id="name" name="name" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="password">Senha</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Confirmar Senha</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            
            <button type="submit" class="btn btn-primary btn-block">Criar Conta</button>
        </form>
        
        <p class="auth-link">
            Já tem conta? <a href="/auth/login">Faça login</a>
        </p>
    </div>
</div>

<?php include VIEWS . '/layouts/footer.php'; ?>
