<?php include VIEWS . '/layouts/header.php'; ?>

<div class="container-small">
    <div class="card">
        <h2>Criar Grupo Financeiro</h2>
        <p>Crie um grupo para compartilhar o controle financeiro com outras pessoas</p>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?= $error ?></div>
        <?php endif; ?>
        
        <form method="POST" action="/grupos/criar">
            <div class="form-group">
                <label for="name">Nome do Grupo</label>
                <input type="text" id="name" name="name" placeholder="Ex: Família Silva" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Criar Grupo</button>
        </form>
        
        <hr>
        
        <p class="text-center">Ou</p>
        
        <a href="/grupos/entrar" class="btn btn-secondary btn-block">Entrar em um Grupo Existente</a>
    </div>
</div>

<?php include VIEWS . '/layouts/footer.php'; ?>

