-- ================================================================
-- TRENCH CITY V2 - PROPERTIES SYSTEM SCHEMA
-- Complete implementation following full spec
-- ALL CURRENCY IN WHOLE POUNDS (£1234 not £1234.56)
-- ================================================================
-- Version: 1.1
-- Date: 2025-12-24
-- ================================================================

-- ================================================================
-- 1. PROPERTIES CATALOGUE (Master list of all property types)
-- ================================================================
CREATE TABLE IF NOT EXISTS properties (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    tier INT UNSIGNED NOT NULL DEFAULT 1,
    description TEXT,

    -- Pricing (whole pounds only)
    base_cost INT UNSIGNED NOT NULL DEFAULT 0,
    base_upkeep INT UNSIGNED NOT NULL DEFAULT 0,

    -- Base bonuses (before upgrades)
    base_happy INT NOT NULL DEFAULT 0,
    base_energy_regen_modifier DECIMAL(5,2) NOT NULL DEFAULT 0.00,
    base_life_regen_modifier DECIMAL(5,2) NOT NULL DEFAULT 0.00,
    base_happy_regen_modifier DECIMAL(5,2) NOT NULL DEFAULT 0.00,

    -- Capacity
    base_max_occupants INT UNSIGNED NOT NULL DEFAULT 1,
    base_storage_slots INT UNSIGNED NOT NULL DEFAULT 0,

    -- Availability
    is_unique BOOLEAN NOT NULL DEFAULT FALSE,
    is_active BOOLEAN NOT NULL DEFAULT TRUE,
    unlock_level INT UNSIGNED NOT NULL DEFAULT 1,

    -- Metadata
    location VARCHAR(100),
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_tier (tier),
    INDEX idx_active (is_active),
    INDEX idx_unique (is_unique)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ================================================================
-- 2. USER_PROPERTIES (Player-owned property instances)
-- ================================================================
CREATE TABLE IF NOT EXISTS user_properties (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    property_id INT UNSIGNED NOT NULL,

    -- Ownership
    is_primary BOOLEAN NOT NULL DEFAULT FALSE,
    acquired_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    purchase_price INT UNSIGNED NOT NULL DEFAULT 0,

    -- State
    upkeep_debt INT UNSIGNED NOT NULL DEFAULT 0,
    last_upkeep_tick_at TIMESTAMP NULL,
    delinquency_days INT UNSIGNED NOT NULL DEFAULT 0,

    -- Vault (owner-only storage, whole pounds)
    vault_balance INT UNSIGNED NOT NULL DEFAULT 0,

    -- Cached totals (computed from upgrades + staff)
    cached_effective_happy INT NOT NULL DEFAULT 0,
    cached_energy_regen_modifier DECIMAL(5,2) NOT NULL DEFAULT 0.00,
    cached_life_regen_modifier DECIMAL(5,2) NOT NULL DEFAULT 0.00,
    cached_max_occupants INT UNSIGNED NOT NULL DEFAULT 1,
    cached_storage_slots INT UNSIGNED NOT NULL DEFAULT 0,
    cached_daily_upkeep INT UNSIGNED NOT NULL DEFAULT 0,
    cached_at TIMESTAMP NULL,

    INDEX idx_user (user_id),
    INDEX idx_property (property_id),
    INDEX idx_primary (is_primary),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (property_id) REFERENCES properties(id) ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ================================================================
-- 3. PROPERTY_LISTINGS (Player market for selling properties)
-- ================================================================
CREATE TABLE IF NOT EXISTS property_listings (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_property_id INT UNSIGNED NOT NULL,
    seller_user_id INT UNSIGNED NOT NULL,

    -- Pricing (whole pounds)
    asking_price INT UNSIGNED NOT NULL,

    -- Status
    status ENUM('active', 'sold', 'cancelled') NOT NULL DEFAULT 'active',
    listed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    sold_at TIMESTAMP NULL,
    buyer_user_id INT UNSIGNED NULL,

    INDEX idx_status (status),
    INDEX idx_seller (seller_user_id),
    FOREIGN KEY (user_property_id) REFERENCES user_properties(id) ON DELETE CASCADE,
    FOREIGN KEY (seller_user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (buyer_user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ================================================================
-- 4. PROPERTY_RENTAL_OFFERS (Landlord creates rental offers)
-- ================================================================
CREATE TABLE IF NOT EXISTS property_rental_offers (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_property_id INT UNSIGNED NOT NULL,
    landlord_user_id INT UNSIGNED NOT NULL,

    -- Terms (whole pounds)
    daily_rent INT UNSIGNED NOT NULL,
    security_deposit INT UNSIGNED NOT NULL DEFAULT 0,
    min_lease_days INT UNSIGNED NOT NULL DEFAULT 7,
    max_lease_days INT UNSIGNED NULL,

    -- Restrictions
    min_level_required INT UNSIGNED NOT NULL DEFAULT 1,
    allowed_occupants INT UNSIGNED NOT NULL DEFAULT 1,

    -- Status
    status ENUM('active', 'paused', 'cancelled') NOT NULL DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_status (status),
    INDEX idx_landlord (landlord_user_id),
    FOREIGN KEY (user_property_id) REFERENCES user_properties(id) ON DELETE CASCADE,
    FOREIGN KEY (landlord_user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ================================================================
-- 5. PROPERTY_LEASES (Active rental agreements)
-- ================================================================
CREATE TABLE IF NOT EXISTS property_leases (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_property_id INT UNSIGNED NOT NULL,
    rental_offer_id INT UNSIGNED NULL,

    -- Parties
    landlord_user_id INT UNSIGNED NOT NULL,
    tenant_user_id INT UNSIGNED NOT NULL,

    -- Terms (whole pounds)
    daily_rent INT UNSIGNED NOT NULL,
    security_deposit_held INT UNSIGNED NOT NULL DEFAULT 0,

    -- Duration
    start_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    end_at TIMESTAMP NOT NULL,

    -- Status
    status ENUM('active', 'completed', 'terminated', 'evicted') NOT NULL DEFAULT 'active',
    termination_reason TEXT NULL,

    -- Payments
    last_rent_paid_at TIMESTAMP NULL,
    rent_debt INT UNSIGNED NOT NULL DEFAULT 0,

    INDEX idx_status (status),
    INDEX idx_tenant (tenant_user_id),
    INDEX idx_landlord (landlord_user_id),
    INDEX idx_end_date (end_at),
    FOREIGN KEY (user_property_id) REFERENCES user_properties(id) ON DELETE CASCADE,
    FOREIGN KEY (rental_offer_id) REFERENCES property_rental_offers(id) ON DELETE SET NULL,
    FOREIGN KEY (landlord_user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (tenant_user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ================================================================
-- 6. PROPERTY_OCCUPANTS (Who lives in the property)
-- ================================================================
CREATE TABLE IF NOT EXISTS property_occupants (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_property_id INT UNSIGNED NOT NULL,
    user_id INT UNSIGNED NOT NULL,

    -- Permissions
    role ENUM('owner', 'tenant', 'guest') NOT NULL DEFAULT 'guest',
    can_use_vault BOOLEAN NOT NULL DEFAULT FALSE,

    -- Bonuses received
    happy_bonus_share DECIMAL(5,2) NOT NULL DEFAULT 0.50,
    energy_bonus_share DECIMAL(5,2) NOT NULL DEFAULT 0.50,
    life_bonus_share DECIMAL(5,2) NOT NULL DEFAULT 0.50,

    -- Duration
    joined_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    left_at TIMESTAMP NULL,

    INDEX idx_user_property (user_property_id),
    INDEX idx_user (user_id),
    INDEX idx_active (left_at),
    FOREIGN KEY (user_property_id) REFERENCES user_properties(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ================================================================
-- 7. PROPERTY_UPGRADE_CATALOG (Master list of all upgrades)
-- ================================================================
CREATE TABLE IF NOT EXISTS property_upgrade_catalog (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    category ENUM('comfort', 'energy', 'life', 'capacity', 'security', 'prestige', 'utility') NOT NULL,
    description TEXT,

    -- Requirements
    min_property_tier INT UNSIGNED NOT NULL DEFAULT 1,
    required_level INT UNSIGNED NOT NULL DEFAULT 1,

    -- Costs (whole pounds)
    cost INT UNSIGNED NOT NULL,
    upkeep_delta INT UNSIGNED NOT NULL DEFAULT 0,

    -- Bonuses provided
    happy_bonus INT NOT NULL DEFAULT 0,
    energy_regen_bonus DECIMAL(5,2) NOT NULL DEFAULT 0.00,
    life_regen_bonus DECIMAL(5,2) NOT NULL DEFAULT 0.00,
    happy_regen_bonus DECIMAL(5,2) NOT NULL DEFAULT 0.00,
    max_occupants_bonus INT NOT NULL DEFAULT 0,
    storage_slots_bonus INT NOT NULL DEFAULT 0,
    security_rating_bonus INT NOT NULL DEFAULT 0,

    -- Stacking rules
    is_unique BOOLEAN NOT NULL DEFAULT TRUE,
    max_stack INT UNSIGNED NOT NULL DEFAULT 1,

    -- Mutual exclusivity (comma-separated upgrade IDs)
    mutually_exclusive_with VARCHAR(255) NULL,

    -- Metadata
    slot_type VARCHAR(50) NULL,
    image_url VARCHAR(255),
    is_active BOOLEAN NOT NULL DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_category (category),
    INDEX idx_tier (min_property_tier),
    INDEX idx_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ================================================================
-- 8. PROPERTY_UPGRADES (Installed upgrades on properties)
-- ================================================================
CREATE TABLE IF NOT EXISTS property_upgrades (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_property_id INT UNSIGNED NOT NULL,
    upgrade_id INT UNSIGNED NOT NULL,

    -- Installation
    installed_by_user_id INT UNSIGNED NOT NULL,
    installed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    install_cost_paid INT UNSIGNED NOT NULL,

    -- Stack count (for stackable upgrades)
    quantity INT UNSIGNED NOT NULL DEFAULT 1,

    -- Status
    is_active BOOLEAN NOT NULL DEFAULT TRUE,
    deactivated_at TIMESTAMP NULL,

    INDEX idx_user_property (user_property_id),
    INDEX idx_upgrade (upgrade_id),
    FOREIGN KEY (user_property_id) REFERENCES user_properties(id) ON DELETE CASCADE,
    FOREIGN KEY (upgrade_id) REFERENCES property_upgrade_catalog(id) ON DELETE RESTRICT,
    FOREIGN KEY (installed_by_user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ================================================================
-- 9. PROPERTY_STAFF_CATALOG (Master list of staff types)
-- ================================================================
CREATE TABLE IF NOT EXISTS property_staff_catalog (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    role VARCHAR(50) NOT NULL,
    description TEXT,

    -- Requirements
    min_property_tier INT UNSIGNED NOT NULL DEFAULT 1,

    -- Costs (whole pounds)
    daily_wage INT UNSIGNED NOT NULL,
    hiring_fee INT UNSIGNED NOT NULL DEFAULT 0,

    -- Benefits
    upkeep_reduction_percent DECIMAL(5,2) NOT NULL DEFAULT 0.00,
    happy_bonus INT NOT NULL DEFAULT 0,
    energy_bonus DECIMAL(5,2) NOT NULL DEFAULT 0.00,
    life_bonus DECIMAL(5,2) NOT NULL DEFAULT 0.00,
    security_bonus INT NOT NULL DEFAULT 0,

    -- Quality tier
    quality_tier ENUM('basic', 'professional', 'expert') NOT NULL DEFAULT 'basic',

    -- Availability
    is_active BOOLEAN NOT NULL DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_role (role),
    INDEX idx_tier (min_property_tier),
    INDEX idx_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ================================================================
-- 10. PROPERTY_STAFF (Hired staff at properties)
-- ================================================================
CREATE TABLE IF NOT EXISTS property_staff (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_property_id INT UNSIGNED NOT NULL,
    staff_catalog_id INT UNSIGNED NOT NULL,

    -- Employment
    hired_by_user_id INT UNSIGNED NOT NULL,
    hired_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fired_at TIMESTAMP NULL,

    -- Status
    is_active BOOLEAN NOT NULL DEFAULT TRUE,

    INDEX idx_user_property (user_property_id),
    INDEX idx_staff_catalog (staff_catalog_id),
    INDEX idx_active (is_active),
    FOREIGN KEY (user_property_id) REFERENCES user_properties(id) ON DELETE CASCADE,
    FOREIGN KEY (staff_catalog_id) REFERENCES property_staff_catalog(id) ON DELETE RESTRICT,
    FOREIGN KEY (hired_by_user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ================================================================
-- 11. PROPERTY_UPKEEP_LEDGER (Daily upkeep tracking)
-- ================================================================
CREATE TABLE IF NOT EXISTS property_upkeep_ledger (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_property_id INT UNSIGNED NOT NULL,

    -- Charges (whole pounds)
    ledger_date DATE NOT NULL,
    base_upkeep INT UNSIGNED NOT NULL DEFAULT 0,
    upgrades_upkeep INT UNSIGNED NOT NULL DEFAULT 0,
    staff_wages INT UNSIGNED NOT NULL DEFAULT 0,
    total_upkeep INT UNSIGNED NOT NULL DEFAULT 0,

    -- Payment status
    amount_paid INT UNSIGNED NOT NULL DEFAULT 0,
    paid_at TIMESTAMP NULL,
    is_paid BOOLEAN NOT NULL DEFAULT FALSE,

    -- Auto-generation
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    UNIQUE KEY unique_property_date (user_property_id, ledger_date),
    INDEX idx_date (ledger_date),
    INDEX idx_paid (is_paid),
    FOREIGN KEY (user_property_id) REFERENCES user_properties(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ================================================================
-- 12. PROPERTY_TRANSACTIONS (Complete audit trail)
-- ================================================================
CREATE TABLE IF NOT EXISTS property_transactions (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_property_id INT UNSIGNED NULL,
    user_id INT UNSIGNED NOT NULL,

    -- Transaction type
    transaction_type ENUM(
        'BUY_CITY',
        'BUY_MARKET',
        'SELL_MARKET',
        'LIST_PROPERTY',
        'DELIST_PROPERTY',
        'RENT_CREATE_OFFER',
        'RENT_ACCEPT',
        'RENT_PAYMENT',
        'UPGRADE_PURCHASE',
        'UPGRADE_REMOVE',
        'UPKEEP_CHARGE',
        'UPKEEP_PAYMENT',
        'EVICTION',
        'REFUND_DEPOSIT',
        'FORFEIT_DEPOSIT',
        'VAULT_DEPOSIT',
        'VAULT_WITHDRAW',
        'STAFF_HIRE',
        'STAFF_FIRE'
    ) NOT NULL,

    -- Amounts (whole pounds)
    amount INT UNSIGNED NOT NULL DEFAULT 0,
    balance_before INT UNSIGNED NULL,
    balance_after INT UNSIGNED NULL,

    -- Related entities
    related_user_id INT UNSIGNED NULL,
    related_property_id INT UNSIGNED NULL,
    related_upgrade_id INT UNSIGNED NULL,
    related_lease_id INT UNSIGNED NULL,

    -- Details
    description TEXT,
    metadata JSON NULL,

    -- Timestamp
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    INDEX idx_user (user_id),
    INDEX idx_type (transaction_type),
    INDEX idx_date (created_at),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (user_property_id) REFERENCES user_properties(id) ON DELETE SET NULL,
    FOREIGN KEY (related_user_id) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ================================================================
-- END OF SCHEMA
-- ALL CURRENCY FIELDS USE INT UNSIGNED (whole pounds only)
-- ================================================================
