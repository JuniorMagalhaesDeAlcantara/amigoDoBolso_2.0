<?php include VIEWS . '/layouts/header.php'; ?>

<div class="container-small">
    <div class="card">
        <h2>Entrar em um Grupo</h2>
        <p>Use o código de convite para entrar em um grupo existente</p>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?= $error ?></div>
        <?php endif; ?>
        
        <form method="POST" action="/grupos/entrar">
            <div class="form-group">
                <label for="invite_code">Código de Convite</label>
                <input 
                    type="text" 
                    id="invite_code" 
                    name="invite_code" 
                    placeholder="Ex: ABC12345" 
                    maxlength="10"
                    style="text-transform: uppercase"
                    required>
            </div>
            
            <button type="submit" class="btn btn-primary">Entrar no Grupo</button>
        </form>
        
        <hr>
        
        <a href="/grupos/criar" class="btn btn-link"> Voltar para criar grupo</a>
    </div>
</div>

<?php include VIEWS . '/layouts/footer.php'; ?>
