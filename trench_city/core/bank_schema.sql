-- ================================================================
-- BANK SYSTEM SCHEMA
-- Trench City V2 - Banking & Financial Transactions
-- ================================================================

-- Bank transactions log
CREATE TABLE IF NOT EXISTS bank_transactions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,

    -- Transaction details
    transaction_type ENUM('deposit', 'withdraw', 'transfer_send', 'transfer_receive', 'interest') NOT NULL,
    amount DECIMAL(15,2) NOT NULL,

    -- Balances after transaction (for audit trail)
    cash_after DECIMAL(15,2) NOT NULL,
    bank_after DECIMAL(15,2) NOT NULL,

    -- Transfer-specific fields
    transfer_to_user_id BIGINT UNSIGNED NULL DEFAULT NULL,
    transfer_from_user_id BIGINT UNSIGNED NULL DEFAULT NULL,

    -- Metadata
    description VARCHAR(255) NULL DEFAULT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    KEY idx_user_transactions (user_id, created_at),
    KEY idx_transfer_to (transfer_to_user_id),
    KEY idx_transfer_from (transfer_from_user_id),
    KEY idx_created (created_at),

    CONSTRAINT fk_bank_trans_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_bank_trans_to FOREIGN KEY (transfer_to_user_id) REFERENCES users(id) ON DELETE SET NULL,
    CONSTRAINT fk_bank_trans_from FOREIGN KEY (transfer_from_user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Bank configuration
CREATE TABLE IF NOT EXISTS bank_config (
    config_key VARCHAR(50) PRIMARY KEY,
    config_value VARCHAR(255) NOT NULL,
    description TEXT,
    updated_at DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default bank configuration
INSERT INTO bank_config (config_key, config_value, description) VALUES
('interest_rate_daily', '0.1', 'Daily interest rate percentage (0.1% = 0.001 per day)'),
('transfer_fee_percent', '1', 'Percentage fee for player-to-player transfers'),
('transfer_fee_min', '100', 'Minimum transfer fee amount'),
('withdraw_limit_daily', '1000000', 'Maximum daily withdrawal limit'),
('deposit_limit_daily', '10000000', 'Maximum daily deposit limit'),
('interest_enabled', '1', 'Whether daily interest is enabled (1=yes, 0=no)')
ON DUPLICATE KEY UPDATE config_value=VALUES(config_value);
