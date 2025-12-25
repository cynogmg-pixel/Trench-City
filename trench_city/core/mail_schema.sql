-- ================================================================
-- MAIL/MESSAGING SYSTEM SCHEMA
-- Trench City V2 - Player to Player Communication
-- ================================================================

CREATE TABLE IF NOT EXISTS mail_messages (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    from_user_id BIGINT UNSIGNED NOT NULL,
    to_user_id BIGINT UNSIGNED NOT NULL,

    -- Message content
    subject VARCHAR(255) NOT NULL,
    body TEXT NOT NULL,

    -- Status flags
    is_read TINYINT(1) NOT NULL DEFAULT 0,
    is_deleted_by_sender TINYINT(1) NOT NULL DEFAULT 0,
    is_deleted_by_recipient TINYINT(1) NOT NULL DEFAULT 0,

    -- Timestamps
    sent_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    read_at DATETIME NULL DEFAULT NULL,

    KEY idx_to_user (to_user_id, sent_at),
    KEY idx_from_user (from_user_id, sent_at),
    KEY idx_unread (to_user_id, is_read, sent_at),

    CONSTRAINT fk_mail_from FOREIGN KEY (from_user_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_mail_to FOREIGN KEY (to_user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Mail configuration
CREATE TABLE IF NOT EXISTS mail_config (
    config_key VARCHAR(50) PRIMARY KEY,
    config_value VARCHAR(255) NOT NULL,
    description TEXT,
    updated_at DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO mail_config (config_key, config_value, description) VALUES
('max_subject_length', '255', 'Maximum characters for message subject'),
('max_body_length', '5000', 'Maximum characters for message body'),
('max_messages_per_day', '100', 'Maximum messages a user can send per day'),
('cooldown_seconds', '30', 'Cooldown between sending messages')
ON DUPLICATE KEY UPDATE config_value=VALUES(config_value);
