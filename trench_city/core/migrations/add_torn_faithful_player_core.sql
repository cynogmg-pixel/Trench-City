-- ================================================================
-- TRENCH CITY V2 - TORN-FAITHFUL PLAYER CORE MIGRATION
-- Adds all schema changes for Torn-faithful player system
-- ================================================================
-- Version: 1.0
-- Date: 2025-12-24
-- ================================================================

USE trench_city;

-- ================================================================
-- 1. EXTEND USERS TABLE
-- ================================================================

ALTER TABLE users
    -- Level holding system
    ADD COLUMN true_level INT UNSIGNED NOT NULL DEFAULT 1 AFTER level,
    ADD COLUMN level_holding_enabled TINYINT(1) NOT NULL DEFAULT 0 AFTER true_level,
    ADD COLUMN last_level_upgrade_at DATETIME NULL AFTER level_holding_enabled,

    -- Player state (hospital, jail, traveling)
    ADD COLUMN player_state ENUM('normal', 'hospital', 'jail', 'traveling') NOT NULL DEFAULT 'normal' AFTER status,
    ADD COLUMN state_until DATETIME NULL AFTER player_state,

    -- Tutorial/onboarding
    ADD COLUMN tutorial_completed TINYINT(1) NOT NULL DEFAULT 0 AFTER created_at,

    -- Anti-abuse
    ADD COLUMN last_action_at DATETIME NULL AFTER last_login_at,
    ADD COLUMN daily_reset_at DATETIME NULL AFTER last_action_at,

    -- Email verification
    ADD COLUMN email_verified TINYINT(1) NOT NULL DEFAULT 0 AFTER email;

-- Initialize true_level from current level for existing users
UPDATE users SET true_level = level WHERE true_level = 1;

-- ================================================================
-- 2. EXTEND PLAYER_BARS TABLE (NERVE SYSTEM)
-- ================================================================

ALTER TABLE player_bars
    -- Natural Nerve Bar (NNB) from Crime Experience
    ADD COLUMN nerve_natural_max INT UNSIGNED NOT NULL DEFAULT 15 AFTER nerve_max,

    -- Nerve bonus layers
    ADD COLUMN nerve_bonus_merits INT UNSIGNED NOT NULL DEFAULT 0 AFTER nerve_natural_max,
    ADD COLUMN nerve_bonus_faction INT UNSIGNED NOT NULL DEFAULT 0 AFTER nerve_bonus_merits,
    ADD COLUMN nerve_bonus_job INT UNSIGNED NOT NULL DEFAULT 0 AFTER nerve_bonus_faction,

    -- Crime Experience (hidden, drives NNB)
    ADD COLUMN crime_experience BIGINT UNSIGNED NOT NULL DEFAULT 0 AFTER nerve_bonus_job,
    ADD COLUMN crime_success_count INT UNSIGNED NOT NULL DEFAULT 0 AFTER crime_experience,
    ADD COLUMN last_ce_recalc_at DATETIME NULL AFTER crime_success_count,

    -- Training count (moved from player_stats if it exists there)
    ADD COLUMN total_training_count INT UNSIGNED NOT NULL DEFAULT 0 AFTER last_ce_recalc_at;

-- ================================================================
-- 3. ADD INDIVIDUAL REGEN TIMESTAMPS (if not exists)
-- ================================================================

-- Check if columns exist before adding
SET @dbname = DATABASE();
SET @tablename = 'player_bars';
SET @columnname = 'energy_last_regen';
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
      (table_name = @tablename)
      AND (table_schema = @dbname)
      AND (column_name = @columnname)
  ) > 0,
  "SELECT 1",
  "ALTER TABLE player_bars ADD COLUMN energy_last_regen DATETIME NULL DEFAULT NULL AFTER energy_max"
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

SET @columnname = 'nerve_last_regen';
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
      (table_name = @tablename)
      AND (table_schema = @dbname)
      AND (column_name = @columnname)
  ) > 0,
  "SELECT 1",
  "ALTER TABLE player_bars ADD COLUMN nerve_last_regen DATETIME NULL DEFAULT NULL AFTER nerve_max"
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

SET @columnname = 'happy_last_regen';
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
      (table_name = @tablename)
      AND (table_schema = @dbname)
      AND (column_name = @columnname)
  ) > 0,
  "SELECT 1",
  "ALTER TABLE player_bars ADD COLUMN happy_last_regen DATETIME NULL DEFAULT NULL AFTER happy_max"
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

SET @columnname = 'life_last_regen';
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
      (table_name = @tablename)
      AND (table_schema = @dbname)
      AND (column_name = @columnname)
  ) > 0,
  "SELECT 1",
  "ALTER TABLE player_bars ADD COLUMN life_last_regen DATETIME NULL DEFAULT NULL AFTER life_max"
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- Initialize individual regen timestamps from last_regen_at
UPDATE player_bars
SET
    energy_last_regen = COALESCE(energy_last_regen, last_regen_at, NOW()),
    nerve_last_regen = COALESCE(nerve_last_regen, last_regen_at, NOW()),
    happy_last_regen = COALESCE(happy_last_regen, last_regen_at, NOW()),
    life_last_regen = COALESCE(life_last_regen, last_regen_at, NOW())
WHERE energy_last_regen IS NULL;

-- ================================================================
-- 4. CREATE PLAYER_STATE_LOG TABLE
-- ================================================================

CREATE TABLE IF NOT EXISTS player_state_log (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    previous_state ENUM('normal', 'hospital', 'jail', 'traveling') NOT NULL,
    new_state ENUM('normal', 'hospital', 'jail', 'traveling') NOT NULL,
    reason TEXT NULL,
    state_until DATETIME NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_player_state_log_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE,
    KEY idx_player_state_log_user (user_id),
    KEY idx_player_state_log_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ================================================================
-- 5. CREATE XP_AWARDS_LOG TABLE (ANTI-ABUSE)
-- ================================================================

CREATE TABLE IF NOT EXISTS xp_awards_log (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    xp_amount INT UNSIGNED NOT NULL,
    source ENUM('attack_leave', 'attack_mug', 'attack_hosp', 'crime', 'gym', 'job', 'mission', 'other') NOT NULL,
    source_id BIGINT UNSIGNED NULL,
    base_xp INT UNSIGNED NOT NULL,
    multiplier DECIMAL(5,2) NOT NULL DEFAULT 1.00,
    victim_level INT UNSIGNED NULL,
    metadata JSON NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_xp_awards_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE,
    KEY idx_xp_awards_user (user_id),
    KEY idx_xp_awards_source (source),
    KEY idx_xp_awards_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ================================================================
-- 6. CREATE LEVEL_GATES TABLE
-- ================================================================

CREATE TABLE IF NOT EXISTS level_gates (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    gate_name VARCHAR(64) NOT NULL UNIQUE,
    required_level INT UNSIGNED NOT NULL,
    description TEXT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    KEY idx_level_gates_level (required_level)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Seed Torn-faithful level gates
INSERT INTO level_gates (gate_name, required_level, description) VALUES
('bookies', 2, 'Access to Bookies betting system'),
('company', 3, 'Ability to join companies'),
('lottery', 3, 'Access to lottery system'),
('blackjack', 4, 'Access to Blackjack casino game'),
('auction', 5, 'Access to Auction House'),
('post_george_missions', 5, 'Access to missions after George tutorial'),
('poker', 5, 'Access to Poker casino game'),
('russian_roulette', 6, 'Access to Russian Roulette'),
('spin_wheel', 7, 'Access to Spin the Wheel'),
('company_director', 10, 'Ability to become Company Director'),
('global_chat', 13, 'Access to Global Chat (lose newbie chat)'),
('travel_agency', 15, 'Access to Travel Agency')
ON DUPLICATE KEY UPDATE
    required_level = VALUES(required_level),
    description = VALUES(description);

-- ================================================================
-- 7. CREATE ACTION_COOLDOWNS TABLE
-- ================================================================

CREATE TABLE IF NOT EXISTS action_cooldowns (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    cooldown_type VARCHAR(64) NOT NULL,
    expires_at DATETIME NOT NULL,
    metadata JSON NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_action_cooldowns_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE,
    UNIQUE KEY uq_cooldowns_user_type (user_id, cooldown_type),
    KEY idx_cooldowns_expires (expires_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ================================================================
-- 8. PLAYER_STATS TABLE (check if total_training_count exists)
-- ================================================================

SET @tablename = 'player_stats';
SET @columnname = 'total_training_count';
SET @preparedStatement = (SELECT IF(
  (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE
      (table_name = @tablename)
      AND (table_schema = @dbname)
      AND (column_name = @columnname)
  ) > 0,
  "SELECT 1",
  "ALTER TABLE player_stats ADD COLUMN total_training_count INT UNSIGNED NOT NULL DEFAULT 0 AFTER dexterity"
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- ================================================================
-- VERIFICATION QUERIES
-- ================================================================

-- Run these to verify migration success:
--
-- SELECT COUNT(*) FROM users WHERE true_level > 0;
-- SELECT COUNT(*) FROM player_bars WHERE nerve_natural_max = 15;
-- SELECT COUNT(*) FROM level_gates;
-- SELECT * FROM level_gates ORDER BY required_level;
--
-- DESCRIBE users;
-- DESCRIBE player_bars;

-- ================================================================
-- END OF MIGRATION
-- ================================================================
