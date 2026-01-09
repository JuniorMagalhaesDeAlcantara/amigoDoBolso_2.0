<?php include VIEWS . '/layouts/header.php'; ?>

<div class="container-small">
    <div class="card">
        <h2> Nova Categoria</h2>
        
        <form method="POST" action="/categorias/criar">
            <div class="form-group">
                <label for="name">Nome da Categoria *</label>
                <input type="text" id="name" name="name" placeholder="Ex: Delivery, Pets, Transporte" required>
            </div>
            
            <div class="form-group">
                <label for="type">Tipo *</label>
                <select name="type" id="type" required>
                    <option value="despesa"> Despesa</option>
                    <option value="receita"> Receita</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="color">Cor</label>
                <input type="color" id="color" name="color" value="#667eea">
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Salvar Categoria</button>
                <a href="/transacoes/criar" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<style>
.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
}
</style>

<?php include VIEWS . '/layouts/footer.php'; ?>
