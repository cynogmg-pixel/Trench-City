# TRENCH CITY V2 - PLAYER CORE (TORN-FAITHFUL) IMPLEMENTATION SPEC

**Date**: 2025-12-24
**Version**: 1.0
**Status**: 🔨 IN PROGRESS

---

## EXECUTIVE SUMMARY

This document specifies the complete Torn-faithful player core system implementation. It covers:
- Hidden XP system with upgrade link (not XP bar)
- Level holding mechanism
- Crime Experience (CE) → Natural Nerve Bar (NNB) system
- Nerve bonus layers (merits, faction, job)
- Level-gated unlocks
- XP weighting for different attack types
- Anti-abuse measures

---

## CURRENT STATE AUDIT

### ✅ What Exists (Working)
- `users` table with `xp` and `level` fields
- `player_stats` table (strength, speed, defense, dexterity)
- `player_bars` table with individual regen timestamps
- Basic XP/level functions: `calculateLevel()`, `awardXP()`
- Bar regeneration system with individual timers
- Profile, settings, player directory pages

### ❌ What's Missing (Torn-Faithful Requirements)

#### Critical Missing Features:
1. **Hidden XP System**
   - XP is currently visible (need to hide it)
   - No "Upgrade" link when level-up available
   - No level holding mechanism
   - No `true_level` vs `display_level` separation

2. **Crime Experience (CE) System**
   - No `crime_experience` field in database
   - No `nerve_natural_max` (NNB) field
   - No CE → NNB threshold calculation
   - No CE gain/loss on crime success/critical fail

3. **Nerve Bonus Layers**
   - No separation of natural nerve vs bonus nerve
   - No merits system for +1 nerve per point
   - No faction nerve bonuses
   - No job/company nerve bonuses

4. **Level-Gated Unlocks**
   - No centralized permission system for level gates
   - No unlock checks for bookies, company, blackjack, etc.

5. **XP Weighting System**
   - No attack type XP multipliers (leave 1.0x, mug 0.55x, hosp 0.4x)
   - No victim level multiplier
   - No crime XP calculation
   - No gym XP integration

6. **Anti-Abuse**
   - No XP award logging table
   - No attack target abuse prevention
   - No rate limiting on actions
   - No anomaly detection

7. **Status/Permission Engine**
   - No hospital/jail/travel status blocking
   - No `canTrainGym()`, `canCommitCrime()`, `canAttack()` checks
   - No cooldown system

---

## SCHEMA CHANGES REQUIRED

### 1. Extend `users` table

```sql
ALTER TABLE users
    -- Level holding system
    ADD COLUMN true_level INT UNSIGNED NOT NULL DEFAULT 1 AFTER level,
    ADD COLUMN level_holding_enabled TINYINT(1) NOT NULL DEFAULT 0 AFTER true_level,
    ADD COLUMN last_level_upgrade_at DATETIME NULL AFTER level_holding_enabled,

    -- Player state
    ADD COLUMN player_state ENUM('normal', 'hospital', 'jail', 'traveling') NOT NULL DEFAULT 'normal' AFTER status,
    ADD COLUMN state_until DATETIME NULL AFTER player_state,

    -- Tutorial/onboarding
    ADD COLUMN tutorial_completed TINYINT(1) NOT NULL DEFAULT 0 AFTER created_at,

    -- Anti-abuse
    ADD COLUMN last_action_at DATETIME NULL AFTER last_login_at,
    ADD COLUMN daily_reset_at DATETIME NULL AFTER last_action_at;
```

### 2. Extend `player_bars` table for Nerve system

```sql
ALTER TABLE player_bars
    -- Natural Nerve Bar (NNB) from Crime Experience
    ADD COLUMN nerve_natural_max INT UNSIGNED NOT NULL DEFAULT 15 AFTER nerve_max,

    -- Nerve bonus layers
    ADD COLUMN nerve_bonus_merits INT UNSIGNED NOT NULL DEFAULT 0 AFTER nerve_natural_max,
    ADD COLUMN nerve_bonus_faction INT UNSIGNED NOT NULL DEFAULT 0 AFTER nerve_bonus_merits,
    ADD COLUMN nerve_bonus_job INT UNSIGNED NOT NULL DEFAULT 0 AFTER nerve_bonus_faction,

    -- nerve_max becomes computed: nerve_natural_max + bonuses
    -- Keep nerve_max as cached value for performance

    -- Crime Experience (hidden, drives NNB)
    ADD COLUMN crime_experience BIGINT UNSIGNED NOT NULL DEFAULT 0 AFTER nerve_bonus_job,
    ADD COLUMN crime_success_count INT UNSIGNED NOT NULL DEFAULT 0 AFTER crime_experience,
    ADD COLUMN last_ce_recalc_at DATETIME NULL AFTER crime_success_count;
```

### 3. Create `player_state_log` table

```sql
CREATE TABLE IF NOT EXISTS player_state_log (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    previous_state ENUM('normal', 'hospital', 'jail', 'traveling') NOT NULL,
    new_state ENUM('normal', 'hospital', 'jail', 'traveling') NOT NULL,
    reason TEXT NULL,
    state_until DATETIME NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_player_state_log_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE,
    KEY idx_player_state_log_user (user_id),
    KEY idx_player_state_log_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### 4. Create `xp_awards_log` table (anti-abuse)

```sql
CREATE TABLE IF NOT EXISTS xp_awards_log (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    xp_amount INT UNSIGNED NOT NULL,
    source ENUM('attack_leave', 'attack_mug', 'attack_hosp', 'crime', 'gym', 'job', 'mission', 'other') NOT NULL,
    source_id BIGINT UNSIGNED NULL, -- combat_log_id, training_log_id, etc
    base_xp INT UNSIGNED NOT NULL,
    multiplier DECIMAL(5,2) NOT NULL DEFAULT 1.00,
    victim_level INT UNSIGNED NULL,
    metadata JSON NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_xp_awards_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE,
    KEY idx_xp_awards_user (user_id),
    KEY idx_xp_awards_source (source),
    KEY idx_xp_awards_created (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

### 5. Create `level_gates` configuration table

```sql
CREATE TABLE IF NOT EXISTS level_gates (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    gate_name VARCHAR(64) NOT NULL UNIQUE,
    required_level INT UNSIGNED NOT NULL,
    description TEXT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    KEY idx_level_gates_level (required_level)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Seed Torn-faithful level gates
INSERT INTO level_gates (gate_name, required_level, description) VALUES
('bookies', 2, 'Access to Bookies betting system'),
('company', 3, 'Ability to join companies'),
('lottery', 3, 'Access to lottery system'),
('blackjack', 4, 'Access to Blackjack casino game'),
('auction', 5, 'Access to Auction House'),
('post_george_missions', 5, 'Access to missions after George tutorial'),
('poker', 5, 'Access to Poker casino game'),
('russian_roulette', 6, 'Access to Russian Roulette'),
('spin_wheel', 7, 'Access to Spin the Wheel'),
('company_director', 10, 'Ability to become Company Director'),
('global_chat', 13, 'Access to Global Chat (lose newbie chat)'),
('travel_agency', 15, 'Access to Travel Agency');
```

### 6. Create `action_cooldowns` table

```sql
CREATE TABLE IF NOT EXISTS action_cooldowns (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    cooldown_type VARCHAR(64) NOT NULL,
    expires_at DATETIME NOT NULL,
    metadata JSON NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_action_cooldowns_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE,
    UNIQUE KEY uq_cooldowns_user_type (user_id, cooldown_type),
    KEY idx_cooldowns_expires (expires_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

## CORE FUNCTIONS TO IMPLEMENT

### 1. XP System (Torn-faithful)

#### `getTrueLevel(int $userId): int`
```php
/**
 * Calculate true level from total XP (always authoritative)
 */
function getTrueLevel(int $userId): int {
    $user = getUser($userId);
    if (!$user) return 1;
    return calculateLevel((int)$user['xp']);
}
```

#### `getDisplayLevel(int $userId): int`
```php
/**
 * Get display level (may be held below true level)
 */
function getDisplayLevel(int $userId): int {
    $user = getUser($userId);
    if (!$user) return 1;
    return (int)$user['level']; // This is the held/displayed level
}
```

#### `canUpgradeLevel(int $userId): bool`
```php
/**
 * Check if player can upgrade (true_level > display_level)
 */
function canUpgradeLevel(int $userId): bool {
    $user = getUser($userId);
    if (!$user) return false;

    $trueLevel = calculateLevel((int)$user['xp']);
    $displayLevel = (int)$user['level'];

    return $trueLevel > $displayLevel;
}
```

#### `upgradeLevelToTrue(int $userId): bool`
```php
/**
 * Upgrade display level to true level (exit level holding)
 */
function upgradeLevelToTrue(int $userId): bool {
    global $db;
    if (!$db) return false;

    $user = getUser($userId);
    if (!$user) return false;

    $trueLevel = calculateLevel((int)$user['xp']);
    $currentLevel = (int)$user['level'];

    if ($trueLevel <= $currentLevel) {
        return false; // Nothing to upgrade
    }

    $levelsGained = $trueLevel - $currentLevel;

    $db->execute(
        "UPDATE users
         SET level = :true_level,
             true_level = :true_level,
             last_level_upgrade_at = NOW()
         WHERE id = :id",
        [
            'true_level' => $trueLevel,
            'id' => $userId
        ]
    );

    tc_log("[LEVEL_UP] User {$userId} upgraded from {$currentLevel} to {$trueLevel} (+{$levelsGained} levels)", 'info');

    return true;
}
```

#### `toggleLevelHolding(int $userId, bool $enabled): bool`
```php
/**
 * Enable/disable level holding
 */
function toggleLevelHolding(int $userId, bool $enabled): bool {
    global $db;
    if (!$db) return false;

    return $db->execute(
        "UPDATE users SET level_holding_enabled = :enabled WHERE id = :id",
        ['enabled' => $enabled ? 1 : 0, 'id' => $userId]
    );
}
```

#### `getXPProgress(int $userId): array`
```php
/**
 * Get XP progress for "Fortune Teller" style reveal
 * Returns percentage to next level
 */
function getXPProgress(int $userId): array {
    $user = getUser($userId);
    if (!$user) return ['percent' => 0, 'holding' => false];

    $currentXP = (int)$user['xp'];
    $displayLevel = (int)$user['level'];
    $trueLevel = calculateLevel($currentXP);

    // If level holding and can upgrade, show 100%
    if ($trueLevel > $displayLevel) {
        return [
            'percent' => 100,
            'holding' => true,
            'levels_ready' => $trueLevel - $displayLevel
        ];
    }

    // Calculate progress to next level
    $currentLevelXP = getXPForLevel($displayLevel);
    $nextLevelXP = getXPForLevel($displayLevel + 1);
    $xpNeeded = $nextLevelXP - $currentLevelXP;
    $xpProgress = $currentXP - $currentLevelXP;

    $percent = ($xpNeeded > 0) ? min(99, floor(($xpProgress / $xpNeeded) * 100)) : 0;

    return [
        'percent' => $percent,
        'holding' => false,
        'levels_ready' => 0
    ];
}
```

### 2. XP Awarding with Torn-faithful Weighting

#### `awardXPFromAttack(int $userId, string $attackType, int $victimLevel, int $combatLogId): int`
```php
/**
 * Award XP from attack with Torn-faithful weighting
 *
 * Leave = 1.0x base
 * Mug = 0.55x base
 * Hospitalize = 0.40x base
 *
 * Higher victim level = more XP
 */
function awardXPFromAttack(int $userId, string $attackType, int $victimLevel, int $combatLogId): int {
    global $db;
    if (!$db) return 0;

    $user = getUser($userId);
    if (!$user) return 0;

    $attackerLevel = (int)$user['level'];

    // Base XP calculation (tunable)
    $baseXP = 10 + ($victimLevel * 2); // Simple formula, adjust as needed

    // Attack type multipliers (Torn-faithful)
    $multipliers = [
        'leave' => 1.00,
        'mug' => 0.55,
        'hospitalize' => 0.40
    ];

    $multiplier = $multipliers[$attackType] ?? 0.40;

    // Victim level bonus (higher level = more XP)
    if ($victimLevel > $attackerLevel) {
        $levelDiff = $victimLevel - $attackerLevel;
        $multiplier *= (1.0 + ($levelDiff * 0.05)); // +5% per level above
    }

    $finalXP = max(1, (int)floor($baseXP * $multiplier));

    // Award XP
    awardXP($userId, $finalXP);

    // Log it
    logXPAward($userId, $finalXP, 'attack_' . $attackType, $combatLogId, $baseXP, $multiplier, $victimLevel);

    return $finalXP;
}
```

#### `logXPAward(...)`
```php
/**
 * Log XP award for anti-abuse tracking
 */
function logXPAward(
    int $userId,
    int $xpAmount,
    string $source,
    ?int $sourceId = null,
    int $baseXP = 0,
    float $multiplier = 1.0,
    ?int $victimLevel = null
): bool {
    global $db;
    if (!$db) return false;

    return $db->execute(
        "INSERT INTO xp_awards_log
         (user_id, xp_amount, source, source_id, base_xp, multiplier, victim_level, created_at)
         VALUES (:user_id, :xp, :source, :source_id, :base_xp, :multiplier, :victim_level, NOW())",
        [
            'user_id' => $userId,
            'xp' => $xpAmount,
            'source' => $source,
            'source_id' => $sourceId,
            'base_xp' => $baseXP,
            'multiplier' => $multiplier,
            'victim_level' => $victimLevel
        ]
    );
}
```

### 3. Crime Experience (CE) → Natural Nerve Bar (NNB) System

#### CE Threshold Configuration

```php
/**
 * CE thresholds for NNB increases
 * Each tier grants +5 nerve_natural_max
 *
 * Tuned to make early gains fast, later gains very slow (Torn-like)
 */
function getCEThresholds(): array {
    return [
        0 => 15,      // Base NNB (starting value)
        100 => 20,    // +5 at 100 CE
        300 => 25,    // +5 at 300 CE
        600 => 30,    // +5 at 600 CE
        1000 => 35,   // +5 at 1,000 CE
        1500 => 40,   // +5 at 1,500 CE
        2200 => 45,   // +5 at 2,200 CE
        3100 => 50,   // +5 at 3,100 CE
        4200 => 55,   // +5 at 4,200 CE
        5500 => 60,   // +5 at 5,500 CE
        7000 => 65,   // +5 at 7,000 CE
        9000 => 70,   // +5 at 9,000 CE
        11500 => 75,  // +5 at 11,500 CE
        14500 => 80,  // +5 at 14,500 CE
        18000 => 85,  // +5 at 18,000 CE
        22000 => 90,  // +5 at 22,000 CE
        27000 => 95,  // +5 at 27,000 CE
        33000 => 100, // +5 at 33,000 CE
        // Extend as needed; no hard cap (Torn-like)
    ];
}
```

#### `awardCrimeExperience(int $userId, int $ceDelta, string $reason): bool`
```php
/**
 * Award (or remove) Crime Experience
 * Recalculates Natural Nerve Bar from CE thresholds
 */
function awardCrimeExperience(int $userId, int $ceDelta, string $reason): bool {
    global $db;
    if (!$db) return false;

    $bars = getUserBars($userId);
    if (!$bars) return false;

    $oldCE = (int)($bars['crime_experience'] ?? 0);
    $newCE = max(0, $oldCE + $ceDelta);

    // Calculate new NNB from CE
    $newNNB = calculateNNBFromCE($newCE);
    $oldNNB = (int)($bars['nerve_natural_max'] ?? 15);

    // Update CE and NNB
    $db->execute(
        "UPDATE player_bars
         SET crime_experience = :ce,
             nerve_natural_max = :nnb,
             last_ce_recalc_at = NOW()
         WHERE user_id = :user_id",
        [
            'ce' => $newCE,
            'nnb' => $newNNB,
            'user_id' => $userId
        ]
    );

    // Recalculate total nerve_max (NNB + bonuses)
    recalculateNerveMax($userId);

    // Log if NNB increased
    if ($newNNB > $oldNNB) {
        tc_log("[NNB_GAIN] User {$userId} gained +5 NNB (CE: {$newCE}, NNB: {$newNNB}), reason: {$reason}", 'info');
    }

    return true;
}
```

#### `calculateNNBFromCE(int $ce): int`
```php
/**
 * Calculate Natural Nerve Bar from Crime Experience
 */
function calculateNNBFromCE(int $ce): int {
    $thresholds = getCEThresholds();

    $nnb = 15; // Base starting NNB

    foreach ($thresholds as $requiredCE => $resultingNNB) {
        if ($ce >= $requiredCE) {
            $nnb = $resultingNNB;
        } else {
            break;
        }
    }

    return $nnb;
}
```

#### `recalculateNerveMax(int $userId): bool`
```php
/**
 * Recalculate total nerve_max from NNB + all bonuses
 * Torn formula: max_nerve = NNB + merits + faction + job
 */
function recalculateNerveMax(int $userId): bool {
    global $db;
    if (!$db) return false;

    $bars = getUserBars($userId);
    if (!$bars) return false;

    $nnb = (int)($bars['nerve_natural_max'] ?? 15);
    $bonusMerits = (int)($bars['nerve_bonus_merits'] ?? 0);
    $bonusFaction = (int)($bars['nerve_bonus_faction'] ?? 0);
    $bonusJob = (int)($bars['nerve_bonus_job'] ?? 0);

    $totalMax = $nnb + $bonusMerits + $bonusFaction + $bonusJob;

    // Cap at 32,767 (Torn's hard cap)
    $totalMax = min(32767, $totalMax);

    return $db->execute(
        "UPDATE player_bars SET nerve_max = :max WHERE user_id = :user_id",
        ['max' => $totalMax, 'user_id' => $userId]
    );
}
```

### 4. Nerve Regeneration (Torn-faithful)

#### Update `regenerateUserBars()` for Torn nerve behavior

```php
// In existing regenerateUserBars() function, update nerve section:

// Nerve regeneration: 1 every 5 minutes (300 seconds) - TORN RATE
$nerveLastRegen = $bars['nerve_last_regen'] ? new DateTime($bars['nerve_last_regen']) : $now;
$nerveElapsed = $now->getTimestamp() - $nerveLastRegen->getTimestamp();
$nerveTicks = floor($nerveElapsed / 300); // 5 minutes = 300 seconds (TORN)

// Only regen if current < max (if over max, don't snap down - TORN behavior)
if ($nerveTicks > 0 && $bars['nerve_current'] < $bars['nerve_max']) {
    $nerveGain = $nerveTicks * 1;
    $newNerve = min($bars['nerve_current'] + $nerveGain, $bars['nerve_max']);
    $bars['nerve_current'] = $newNerve;
    $bars['nerve_last_regen'] = $now->format('Y-m-d H:i:s');
    $updated = true;
}

// If nerve_current > nerve_max, do NOT regen (Torn: pause regen, don't snap down)
// This happens after refills/drugs
```

### 5. Level-Gated Unlock System

#### `checkLevelGate(int $userId, string $gateName): array`
```php
/**
 * Check if player has unlocked a level-gated feature
 * Returns ['unlocked' => bool, 'required_level' => int, 'current_level' => int]
 */
function checkLevelGate(int $userId, string $gateName): array {
    global $db;
    if (!$db) {
        return ['unlocked' => false, 'required_level' => 999, 'current_level' => 1, 'error' => 'Database error'];
    }

    $user = getUser($userId);
    if (!$user) {
        return ['unlocked' => false, 'required_level' => 999, 'current_level' => 1, 'error' => 'User not found'];
    }

    $gate = $db->fetchOne(
        "SELECT required_level FROM level_gates WHERE gate_name = :gate AND is_active = 1 LIMIT 1",
        ['gate' => $gateName]
    );

    if (!$gate) {
        // Gate doesn't exist or inactive - allow by default
        return ['unlocked' => true, 'required_level' => 0, 'current_level' => (int)$user['level']];
    }

    $requiredLevel = (int)$gate['required_level'];
    $currentLevel = (int)$user['level'];
    $unlocked = $currentLevel >= $requiredLevel;

    return [
        'unlocked' => $unlocked,
        'required_level' => $requiredLevel,
        'current_level' => $currentLevel
    ];
}
```

#### `requireLevelGate(int $userId, string $gateName): void`
```php
/**
 * Require level gate or throw exception
 * Use this at the top of gated pages
 */
function requireLevelGate(int $userId, string $gateName): void {
    $check = checkLevelGate($userId, $gateName);

    if (!$check['unlocked']) {
        $_SESSION['error_flash'] = "You must be level {$check['required_level']} to access this feature. (Current: {$check['current_level']})";
        header('Location: /dashboard.php');
        exit;
    }
}
```

### 6. Player State/Permission Engine

#### `getPlayerState(int $userId): string`
```php
/**
 * Get current player state (normal, hospital, jail, traveling)
 */
function getPlayerState(int $userId): string {
    $user = getUser($userId);
    if (!$user) return 'normal';

    $state = $user['player_state'] ?? 'normal';
    $stateUntil = $user['state_until'] ?? null;

    // Check if state has expired
    if ($stateUntil && strtotime($stateUntil) < time()) {
        // State expired, reset to normal
        setPlayerState($userId, 'normal');
        return 'normal';
    }

    return $state;
}
```

#### `setPlayerState(int $userId, string $state, ?string $until = null, ?string $reason = null): bool`
```php
/**
 * Set player state (hospital, jail, traveling)
 */
function setPlayerState(int $userId, string $state, ?string $until = null, ?string $reason = null): bool {
    global $db;
    if (!$db) return false;

    $user = getUser($userId);
    if (!$user) return false;

    $previousState = $user['player_state'] ?? 'normal';

    // Update state
    $db->execute(
        "UPDATE users
         SET player_state = :state, state_until = :until
         WHERE id = :id",
        [
            'state' => $state,
            'until' => $until,
            'id' => $userId
        ]
    );

    // Log state change
    $db->execute(
        "INSERT INTO player_state_log
         (user_id, previous_state, new_state, reason, state_until, created_at)
         VALUES (:user_id, :prev, :new, :reason, :until, NOW())",
        [
            'user_id' => $userId,
            'prev' => $previousState,
            'new' => $state,
            'reason' => $reason,
            'until' => $until
        ]
    );

    tc_log("[STATE_CHANGE] User {$userId}: {$previousState} → {$state}, until: {$until}, reason: {$reason}", 'info');

    return true;
}
```

#### Permission Checks

```php
function canTrainGym(int $userId): array {
    $state = getPlayerState($userId);
    if ($state !== 'normal') {
        return ['allowed' => false, 'reason' => "Cannot train while in {$state}"];
    }

    $bars = getUserBars($userId);
    if (!$bars || $bars['energy_current'] < 5) {
        return ['allowed' => false, 'reason' => 'Not enough energy'];
    }

    return ['allowed' => true];
}

function canCommitCrime(int $userId): array {
    $state = getPlayerState($userId);
    if ($state !== 'normal') {
        return ['allowed' => false, 'reason' => "Cannot commit crimes while in {$state}"];
    }

    $bars = getUserBars($userId);
    if (!$bars || $bars['nerve_current'] < 1) {
        return ['allowed' => false, 'reason' => 'Not enough nerve'];
    }

    return ['allowed' => true];
}

function canAttack(int $userId, int $targetId): array {
    $state = getPlayerState($userId);
    if ($state !== 'normal') {
        return ['allowed' => false, 'reason' => "Cannot attack while in {$state}"];
    }

    $bars = getUserBars($userId);
    if (!$bars || $bars['energy_current'] < 10) {
        return ['allowed' => false, 'reason' => 'Not enough energy'];
    }

    // Check for attack abuse (same target repeatedly)
    if (isAttackAbuse($userId, $targetId)) {
        return ['allowed' => false, 'reason' => 'You have attacked this player too many times recently'];
    }

    return ['allowed' => true];
}
```

---

## IMPLEMENTATION PRIORITY

### Phase 1: Schema Changes (Foundation)
1. Run all ALTER TABLE commands
2. Create new tables (xp_awards_log, player_state_log, level_gates, action_cooldowns)
3. Seed level_gates data

### Phase 2: Core Functions (XP/Level)
1. Implement `getTrueLevel()`, `canUpgradeLevel()`, `upgradeLevelToTrue()`
2. Implement `getXPProgress()` for Fortune Teller
3. Implement `toggleLevelHolding()`
4. Update `awardXP()` to maintain true_level

### Phase 3: XP Weighting System
1. Implement `awardXPFromAttack()` with Torn multipliers
2. Implement `logXPAward()`
3. Update combat module to use new XP system
4. Implement crime XP, gym XP

### Phase 4: CE/NNB System
1. Implement CE threshold configuration
2. Implement `awardCrimeExperience()`
3. Implement `calculateNNBFromCE()`
4. Implement `recalculateNerveMax()`
5. Update nerve regeneration to Torn rate (5 minutes)

### Phase 5: Level Gates
1. Implement `checkLevelGate()` and `requireLevelGate()`
2. Add gates to all restricted pages

### Phase 6: Status/Permission Engine
1. Implement player state functions
2. Implement permission checks (canTrainGym, canCommitCrime, canAttack)
3. Update all modules to use permission checks

### Phase 7: UI Updates
1. Hide XP from profile (only show level)
2. Add "Upgrade" button when canUpgradeLevel() is true
3. Create Fortune Teller page
4. Add level holding toggle to settings
5. Update dashboard to show state (hospital/jail/travel)

---

## TESTING CHECKLIST

### XP/Level System
- [ ] Hidden XP (not shown in UI)
- [ ] Upgrade link appears when true_level > display_level
- [ ] Level holding works (can stay at lower level)
- [ ] Multi-level upgrade works (jump from 5 to 10 if held)
- [ ] Fortune Teller shows correct % (100% when holding)

### CE/NNB System
- [ ] Crime success awards CE
- [ ] Critical fail reduces CE
- [ ] NNB increases by +5 at thresholds
- [ ] nerve_max = NNB + bonuses
- [ ] Nerve regens at 1/5min (not 1/4min)
- [ ] Over-max nerve doesn't snap down

### Level Gates
- [ ] Level 2: Bookies locked until level 2
- [ ] Level 15: Travel locked until level 15
- [ ] All 12 gates work correctly

### XP Weighting
- [ ] Leave attack gives 1.0x XP
- [ ] Mug attack gives ~0.55x XP
- [ ] Hosp attack gives ~0.40x XP
- [ ] Higher victim level = more XP

---

## ANTI-ABUSE MEASURES

### Attack XP Farming Prevention
```php
function isAttackAbuse(int $userId, int $targetId): bool {
    global $db;
    if (!$db) return false;

    // Count attacks on same target in last hour
    $count = $db->fetchOne(
        "SELECT COUNT(*) as cnt
         FROM combat_logs
         WHERE attacker_id = :user_id
         AND defender_id = :target_id
         AND created_at > DATE_SUB(NOW(), INTERVAL 1 HOUR)",
        ['user_id' => $userId, 'target_id' => $targetId]
    );

    // Diminishing returns after 5 attacks
    return ($count['cnt'] ?? 0) >= 5;
}
```

---

**End of Specification**
