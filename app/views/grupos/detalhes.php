<?php include VIEWS . '/layouts/header.php'; ?>

<div class="container-small">
    <div class="card">
        <h2> Detalhes do Grupo</h2>
        
        <div class="group-details">
            <div class="detail-item">
                <strong>Nome do Grupo:</strong>
                <span><?= htmlspecialchars($group['name']) ?></span>
            </div>
            
            <div class="detail-item">
                <strong>Código de Convite:</strong>
                <span class="invite-code-display"><?= $group['invite_code'] ?></span>
                <button onclick="copyInviteCode('<?= $group['invite_code'] ?>')" class="btn btn-sm btn-secondary">
                     Copiar
                </button>
            </div>
            
            <div class="detail-item">
                <strong>Criado em:</strong>
                <span><?= date('d/m/Y', strtotime($group['created_at'])) ?></span>
            </div>
        </div>
        
        <hr>
        
        <h3>Membros do Grupo (<?= count($members) ?>)</h3>
        
        <div class="members-list">
            <?php foreach ($members as $member): ?>
                <div class="member-card">
                    <div class="member-info">
                        <span class="member-icon"></span>
                        <div>
                            <strong><?= htmlspecialchars($member['name']) ?></strong>
                            <small><?= htmlspecialchars($member['email']) ?></small>
                        </div>
                    </div>
                    <span class="member-date">
                        Entrou em <?= date('d/m/Y', strtotime($member['joined_at'])) ?>
                    </span>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="form-actions">
            <a href="/dashboard" class="btn btn-primary"> Voltar ao Dashboard</a>
        </div>
    </div>
</div>

<script>
function copyInviteCode(code) {
    navigator.clipboard.writeText(code);
    alert('Código copiado: ' + code);
}
</script>

<style>
.group-details {
    margin-bottom: 2rem;
}

.detail-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 8px;
    margin-bottom: 1rem;
}

.invite-code-display {
    font-family: monospace;
    font-size: 1.2rem;
    font-weight: bold;
    color: #667eea;
}

.members-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin-top: 1rem;
}

.member-card {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 8px;
}

.member-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.member-icon {
    font-size: 2rem;
}

.member-date {
    color: #666;
    font-size: 0.85rem;
}

.btn-sm {
    padding: 0.4rem 0.8rem;
    font-size: 0.85rem;
}

.form-actions {
    margin-top: 2rem;
}
</style>

<?php include VIEWS . '/layouts/footer.php'; ?>
