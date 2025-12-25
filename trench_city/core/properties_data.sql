-- ================================================================
-- TRENCH CITY V2 - PROPERTIES DATA
-- Complete catalogue of all properties (Trench City themed)
-- ================================================================
-- Version: 1.0
-- Date: 2025-12-24
-- ================================================================

-- ================================================================
-- TIER 1: STARTER PROPERTIES (£5K - £15K)
-- Basic housing for new players
-- ================================================================

INSERT INTO properties (name, tier, description, base_cost, base_upkeep, base_happy, base_energy_regen_modifier, base_life_regen_modifier, base_happy_regen_modifier, base_max_occupants, base_storage_slots, is_unique, unlock_level, location) VALUES
('Battered Bedsit', 1, 'A rundown bedsit in Peckham. Four walls and a radiator that sometimes works. Better than sleeping rough.', 5000, 10, 5, 0, 0, 0, 1, 10, FALSE, 1, 'Peckham'),
('Council Flat', 1, 'Standard council housing in Hackney. The lift''s broken but it''s home.', 8000, 15, 8, 0, 0, 0, 2, 15, FALSE, 1, 'Hackney'),
('Hostel Room', 1, 'Shared facilities in Camden Lock. Noisy neighbours but cheap rent.', 6000, 12, 6, 0, 0, 0, 1, 8, FALSE, 1, 'Camden Lock');

-- ================================================================
-- TIER 2: EARLY CLIMB (£15K - £50K)
-- Modest improvements, unlock at level 5
-- ================================================================

INSERT INTO properties (name, tier, description, base_cost, base_upkeep, base_happy, base_energy_regen_modifier, base_life_regen_modifier, base_happy_regen_modifier, base_max_occupants, base_storage_slots, is_unique, unlock_level, location) VALUES
('Studio Flat', 2, 'A proper studio in Stratford. Small but it''s all yours.', 20000, 30, 12, 0.01, 0, 0.01, 2, 20, FALSE, 5, 'Stratford'),
('Brick Walk-Up', 2, 'Classic Brixton terrace walk-up. Three floors of character (and creaky stairs).', 30000, 40, 15, 0.01, 0, 0.01, 2, 25, FALSE, 5, 'Brixton'),
('Small Terrace', 2, 'Walthamstow terrace house. Needs work but has potential.', 35000, 45, 18, 0.01, 0, 0.01, 3, 30, FALSE, 5, 'Walthamstow');

-- ================================================================
-- TIER 3: MID-TIER (£50K - £150K)
-- Comfortable living, unlock at level 10
-- ================================================================

INSERT INTO properties (name, tier, description, base_cost, base_upkeep, base_happy, base_energy_regen_modifier, base_life_regen_modifier, base_happy_regen_modifier, base_max_occupants, base_storage_slots, is_unique, unlock_level, location) VALUES
('Renovated Terrace', 3, 'Freshly renovated terrace on Islington''s edge. Exposed brick and new kitchen.', 75000, 80, 25, 0.02, 0.01, 0.02, 3, 40, FALSE, 10, 'Islington Fringe'),
('Modern Apartment', 3, 'Contemporary flat near Canary Wharf. Floor-to-ceiling windows and a doorman.', 100000, 100, 30, 0.02, 0.01, 0.02, 3, 45, FALSE, 10, 'Canary Wharf Edge'),
('Townhouse Lite', 3, 'Compact townhouse in Greenwich. Three bedrooms and a tiny garden.', 120000, 110, 35, 0.02, 0.01, 0.02, 4, 50, FALSE, 10, 'Greenwich');

-- ================================================================
-- TIER 4: UPPER-MID (£150K - £500K)
-- Prestigious addresses, unlock at level 20
-- ================================================================

INSERT INTO properties (name, tier, description, base_cost, base_upkeep, base_happy, base_energy_regen_modifier, base_life_regen_modifier, base_happy_regen_modifier, base_max_occupants, base_storage_slots, is_unique, unlock_level, location) VALUES
('Riverside Apartment', 4, 'South Bank apartment with Thames views. Concierge and gym access.', 250000, 200, 50, 0.03, 0.02, 0.03, 4, 60, FALSE, 20, 'South Bank'),
('Gated Mews House', 4, 'Exclusive mews house on Kensington''s fringe. Private gated courtyard.', 350000, 250, 60, 0.03, 0.02, 0.03, 4, 70, FALSE, 20, 'Kensington Fringe'),
('Penthouse View', 4, 'High-floor penthouse with Shard views. Private lift and rooftop terrace.', 450000, 300, 70, 0.03, 0.02, 0.03, 5, 80, FALSE, 20, 'Shard View');

-- ================================================================
-- TIER 5: PRESTIGE (£500K - £2M)
-- Elite addresses, unlock at level 35
-- ================================================================

INSERT INTO properties (name, tier, description, base_cost, base_upkeep, base_happy, base_energy_regen_modifier, base_life_regen_modifier, base_happy_regen_modifier, base_max_occupants, base_storage_slots, is_unique, unlock_level, location) VALUES
('Mayfair Townhouse', 5, 'Five-storey Mayfair townhouse. Marble floors, wine cellar, and underground parking.', 1000000, 500, 100, 0.04, 0.03, 0.04, 6, 100, FALSE, 35, 'Mayfair'),
('Knightsbridge Penthouse', 5, 'Luxury penthouse in Knightsbridge. 360-degree views and private cinema.', 1500000, 600, 120, 0.04, 0.03, 0.04, 6, 120, FALSE, 35, 'Knightsbridge'),
('Richmond Estate House', 5, 'Private estate house in Richmond. Acres of grounds and a river frontage.', 1800000, 700, 140, 0.04, 0.03, 0.04, 8, 150, FALSE, 35, 'Richmond');

-- ================================================================
-- TIER 6: ICONIC / UNIQUE (£2M+)
-- Legendary properties, special unlocks, limited availability
-- ================================================================

INSERT INTO properties (name, tier, description, base_cost, base_upkeep, base_happy, base_energy_regen_modifier, base_life_regen_modifier, base_happy_regen_modifier, base_max_occupants, base_storage_slots, is_unique, unlock_level, location) VALUES
('The Black Cab Loft', 6, 'Converted Victorian cab depot. Industrial chic with original black cabs as décor. One of a kind.', 2500000, 1000, 180, 0.05, 0.04, 0.05, 8, 200, TRUE, 50, 'Shoreditch'),
('The Underground Bunker', 6, 'Secret WW2 bunker beneath Whitehall. Reinforced steel doors, generator, and escape tunnels. Paranoia included.', 3000000, 1200, 200, 0.05, 0.04, 0.05, 10, 250, TRUE, 50, 'Whitehall'),
('The Trench Manor', 6, 'The crown jewel. A sprawling Hampstead manor once owned by crime lords. Pool, helipad, panic room, and legend status.', 5000000, 2000, 300, 0.06, 0.05, 0.06, 12, 500, TRUE, 60, 'Hampstead Heath');

-- Additional Tier 1-2 variety
INSERT INTO properties (name, tier, description, base_cost, base_upkeep, base_happy, base_energy_regen_modifier, base_life_regen_modifier, base_happy_regen_modifier, base_max_occupants, base_storage_slots, is_unique, unlock_level, location) VALUES
('Converted Warehouse Room', 2, 'Industrial conversion in Shoreditch. Exposed pipes and brick walls.', 25000, 35, 14, 0.01, 0, 0.01, 2, 22, FALSE, 5, 'Shoreditch'),
('Tower Block Flat', 1, 'High-rise council flat in Elephant & Castle. Great views if you ignore the lift.', 10000, 18, 10, 0, 0, 0, 2, 18, FALSE, 1, 'Elephant & Castle');

-- Additional Tier 3-4 variety
INSERT INTO properties (name, tier, description, base_cost, base_upkeep, base_happy, base_energy_regen_modifier, base_life_regen_modifier, base_happy_regen_modifier, base_max_occupants, base_storage_slots, is_unique, unlock_level, location) VALUES
('Docklands Loft', 3, 'Converted warehouse loft in Docklands. Open-plan living with river access.', 95000, 95, 28, 0.02, 0.01, 0.02, 3, 42, FALSE, 10, 'Docklands'),
('Notting Hill Garden Flat', 4, 'Ground-floor flat with private garden in Notting Hill. Bohemian charm.', 280000, 220, 55, 0.03, 0.02, 0.03, 4, 65, FALSE, 20, 'Notting Hill');

-- Additional Tier 5 variety
INSERT INTO properties (name, tier, description, base_cost, base_upkeep, base_happy, base_energy_regen_modifier, base_life_regen_modifier, base_happy_regen_modifier, base_max_occupants, base_storage_slots, is_unique, unlock_level, location) VALUES
('Chelsea Riverside Mansion', 5, 'Grand riverside mansion in Chelsea. Private dock and ballroom.', 2000000, 750, 150, 0.04, 0.03, 0.04, 7, 130, FALSE, 35, 'Chelsea');

-- ================================================================
-- TOTAL: 26 PROPERTIES
-- Tier 1: 5 properties (£5K - £15K)
-- Tier 2: 5 properties (£15K - £50K)
-- Tier 3: 4 properties (£50K - £150K)
-- Tier 4: 4 properties (£150K - £500K)
-- Tier 5: 5 properties (£500K - £2M)
-- Tier 6: 3 unique properties (£2.5M - £5M)
-- ================================================================

-- ================================================================
-- END OF PROPERTIES DATA
-- ================================================================
