-- ==========================================
-- AMIGO DO BOLSO 2.0 - DATABASE SCHEMA
-- ==========================================

--CREATE DATABASE IF NOT EXISTS amigo_do_bolso CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
--USE amigo_do_bolso;

-- Tabela de Usuários
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email)
) ENGINE=InnoDB;

-- Tabela de Grupos Financeiros
CREATE TABLE groups (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    invite_code VARCHAR(10) NOT NULL UNIQUE,
    owner_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (owner_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_invite_code (invite_code)
) ENGINE=InnoDB;

-- Tabela de Membros do Grupo
CREATE TABLE group_members (
    id INT AUTO_INCREMENT PRIMARY KEY,
    group_id INT NOT NULL,
    user_id INT NOT NULL,
    joined_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (group_id) REFERENCES groups(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_member (group_id, user_id),
    INDEX idx_user_group (user_id, group_id)
) ENGINE=InnoDB;

-- Tabela de Categorias
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    group_id INT NOT NULL,
    name VARCHAR(50) NOT NULL,
    type ENUM('receita', 'despesa') NOT NULL,
    icon VARCHAR(50) DEFAULT 'default',
    color VARCHAR(7) DEFAULT '#6c757d',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (group_id) REFERENCES groups(id) ON DELETE CASCADE,
    INDEX idx_group_type (group_id, type)
) ENGINE=InnoDB;

-- Tabela de Transações
CREATE TABLE transactions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    group_id INT NOT NULL,
    user_id INT NOT NULL,
    category_id INT NOT NULL,
    description VARCHAR(200) NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    type ENUM('receita', 'despesa') NOT NULL,
    transaction_date DATE NOT NULL,
    is_recurring BOOLEAN DEFAULT FALSE,
    recurrence_type ENUM('mensal', 'semanal', 'anual') DEFAULT NULL,
    credit_card_id INT DEFAULT NULL,
    installments INT DEFAULT 1,
    installment_number INT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (group_id) REFERENCES groups(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE RESTRICT,
    INDEX idx_group_date (group_id, transaction_date),
    INDEX idx_type (type),
    INDEX idx_card (credit_card_id)
) ENGINE=InnoDB;

-- Tabela de Cartões de Crédito
CREATE TABLE credit_cards (
    id INT AUTO_INCREMENT PRIMARY KEY,
    group_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    last_digits VARCHAR(4) NOT NULL,
    closing_day INT NOT NULL,
    due_day INT NOT NULL,
    credit_limit DECIMAL(10, 2) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (group_id) REFERENCES groups(id) ON DELETE CASCADE,
    INDEX idx_group (group_id)
) ENGINE=InnoDB;

-- Tabela de Metas Financeiras
CREATE TABLE goals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    group_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    target_amount DECIMAL(10, 2) NOT NULL,
    current_amount DECIMAL(10, 2) DEFAULT 0.00,
    deadline DATE NOT NULL,
    status ENUM('em_andamento', 'concluida', 'cancelada') DEFAULT 'em_andamento',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (group_id) REFERENCES groups(id) ON DELETE CASCADE,
    INDEX idx_group_status (group_id, status)
) ENGINE=InnoDB;

-- ==========================================
-- VIEWS ÚTEIS
-- ==========================================

-- View: Saldo do Grupo por Mês
CREATE VIEW vw_group_monthly_balance AS
SELECT 
    group_id,
    YEAR(transaction_date) as year,
    MONTH(transaction_date) as month,
    SUM(CASE WHEN type = 'receita' THEN amount ELSE 0 END) as total_income,
    SUM(CASE WHEN type = 'despesa' THEN amount ELSE 0 END) as total_expense,
    SUM(CASE WHEN type = 'receita' THEN amount ELSE -amount END) as balance
FROM transactions
GROUP BY group_id, YEAR(transaction_date), MONTH(transaction_date);

-- View: Gastos por Categoria
CREATE VIEW vw_category_spending AS
SELECT 
    t.group_id,
    c.name as category_name,
    c.type,
    c.color,
    YEAR(t.transaction_date) as year,
    MONTH(t.transaction_date) as month,
    SUM(t.amount) as total_amount,
    COUNT(t.id) as transaction_count
FROM transactions t
INNER JOIN categories c ON t.category_id = c.id
GROUP BY t.group_id, c.id, YEAR(t.transaction_date), MONTH(t.transaction_date);

-- Ajustar tabela de transações para o novo fluxo
ALTER TABLE transactions 
ADD COLUMN payment_method ENUM('dinheiro', 'cartao_credito') DEFAULT 'dinheiro' AFTER type;

ALTER TABLE transactions
MODIFY COLUMN recurrence_type ENUM('mensal', 'semanal', 'anual') DEFAULT NULL;

-- Adicionar coluna para quantidade de recorrências
ALTER TABLE transactions
ADD COLUMN recurrence_months INT DEFAULT NULL AFTER recurrence_type;

-- Adicionar coluna brand na tabela credit_cards
ALTER TABLE credit_cards ADD COLUMN IF NOT EXISTS brand VARCHAR(50) DEFAULT NULL;

-- Adicionar colunas para controle de parcelamento/recorrência
ALTER TABLE transactions ADD COLUMN IF NOT EXISTS parent_transaction_id INT DEFAULT NULL;
ALTER TABLE transactions ADD COLUMN IF NOT EXISTS is_installment BOOLEAN DEFAULT FALSE;
ALTER TABLE transactions ADD COLUMN IF NOT EXISTS is_recurring BOOLEAN DEFAULT FALSE;

-- Criar índice para melhorar performance nas buscas
CREATE INDEX IF NOT EXISTS idx_parent_transaction ON transactions(parent_transaction_id);

-- Adicionar foreign key para parent_transaction_id
ALTER TABLE transactions 
ADD CONSTRAINT fk_parent_transaction 
FOREIGN KEY (parent_transaction_id) 
REFERENCES transactions(id) 
ON DELETE CASCADE;

-- Adicionar coluna bank na tabela credit_cards
ALTER TABLE credit_cards ADD COLUMN bank VARCHAR(50) DEFAULT 'outros';

-- Adicionar coluna holder_name na tabela credit_cards
ALTER TABLE credit_cards ADD COLUMN holder_name VARCHAR(255) NULL AFTER name;

-- Tabela de Carteiras de Benefício (VR/VA)
CREATE TABLE benefit_cards (
    id INT AUTO_INCREMENT PRIMARY KEY,
    group_id INT NOT NULL,
    type ENUM('vr', 'va') NOT NULL COMMENT 'vr = Vale Refeição, va = Vale Alimentação',
    provider VARCHAR(50) NOT NULL COMMENT 'sodexo, caju, swile, alelo, ticket, etc',
    name VARCHAR(100) NOT NULL COMMENT 'Nome personalizado: ex: VR Sodexo, VA Caju',
    monthly_amount DECIMAL(10, 2) NOT NULL DEFAULT 0.00 COMMENT 'Valor que entra todo mês',
    current_balance DECIMAL(10, 2) NOT NULL DEFAULT 0.00 COMMENT 'Saldo disponível atual',
    recharge_day INT NOT NULL DEFAULT 1 COMMENT 'Dia do mês que entra o crédito (1-31)',
    last_recharge_date DATE NULL COMMENT 'Última vez que foi creditado',
    active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (group_id) REFERENCES groups(id) ON DELETE CASCADE,
    INDEX idx_group_type (group_id, type),
    INDEX idx_active (active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela de Histórico de Recargas (para auditoria e relatórios)
CREATE TABLE benefit_recharges (
    id INT AUTO_INCREMENT PRIMARY KEY,
    benefit_card_id INT NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    recharge_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (benefit_card_id) REFERENCES benefit_cards(id) ON DELETE CASCADE,
    INDEX idx_benefit_date (benefit_card_id, recharge_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Adicionar novos payment_methods na tabela transactions
-- (assumindo que você já tem essa tabela)
ALTER TABLE transactions 
    MODIFY COLUMN payment_method ENUM(
        'dinheiro', 
        'pix', 
        'credito', 
        'debito', 
        'vr',      -- NOVO
        'va'       -- NOVO
    ) NOT NULL DEFAULT 'dinheiro';

-- Adicionar coluna benefit_card_id em transactions (opcional, para rastreamento)
ALTER TABLE transactions 
    ADD COLUMN benefit_card_id INT NULL AFTER credit_card_id,
    ADD FOREIGN KEY (benefit_card_id) REFERENCES benefit_cards(id) ON DELETE SET NULL;

-- Adicionar coluna initial_balance em benefit_cards
ALTER TABLE benefit_cards
ADD COLUMN initial_balance DECIMAL(10,2) NOT NULL DEFAULT 0.00
AFTER monthly_amount;

-- Adicionar coluna paid em transactions para controle de pagamento
ALTER TABLE transactions 
ADD COLUMN paid TINYINT(1) DEFAULT 1 AFTER is_recurring;

-- Índice para melhorar performance de queries
CREATE INDEX idx_paid ON transactions(paid);

-- Tabela de Notificações
CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    type ENUM('fatura_vencimento', 'boleto_vencimento', 'fatura_vencida', 'boleto_vencido', 'relatorio_mensal') NOT NULL,
    title VARCHAR(255) NOT NULL,
    message TEXT NOT NULL,
    priority ENUM('low', 'medium', 'high', 'urgent') DEFAULT 'medium',
    related_type ENUM('card', 'bill', 'report') NULL,
    related_id INT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    read_at TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_read (user_id, is_read),
    INDEX idx_created (created_at),
    INDEX idx_type (type)
);

-- Tabela de Configurações de Notificação do Usuário
CREATE TABLE notification_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL UNIQUE,
    
    -- Notificações In-App
    enable_app_notifications BOOLEAN DEFAULT TRUE,
    
    -- Notificações por E-mail
    enable_email_notifications BOOLEAN DEFAULT TRUE,
    email_notify_3days BOOLEAN DEFAULT TRUE,
    email_notify_1day BOOLEAN DEFAULT TRUE,
    email_notify_today BOOLEAN DEFAULT TRUE,
    email_notify_overdue BOOLEAN DEFAULT TRUE,
    email_monthly_report BOOLEAN DEFAULT TRUE,
    
    -- Horário preferido para envio (relatório mensal)
    preferred_send_hour INT DEFAULT 9,
    
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Tabela de Log de E-mails Enviados (evitar duplicatas)
CREATE TABLE notification_email_log (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    notification_type VARCHAR(100) NOT NULL,
    related_type VARCHAR(50) NULL,
    related_id INT NULL,
    reference_date DATE NOT NULL,
    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_notification (user_id, notification_type, related_type, related_id, reference_date),
    INDEX idx_user_date (user_id, reference_date)
);

--- Tabela de Reset de Senha
CREATE TABLE password_resets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    token VARCHAR(255) NOT NULL,
    expires_at DATETIME NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    used_at DATETIME NULL DEFAULT NULL,

    UNIQUE KEY uq_token (token),
    KEY idx_user_id (user_id),
    KEY idx_expires_at (expires_at),

    CONSTRAINT fk_password_resets_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
) ENGINE=InnoDB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;

CREATE INDEX idx_token_expires ON password_resets(token, expires_at);
CREATE INDEX idx_user_expires ON password_resets(user_id, expires_at);
