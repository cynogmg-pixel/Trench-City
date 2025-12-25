-- ===============================================================
-- TRENCH CITY - CRIMES SYSTEM SCHEMA (Phase 4)
-- ===============================================================
-- Creates crimes table and crime_logs for tracking criminal activities
-- Author: Architect
-- Version: 1.0.0
-- ===============================================================

USE trench_city;

-- ===============================================================
-- CRIMES TABLE
-- ===============================================================
-- Stores all available crimes with requirements and rewards
CREATE TABLE IF NOT EXISTS crimes (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(128) NOT NULL,
    description TEXT NULL,
    category ENUM('petty','theft','violence','organized','elite') NOT NULL DEFAULT 'petty',

    -- Requirements
    nerve_cost INT UNSIGNED NOT NULL DEFAULT 1,
    min_level INT UNSIGNED NOT NULL DEFAULT 1,
    min_stats INT UNSIGNED NOT NULL DEFAULT 0,

    -- Rewards
    cash_min DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    cash_max DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    xp_reward INT UNSIGNED NOT NULL DEFAULT 0,

    -- Risk factors
    base_success_rate DECIMAL(5,2) NOT NULL DEFAULT 50.00,
    jail_chance DECIMAL(5,2) NOT NULL DEFAULT 5.00,
    hospital_chance DECIMAL(5,2) NOT NULL DEFAULT 2.00,

    difficulty INT UNSIGNED NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    KEY idx_crimes_category (category),
    KEY idx_crimes_min_level (min_level),
    KEY idx_crimes_difficulty (difficulty)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===============================================================
-- CRIME LOGS TABLE
-- ===============================================================
-- Tracks all crime attempts and outcomes
CREATE TABLE IF NOT EXISTS crime_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    crime_id INT UNSIGNED NOT NULL,
    success TINYINT(1) NOT NULL,
    cash_earned DECIMAL(15,2) DEFAULT 0.00,
    xp_earned INT UNSIGNED DEFAULT 0,
    jail TINYINT(1) DEFAULT 0,
    hospital TINYINT(1) DEFAULT 0,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_crime_logs_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_crime_logs_crime
        FOREIGN KEY (crime_id) REFERENCES crimes(id)
        ON DELETE CASCADE,

    KEY idx_crime_logs_user (user_id),
    KEY idx_crime_logs_crime (crime_id),
    KEY idx_crime_logs_created (created_at),
    KEY idx_crime_logs_success (success)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===============================================================
-- ALTER USERS TABLE FOR JAIL/HOSPITAL MECHANICS
-- ===============================================================
-- Add jail and hospital lockout timestamps if they don't exist
ALTER TABLE users
    ADD COLUMN IF NOT EXISTS jail_until DATETIME NULL DEFAULT NULL,
    ADD COLUMN IF NOT EXISTS hospital_until DATETIME NULL DEFAULT NULL;

-- Add indexes for jail/hospital queries
ALTER TABLE users
    ADD KEY IF NOT EXISTS idx_users_jail_until (jail_until),
    ADD KEY IF NOT EXISTS idx_users_hospital_until (hospital_until);
