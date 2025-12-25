<?php
/**
 * TRENCH CITY V2 - PLAYER CORE (TORN-FAITHFUL)
 * Complete Torn-faithful player system implementation
 *
 * Features:
 * - Hidden XP with upgrade link (no XP bar)
 * - Level holding mechanism
 * - Crime Experience (CE) → Natural Nerve Bar (NNB)
 * - Nerve bonus layers
 * - Level-gated unlocks
 * - XP weighting for attacks
 * - Player state/permission engine
 *
 * @version 1.0
 * @date 2025-12-24
 */

declare(strict_types=1);

// ================================================================
// XP THRESHOLDS CONFIGURATION (TORN-FAITHFUL)
// ================================================================

/**
 * Get XP required for each level
 * Tuned to make level 15 achievable quickly, then progressively harder
 *
 * This is the part Torn hides - we tune it to match Torn-like pacing
 */
function getXPThresholds(): array {
    static $thresholds = null;

    if ($thresholds === null) {
        $thresholds = [];
        for ($level = 1; $level <= 100; $level++) {
            if ($level === 1) {
                $thresholds[$level] = 0;
            } else if ($level <= 15) {
                // Fast progression to level 15 (Torn behavior)
                $thresholds[$level] = (int)pow($level / 0.25, 2);
            } else {
                // Progressively harder after 15
                $thresholds[$level] = (int)pow($level / 0.20, 2);
            }
        }
    }

    return $thresholds;
}

/**
 * Calculate level from total XP (always authoritative)
 * Same formula as before but using threshold table
 */
function calculateLevel(int $xp): int {
    if ($xp <= 0) return 1;

    $thresholds = getXPThresholds();

    for ($level = 100; $level >= 1; $level--) {
        if ($xp >= $thresholds[$level]) {
            return $level;
        }
    }

    return 1;
}

/**
 * Get XP required for specific level
 */
function getXPForLevel(int $level): int {
    $thresholds = getXPThresholds();
    return $thresholds[$level] ?? $thresholds[100];
}

// ================================================================
// XP/LEVEL SYSTEM (TORN-FAITHFUL: HIDDEN XP, UPGRADE LINK)
// ================================================================

/**
 * Get true level from total XP (what level player "actually" is)
 */
function getTrueLevel(int $userId): int {
    $user = getUser($userId);
    if (!$user) return 1;
    return calculateLevel((int)$user['xp']);
}

/**
 * Get display level (may be held below true level)
 */
function getDisplayLevel(int $userId): int {
    $user = getUser($userId);
    if (!$user) return 1;
    return (int)$user['level'];
}

/**
 * Check if player can upgrade (true_level > display_level)
 * This controls when the "Upgrade" link appears (Torn behavior)
 */
function canUpgradeLevel(int $userId): bool {
    $user = getUser($userId);
    if (!$user) return false;

    $trueLevel = calculateLevel((int)$user['xp']);
    $displayLevel = (int)$user['level'];

    return $trueLevel > $displayLevel;
}

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

/**
 * Get XP progress for "Fortune Teller" style reveal
 * Returns percentage to next level (Torn behavior)
 *
 * If level holding and can upgrade: returns 100%
 * Otherwise: returns % progress to next level
 */
function getXPProgress(int $userId): array {
    $user = getUser($userId);
    if (!$user) {
        return [
            'percent' => 0,
            'holding' => false,
            'levels_ready' => 0,
            'next_level_xp' => 0,
            'current_level_xp' => 0
        ];
    }

    $currentXP = (int)$user['xp'];
    $displayLevel = (int)$user['level'];
    $trueLevel = calculateLevel($currentXP);

    // If level holding and can upgrade, show 100% (Torn behavior)
    if ($trueLevel > $displayLevel) {
        return [
            'percent' => 100,
            'holding' => true,
            'levels_ready' => $trueLevel - $displayLevel,
            'next_level_xp' => 0,
            'current_level_xp' => 0
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
        'levels_ready' => 0,
        'next_level_xp' => $nextLevelXP,
        'current_level_xp' => $currentLevelXP
    ];
}

/**
 * Award XP (updated to maintain true_level)
 */
function awardXP(int $userId, int $xpAmount): bool {
    global $db;
    if (!$db || $xpAmount <= 0) return false;

    $user = getUser($userId);
    if (!$user) return false;

    $newXP = (int)$user['xp'] + $xpAmount;
    $newTrueLevel = calculateLevel($newXP);

    // If not level holding, update display level immediately
    if (!$user['level_holding_enabled']) {
        $db->execute(
            "UPDATE users
             SET xp = :xp,
                 level = :true_level,
                 true_level = :true_level
             WHERE id = :id",
            [
                'xp' => $newXP,
                'true_level' => $newTrueLevel,
                'id' => $userId
            ]
        );
    } else {
        // Level holding: update XP and true_level, keep display level frozen
        $db->execute(
            "UPDATE users
             SET xp = :xp,
                 true_level = :true_level
             WHERE id = :id",
            [
                'xp' => $newXP,
                'true_level' => $newTrueLevel,
                'id' => $userId
            ]
        );
    }

    return true;
}

// ================================================================
// XP AWARDING WITH TORN-FAITHFUL WEIGHTING
// ================================================================

/**
 * Award XP from attack with Torn-faithful weighting
 *
 * Torn weighting:
 * - Leave = 1.0x base (100% XP)
 * - Mug = 0.55x base (55% XP)
 * - Hospitalize = 0.40x base (40% XP)
 *
 * Higher victim level = more XP
 *
 * @param int $userId Attacker user ID
 * @param string $attackType 'leave', 'mug', or 'hospitalize'
 * @param int $victimLevel Victim's level
 * @param int $combatLogId Combat log ID for tracking
 * @return int XP awarded
 */
function awardXPFromAttack(int $userId, string $attackType, int $victimLevel, int $combatLogId): int {
    global $db;
    if (!$db) return 0;

    $user = getUser($userId);
    if (!$user) return 0;

    $attackerLevel = (int)$user['level'];

    // Base XP calculation (tunable formula)
    $baseXP = 10 + ($victimLevel * 2);

    // Attack type multipliers (Torn-faithful)
    $multipliers = [
        'leave' => 1.00,
        'mug' => 0.55,
        'hospitalize' => 0.40
    ];

    $multiplier = $multipliers[$attackType] ?? 0.40;

    // Victim level bonus (higher level victim = more XP)
    if ($victimLevel > $attackerLevel) {
        $levelDiff = $victimLevel - $attackerLevel;
        $multiplier *= (1.0 + ($levelDiff * 0.05)); // +5% per level above attacker
    }

    // Diminishing returns for lower level victims
    if ($victimLevel < $attackerLevel) {
        $levelDiff = $attackerLevel - $victimLevel;
        $multiplier *= max(0.1, (1.0 - ($levelDiff * 0.05))); // -5% per level below
    }

    $finalXP = max(1, (int)floor($baseXP * $multiplier));

    // Award XP
    awardXP($userId, $finalXP);

    // Log it for anti-abuse tracking
    logXPAward($userId, $finalXP, 'attack_' . $attackType, $combatLogId, $baseXP, $multiplier, $victimLevel);

    return $finalXP;
}

/**
 * Award XP from crime
 */
function awardXPFromCrime(int $userId, int $crimeId, bool $success): int {
    if (!$success) return 0;

    // Base XP from crime (tunable)
    $baseXP = 5;
    $finalXP = $baseXP;

    awardXP($userId, $finalXP);
    logXPAward($userId, $finalXP, 'crime', $crimeId, $baseXP, 1.0, null);

    return $finalXP;
}

/**
 * Award XP from gym training
 */
function awardXPFromGym(int $userId, int $trainingLogId, int $statGain): int {
    // XP based on stat gain
    $baseXP = $statGain;
    $finalXP = $baseXP;

    awardXP($userId, $finalXP);
    logXPAward($userId, $finalXP, 'gym', $trainingLogId, $baseXP, 1.0, null);

    return $finalXP;
}

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

// ================================================================
// CRIME EXPERIENCE (CE) → NATURAL NERVE BAR (NNB) SYSTEM
// ================================================================

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
        40000 => 105, // Continue extending as needed
        48000 => 110,
        57000 => 115,
        67000 => 120,
        // No hard cap - Torn has no published max
    ];
}

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
    } else if ($newNNB < $oldNNB) {
        tc_log("[NNB_LOSS] User {$userId} lost -5 NNB (CE: {$newCE}, NNB: {$newNNB}), reason: {$reason}", 'warning');
    }

    return true;
}

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

/**
 * Set nerve bonus from source (merits, faction, job)
 */
function setNerveBonus(int $userId, string $source, int $bonus): bool {
    global $db;
    if (!$db) return false;

    $validSources = ['merits', 'faction', 'job'];
    if (!in_array($source, $validSources)) {
        return false;
    }

    $column = 'nerve_bonus_' . $source;

    $db->execute(
        "UPDATE player_bars SET {$column} = :bonus WHERE user_id = :user_id",
        ['bonus' => $bonus, 'user_id' => $userId]
    );

    // Recalculate total nerve_max
    return recalculateNerveMax($userId);
}

// ================================================================
// LEVEL-GATED UNLOCK SYSTEM
// ================================================================

/**
 * Check if player has unlocked a level-gated feature
 * Returns ['unlocked' => bool, 'required_level' => int, 'current_level' => int]
 */
function checkLevelGate(int $userId, string $gateName): array {
    global $db;
    if (!$db) {
        return [
            'unlocked' => false,
            'required_level' => 999,
            'current_level' => 1,
            'error' => 'Database error'
        ];
    }

    $user = getUser($userId);
    if (!$user) {
        return [
            'unlocked' => false,
            'required_level' => 999,
            'current_level' => 1,
            'error' => 'User not found'
        ];
    }

    $gate = $db->fetchOne(
        "SELECT required_level FROM level_gates WHERE gate_name = :gate AND is_active = 1 LIMIT 1",
        ['gate' => $gateName]
    );

    if (!$gate) {
        // Gate doesn't exist or inactive - allow by default
        return [
            'unlocked' => true,
            'required_level' => 0,
            'current_level' => (int)$user['level']
        ];
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

/**
 * Require level gate or redirect with error
 * Use this at the top of gated pages
 */
function requireLevelGate(int $userId, string $gateName): void {
    $check = checkLevelGate($userId, $gateName);

    if (!$check['unlocked']) {
        $_SESSION['error_flash'] = "You must be level {$check['required_level']} to access this feature. (Current: Level {$check['current_level']})";
        header('Location: /dashboard.php');
        exit;
    }
}

// ================================================================
// PLAYER STATE/PERMISSION ENGINE
// ================================================================

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

/**
 * Permission: Can train gym?
 */
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

/**
 * Permission: Can commit crime?
 */
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

/**
 * Permission: Can attack another player?
 */
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

// ================================================================
// ANTI-ABUSE MEASURES
// ================================================================

/**
 * Check if attacking same target too frequently (XP farming prevention)
 */
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
    return ((int)($count['cnt'] ?? 0)) >= 5;
}

/**
 * Check anomalous XP gain rate (anti-bot detection)
 */
function detectAnomalousXPGain(int $userId): bool {
    global $db;
    if (!$db) return false;

    // Count XP gains in last 10 minutes
    $count = $db->fetchOne(
        "SELECT COUNT(*) as cnt, SUM(xp_amount) as total_xp
         FROM xp_awards_log
         WHERE user_id = :user_id
         AND created_at > DATE_SUB(NOW(), INTERVAL 10 MINUTE)",
        ['user_id' => $userId]
    );

    $recentXP = (int)($count['total_xp'] ?? 0);
    $recentCount = (int)($count['cnt'] ?? 0);

    // Flag if more than 100 XP in 10 minutes from more than 20 actions
    if ($recentXP > 100 && $recentCount > 20) {
        tc_log("[ANOMALY] User {$userId} gained {$recentXP} XP from {$recentCount} actions in 10 minutes", 'warning');
        return true;
    }

    return false;
}

// ================================================================
// NERVE REGENERATION (TORN-FAITHFUL: 1 per 5 minutes)
// ================================================================

/**
 * Update existing regenerateUserBars() to use Torn nerve rate
 * This should replace the nerve section in helpers.php:regenerateUserBars()
 *
 * NOTE: This is documentation - actual update happens in helpers.php
 */
function tornFaithfulNerveRegen(array $bars, DateTime $now): array {
    // Nerve regeneration: 1 every 5 minutes (300 seconds) - TORN RATE
    $nerveLastRegen = $bars['nerve_last_regen'] ? new DateTime($bars['nerve_last_regen']) : $now;
    $nerveElapsed = $now->getTimestamp() - $nerveLastRegen->getTimestamp();
    $nerveTicks = floor($nerveElapsed / 300); // 5 minutes = 300 seconds (TORN)

    // Only regen if current < max (if over max, don't snap down - TORN behavior)
    $updated = false;
    if ($nerveTicks > 0 && $bars['nerve_current'] < $bars['nerve_max']) {
        $nerveGain = $nerveTicks * 1;
        $newNerve = min($bars['nerve_current'] + $nerveGain, $bars['nerve_max']);
        $bars['nerve_current'] = $newNerve;
        $bars['nerve_last_regen'] = $now->format('Y-m-d H:i:s');
        $updated = true;
    }

    // If nerve_current > nerve_max, do NOT regen (Torn: pause regen, don't snap down)
    // This happens after refills/drugs

    return ['bars' => $bars, 'updated' => $updated];
}

// ================================================================
// END OF PLAYER CORE
// ================================================================
