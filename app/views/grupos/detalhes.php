<?php include VIEWS . '/layouts/header.php'; ?>

<div class="container-small">
    <div class="card">
        <div class="page-header-section">
            <div>
                <h2>🏠 Detalhes do Grupo</h2>
                <p class="subtitle">Gerencie informações e membros do grupo</p>
            </div>
            <div class="header-actions">
                <a href="/grupos/criar" class="btn btn-success">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 5v14M5 12h14"/>
                    </svg>
                    Criar Novo Grupo
                </a>
                <a href="/grupos/entrar" class="btn btn-secondary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M13.8 12H3"/>
                    </svg>
                    Entrar em Grupo
                </a>
            </div>
        </div>
        
        <div class="group-details">
            <div class="detail-item">
                <div class="detail-label">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                    <strong>Nome do Grupo:</strong>
                </div>
                <span><?= htmlspecialchars($group['name']) ?></span>
            </div>
            
            <div class="detail-item highlight">
                <div class="detail-label">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    </svg>
                    <strong>Código de Convite:</strong>
                </div>
                <div class="invite-code-section">
                    <span class="invite-code-display"><?= $group['invite_code'] ?></span>
                    <button onclick="copyInviteCode('<?= $group['invite_code'] ?>')" class="btn btn-copy">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="9" y="9" width="13" height="13" rx="2" ry="2"/>
                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/>
                        </svg>
                        Copiar
                    </button>
                </div>
            </div>
            
            <div class="detail-item">
                <div class="detail-label">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                        <path d="M16 2v4M8 2v4M3 10h18"/>
                    </svg>
                    <strong>Criado em:</strong>
                </div>
                <span><?= date('d/m/Y', strtotime($group['created_at'])) ?></span>
            </div>
        </div>
        
        <hr>
        
        <div class="section-header">
            <h3>👥 Membros do Grupo</h3>
            <span class="member-count"><?= count($members) ?> membro(s)</span>
        </div>
        
        <div class="members-list">
            <?php foreach ($members as $member): ?>
                <div class="member-card">
                    <div class="member-info">
                        <div class="member-avatar">
                            <?= strtoupper(substr($member['name'], 0, 2)) ?>
                        </div>
                        <div class="member-details">
                            <strong><?= htmlspecialchars($member['name']) ?></strong>
                            <small><?= htmlspecialchars($member['email']) ?></small>
                        </div>
                    </div>
                    <div class="member-meta">
                        <span class="member-date">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                <path d="M16 2v4M8 2v4M3 10h18"/>
                            </svg>
                            <?= date('d/m/Y', strtotime($member['joined_at'])) ?>
                        </span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="form-actions">
            <a href="/dashboard" class="btn btn-primary">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M19 12H5M12 19l-7-7 7-7"/>
                </svg>
                Voltar ao Dashboard
            </a>
        </div>
    </div>
</div>

<script>
function copyInviteCode(code) {
    navigator.clipboard.writeText(code).then(() => {
        // Feedback visual
        const btn = event.target.closest('button');
        const originalText = btn.innerHTML;
        
        btn.innerHTML = `
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
            Copiado!
        `;
        btn.classList.add('copied');
        
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.classList.remove('copied');
        }, 2000);
    });
}
</script>

<style>
.page-header-section {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 2rem;
    gap: 1rem;
    flex-wrap: wrap;
}

.page-header-section h2 {
    margin: 0 0 0.25rem 0;
    font-size: 1.75rem;
}

.subtitle {
    color: var(--gray-500);
    margin: 0;
}

.header-actions {
    display: flex;
    gap: 0.75rem;
    flex-wrap: wrap;
}

.group-details {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin-bottom: 2rem;
}

.detail-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.25rem;
    background: var(--gray-50);
    border-radius: 12px;
    border: 1px solid var(--gray-200);
    transition: all 0.2s;
}

.detail-item:hover {
    background: white;
    border-color: var(--gray-300);
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.detail-item.highlight {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
}

.detail-item.highlight strong {
    color: white;
}

.detail-label {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.detail-label svg {
    color: var(--primary);
}

.detail-item.highlight .detail-label svg {
    color: white;
}

.invite-code-section {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.invite-code-display {
    font-family: 'Courier New', monospace;
    font-size: 1.5rem;
    font-weight: 800;
    color: white;
    letter-spacing: 2px;
    padding: 0.5rem 1rem;
    background: rgba(255,255,255,0.2);
    border-radius: 8px;
    border: 2px dashed rgba(255,255,255,0.5);
}

.btn-copy {
    background: white;
    color: #667eea;
    border: 2px solid white;
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    font-weight: 600;
    transition: all 0.2s;
}

.btn-copy:hover {
    background: rgba(255,255,255,0.9);
    transform: scale(1.05);
}

.btn-copy.copied {
    background: #10b981;
    color: white;
    border-color: #10b981;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 2rem 0 1rem 0;
}

.section-header h3 {
    margin: 0;
    font-size: 1.25rem;
}

.member-count {
    background: var(--primary);
    color: white;
    padding: 0.375rem 0.875rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
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
    padding: 1.25rem;
    background: white;
    border: 1px solid var(--gray-200);
    border-radius: 12px;
    transition: all 0.2s;
}

.member-card:hover {
    border-color: var(--primary);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.1);
    transform: translateY(-2px);
}

.member-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.member-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1rem;
}

.member-details {
    display: flex;
    flex-direction: column;
    gap: 0.25rem;
}

.member-details strong {
    font-size: 1rem;
    color: var(--gray-900);
}

.member-details small {
    color: var(--gray-500);
    font-size: 0.875rem;
}

.member-meta {
    text-align: right;
}

.member-date {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--gray-500);
    font-size: 0.875rem;
    padding: 0.5rem 0.875rem;
    background: var(--gray-50);
    border-radius: 8px;
}

.form-actions {
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid var(--gray-200);
}

hr {
    border: none;
    border-top: 1px solid var(--gray-200);
    margin: 2rem 0;
}

@media (max-width: 768px) {
    .page-header-section {
        flex-direction: column;
        align-items: stretch;
    }
    
    .header-actions {
        flex-direction: column;
    }
    
    .detail-item {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .invite-code-section {
        flex-direction: column;
        align-items: flex-start;
        width: 100%;
    }
    
    .member-card {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .member-meta {
        text-align: left;
    }
}
</style>

<?php include VIEWS . '/layouts/footer.php'; ?>