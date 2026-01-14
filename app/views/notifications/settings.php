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
    .settings-form {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .settings-section {
        padding: 1.5rem;
    }

    .settings-section h2 {
        color: #1f2937;
        margin-bottom: 0.5rem;
        font-size: 1.25rem;
    }

    .section-description {
        color: #6b7280;
        margin-bottom: 1.5rem;
        font-size: 0.95rem;
    }

    .setting-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        background: #f9fafb;
        border-radius: 8px;
        margin-bottom: 1rem;
        gap: 1rem;
    }

    .setting-item:last-child {
        margin-bottom: 0;
    }

    .setting-info {
        flex: 1;
    }

    .setting-info label {
        display: block;
        color: #1f2937;
        font-size: 1rem;
        margin-bottom: 0.25rem;
        cursor: pointer;
    }

    .setting-info p {
        color: #6b7280;
        font-size: 0.875rem;
        margin: 0;
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
    }

    .toggle input:checked + .toggle-slider {
        background-color: #667eea;
    }

    .toggle input:checked + .toggle-slider:before {
        transform: translateX(24px);
    }

    /* Email Options */
    .email-options {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 2px solid #e5e7eb;
    }

    .email-options h3 {
        color: #374151;
        font-size: 1rem;
        margin-bottom: 1rem;
    }

    /* Form Select */
    .form-select {
        padding: 0.5rem 1rem;
        border: 2px solid #d1d5db;
        border-radius: 6px;
        font-size: 0.95rem;
        background: white;
        cursor: pointer;
        transition: all 0.3s;
    }

    .form-select:focus {
        outline: none;
        border-color: #667eea;
    }

    /* Form Actions */
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
    }

    .form-actions .btn {
        min-width: 200px;
    }

    @media (max-width: 768px) {
        .setting-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .setting-control {
            width: 100%;
            display: flex;
            justify-content: flex-end;
        }

        .form-actions {
            flex-direction: column;
        }

        .form-actions .btn {
            width: 100%;
        }
    }
</style>

<script>
    // Controla visibilidade das opções de e-mail
    const emailToggle = document.getElementById('enable_email_notifications');
    const emailOptions = document.getElementById('emailOptions');

    function toggleEmailOptions() {
        if (emailToggle.checked) {
            emailOptions.style.display = 'block';
        } else {
            emailOptions.style.display = 'none';
        }
    }

    emailToggle.addEventListener('change', toggleEmailOptions);
    toggleEmailOptions(); // Executa ao carregar
</script>

<?php include VIEWS . '/layouts/footer.php'; ?>