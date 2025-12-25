-- =====================================================
-- TRENCH CITY - MARKET SYSTEM SCHEMA
-- Black market items, inventory, and transactions
-- =====================================================

-- Market Items (What's available to buy)
CREATE TABLE IF NOT EXISTS market_items (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    category ENUM('weapon', 'armor', 'vehicle', 'consumable', 'other') DEFAULT 'other',
    item_type VARCHAR(50) NOT NULL COMMENT 'pistol, rifle, kevlar, car, health_pack, etc',
    base_price INT UNSIGNED NOT NULL DEFAULT 0,
    stock_quantity INT UNSIGNED DEFAULT NULL COMMENT 'NULL = unlimited stock',
    min_level INT UNSIGNED DEFAULT 1,
    strength_bonus INT DEFAULT 0,
    defense_bonus INT DEFAULT 0,
    speed_bonus INT DEFAULT 0,
    health_bonus INT DEFAULT 0,
    energy_bonus INT DEFAULT 0,
    icon VARCHAR(50) DEFAULT 'item',
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_category (category),
    INDEX idx_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- User Inventory
CREATE TABLE IF NOT EXISTS user_inventory (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    item_id INT UNSIGNED NOT NULL,
    quantity INT UNSIGNED DEFAULT 1,
    equipped BOOLEAN DEFAULT FALSE,
    purchased_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (item_id) REFERENCES market_items(id) ON DELETE CASCADE,
    INDEX idx_user (user_id),
    INDEX idx_item (item_id),
    INDEX idx_equipped (equipped),
    UNIQUE KEY unique_user_item (user_id, item_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Market Transactions History
CREATE TABLE IF NOT EXISTS market_transactions (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    item_id INT UNSIGNED NOT NULL,
    transaction_type ENUM('buy', 'sell') NOT NULL,
    quantity INT UNSIGNED DEFAULT 1,
    price_per_unit INT UNSIGNED NOT NULL,
    total_price INT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_user (user_id),
    INDEX idx_type (transaction_type),
    INDEX idx_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert starter market items
INSERT INTO market_items (name, description, category, item_type, base_price, stock_quantity, min_level, strength_bonus, defense_bonus, icon) VALUES
-- Weapons
('9mm Pistol', 'Basic handgun. Low damage but cheap and reliable.', 'weapon', 'pistol', 500, NULL, 1, 5, 0, 'GUN'),
('.45 Revolver', 'Heavy revolver with stopping power.', 'weapon', 'pistol', 1200, NULL, 3, 12, 0, 'GUN'),
('Uzi SMG', 'Rapid-fire submachine gun.', 'weapon', 'smg', 2500, NULL, 5, 20, 0, 'GUN'),
('AK-47', 'Assault rifle. High damage and reliability.', 'weapon', 'rifle', 5000, NULL, 8, 35, 0, 'GUN'),
('Shotgun', 'Close-range devastation.', 'weapon', 'shotgun', 3500, NULL, 6, 28, 0, 'GUN'),
('Sniper Rifle', 'Long-range precision weapon.', 'weapon', 'sniper', 8000, NULL, 10, 50, 0, 'GUN'),

-- Armor
('Leather Jacket', 'Basic protection against small arms.', 'armor', 'light', 300, NULL, 1, 0, 5, 'ARMOR'),
('Bulletproof Vest', 'Standard kevlar protection.', 'armor', 'medium', 1500, NULL, 4, 0, 15, 'ARMOR'),
('Tactical Armor', 'Military-grade body armor.', 'armor', 'heavy', 4000, NULL, 7, 0, 30, 'ARMOR'),
('Combat Suit', 'Full tactical gear with plates.', 'armor', 'elite', 10000, NULL, 12, 0, 50, 'ARMOR'),

-- Vehicles
('Motorcycle', 'Fast and maneuverable. Great for getaways.', 'vehicle', 'bike', 2000, NULL, 2, 0, 0, 'BIKE'),
('Sedan', 'Reliable everyday car.', 'vehicle', 'car', 5000, NULL, 3, 0, 5, 'CAR'),
('Sports Car', 'High speed performance vehicle.', 'vehicle', 'sports', 15000, NULL, 6, 0, 10, 'CAR'),
('SUV', 'Armored vehicle with high defense.', 'vehicle', 'suv', 25000, NULL, 10, 0, 25, 'CAR'),

-- Consumables
('First Aid Kit', 'Restores 50 health.', 'consumable', 'health', 100, NULL, 1, 0, 0, 'MEDKIT'),
('Energy Drink', 'Restores 25 energy.', 'consumable', 'energy', 50, NULL, 1, 0, 0, 'DRINK'),
('Protein Shake', 'Temporary +10 strength for 1 hour.', 'consumable', 'buff_strength', 200, NULL, 3, 0, 0, 'DRINK'),
('Adrenaline Shot', 'Temporary +15% damage for 30 minutes.', 'consumable', 'buff_damage', 500, NULL, 5, 0, 0, 'SYRINGE');
