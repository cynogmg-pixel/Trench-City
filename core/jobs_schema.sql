-- =====================================================
-- TRENCH CITY - JOBS SYSTEM SCHEMA (ALPHA)
-- Simple job system for earning money
-- =====================================================

-- Available Jobs
CREATE TABLE IF NOT EXISTS jobs (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    tier ENUM('legitimate', 'criminal', 'management') DEFAULT 'legitimate',
    hourly_pay INT UNSIGNED NOT NULL DEFAULT 50,
    min_level INT UNSIGNED DEFAULT 1,
    icon VARCHAR(50) DEFAULT 'job',
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_tier (tier),
    INDEX idx_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- User Job History
CREATE TABLE IF NOT EXISTS user_job_history (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    job_id INT UNSIGNED NOT NULL,
    hours_worked DECIMAL(4,2) DEFAULT 1.00,
    earnings INT UNSIGNED NOT NULL,
    worked_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (job_id) REFERENCES jobs(id) ON DELETE CASCADE,
    INDEX idx_user (user_id),
    INDEX idx_worked_at (worked_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- User Current Job (optional - tracks what job user is currently employed at)
CREATE TABLE IF NOT EXISTS user_current_job (
    user_id INT UNSIGNED PRIMARY KEY,
    job_id INT UNSIGNED NOT NULL,
    hired_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_worked_at TIMESTAMP NULL DEFAULT NULL,
    FOREIGN KEY (job_id) REFERENCES jobs(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert starter jobs
INSERT INTO jobs (name, description, tier, hourly_pay, min_level, icon) VALUES
-- Legitimate Jobs (Tier 1)
('Warehouse Worker', 'Load and unload boxes at the docks. Hard work but honest pay.', 'legitimate', 50, 1, 'BOX'),
('Taxi Driver', 'Drive people around the city. Tips included.', 'legitimate', 75, 1, 'TAXI'),
('Janitor', 'Clean up businesses around town.', 'legitimate', 60, 1, 'BROOM'),
('Construction Worker', 'Build structures and repair buildings.', 'legitimate', 100, 2, 'CONSTRUCTION'),
('Security Guard', 'Protect businesses from criminals.', 'legitimate', 120, 3, 'SHIELD'),

-- Criminal Jobs (Tier 2)
('Drug Runner', 'Transport illegal substances across the city. High risk, high reward.', 'criminal', 200, 3, 'PILL'),
('Getaway Driver', 'Drive for criminal operations. Fast cars, faster money.', 'criminal', 250, 4, 'RACECAR'),
('Arms Dealer', 'Sell illegal weapons on the black market.', 'criminal', 300, 5, 'GUN'),
('Enforcer', 'Collect debts and intimidate rivals for the mob.', 'criminal', 350, 6, 'MUSCLE'),
('Money Launderer', 'Clean dirty money through front businesses.', 'criminal', 500, 8, 'MONEYBAG'),

-- Management Jobs (Tier 3)
('Business Manager', 'Manage legitimate business operations.', 'management', 400, 7, 'BUILDING'),
('Casino Floor Manager', 'Oversee casino operations and VIP guests.', 'management', 750, 10, 'CASINO'),
('Nightclub Owner', 'Run a popular nightclub and entertainment venue.', 'management', 600, 9, 'MUSIC'),
('Crime Lord', 'Orchestrate major criminal operations. Top of the food chain.', 'management', 1000, 15, 'CROWN'),
('City Councilman', 'Use political influence for profit. Legal on paper.', 'management', 800, 12, 'SCALES');
