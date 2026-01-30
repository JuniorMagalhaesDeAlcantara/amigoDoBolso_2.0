<?php include VIEWS . '/layouts/header.php'; ?>

<style>
    :root {
        --primary: #667eea;
        --primary-hover: #5568d3;
        --secondary: #764ba2;
        --success: #10b981;
        --danger: #ef4444;
        --warning: #f59e0b;
        --gray-50: #f9fafb;
        --gray-100: #f3f4f6;
        --gray-200: #e5e7eb;
        --gray-300: #d1d5db;
        --gray-400: #9ca3af;
        --gray-500: #6b7280;
        --gray-600: #4b5563;
        --gray-700: #374151;
        --gray-800: #1f2937;
        --gray-900: #111827;
        --shadow-sm: 0 1px 3px rgba(0, 0, 0, 0.12);
        --shadow-md: 0 4px 6px rgba(0, 0, 0, 0.1);
        --shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.15);
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* ========== ANIMATIONS ========== */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes fadeInDown {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* ========== CONTAINER ========== */
    .container-small {
        max-width: 900px;
        margin: 0 auto;
        padding: 2rem;
        animation: fadeIn 0.5s ease-out;
    }

    /* ========== CARD ========== */
    .card {
        background: white;
        border-radius: 16px;
        padding: 2.5rem;
        box-shadow: var(--shadow-sm);
        border: 1px solid var(--gray-200);
        animation: fadeInUp 0.5s ease-out;
    }

    /* ========== PAGE HEADER ========== */
    .page-header-section {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 2.5rem;
        gap: 1.5rem;
        animation: fadeInDown 0.5s ease-out 0.1s both;
    }

    .page-header-section h2 {
        margin: 0 0 0.5rem 0;
        font-size: 1.875rem;
        font-weight: 700;
        color: var(--gray-900);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .subtitle {
        color: var(--gray-600);
        margin: 0;
        font-size: 1rem;
        line-height: 1.5;
    }

    .header-actions {
        display: flex;
        gap: 0.75rem;
        flex-shrink: 0;
        flex-wrap: wrap;
    }

    /* ========== BUTTONS ========== */
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.75rem 1.25rem;
        border-radius: 10px;
        font-size: 0.9375rem;
        font-weight: 600;
        text-decoration: none;
        transition: var(--transition);
        cursor: pointer;
        border: none;
        white-space: nowrap;
        font-family: inherit;
    }

    .btn-secondary {
        background: white;
        color: var(--gray-700);
        border: 2px solid var(--gray-300);
    }

    .btn-secondary:hover {
        background: var(--gray-50);
        border-color: var(--gray-400);
        transform: translateY(-2px);
        box-shadow: var(--shadow-sm);
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.25);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.35);
    }

    .btn-primary:active,
    .btn-secondary:active {
        transform: translateY(0);
    }

    /* ========== SETTINGS SECTIONS ========== */
    .settings-section {
        margin-bottom: 2rem;
        animation: fadeInUp 0.5s ease-out 0.2s both;
    }

    .settings-section:last-child {
        margin-bottom: 0;
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--gray-900);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section-description {
        color: var(--gray-600);
        font-size: 0.9375rem;
        margin-bottom: 1.5rem;
        line-height: 1.5;
    }

    /* ========== SETTING ITEMS ========== */
    .setting-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.25rem;
        background: var(--gray-50);
        border: 2px solid var(--gray-200);
        border-radius: 12px;
        margin-bottom: 1rem;
        gap: 1.5rem;
        transition: var(--transition);
    }

    .setting-item:hover {
        background: white;
        border-color: var(--gray-300);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        transform: translateY(-2px);
    }

    .setting-item:last-child {
        margin-bottom: 0;
    }

    .setting-info {
        flex: 1;
    }

    .setting-info label {
        display: block;
        color: var(--gray-900);
        font-size: 1rem;
        margin-bottom: 0.375rem;
        cursor: pointer;
        font-weight: 600;
    }

    .setting-info p {
        color: var(--gray-600);
        font-size: 0.875rem;
        margin: 0;
        line-height: 1.5;
    }

    .setting-control {
        flex-shrink: 0;
    }

    /* ========== TOGGLE SWITCH ========== */
    .toggle {
        position: relative;
        display: inline-block;
        width: 52px;
        height: 28px;
        cursor: pointer;
    }

    .toggle input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .toggle-slider {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #cbd5e1;
        border-radius: 28px;
        transition: 0.3s;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .toggle-slider:before {
        position: absolute;
        content: "";
        height: 20px;
        width: 20px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        border-radius: 50%;
        transition: 0.3s;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .toggle input:checked + .toggle-slider {
        background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    }

    .toggle input:checked + .toggle-slider:before {
        transform: translateX(24px);
    }

    .toggle:active .toggle-slider:before {
        width: 24px;
    }

    /* ========== EMAIL OPTIONS ========== */
    .email-options {
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 2px solid var(--gray-200);
    }

    .email-options h3 {
        color: var(--gray-700);
        font-size: 1rem;
        margin-bottom: 1.25rem;
        font-weight: 600;
    }

    /* ========== FORM SELECT ========== */
    .form-select {
        padding: 0.625rem 1rem;
        border: 2px solid var(--gray-300);
        border-radius: 8px;
        font-size: 0.9375rem;
        background: white;
        cursor: pointer;
        transition: var(--transition);
        font-family: inherit;
        color: var(--gray-900);
        min-width: 120px;
    }

    .form-select:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    }

    .form-select:hover {
        border-color: var(--gray-400);
    }

    /* ========== DIVIDER ========== */
    hr {
        border: none;
        border-top: 2px solid var(--gray-200);
        margin: 2.5rem 0;
        opacity: 0.6;
    }

    /* ========== FORM ACTIONS ========== */
    .form-actions {
        margin-top: 2.5rem;
        padding-top: 2.5rem;
        border-top: 2px solid var(--gray-200);
        animation: fadeInUp 0.5s ease-out 0.5s both;
    }

    .form-actions .btn {
        width: 100%;
    }

    /* ========== RESPONSIVE - TABLET ========== */
    @media (max-width: 1024px) {
        .container-small { padding: 1.5rem; }
        .card { padding: 2rem; }
    }

    /* ========== RESPONSIVE - MOBILE ========== */
    @media (max-width: 768px) {
        .container-small { padding: 1rem; }
        .card { padding: 1.5rem; border-radius: 12px; }
        
        .page-header-section {
            flex-direction: column;
            align-items: stretch;
            gap: 1.25rem;
        }
        
        .page-header-section h2 { font-size: 1.5rem; }
        
        .header-actions {
            flex-direction: column;
        }
        
        .header-actions .btn {
            width: 100%;
        }
        
        .setting-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
            padding: 1.25rem;
        }
        
        .setting-control {
            width: 100%;
            display: flex;
            justify-content: flex-end;
        }
        
        .form-select {
            width: 100%;
        }
    }

    /* ========== MOBILE PORTRAIT ========== */
    @media (max-width: 480px) {
        .container-small { padding: 0.875rem; }
        .card { padding: 1.25rem; }
        .page-header-section h2 { font-size: 1.375rem; }
        .subtitle { font-size: 0.875rem; }
        .section-title { font-size: 1.125rem; }
        .setting-info label { font-size: 0.9375rem; }
        .setting-info p { font-size: 0.8125rem; }
    }

    /* ========== PWA/STANDALONE MODE ========== */
    @media (display-mode: standalone) {
        .container-small {
            padding-top: calc(env(safe-area-inset-top) + 2rem);
            padding-bottom: calc(env(safe-area-inset-bottom) + 2rem);
        }
    }

    /* ========== ACCESSIBILITY ========== */
    @media (prefers-reduced-motion: reduce) {
        *, *::before, *::after {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
    }
</style>

<div class="container-small">
    <div class="card">
        <div class="page-header-section">
            <div>
                <h2>⚙️ Configurações de Notificações</h2>
                <p class="subtitle">Personalize como e quando você quer receber alertas</p>
            </div>
            <div class="header-actions">
                <a href="/notificacoes" class="btn btn-secondary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 12H5M12 19l-7-7 7-7"/>
                    </svg>
                    Voltar
                </a>
            </div>
        </div>

        <form method="POST" class="settings-form">
            <!-- Notificações In-App -->
            <div class="settings-section">
                <h3 class="section-title">📱 Notificações no Sistema</h3>
                <p class="section-description">Receba alertas dentro do sistema</p>

                <div class="setting-item">
                    <div class="setting-info">
                        <label for="enable_app_notifications">
                            <strong>Ativar notificações no sistema</strong>
                        </label>
                        <p>Exibe um badge com contador de notificações não lidas</p>
                    </div>
                    <div class="setting-control">
                        <label class="toggle">
                            <input type="checkbox"
                                name="enable_app_notifications"
                                id="enable_app_notifications"
                                <?= $settings['enable_app_notifications'] ? 'checked' : '' ?>>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                </div>
            </div>

            <hr>

            <!-- Notificações por E-mail -->
            <div class="settings-section">
                <h3 class="section-title">📧 Notificações por E-mail</h3>
                <p class="section-description">Receba alertas no seu e-mail</p>

                <div class="setting-item">
                    <div class="setting-info">
                        <label for="enable_email_notifications">
                            <strong>Ativar notificações por e-mail</strong>
                        </label>
                        <p>Enviar alertas importantes para seu e-mail</p>
                    </div>
                    <div class="setting-control">
                        <label class="toggle">
                            <input type="checkbox"
                                name="enable_email_notifications"
                                id="enable_email_notifications"
                                <?= $settings['enable_email_notifications'] ? 'checked' : '' ?>>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                </div>

                <div class="email-options" id="emailOptions">
                    <h3>Quando notificar:</h3>

                    <div class="setting-item">
                        <div class="setting-info">
                            <label for="email_notify_3days">
                                <strong>⏰ 3 dias antes do vencimento</strong>
                            </label>
                            <p>Aviso antecipado para você se organizar</p>
                        </div>
                        <div class="setting-control">
                            <label class="toggle">
                                <input type="checkbox"
                                    name="email_notify_3days"
                                    id="email_notify_3days"
                                    <?= $settings['email_notify_3days'] ? 'checked' : '' ?>>
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                    </div>

                    <div class="setting-item">
                        <div class="setting-info">
                            <label for="email_notify_1day">
                                <strong>⚠️ 1 dia antes do vencimento</strong>
                            </label>
                            <p>Lembrete final antes do vencimento</p>
                        </div>
                        <div class="setting-control">
                            <label class="toggle">
                                <input type="checkbox"
                                    name="email_notify_1day"
                                    id="email_notify_1day"
                                    <?= $settings['email_notify_1day'] ? 'checked' : '' ?>>
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                    </div>

                    <div class="setting-item">
                        <div class="setting-info">
                            <label for="email_notify_today">
                                <strong>🔴 No dia do vencimento</strong>
                            </label>
                            <p>Alerta no dia que vence</p>
                        </div>
                        <div class="setting-control">
                            <label class="toggle">
                                <input type="checkbox"
                                    name="email_notify_today"
                                    id="email_notify_today"
                                    <?= $settings['email_notify_today'] ? 'checked' : '' ?>>
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                    </div>

                    <div class="setting-item">
                        <div class="setting-info">
                            <label for="email_notify_overdue">
                                <strong>❌ Contas vencidas</strong>
                            </label>
                            <p>Alerta diário para contas em atraso</p>
                        </div>
                        <div class="setting-control">
                            <label class="toggle">
                                <input type="checkbox"
                                    name="email_notify_overdue"
                                    id="email_notify_overdue"
                                    <?= $settings['email_notify_overdue'] ? 'checked' : '' ?>>
                                <span class="toggle-slider"></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <hr>

            <!-- Relatório Mensal -->
            <div class="settings-section">
                <h3 class="section-title">📊 Relatório Mensal</h3>
                <p class="section-description">Resumo automático no início de cada mês</p>

                <div class="setting-item">
                    <div class="setting-info">
                        <label for="email_monthly_report">
                            <strong>Receber relatório mensal</strong>
                        </label>
                        <p>Resumo com receitas, despesas e saldo do mês anterior</p>
                    </div>
                    <div class="setting-control">
                        <label class="toggle">
                            <input type="checkbox"
                                name="email_monthly_report"
                                id="email_monthly_report"
                                <?= $settings['email_monthly_report'] ? 'checked' : '' ?>>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                </div>

                <div class="setting-item">
                    <div class="setting-info">
                        <label for="preferred_send_hour">
                            <strong>Horário preferido</strong>
                        </label>
                        <p>Hora do dia para receber o relatório</p>
                    </div>
                    <div class="setting-control">
                        <select name="preferred_send_hour" id="preferred_send_hour" class="form-select">
                            <?php for ($h = 0; $h < 24; $h++): ?>
                                <option value="<?= $h ?>" <?= $settings['preferred_send_hour'] == $h ? 'selected' : '' ?>>
                                    <?= str_pad($h, 2, '0', STR_PAD_LEFT) ?>:00
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                        <polyline points="17 21 17 13 7 13 7 21"/>
                        <polyline points="7 3 7 8 15 8"/>
                    </svg>
                    Salvar Configurações
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Controla visibilidade das opções de e-mail
    const emailToggle = document.getElementById('enable_email_notifications');
    const emailOptions = document.getElementById('emailOptions');

    function toggleEmailOptions() {
        if (emailToggle && emailOptions) {
            if (emailToggle.checked) {
                emailOptions.style.display = 'block';
            } else {
                emailOptions.style.display = 'none';
            }
        }
    }

    // Inicializa ao carregar
    if (emailToggle) {
        emailToggle.addEventListener('change', toggleEmailOptions);
        toggleEmailOptions();
    }

    // FIX: Garante que todos os checkboxes sejam enviados corretamente
    document.querySelector('.settings-form').addEventListener('submit', function(e) {
        // Para cada checkbox desmarcado, adiciona um input hidden com valor "0"
        const checkboxes = this.querySelectorAll('input[type="checkbox"]');

        checkboxes.forEach(function(checkbox) {
            // Remove inputs hidden antigos deste checkbox
            const oldHidden = document.querySelector(`input[type="hidden"][name="${checkbox.name}"]`);
            if (oldHidden) {
                oldHidden.remove();
            }

            // Se o checkbox estiver desmarcado, adiciona um hidden com valor "0"
            if (!checkbox.checked) {
                const hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = checkbox.name;
                hidden.value = '0';
                checkbox.parentNode.appendChild(hidden);
            }
        });
    });

    // Feedback visual ao salvar
    document.querySelector('.btn-primary').addEventListener('click', function(e) {
        const btn = this;
        const originalHTML = btn.innerHTML;

        // Não previne o submit, apenas dá feedback
        btn.innerHTML = `
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="10"/>
            </svg>
            Salvando...
        `;
        btn.disabled = true;

        // Restaura após 2 segundos (caso não recarregue a página)
        setTimeout(() => {
            btn.innerHTML = originalHTML;
            btn.disabled = false;
        }, 2000);
    });
</script>

<?php include VIEWS . '/layouts/footer.php'; ?>