-- ================================================================
-- EMAIL VERIFICATION SYSTEM SCHEMA
-- Trench City V2 - Email Verification & reCAPTCHA Support
-- ================================================================

-- Add email verification columns to users table
ALTER TABLE users
ADD COLUMN IF NOT EXISTS email_verified TINYINT(1) NOT NULL DEFAULT 0 AFTER email,
ADD COLUMN IF NOT EXISTS email_verification_token VARCHAR(64) NULL DEFAULT NULL AFTER email_verified,
ADD COLUMN IF NOT EXISTS email_verification_sent_at DATETIME NULL DEFAULT NULL AFTER email_verification_token,
ADD COLUMN IF NOT EXISTS email_verified_at DATETIME NULL DEFAULT NULL AFTER email_verification_sent_at;

-- Add index for verification token lookups
ALTER TABLE users
ADD INDEX IF NOT EXISTS idx_email_verification_token (email_verification_token);

-- Email verification tracking table
CREATE TABLE IF NOT EXISTS email_verification_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    email VARCHAR(255) NOT NULL,
    token VARCHAR(64) NOT NULL,
    sent_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    verified_at DATETIME NULL DEFAULT NULL,
    ip_address VARCHAR(45) NULL DEFAULT NULL,
    user_agent TEXT NULL DEFAULT NULL,

    KEY idx_user_id (user_id),
    KEY idx_token (token),
    KEY idx_sent_at (sent_at),

    CONSTRAINT fk_email_verification_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Email configuration table
CREATE TABLE IF NOT EXISTS email_config (
    config_key VARCHAR(50) PRIMARY KEY,
    config_value TEXT NOT NULL,
    description TEXT,
    updated_at DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert email configuration defaults
INSERT INTO email_config (config_key, config_value, description) VALUES
('smtp_enabled', 'false', 'Enable SMTP email sending (true/false)'),
('smtp_host', 'smtp.gmail.com', 'SMTP server hostname'),
('smtp_port', '587', 'SMTP server port'),
('smtp_username', '', 'SMTP username/email'),
('smtp_password', '', 'SMTP password'),
('smtp_encryption', 'tls', 'SMTP encryption (tls/ssl/none)'),
('from_email', 'noreply@trenchcity.com', 'From email address'),
('from_name', 'Trench City', 'From name'),
('verification_required', 'true', 'Require email verification to play (true/false)'),
('verification_token_expiry', '24', 'Hours until verification token expires'),
('recaptcha_enabled', 'false', 'Enable reCAPTCHA on registration (true/false)'),
('recaptcha_site_key', '', 'Google reCAPTCHA site key'),
('recaptcha_secret_key', '', 'Google reCAPTCHA secret key')
ON DUPLICATE KEY UPDATE config_value=VALUES(config_value);
