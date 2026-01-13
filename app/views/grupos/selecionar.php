<?php include VIEWS . '/layouts/header.php'; ?>

<div class="container-small">
    <div class="card welcome-card">
        <div class="welcome-header">
            <h2>👋 Bem-vindo de volta!</h2>
            <p>Selecione o grupo que deseja acessar</p>
        </div>
        
        <?php if (empty($groups)): ?>
            <div class="empty-state">
                <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" opacity="0.3">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
                <h3>Nenhum grupo encontrado</h3>
                <p>Você ainda não faz parte de nenhum grupo. Crie seu primeiro grupo ou entre em um existente!</p>
                
                <div class="empty-actions">
                    <a href="/grupos/criar" class="btn btn-primary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 5v14M5 12h14"/>
                        </svg>
                        Criar Grupo
                    </a>
                    <a href="/grupos/entrar" class="btn btn-secondary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M13.8 12H3"/>
                        </svg>
                        Entrar em Grupo
                    </a>
                </div>
            </div>
        <?php else: ?>
            <div class="groups-grid">
                <?php foreach ($groups as $group): ?>
                    <a href="/grupos/trocar/<?= $group['id'] ?>" class="group-card-link">
                        <div class="group-card">
                            <div class="group-card-icon">
                                <?= strtoupper(substr($group['name'], 0, 2)) ?>
                            </div>
                            <div class="group-card-content">
                                <h3><?= htmlspecialchars($group['name']) ?></h3>
                                <div class="group-card-meta">
                                    <span class="meta-item">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                                            <circle cx="9" cy="7" r="4"/>
                                            <path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                                        </svg>
                                        <?= $group['member_count'] ?? 0 ?> membro(s)
                                    </span>
                                    <span class="meta-item">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                            <path d="M16 2v4M8 2v4M3 10h18"/>
                                        </svg>
                                        <?= date('d/m/Y', strtotime($group['created_at'])) ?>
                                    </span>
                                </div>
                            </div>
                            <svg class="arrow-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="9 18 15 12 9 6"/>
                            </svg>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
            
            <div class="additional-actions">
                <a href="/grupos/criar" class="action-link">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 5v14M5 12h14"/>
                    </svg>
                    Criar novo grupo
                </a>
                <a href="/grupos/entrar" class="action-link">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M13.8 12H3"/>
                    </svg>
                    Entrar em grupo existente
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.welcome-card {
    max-width: 800px;
    margin: 2rem auto;
}

.welcome-header {
    text-align: center;
    margin-bottom: 2rem;
}

.welcome-header h2 {
    font-size: 2rem;
    margin-bottom: 0.5rem;
    color: var(--gray-900);
}

.welcome-header p {
    color: var(--gray-500);
    font-size: 1.125rem;
}

.empty-state {
    text-align: center;
    padding: 3rem 2rem;
}

.empty-state svg {
    margin-bottom: 1.5rem;
}

.empty-state h3 {
    font-size: 1.5rem;
    margin-bottom: 0.75rem;
    color: var(--gray-900);
}

.empty-state p {
    color: var(--gray-500);
    margin-bottom: 2rem;
    line-height: 1.6;
}

.empty-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.groups-grid {
    display: grid;
    gap: 1rem;
    margin-bottom: 2rem;
}

.group-card-link {
    text-decoration: none;
}

.group-card {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    padding: 1.5rem;
    background: white;
    border: 2px solid var(--gray-200);
    border-radius: 16px;
    transition: all 0.3s;
    cursor: pointer;
}

.group-card:hover {
    border-color: var(--primary);
    box-shadow: 0 8px 24px rgba(102, 126, 234, 0.15);
    transform: translateX(8px);
}

.group-card-icon {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    font-weight: 700;
    flex-shrink: 0;
}

.group-card-content {
    flex: 1;
}

.group-card-content h3 {
    font-size: 1.25rem;
    margin: 0 0 0.75rem 0;
    color: var(--gray-900);
}

.group-card-meta {
    display: flex;
    gap: 1.5rem;
    flex-wrap: wrap;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--gray-500);
    font-size: 0.875rem;
}

.meta-item svg {
    color: var(--gray-400);
}

.arrow-icon {
    color: var(--gray-300);
    flex-shrink: 0;
    transition: all 0.3s;
}

.group-card:hover .arrow-icon {
    color: var(--primary);
    transform: translateX(4px);
}

.additional-actions {
    display: flex;
    justify-content: center;
    gap: 2rem;
    padding-top: 2rem;
    border-top: 1px solid var(--gray-200);
    flex-wrap: wrap;
}

.action-link {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--primary);
    text-decoration: none;
    font-weight: 600;
    transition: all 0.2s;
}

.action-link:hover {
    gap: 0.75rem;
    color: #764ba2;
}

.action-link svg {
    transition: transform 0.2s;
}

.action-link:hover svg {
    transform: scale(1.1);
}

@media (max-width: 768px) {
    .welcome-header h2 {
        font-size: 1.5rem;
    }
    
    .group-card {
        flex-direction: column;
        text-align: center;
    }
    
    .group-card:hover {
        transform: translateY(-4px);
    }
    
    .group-card-meta {
        justify-content: center;
    }
    
    .arrow-icon {
        transform: rotate(90deg);
    }
    
    .group-card:hover .arrow-icon {
        transform: rotate(90deg) translateX(4px);
    }
    
    .additional-actions {
        flex-direction: column;
        gap: 1rem;
    }
}
</style>

<?php include VIEWS . '/layouts/footer.php'; ?>