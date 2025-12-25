-- ================================================================
-- TRENCH CITY V2 - CURRENCY FORMAT MIGRATION
-- Converts all DECIMAL currency fields to INT UNSIGNED
-- ================================================================
-- Version: 1.0
-- Date: 2025-12-24
-- WARNING: This migration will convert DECIMAL(15,2) to INT UNSIGNED
--          Any fractional pennies will be lost (rounded down)
-- ================================================================

-- ================================================================
-- 1. USERS TABLE - Convert cash and bank_balance
-- ================================================================

-- Convert cash from DECIMAL(15,2) to INT UNSIGNED
ALTER TABLE users
    MODIFY COLUMN cash INT UNSIGNED NOT NULL DEFAULT 0;

-- Convert bank_balance from DECIMAL(15,2) to INT UNSIGNED
ALTER TABLE users
    MODIFY COLUMN bank_balance INT UNSIGNED NOT NULL DEFAULT 0;

-- ================================================================
-- 2. ITEMS TABLE - Convert base_price
-- ================================================================

ALTER TABLE items
    MODIFY COLUMN base_price INT UNSIGNED NOT NULL DEFAULT 0;

-- ================================================================
-- 3. GYMS TABLE - Convert unlock_cost_cash
-- ================================================================

ALTER TABLE gyms
    MODIFY COLUMN unlock_cost_cash INT UNSIGNED NOT NULL DEFAULT 0;

-- ================================================================
-- 4. BUSINESSES TABLE (if exists) - Convert relevant fields
-- ================================================================

-- Check if table exists before altering
ALTER TABLE businesses
    MODIFY COLUMN purchase_cost INT UNSIGNED NOT NULL DEFAULT 0;

ALTER TABLE businesses
    MODIFY COLUMN daily_profit INT UNSIGNED NOT NULL DEFAULT 0;

-- ================================================================
-- 5. CRIMES TABLE (if exists) - Convert min/max cash
-- ================================================================

ALTER TABLE crimes
    MODIFY COLUMN min_cash INT UNSIGNED NOT NULL DEFAULT 0;

ALTER TABLE crimes
    MODIFY COLUMN max_cash INT UNSIGNED NOT NULL DEFAULT 0;

-- ================================================================
-- 6. VERIFY CHANGES
-- ================================================================

-- Run these queries to verify the migration:
--
-- SELECT COLUMN_NAME, DATA_TYPE
-- FROM INFORMATION_SCHEMA.COLUMNS
-- WHERE TABLE_SCHEMA = 'trench_city'
-- AND TABLE_NAME = 'users'
-- AND COLUMN_NAME IN ('cash', 'bank_balance');
--
-- Expected result: Both should show 'int unsigned'

-- ================================================================
-- END OF MIGRATION
-- All currency values now use whole pounds (£1234 not £1234.56)
-- ================================================================
