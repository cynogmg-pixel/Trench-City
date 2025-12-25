-- ================================================================
-- TRENCH CITY V2 - PROPERTY UPGRADES DATA
-- Complete catalogue of all property upgrades
-- ================================================================
-- Version: 1.0
-- Date: 2025-12-24
-- ================================================================

-- ================================================================
-- COMFORT & QUALITY UPGRADES (Happy / Regen)
-- ================================================================

INSERT INTO property_upgrade_catalog (name, category, description, min_property_tier, required_level, cost, upkeep_delta, happy_bonus, energy_regen_bonus, life_regen_bonus, happy_regen_bonus, max_occupants_bonus, storage_slots_bonus, security_rating_bonus, is_unique, max_stack, mutually_exclusive_with, slot_type) VALUES
-- Tier 1-2: Basic comfort
('New Carpets', 'comfort', 'Fresh carpeting throughout. Makes the place feel cleaner.', 1, 1, 500, 2, 2, 0, 0, 0.01, 0, 0, 0, TRUE, 1, NULL, 'flooring'),
('Heating Upgrade', 'comfort', 'Modern heating system. No more frozen mornings.', 1, 1, 1000, 5, 3, 0, 0.01, 0.01, 0, 0, 0, TRUE, 1, NULL, 'climate'),
('Luxury Bedding', 'comfort', 'Premium mattress and bedding. Sleep like royalty.', 2, 5, 2000, 3, 5, 0.01, 0.01, 0.01, 0, 0, 0, TRUE, 1, NULL, 'bedroom'),
('Soundproofing', 'comfort', 'Acoustic panels on walls. Silence the outside world.', 2, 5, 3000, 5, 8, 0, 0, 0.02, 0, 0, 0, TRUE, 1, NULL, 'walls'),

-- Tier 3-4: Premium comfort
('Mood Lighting', 'comfort', 'Smart LED lighting system. Set the perfect ambiance.', 3, 10, 5000, 8, 10, 0, 0, 0.02, 0, 0, 0, TRUE, 1, NULL, 'lighting'),
('Home Cinema Room', 'prestige', 'Dedicated cinema room with projector and surround sound. Luxury entertainment.', 4, 20, 50000, 50, 30, 0, 0, 0.03, 0, 0, 0, TRUE, 1, '17', 'entertainment'),
('Designer Interior', 'prestige', 'Professional interior design makeover. Every room is Instagram-worthy.', 4, 20, 75000, 20, 40, 0, 0, 0.04, 0, 0, 0, TRUE, 1, NULL, 'decor'),

-- Tier 5-6: Ultimate luxury
('Art Collection Display', 'prestige', 'Curated art collection with gallery lighting. Culture and class.', 5, 35, 100000, 30, 50, 0, 0, 0.05, 0, 0, 0, TRUE, 1, NULL, 'decor'),
('Rooftop Terrace', 'prestige', 'Private rooftop terrace with gardens and city views. Your personal oasis.', 5, 35, 150000, 80, 60, 0.01, 0.01, 0.05, +1, 0, 0, TRUE, 1, NULL, 'outdoor'),

-- ================================================================
-- ENERGY / TRAINING SUPPORT UPGRADES
-- ================================================================

INSERT INTO property_upgrade_catalog (name, category, description, min_property_tier, required_level, cost, upkeep_delta, happy_bonus, energy_regen_bonus, life_regen_bonus, happy_regen_bonus, max_occupants_bonus, storage_slots_bonus, security_rating_bonus, is_unique, max_stack, mutually_exclusive_with, slot_type) VALUES
-- Tier 2-3: Basic home gym
('Basic Home Gym Kit', 'energy', 'Dumbbells, mat, and resistance bands. Train at home.', 2, 5, 3000, 10, 0, 0.01, 0, 0, 0, 0, 0, TRUE, 1, NULL, 'gym'),
('Weights Rack', 'energy', 'Full weights rack with barbell and plates. Serious training.', 3, 10, 8000, 15, 0, 0.02, 0, 0, 0, 0, 0, TRUE, 1, NULL, 'gym'),
('Cardio Corner', 'energy', 'Treadmill and rowing machine. Cardio on demand.', 3, 10, 10000, 20, 0, 0.02, 0.01, 0, 0, 0, 0, TRUE, 1, NULL, 'gym'),

-- Tier 4-5: Pro training
('PT Corner', 'energy', 'Personal training equipment and mirrors. Train like a pro.', 4, 20, 25000, 30, 5, 0.03, 0.01, 0, 0, 0, 0, TRUE, 1, NULL, 'gym'),
('Recovery Spa', 'energy', 'Sauna, steam room, and ice bath. Elite recovery.', 5, 35, 100000, 100, 10, 0.04, 0.03, 0.02, 0, 0, 0, TRUE, 1, NULL, 'spa'),

-- ================================================================
-- LIFE / RECOVERY UPGRADES
-- ================================================================

INSERT INTO property_upgrade_catalog (name, category, description, min_property_tier, required_level, cost, upkeep_delta, happy_bonus, energy_regen_bonus, life_regen_bonus, happy_regen_bonus, max_occupants_bonus, storage_slots_bonus, security_rating_bonus, is_unique, max_stack, mutually_exclusive_with, slot_type) VALUES
-- Tier 1-3: Basic medical
('First Aid Cabinet', 'life', 'Well-stocked first aid cabinet. Patch yourself up.', 1, 1, 800, 3, 0, 0, 0.01, 0, 0, 0, 0, TRUE, 1, NULL, 'medical'),
('Private Clinic Room', 'life', 'Medical-grade examination room with basic equipment. Treat injuries privately.', 4, 20, 50000, 60, 0, 0, 0.03, 0, 0, 0, 0, TRUE, 1, NULL, 'medical'),

-- Tier 5: Ultimate recovery
('Sauna & Steam Room', 'life', 'Luxury sauna and steam room. Detox and heal.', 5, 35, 80000, 90, 15, 0.01, 0.04, 0.02, 0, 0, 0, TRUE, 1, NULL, 'spa'),

-- ================================================================
-- CAPACITY & UTILITY UPGRADES
-- ================================================================

INSERT INTO property_upgrade_catalog (name, category, description, min_property_tier, required_level, cost, upkeep_delta, happy_bonus, energy_regen_bonus, life_regen_bonus, happy_regen_bonus, max_occupants_bonus, storage_slots_bonus, security_rating_bonus, is_unique, max_stack, mutually_exclusive_with, slot_type) VALUES
-- Occupant capacity (limited stacking)
('Extra Room Extension', 'capacity', 'Build an extra bedroom. House more people.', 2, 5, 15000, 25, 0, 0, 0, 0, +1, 0, 0, FALSE, 3, NULL, 'room'),
('Loft Conversion', 'capacity', 'Convert the loft into living space. Extra room and storage.', 3, 10, 25000, 35, 5, 0, 0, 0, +1, +20, 0, TRUE, 1, NULL, 'room'),

-- Storage
('Basement Storage', 'utility', 'Excavate a basement for storage. Secure and spacious.', 3, 10, 20000, 15, 0, 0, 0, 0, 0, +50, 0, TRUE, 1, NULL, 'storage'),
('Secure Storage Locker', 'utility', 'Reinforced storage locker. Keep valuables safe.', 2, 5, 5000, 5, 0, 0, 0, 0, 0, +20, +5, TRUE, 1, NULL, 'storage'),
('Workshop / Tool Bench', 'utility', 'Dedicated workshop space with tools. Future crafting potential.', 3, 10, 12000, 10, 3, 0, 0, 0, 0, +30, 0, TRUE, 1, NULL, 'utility'),

-- ================================================================
-- SECURITY UPGRADES (Future crimes/faction hooks)
-- ================================================================

INSERT INTO property_upgrade_catalog (name, category, description, min_property_tier, required_level, cost, upkeep_delta, happy_bonus, energy_regen_bonus, life_regen_bonus, happy_regen_bonus, max_occupants_bonus, storage_slots_bonus, security_rating_bonus, is_unique, max_stack, mutually_exclusive_with, slot_type) VALUES
-- Basic security
('Reinforced Door', 'security', 'Heavy-duty door with deadbolts. Keep intruders out.', 1, 1, 1500, 5, 0, 0, 0, 0, 0, 0, +10, TRUE, 1, NULL, 'door'),
('Window Bars', 'security', 'Steel bars on all windows. Not pretty, but effective.', 1, 1, 2000, 3, -2, 0, 0, 0, 0, 0, +15, TRUE, 1, NULL, 'windows'),
('CCTV System', 'security', '24/7 surveillance cameras. See everything.', 2, 5, 8000, 15, 0, 0, 0, 0, 0, 0, +25, TRUE, 1, NULL, 'surveillance'),

-- Advanced security
('Alarm Response Contract', 'security', 'Professional alarm monitoring with rapid response. Peace of mind.', 3, 10, 5000, 50, 5, 0, 0, 0, 0, 0, +30, TRUE, 1, NULL, 'alarm'),
('Safe / Vault', 'security', 'Hidden wall safe for valuables. Fireproof and reinforced.', 3, 10, 20000, 10, 0, 0, 0, 0, 0, 0, +20, TRUE, 1, NULL, 'vault'),

-- Prestige security
('Panic Room', 'security', 'Fortified panic room with supplies and communications. Ultimate safety.', 5, 35, 200000, 100, 10, 0, 0, 0, 0, +50, +100, TRUE, 1, NULL, 'security'),

-- ================================================================
-- PRESTIGE / COSMETIC UPGRADES
-- ================================================================

INSERT INTO property_upgrade_catalog (name, category, description, min_property_tier, required_level, cost, upkeep_delta, happy_bonus, energy_regen_bonus, life_regen_bonus, happy_regen_bonus, max_occupants_bonus, storage_slots_bonus, security_rating_bonus, is_unique, max_stack, mutually_exclusive_with, slot_type) VALUES
-- High-tier luxury
('Private Bar Room', 'prestige', 'Custom-built bar with premium spirits. Entertain in style.', 4, 20, 60000, 40, 35, 0, 0, 0.03, 0, 0, 0, TRUE, 1, '6', 'entertainment'),
('Car Showcase Garage', 'prestige', 'Climate-controlled garage with display lighting. Show off your rides.', 4, 20, 80000, 30, 20, 0, 0, 0, 0, +40, +10, TRUE, 1, NULL, 'garage'),
('Private Pool', 'prestige', 'Indoor heated pool with spa jets. Swim year-round.', 5, 35, 250000, 150, 70, 0.02, 0.02, 0.04, 0, 0, 0, TRUE, 1, NULL, 'pool'),
('Wine Cellar', 'prestige', 'Temperature-controlled wine cellar for 500+ bottles. For the connoisseur.', 4, 20, 40000, 20, 25, 0, 0, 0.02, 0, +20, 0, TRUE, 1, NULL, 'cellar'),
('Helipad', 'prestige', 'Private helipad on the roof. Arrive in style (helicopter not included).', 6, 50, 500000, 200, 100, 0, 0, 0.05, 0, 0, +50, TRUE, 1, NULL, 'transport');

-- ================================================================
-- TOTAL: 35 UPGRADES
-- Comfort: 9 upgrades
-- Energy: 5 upgrades
-- Life: 3 upgrades
-- Capacity: 2 occupant upgrades (Extra Room stackable x3)
-- Utility: 3 storage/workshop upgrades
-- Security: 6 upgrades
-- Prestige: 7 luxury upgrades
-- ================================================================

-- ================================================================
-- UPGRADE STACKING RULES:
-- - Most upgrades are UNIQUE (is_unique = TRUE, max_stack = 1)
-- - "Extra Room Extension" allows 3 stacks (max +3 occupants)
-- - Mutually exclusive: Home Cinema (6) vs Private Bar (17)
-- ================================================================

-- ================================================================
-- END OF UPGRADES DATA
-- ================================================================
