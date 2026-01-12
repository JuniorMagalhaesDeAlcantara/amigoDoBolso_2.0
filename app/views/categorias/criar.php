<?php include VIEWS . '/layouts/header.php'; ?>

<div class="container-small">
    <div class="card">
        <h2>🏷️ Nova Categoria</h2>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                ⚠️ <?= $_SESSION['error'] ?>
            </div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form method="POST" action="/categorias/criar">
            <div class="form-group">
                <label for="name">📝 Nome da Categoria *</label>
                <input type="text" id="name" name="name" placeholder="Ex: Delivery, Pets, Transporte" required>
            </div>

            <div class="form-group">
                <label for="type">💰 Tipo *</label>
                <select name="type" id="type" required>
                    <option value="despesa">💸 Despesa</option>
                    <option value="receita">💚 Receita</option>
                </select>
            </div>

            <div class="form-group">
                <label for="color">🎨 Cor</label>
                <input type="color" id="color" name="color" value="#667eea">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">💾 Salvar Categoria</button>
                <a href="/transacoes/criar" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<style>
    .alert {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem 1.25rem;
        border-radius: 10px;
        margin-bottom: 1.5rem;
        font-size: 0.9375rem;
    }

    .alert-error {
        background: #fee2e2;
        border: 1px solid #fca5a5;
        color: #991b1b;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }

    /* Melhorias nos form-groups */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group:last-child {
        margin-bottom: 0;
    }

    .form-group label {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--gray-700);
        margin-bottom: 0.5rem;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 0.75rem;
        border: 2px solid var(--gray-300);
        border-radius: 8px;
        font-size: 0.9375rem;
        color: var(--gray-900);
        transition: all 0.2s;
        background: white;
    }

    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .form-group input[type="color"] {
        height: 50px;
        cursor: pointer;
    }

    /* Card container */
    .card {
        background: white;
        border-radius: 12px;
        padding: 2rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
    }

    .card h2 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--gray-900);
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Container small */
    .container-small {
        max-width: 700px;
        margin: 0 auto;
        padding: 2rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .container-small {
            padding: 1rem;
        }

        .card {
            padding: 1.5rem;
        }

        .form-actions {
            flex-direction: column;
        }

        .form-actions .btn {
            width: 100%;
        }
    }
</style>

<?php include VIEWS . '/layouts/footer.php'; ?>