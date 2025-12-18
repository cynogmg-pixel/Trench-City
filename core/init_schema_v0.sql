-- Trench City v0 schema (Phases 1-3)
-- Source: TrenchCity Knowledge 3 (Global Pack 02)

CREATE DATABASE IF NOT EXISTS trench_city
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
USE trench_city;

CREATE TABLE IF NOT EXISTS users (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username        VARCHAR(32)  NOT NULL,
    email           VARCHAR(255) NOT NULL,
    password_hash   VARCHAR(255) NOT NULL,

    xp              BIGINT UNSIGNED NOT NULL DEFAULT 0,
    level           INT UNSIGNED    NOT NULL DEFAULT 1,

    cash            DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    bank_balance    DECIMAL(15,2) NOT NULL DEFAULT 0.00,

    status          ENUM('active','banned','inactive') NOT NULL DEFAULT 'active',
    last_login_at   DATETIME NULL DEFAULT NULL,
    last_ip         VARCHAR(45) NULL DEFAULT NULL,

    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,

    UNIQUE KEY uq_users_username (username),
    UNIQUE KEY uq_users_email (email),
    KEY idx_users_status (status),
    KEY idx_users_last_login (last_login_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS player_stats (
    user_id         BIGINT UNSIGNED NOT NULL PRIMARY KEY,
    strength        BIGINT UNSIGNED NOT NULL DEFAULT 0,
    speed           BIGINT UNSIGNED NOT NULL DEFAULT 0,
    defense         BIGINT UNSIGNED NOT NULL DEFAULT 0,
    dexterity       BIGINT UNSIGNED NOT NULL DEFAULT 0,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_player_stats_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS player_bars (
    user_id         BIGINT UNSIGNED NOT NULL PRIMARY KEY,
    energy_current  INT UNSIGNED NOT NULL DEFAULT 0,
    energy_max      INT UNSIGNED NOT NULL DEFAULT 100,
    nerve_current   INT UNSIGNED NOT NULL DEFAULT 0,
    nerve_max       INT UNSIGNED NOT NULL DEFAULT 15,
    happy_current   INT UNSIGNED NOT NULL DEFAULT 0,
    happy_max       INT UNSIGNED NOT NULL DEFAULT 100,
    life_current    INT UNSIGNED NOT NULL DEFAULT 100,
    life_max        INT UNSIGNED NOT NULL DEFAULT 100,
    last_regen_at   DATETIME NULL DEFAULT NULL,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_player_bars_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS player_settings (
    user_id             BIGINT UNSIGNED NOT NULL PRIMARY KEY,
    show_online_status  TINYINT(1) NOT NULL DEFAULT 1,
    dark_mode           TINYINT(1) NOT NULL DEFAULT 1,
    created_at          DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at          DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_player_settings_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS item_categories (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name            VARCHAR(64) NOT NULL,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_item_categories_name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS items (
    id                  BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_id         INT UNSIGNED NOT NULL,
    name                VARCHAR(128) NOT NULL,
    description         TEXT NULL,
    rarity              TINYINT UNSIGNED NOT NULL DEFAULT 1,
    stackable           TINYINT(1) NOT NULL DEFAULT 0,
    base_price          DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    energy_restore      INT UNSIGNED NOT NULL DEFAULT 0,
    nerve_restore       INT UNSIGNED NOT NULL DEFAULT 0,
    happy_restore       INT UNSIGNED NOT NULL DEFAULT 0,
    life_restore        INT UNSIGNED NOT NULL DEFAULT 0,
    created_at          DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at          DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_items_category
        FOREIGN KEY (category_id) REFERENCES item_categories(id)
        ON DELETE CASCADE,
    KEY idx_items_category (category_id),
    KEY idx_items_rarity (rarity)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS user_items (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id         BIGINT UNSIGNED NOT NULL,
    item_id         BIGINT UNSIGNED NOT NULL,
    qty             INT UNSIGNED NOT NULL DEFAULT 1,
    equipped        TINYINT(1) NOT NULL DEFAULT 0,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at      DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_user_items_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_user_items_item
        FOREIGN KEY (item_id) REFERENCES items(id)
        ON DELETE CASCADE,
    UNIQUE KEY uq_user_items_user_item (user_id, item_id),
    KEY idx_user_items_user (user_id),
    KEY idx_user_items_item (item_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS gyms (
    id                  BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name                VARCHAR(128) NOT NULL,
    description         TEXT NULL,
    tier                TINYINT UNSIGNED NOT NULL DEFAULT 1,
    unlock_cost_cash    DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    unlock_cost_bank    DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    energy_cost_per_train INT UNSIGNED NOT NULL DEFAULT 5,
    base_stat_gain      INT UNSIGNED NOT NULL DEFAULT 1,
    created_at          DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at          DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_gyms_name (name),
    KEY idx_gyms_tier (tier)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS gym_unlocks (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id         BIGINT UNSIGNED NOT NULL,
    gym_id          BIGINT UNSIGNED NOT NULL,
    unlocked_at     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_gym_unlocks_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_gym_unlocks_gym
        FOREIGN KEY (gym_id) REFERENCES gyms(id)
        ON DELETE CASCADE,
    UNIQUE KEY uq_gym_unlocks_user_gym (user_id, gym_id),
    KEY idx_gym_unlocks_user (user_id),
    KEY idx_gym_unlocks_gym (gym_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS training_logs (
    id              BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id         BIGINT UNSIGNED NOT NULL,
    gym_id          BIGINT UNSIGNED NOT NULL,
    stat_trained    ENUM('strength','speed','defense','dexterity') NOT NULL,
    energy_spent    INT UNSIGNED NOT NULL DEFAULT 0,
    stat_gain       INT UNSIGNED NOT NULL DEFAULT 0,
    xp_gained       INT UNSIGNED NOT NULL DEFAULT 0,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_training_logs_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_training_logs_gym
        FOREIGN KEY (gym_id) REFERENCES gyms(id)
        ON DELETE CASCADE,
    KEY idx_training_logs_user (user_id),
    KEY idx_training_logs_gym (gym_id),
    KEY idx_training_logs_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
