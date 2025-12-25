-- ================================================================
-- TRENCH CITY V2 - COMPLETE DATABASE UPDATE SCRIPT
-- This script updates your database to the exact current state
-- Combines: Currency fixes + Torn-faithful player core + All features
-- ================================================================
-- Version: 1.0
-- Date: 2025-12-24
-- Safe to run multiple times (idempotent)
-- ================================================================

USE trench_city;

-- ================================================================
-- PART 1: CURRENCY FORMAT FIXES (Already done in init_schema)
-- ================================================================
-- Note: Your init_schema_v0.sql already has INT UNSIGNED for currency
-- This section ensures any existing production database is updated

-- Check if users.cash is DECIMAL and convert to INT UNSIGNED
SET @dbname = DATABASE();
SET @tablename = 'users';
SET @columnname = 'cash';
SET @columntype = (SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS
                   WHERE table_schema = @dbname
                   AND table_name = @tablename
                   AND column_name = @columnname);

SET @sql = IF(@columntype = 'decimal',
              'ALTER TABLE users MODIFY COLUMN cash INT UNSIGNED NOT NULL DEFAULT 0',
              'SELECT "users.cash already INT UNSIGNED" AS status');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Check if users.bank_balance is DECIMAL and convert to INT UNSIGNED
SET @columnname = 'bank_balance';
SET @columntype = (SELECT DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS
                   WHERE table_schema = @dbname
                   AND table_name = @tablename
                   AND column_name = @columnname);

SET @sql = IF(@columntype = 'decimal',
              'ALTER TABLE users MODIFY COLUMN bank_balance INT UNSIGNED NOT NULL DEFAULT 0',
              'SELECT "users.bank_balance already INT UNSIGNED" AS status');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- ================================================================
-- PART 2: EXTEND USERS TABLE FOR TORN-FAITHFUL SYSTEM
-- ================================================================

-- Add true_level column (if not exists)
SET @tablename = 'users';
SET @columnname = 'true_level';
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
   WHERE table_schema = @dbname AND table_name = @tablename AND column_name = @columnname) > 0,
  "SELECT 'users.true_level already exists' AS status",
  "ALTER TABLE users ADD COLUMN true_level INT UNSIGNED NOT NULL DEFAULT 1 AFTER level"
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- Add level_holding_enabled column (if not exists)
SET @columnname = 'level_holding_enabled';
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
   WHERE table_schema = @dbname AND table_name = @tablename AND column_name = @columnname) > 0,
  "SELECT 'users.level_holding_enabled already exists' AS status",
  "ALTER TABLE users ADD COLUMN level_holding_enabled TINYINT(1) NOT NULL DEFAULT 0 AFTER true_level"
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- Add last_level_upgrade_at column (if not exists)
SET @columnname = 'last_level_upgrade_at';
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
   WHERE table_schema = @dbname AND table_name = @tablename AND column_name = @columnname) > 0,
  "SELECT 'users.last_level_upgrade_at already exists' AS status",
  "ALTER TABLE users ADD COLUMN last_level_upgrade_at DATETIME NULL AFTER level_holding_enabled"
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- Add player_state column (if not exists)
SET @columnname = 'player_state';
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
   WHERE table_schema = @dbname AND table_name = @tablename AND column_name = @columnname) > 0,
  "SELECT 'users.player_state already exists' AS status",
  "ALTER TABLE users ADD COLUMN player_state ENUM('normal', 'hospital', 'jail', 'traveling') NOT NULL DEFAULT 'normal' AFTER status"
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- Add state_until column (if not exists)
SET @columnname = 'state_until';
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
   WHERE table_schema = @dbname AND table_name = @tablename AND column_name = @columnname) > 0,
  "SELECT 'users.state_until already exists' AS status",
  "ALTER TABLE users ADD COLUMN state_until DATETIME NULL AFTER player_state"
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- Add email_verified column (if not exists)
SET @columnname = 'email_verified';
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
   WHERE table_schema = @dbname AND table_name = @tablename AND column_name = @columnname) > 0,
  "SELECT 'users.email_verified already exists' AS status",
  "ALTER TABLE users ADD COLUMN email_verified TINYINT(1) NOT NULL DEFAULT 0 AFTER email"
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- Add tutorial_completed column (if not exists)
SET @columnname = 'tutorial_completed';
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
   WHERE table_schema = @dbname AND table_name = @tablename AND column_name = @columnname) > 0,
  "SELECT 'users.tutorial_completed already exists' AS status",
  "ALTER TABLE users ADD COLUMN tutorial_completed TINYINT(1) NOT NULL DEFAULT 0 AFTER created_at"
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- Add last_action_at column (if not exists)
SET @columnname = 'last_action_at';
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
   WHERE table_schema = @dbname AND table_name = @tablename AND column_name = @columnname) > 0,
  "SELECT 'users.last_action_at already exists' AS status",
  "ALTER TABLE users ADD COLUMN last_action_at DATETIME NULL AFTER last_login_at"
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- Add daily_reset_at column (if not exists)
SET @columnname = 'daily_reset_at';
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
   WHERE table_schema = @dbname AND table_name = @tablename AND column_name = @columnname) > 0,
  "SELECT 'users.daily_reset_at already exists' AS status",
  "ALTER TABLE users ADD COLUMN daily_reset_at DATETIME NULL AFTER last_action_at"
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- Initialize true_level from level for existing users
UPDATE users SET true_level = level WHERE true_level = 1 AND level > 1;

-- ================================================================
-- PART 3: EXTEND PLAYER_BARS TABLE (NERVE SYSTEM)
-- ================================================================

SET @tablename = 'player_bars';

-- Add individual regen timestamps (if not exist)
SET @columnname = 'energy_last_regen';
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
   WHERE table_schema = @dbname AND table_name = @tablename AND column_name = @columnname) > 0,
  "SELECT 'player_bars.energy_last_regen already exists' AS status",
  "ALTER TABLE player_bars ADD COLUMN energy_last_regen DATETIME NULL DEFAULT NULL AFTER energy_max"
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

SET @columnname = 'nerve_last_regen';
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
   WHERE table_schema = @dbname AND table_name = @tablename AND column_name = @columnname) > 0,
  "SELECT 'player_bars.nerve_last_regen already exists' AS status",
  "ALTER TABLE player_bars ADD COLUMN nerve_last_regen DATETIME NULL DEFAULT NULL AFTER nerve_max"
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

SET @columnname = 'happy_last_regen';
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
   WHERE table_schema = @dbname AND table_name = @tablename AND column_name = @columnname) > 0,
  "SELECT 'player_bars.happy_last_regen already exists' AS status",
  "ALTER TABLE player_bars ADD COLUMN happy_last_regen DATETIME NULL DEFAULT NULL AFTER happy_max"
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

SET @columnname = 'life_last_regen';
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
   WHERE table_schema = @dbname AND table_name = @tablename AND column_name = @columnname) > 0,
  "SELECT 'player_bars.life_last_regen already exists' AS status",
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

-- Add Natural Nerve Bar (NNB) column (if not exists)
SET @columnname = 'nerve_natural_max';
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
   WHERE table_schema = @dbname AND table_name = @tablename AND column_name = @columnname) > 0,
  "SELECT 'player_bars.nerve_natural_max already exists' AS status",
  "ALTER TABLE player_bars ADD COLUMN nerve_natural_max INT UNSIGNED NOT NULL DEFAULT 15 AFTER nerve_last_regen"
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- Add nerve bonus columns (if not exist)
SET @columnname = 'nerve_bonus_merits';
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
   WHERE table_schema = @dbname AND table_name = @tablename AND column_name = @columnname) > 0,
  "SELECT 'player_bars.nerve_bonus_merits already exists' AS status",
  "ALTER TABLE player_bars ADD COLUMN nerve_bonus_merits INT UNSIGNED NOT NULL DEFAULT 0 AFTER nerve_natural_max"
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

SET @columnname = 'nerve_bonus_faction';
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
   WHERE table_schema = @dbname AND table_name = @tablename AND column_name = @columnname) > 0,
  "SELECT 'player_bars.nerve_bonus_faction already exists' AS status",
  "ALTER TABLE player_bars ADD COLUMN nerve_bonus_faction INT UNSIGNED NOT NULL DEFAULT 0 AFTER nerve_bonus_merits"
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

SET @columnname = 'nerve_bonus_job';
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
   WHERE table_schema = @dbname AND table_name = @tablename AND column_name = @columnname) > 0,
  "SELECT 'player_bars.nerve_bonus_job already exists' AS status",
  "ALTER TABLE player_bars ADD COLUMN nerve_bonus_job INT UNSIGNED NOT NULL DEFAULT 0 AFTER nerve_bonus_faction"
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- Add Crime Experience columns (if not exist)
SET @columnname = 'crime_experience';
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
   WHERE table_schema = @dbname AND table_name = @tablename AND column_name = @columnname) > 0,
  "SELECT 'player_bars.crime_experience already exists' AS status",
  "ALTER TABLE player_bars ADD COLUMN crime_experience BIGINT UNSIGNED NOT NULL DEFAULT 0 AFTER nerve_bonus_job"
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

SET @columnname = 'crime_success_count';
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
   WHERE table_schema = @dbname AND table_name = @tablename AND column_name = @columnname) > 0,
  "SELECT 'player_bars.crime_success_count already exists' AS status",
  "ALTER TABLE player_bars ADD COLUMN crime_success_count INT UNSIGNED NOT NULL DEFAULT 0 AFTER crime_experience"
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

SET @columnname = 'last_ce_recalc_at';
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
   WHERE table_schema = @dbname AND table_name = @tablename AND column_name = @columnname) > 0,
  "SELECT 'player_bars.last_ce_recalc_at already exists' AS status",
  "ALTER TABLE player_bars ADD COLUMN last_ce_recalc_at DATETIME NULL AFTER crime_success_count"
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- Add total_training_count column (if not exists)
SET @columnname = 'total_training_count';
SET @preparedStatement = (SELECT IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
   WHERE table_schema = @dbname AND table_name = @tablename AND column_name = @columnname) > 0,
  "SELECT 'player_bars.total_training_count already exists' AS status",
  "ALTER TABLE player_bars ADD COLUMN total_training_count INT UNSIGNED NOT NULL DEFAULT 0 AFTER last_ce_recalc_at"
));
PREPARE alterIfNotExists FROM @preparedStatement;
EXECUTE alterIfNotExists;
DEALLOCATE PREPARE alterIfNotExists;

-- ================================================================
-- PART 4: CREATE NEW TABLES (IF NOT EXIST)
-- ================================================================

-- Create player_state_log table
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

-- Create xp_awards_log table (anti-abuse tracking)
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

-- Create level_gates table
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

-- Create action_cooldowns table
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
-- VERIFICATION
-- ================================================================

SELECT '========================================' AS '';
SELECT 'DATABASE UPDATE COMPLETE' AS '';
SELECT '========================================' AS '';
SELECT '' AS '';

SELECT 'Checking users table columns...' AS '';
SELECT COLUMN_NAME, DATA_TYPE, COLUMN_DEFAULT
FROM INFORMATION_SCHEMA.COLUMNS
WHERE TABLE_SCHEMA = 'trench_city'
AND TABLE_NAME = 'users'
AND COLUMN_NAME IN ('true_level', 'level_holding_enabled', 'player_state', 'email_verified', 'cash', 'bank_balance')
ORDER BY ORDINAL_POSITION;

SELECT '' AS '';
SELECT 'Checking player_bars table columns...' AS '';
SELECT COLUMN_NAME, DATA_TYPE, COLUMN_DEFAULT
FROM INFORMATION_SCHEMA.COLUMNS
WHERE TABLE_SCHEMA = 'trench_city'
AND TABLE_NAME = 'player_bars'
AND COLUMN_NAME IN ('nerve_natural_max', 'crime_experience', 'nerve_bonus_merits', 'energy_last_regen', 'nerve_last_regen')
ORDER BY ORDINAL_POSITION;

SELECT '' AS '';
SELECT 'Checking new tables...' AS '';
SELECT TABLE_NAME
FROM INFORMATION_SCHEMA.TABLES
WHERE TABLE_SCHEMA = 'trench_city'
AND TABLE_NAME IN ('player_state_log', 'xp_awards_log', 'level_gates', 'action_cooldowns');

SELECT '' AS '';
SELECT 'Checking level gates...' AS '';
SELECT gate_name, required_level FROM level_gates ORDER BY required_level;

SELECT '' AS '';
SELECT '========================================' AS '';
SELECT 'ALL UPDATES APPLIED SUCCESSFULLY' AS '';
SELECT 'Database is now Torn-faithful ready!' AS '';
SELECT '========================================' AS '';

-- ================================================================
-- END OF UPDATE SCRIPT
-- ================================================================
