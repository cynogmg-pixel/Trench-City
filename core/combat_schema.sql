-- ================================================================
-- COMBAT SYSTEM SCHEMA
-- Trench City V2 - Player vs Player Combat
-- ================================================================

-- Combat logs table - records all attacks
CREATE TABLE IF NOT EXISTS combat_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    attacker_id BIGINT UNSIGNED NOT NULL,
    defender_id BIGINT UNSIGNED NOT NULL,

    -- Combat results
    success TINYINT(1) NOT NULL DEFAULT 0,
    damage_dealt INT UNSIGNED NOT NULL DEFAULT 0,
    xp_earned INT UNSIGNED NOT NULL DEFAULT 0,
    cash_stolen DECIMAL(15,2) NOT NULL DEFAULT 0.00,

    -- Combat stats snapshot (for historical accuracy)
    attacker_total_stats BIGINT UNSIGNED NOT NULL DEFAULT 0,
    defender_total_stats BIGINT UNSIGNED NOT NULL DEFAULT 0,

    -- Equipment used (nullable for now, will be populated when items system is implemented)
    attacker_weapon_id BIGINT UNSIGNED NULL DEFAULT NULL,
    attacker_armor_id BIGINT UNSIGNED NULL DEFAULT NULL,
    defender_weapon_id BIGINT UNSIGNED NULL DEFAULT NULL,
    defender_armor_id BIGINT UNSIGNED NULL DEFAULT NULL,

    -- Result details
    outcome ENUM('win', 'loss', 'escape', 'hospitalized') NOT NULL DEFAULT 'win',
    hospital_time INT UNSIGNED NULL DEFAULT NULL COMMENT 'Minutes in hospital',

    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    KEY idx_attacker (attacker_id, created_at),
    KEY idx_defender (defender_id, created_at),
    KEY idx_created (created_at),

    CONSTRAINT fk_combat_attacker FOREIGN KEY (attacker_id) REFERENCES users(id) ON DELETE CASCADE,
    CONSTRAINT fk_combat_defender FOREIGN KEY (defender_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Add hospital and jail fields to users table if they don't exist
ALTER TABLE users
ADD COLUMN IF NOT EXISTS jail_until DATETIME NULL DEFAULT NULL COMMENT 'Player jailed until this time',
ADD COLUMN IF NOT EXISTS hospital_until DATETIME NULL DEFAULT NULL COMMENT 'Player hospitalized until this time';

-- Create index for status checks
ALTER TABLE users
ADD INDEX IF NOT EXISTS idx_jail_until (jail_until),
ADD INDEX IF NOT EXISTS idx_hospital_until (hospital_until);

-- ================================================================
-- SAMPLE DATA - Combat Configuration
-- ================================================================

-- Create combat_config table for tunable values
CREATE TABLE IF NOT EXISTS combat_config (
    config_key VARCHAR(50) PRIMARY KEY,
    config_value VARCHAR(255) NOT NULL,
    description TEXT,
    updated_at DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default combat configuration
INSERT INTO combat_config (config_key, config_value, description) VALUES
('base_hit_chance', '50', 'Base percentage chance to hit (before modifiers)'),
('energy_cost_attack', '10', 'Energy cost per attack'),
('hospital_time_min', '15', 'Minimum hospital time in minutes'),
('hospital_time_max', '60', 'Maximum hospital time in minutes'),
('cash_steal_percent_min', '1', 'Minimum percentage of defender cash that can be stolen'),
('cash_steal_percent_max', '5', 'Maximum percentage of defender cash that can be stolen'),
('xp_base_win', '50', 'Base XP for winning an attack'),
('xp_base_loss', '10', 'Base XP for losing an attack'),
('cooldown_seconds', '30', 'Cooldown between attacks on same target')
ON DUPLICATE KEY UPDATE config_value=VALUES(config_value);
