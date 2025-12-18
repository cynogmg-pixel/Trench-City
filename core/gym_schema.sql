-- ===================================================
-- TRENCH CITY - GYM SAMPLE DATA (Phase 3)
-- Insert default gyms with progression tiers
-- ===================================================

USE trench_city;

-- Clear existing gym data (optional - remove in production)
-- DELETE FROM training_logs;
-- DELETE FROM gym_unlocks;
-- DELETE FROM gyms;

-- Insert sample gyms
INSERT INTO gyms (name, description, tier, unlock_cost_cash, unlock_cost_bank, energy_cost_per_train, base_stat_gain) VALUES
(
    'Street Gym',
    'A basic, gritty gym in the heart of Trench City. Perfect for beginners looking to build their foundation. No frills, just iron and sweat.',
    1,
    0.00,
    0.00,
    5,
    1
),
(
    'Underground Boxing Club',
    'A shadowy fight club where the tough come to train. More intense workouts yield better results. Rumor has it the owner was once a champion.',
    2,
    5000.00,
    0.00,
    10,
    2
),
(
    'Elite Fitness Center',
    'State-of-the-art equipment and professional trainers await those who can afford it. Train smarter, not just harder.',
    3,
    25000.00,
    0.00,
    15,
    3
),
(
    'Private Training Facility',
    'Only the elite are allowed here. Personal trainers, cutting-edge technology, and the best training regimen money can buy.',
    4,
    100000.00,
    50000.00,
    20,
    5
);

-- Verify insert
SELECT * FROM gyms ORDER BY tier ASC;
