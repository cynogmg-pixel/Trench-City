-- ===============================================================
-- TRENCH CITY - CRIMES DATA (Phase 4)
-- ===============================================================
-- Sample crimes across 5 categories: Petty, Theft, Violence, Organized, Elite
-- Balanced progression system with increasing risk/reward
-- Author: Architect
-- Version: 1.0.0
-- ===============================================================

USE trench_city;

-- Clear existing crime data (optional - remove if you want to preserve data)
-- DELETE FROM crime_logs;
-- DELETE FROM crimes;

-- ===============================================================
-- PETTY CRIMES (Level 1-5, Nerve: 1-2)
-- ===============================================================
-- Low risk, low reward, perfect for beginners
INSERT INTO crimes (name, description, category, nerve_cost, min_level, min_stats, cash_min, cash_max, xp_reward, base_success_rate, jail_chance, hospital_chance, difficulty) VALUES
('Pickpocket', 'Swipe a wallet from an unsuspecting tourist in the market district.', 'petty', 1, 1, 0, 50.00, 150.00, 5, 65.00, 3.00, 1.00, 1),
('Shoplifting', 'Steal merchandise from a corner store while the clerk is distracted.', 'petty', 1, 1, 0, 100.00, 300.00, 8, 60.00, 5.00, 2.00, 1),
('Graffiti Tagging', 'Tag rival gang territory and collect payment from your crew.', 'petty', 1, 2, 50, 20.00, 80.00, 3, 70.00, 2.00, 0.00, 1),
('Bike Theft', 'Steal an unlocked bicycle from outside a cafe and sell it for parts.', 'petty', 2, 3, 100, 150.00, 400.00, 10, 55.00, 6.00, 3.00, 2);

-- ===============================================================
-- THEFT CRIMES (Level 5-10, Nerve: 3-5)
-- ===============================================================
-- Medium risk, decent rewards, requires some skill
INSERT INTO crimes (name, description, category, nerve_cost, min_level, min_stats, cash_min, cash_max, xp_reward, base_success_rate, jail_chance, hospital_chance, difficulty) VALUES
('Car Theft', 'Hot-wire a luxury vehicle from the casino parking lot.', 'theft', 3, 5, 200, 500.00, 1500.00, 15, 45.00, 8.00, 4.00, 3),
('Burglary', 'Break into a wealthy home while the owners are away on vacation.', 'theft', 4, 6, 300, 800.00, 2000.00, 20, 40.00, 10.00, 5.00, 4),
('ATM Smashing', 'Smash and grab from a standalone ATM in an alley.', 'theft', 5, 8, 400, 1000.00, 3000.00, 25, 35.00, 12.00, 8.00, 5),
('Jewelry Heist', 'Steal high-end jewelry from an upscale boutique during closing time.', 'theft', 5, 9, 500, 1500.00, 3500.00, 30, 38.00, 11.00, 6.00, 5);

-- ===============================================================
-- VIOLENCE CRIMES (Level 10-15, Nerve: 5-8)
-- ===============================================================
-- High risk, good rewards, dangerous situations
INSERT INTO crimes (name, description, category, nerve_cost, min_level, min_stats, cash_min, cash_max, xp_reward, base_success_rate, jail_chance, hospital_chance, difficulty) VALUES
('Street Mugging', 'Rob a businessman walking alone through a dark alley.', 'violence', 5, 10, 600, 300.00, 800.00, 18, 50.00, 10.00, 10.00, 4),
('Armed Robbery', 'Hold up a convenience store with a loaded weapon.', 'violence', 6, 12, 800, 2000.00, 5000.00, 35, 35.00, 15.00, 15.00, 6),
('Kidnapping', 'Abduct a wealthy target and hold them for ransom.', 'violence', 8, 14, 1000, 5000.00, 10000.00, 50, 30.00, 20.00, 18.00, 7),
('Assassination Contract', 'Eliminate a high-profile target for a mystery client.', 'violence', 8, 15, 1200, 8000.00, 15000.00, 60, 28.00, 18.00, 20.00, 8);

-- ===============================================================
-- ORGANIZED CRIMES (Level 15-25, Nerve: 8-12)
-- ===============================================================
-- Very high risk, excellent rewards, requires organization
INSERT INTO crimes (name, description, category, nerve_cost, min_level, min_stats, cash_min, cash_max, xp_reward, base_success_rate, jail_chance, hospital_chance, difficulty) VALUES
('Drug Trafficking', 'Move a shipment of narcotics across city territories.', 'organized', 8, 15, 1500, 3000.00, 8000.00, 40, 42.00, 16.00, 12.00, 7),
('Extortion Racket', 'Collect protection money from local businesses in your territory.', 'organized', 10, 18, 2000, 10000.00, 20000.00, 60, 38.00, 18.00, 14.00, 8),
('Money Laundering', 'Wash dirty money through a network of shell companies.', 'organized', 10, 20, 2500, 15000.00, 30000.00, 75, 35.00, 15.00, 10.00, 9),
('Arms Dealing', 'Smuggle military-grade weapons to underground buyers.', 'organized', 12, 22, 3000, 20000.00, 40000.00, 85, 32.00, 20.00, 15.00, 9);

-- ===============================================================
-- ELITE CRIMES (Level 25+, Nerve: 12-15)
-- ===============================================================
-- Extreme risk, massive rewards, only for the most skilled criminals
INSERT INTO crimes (name, description, category, nerve_cost, min_level, min_stats, cash_min, cash_max, xp_reward, base_success_rate, jail_chance, hospital_chance, difficulty) VALUES
('Casino Heist', 'Execute a precision heist on the city''s most secure casino vault.', 'elite', 12, 25, 4000, 25000.00, 50000.00, 100, 28.00, 22.00, 18.00, 10),
('Political Bribery', 'Blackmail and bribe high-ranking politicians for lucrative contracts.', 'elite', 13, 28, 5000, 40000.00, 80000.00, 125, 25.00, 20.00, 12.00, 10),
('Corporate Espionage', 'Steal trade secrets from a Fortune 500 company''s secure servers.', 'elite', 15, 30, 6000, 60000.00, 120000.00, 150, 22.00, 18.00, 15.00, 10),
('International Smuggling', 'Coordinate a massive international smuggling operation.', 'elite', 15, 32, 7000, 80000.00, 150000.00, 175, 20.00, 25.00, 20.00, 10),
('Bank Vault Breach', 'Infiltrate and rob the central bank''s maximum security vault.', 'elite', 15, 35, 8000, 100000.00, 200000.00, 200, 18.00, 28.00, 22.00, 10);

-- ===============================================================
-- VERIFICATION QUERY
-- ===============================================================
-- Uncomment to verify data insertion
-- SELECT category, COUNT(*) as crime_count,
--        AVG(base_success_rate) as avg_success_rate,
--        MIN(cash_min) as min_reward,
--        MAX(cash_max) as max_reward
-- FROM crimes
-- GROUP BY category
-- ORDER BY FIELD(category, 'petty', 'theft', 'violence', 'organized', 'elite');
