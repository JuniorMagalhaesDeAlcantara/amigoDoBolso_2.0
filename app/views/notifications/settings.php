<?php include VIEWS . '/layouts/header.php'; ?>

<div class="container">
    <div class="card-header">
        <h1>⚙️ Configurações de Notificações</h1>
        <a href="/notificacoes" class="btn btn-secondary">← Voltar</a>
    </div>

    <form method="POST" class="settings-form">
        <!-- Notificações In-App -->
        <div class="card settings-section">
            <h2>📱 Notificações no Sistema</h2>
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

        <!-- Notificações por E-mail -->
        <div class="card settings-section">
            <h2>📧 Notificações por E-mail</h2>
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

        <!-- Relatório Mensal -->
        <div class="card settings-section">
            <h2>📊 Relatório Mensal</h2>
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
            <button type="submit" class="btn btn-primary">💾 Salvar Configurações</button>
        </div>
    </form>
</div>

<style>
    /* ==================== CONFIGURAÇÕES DE NOTIFICAÇÕES - CSS RESPONSIVO ==================== */

    /* Card Header */
    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        gap: 1.5rem;
        flex-wrap: wrap;
    }

    .card-header h1 {
        font-size: 2rem;
        font-weight: 700;
        color: var(--gray-900);
        margin: 0;
        letter-spacing: -0.02em;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-secondary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        background: white;
        color: var(--gray-700);
        border: 2px solid var(--gray-300);
        border-radius: 10px;
        font-size: 0.9375rem;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: var(--transition);
        font-family: inherit;
        white-space: nowrap;
    }

    .btn-secondary:hover {
        border-color: var(--gray-400);
        background: var(--gray-50);
        transform: translateY(-1px);
    }

    /* Settings Form */
    .settings-form {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .settings-section {
        background: white;
        border-radius: 14px;
        padding: 2rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border: 1px solid var(--gray-200);
    }

    .settings-section h2 {
        color: var(--gray-900);
        margin-bottom: 0.5rem;
        font-size: 1.375rem;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section-description {
        color: var(--gray-500);
        margin-bottom: 1.75rem;
        font-size: 0.9375rem;
        line-height: 1.5;
    }

    .setting-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.25rem;
        background: var(--gray-50);
        border-radius: 10px;
        margin-bottom: 1rem;
        gap: 1.5rem;
        transition: var(--transition);
    }

    .setting-item:hover {
        background: var(--gray-100);
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

    /* Toggle Switch */
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

    .toggle input:checked+.toggle-slider {
        background: linear-gradient(135deg, var(--primary) 0%, #764ba2 100%);
    }

    .toggle input:checked+.toggle-slider:before {
        transform: translateX(24px);
    }

    .toggle:active .toggle-slider:before {
        width: 24px;
    }

    /* Email Options */
    .email-options {
        margin-top: 1.25rem;
        padding-top: 1.25rem;
        border-top: 2px solid var(--gray-200);
    }

    .email-options h3 {
        color: var(--gray-700);
        font-size: 1rem;
        margin-bottom: 1.25rem;
        font-weight: 600;
    }

    /* Form Select */
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

    /* Form Actions */
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        padding-top: 1rem;
    }

    .btn-primary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.875rem 2rem;
        background: linear-gradient(135deg, var(--primary) 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: var(--transition);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.25);
        font-family: inherit;
        white-space: nowrap;
        min-width: 220px;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.35);
    }

    .btn-primary:active {
        transform: translateY(0);
    }

    /* ==================== TABLET RESPONSIVO ==================== */
    @media (max-width: 1024px) {
        .settings-section {
            padding: 1.5rem;
        }

        .setting-item {
            padding: 1rem;
        }
    }

    /* ==================== MOBILE RESPONSIVO ==================== */
    @media (max-width: 768px) {
        .card-header {
            flex-direction: column;
            align-items: stretch;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .card-header h1 {
            font-size: 1.5rem;
        }

        .btn-secondary {
            width: 100%;
            justify-content: center;
            padding: 0.875rem 1.25rem;
        }

        .settings-form {
            gap: 1.25rem;
        }

        .settings-section {
            padding: 1.25rem;
        }

        .settings-section h2 {
            font-size: 1.125rem;
        }

        .section-description {
            font-size: 0.875rem;
            margin-bottom: 1.25rem;
        }

        .setting-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 1rem;
            padding: 1rem;
        }

        .setting-control {
            width: 100%;
            display: flex;
            justify-content: flex-end;
        }

        .form-actions {
            flex-direction: column;
        }

        .btn-primary {
            width: 100%;
            min-width: 100%;
        }

        .form-select {
            width: 100%;
        }
    }

    /* ==================== MOBILE SMALL ==================== */
    @media (max-width: 640px) {
        .card-header h1 {
            font-size: 1.375rem;
        }

        .settings-section {
            padding: 1rem;
        }

        .settings-section h2 {
            font-size: 1rem;
        }

        .setting-item {
            padding: 0.875rem;
        }

        .setting-info label {
            font-size: 0.9375rem;
        }

        .setting-info p {
            font-size: 0.8125rem;
        }
    }

    /* ==================== EXTRA SMALL ==================== */
    @media (max-width: 375px) {
        .card-header h1 {
            font-size: 1.25rem;
        }

        .toggle {
            width: 48px;
            height: 26px;
        }

        .toggle-slider:before {
            height: 18px;
            width: 18px;
        }

        .toggle input:checked+.toggle-slider:before {
            transform: translateX(22px);
        }
    }

    /* ==================== PWA STANDALONE ==================== */
    @media (display-mode: standalone) {
        .card-header {
            padding-top: env(safe-area-inset-top);
        }
    }

    /* ==================== REDUCE MOTION ==================== */
    @media (prefers-reduced-motion: reduce) {

        *,
        *::before,
        *::after {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }
    }

    /* ==================== HIGH CONTRAST ==================== */
    @media (prefers-contrast: high) {
        .settings-section {
            border: 2px solid currentColor;
        }

        .btn-primary,
        .btn-secondary {
            border: 2px solid currentColor;
        }

        .form-select {
            border-width: 3px;
        }
    }
</style>

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
        const originalText = btn.innerHTML;

        // Não previne o submit, apenas dá feedback
        btn.innerHTML = '⏳ Salvando...';
        btn.disabled = true;

        // Restaura após 2 segundos (caso não recarregue a página)
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.disabled = false;
        }, 2000);
    });
</script>

<?php include VIEWS . '/layouts/footer.php'; ?>