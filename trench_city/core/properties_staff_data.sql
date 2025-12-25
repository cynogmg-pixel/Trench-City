-- ================================================================
-- TRENCH CITY V2 - PROPERTY STAFF DATA
-- Complete catalogue of property staff types
-- ================================================================
-- Version: 1.0
-- Date: 2025-12-24
-- ================================================================

-- ================================================================
-- STAFF CATALOGUE (5 core staff types, 3 quality tiers each)
-- ================================================================

-- ================================================================
-- CLEANERS (Reduce upkeep + improve Happy)
-- ================================================================

INSERT INTO property_staff_catalog (name, role, description, min_property_tier, daily_wage, hiring_fee, upkeep_reduction_percent, happy_bonus, energy_bonus, life_bonus, security_bonus, quality_tier) VALUES
('Basic Cleaner', 'cleaner', 'Part-time cleaner. Comes twice a week to tidy up.', 1, 20, 50, 2, 2, 0, 0, 0, 'basic'),
('Professional Cleaner', 'cleaner', 'Daily cleaning service. Your home stays spotless.', 3, 50, 150, 5, 5, 0, 0, 0, 'professional'),
('Live-in Housekeeper', 'cleaner', 'Full-time live-in housekeeper. White-glove service.', 5, 120, 500, 8, 10, 0, 0, 0, 'expert');

-- ================================================================
-- HANDYMAN (Reduce upgrade maintenance / prevent degradation)
-- ================================================================

INSERT INTO property_staff_catalog (name, role, description, min_property_tier, daily_wage, hiring_fee, upkeep_reduction_percent, happy_bonus, energy_bonus, life_bonus, security_bonus, quality_tier) VALUES
('Part-time Handyman', 'handyman', 'On-call handyman for repairs. Fixes the basics.', 2, 30, 100, 3, 1, 0, 0, 0, 'basic'),
('Professional Handyman', 'handyman', 'Experienced tradesman. Handles all maintenance.', 3, 70, 250, 6, 3, 0, 0, 0, 'professional'),
('Estate Manager', 'handyman', 'Full-time estate manager. Oversees all property operations.', 5, 150, 800, 10, 8, 0, 0, 5, 'expert');

-- ================================================================
-- SECURITY GUARD (Improve security rating)
-- ================================================================

INSERT INTO property_staff_catalog (name, role, description, min_property_tier, daily_wage, hiring_fee, upkeep_reduction_percent, happy_bonus, energy_bonus, life_bonus, security_bonus, quality_tier) VALUES
('Night Security', 'security', 'Part-time night security. Patrols after dark.', 2, 40, 150, 0, 0, 0, 0, 20, 'basic'),
('Full-time Security Guard', 'security', '24/7 security presence. Trained in protection.', 4, 100, 400, 0, 3, 0, 0, 50, 'professional'),
('Personal Bodyguard', 'security', 'Elite ex-military bodyguard. Your safety guaranteed.', 5, 250, 1500, 0, 5, 0, 0.01, 100, 'expert');

-- ================================================================
-- CHEF (Happy regen + small energy boost)
-- ================================================================

INSERT INTO property_staff_catalog (name, role, description, min_property_tier, daily_wage, hiring_fee, upkeep_reduction_percent, happy_bonus, energy_bonus, life_bonus, security_bonus, quality_tier) VALUES
('Home Cook', 'chef', 'Home cook prepares daily meals. Simple but tasty.', 3, 50, 200, 0, 8, 0.01, 0, 0, 'basic'),
('Professional Chef', 'chef', 'Trained chef creates restaurant-quality meals.', 4, 120, 600, 0, 15, 0.02, 0.01, 0, 'professional'),
('Private Michelin Chef', 'chef', 'Michelin-starred chef. World-class dining at home.', 6, 300, 2000, 0, 30, 0.03, 0.02, 0, 'expert');

-- ================================================================
-- PERSONAL TRAINER (Boosts gym-at-home upgrades)
-- ================================================================

INSERT INTO property_staff_catalog (name, role, description, min_property_tier, daily_wage, hiring_fee, upkeep_reduction_percent, happy_bonus, energy_bonus, life_bonus, security_bonus, quality_tier) VALUES
('Fitness Coach', 'trainer', 'Part-time fitness coach. Basic training guidance.', 3, 40, 150, 0, 3, 0.02, 0, 0, 'basic'),
('Professional PT', 'trainer', 'Certified personal trainer. Customized programs.', 4, 100, 500, 0, 5, 0.03, 0.01, 0, 'professional'),
('Elite Performance Coach', 'trainer', 'Elite-level coach with sports science degree. Peak performance.', 5, 200, 1200, 0, 10, 0.04, 0.02, 0, 'expert');

-- ================================================================
-- TOTAL: 15 STAFF (5 roles × 3 quality tiers)
-- ================================================================
-- Cleaners: Reduce upkeep, boost Happy
-- Handymen: Reduce upkeep, maintain property
-- Security: Boost security rating
-- Chefs: Boost Happy + Energy
-- Trainers: Boost Energy + Life
-- ================================================================

-- ================================================================
-- STAFF BALANCING NOTES:
-- - Daily wages scale exponentially by tier
-- - Hiring fees are 2.5x - 10x daily wage
-- - Expert staff require Tier 5-6 properties
-- - Staff bonuses stack with upgrade bonuses
-- - Total staff wages contribute to daily upkeep
-- ================================================================

-- ================================================================
-- END OF STAFF DATA
-- ================================================================
