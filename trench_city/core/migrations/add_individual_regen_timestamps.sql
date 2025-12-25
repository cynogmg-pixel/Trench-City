-- Add individual regeneration timestamps for each bar type
-- This allows each bar to regenerate at different rates

USE trench_city;

ALTER TABLE player_bars
    ADD COLUMN energy_last_regen DATETIME NULL DEFAULT NULL AFTER energy_max,
    ADD COLUMN nerve_last_regen DATETIME NULL DEFAULT NULL AFTER nerve_max,
    ADD COLUMN happy_last_regen DATETIME NULL DEFAULT NULL AFTER happy_max,
    ADD COLUMN life_last_regen DATETIME NULL DEFAULT NULL AFTER life_max;

-- Update existing records to use current timestamp
UPDATE player_bars
SET
    energy_last_regen = COALESCE(last_regen_at, NOW()),
    nerve_last_regen = COALESCE(last_regen_at, NOW()),
    happy_last_regen = COALESCE(last_regen_at, NOW()),
    life_last_regen = COALESCE(last_regen_at, NOW())
WHERE energy_last_regen IS NULL;
