<?php
declare(strict_types=1);

if (!function_exists('tcPropertyNow')) {
    function tcPropertyNow(): DateTime
    {
        return new DateTime('now');
    }
}

if (!function_exists('tcPropertyJson')) {
    function tcPropertyJson(array $value): string
    {
        $encoded = json_encode($value);
        return $encoded === false ? '{}' : $encoded;
    }
}

if (!function_exists('tcPropertyCost')) {
    function tcPropertyCost(array $property): float
    {
        if (isset($property['base_cost'])) {
            return (float)$property['base_cost'];
        }
        if (isset($property['price'])) {
            return (float)$property['price'];
        }
        return (float)($property['cost'] ?? 0);
    }
}

if (!function_exists('tcPropertyUpkeep')) {
    function tcPropertyUpkeep(array $property): float
    {
        if (isset($property['base_upkeep'])) {
            return (float)$property['base_upkeep'];
        }
        if (isset($property['daily_upkeep'])) {
            return (float)$property['daily_upkeep'];
        }
        return (float)($property['upkeep'] ?? 0);
    }
}

if (!function_exists('tcPropertyBaseHappy')) {
    function tcPropertyBaseHappy(array $property): int
    {
        if (isset($property['base_happy'])) {
            return (int)$property['base_happy'];
        }
        if (isset($property['happy'])) {
            return (int)$property['happy'];
        }
        return 0;
    }
}

if (!function_exists('tcPropertyGetUserProperty')) {
    function tcPropertyGetUserProperty(int $userPropertyId): ?array
    {
        global $db;
        return $db->fetchOne('SELECT * FROM user_properties WHERE id = :id LIMIT 1', ['id' => $userPropertyId]) ?: null;
    }
}

if (!function_exists('tcPropertyGetProperty')) {
    function tcPropertyGetProperty(int $propertyId): ?array
    {
        global $db;
        return $db->fetchOne('SELECT * FROM properties WHERE id = :id LIMIT 1', ['id' => $propertyId]) ?: null;
    }
}

if (!function_exists('tcGetUserOwnedProperties')) {
    function tcGetUserOwnedProperties(int $userId): array
    {
        global $db;
        return $db->fetchAll(
            'SELECT up.*, p.name AS property_name, p.tier AS property_tier, p.base_happy AS property_happy,
                    p.base_upkeep AS property_upkeep, p.base_cost AS property_cost, p.is_active AS property_active
             FROM user_properties up
             JOIN properties p ON p.id = up.property_id
             WHERE up.user_id = :uid
             ORDER BY up.is_primary DESC, up.id DESC',
            ['uid' => $userId]
        ) ?: [];
    }
}

if (!function_exists('tcPropertyGetOwnedProperties')) {
    function tcPropertyGetOwnedProperties(int $userId): array
    {
        return tcGetUserOwnedProperties($userId);
    }
}

if (!function_exists('tcPropertyGetActiveLeaseForTenant')) {
    function tcPropertyGetActiveLeaseForTenant(int $userId): ?array
    {
        global $db;
        return $db->fetchOne(
            'SELECT * FROM property_leases
             WHERE tenant_user_id = :uid AND status = \'active\' AND end_at > NOW()
             ORDER BY end_at DESC LIMIT 1',
            ['uid' => $userId]
        ) ?: null;
    }
}

if (!function_exists('tcPropertyGetActiveLeaseForUserProperty')) {
    function tcPropertyGetActiveLeaseForUserProperty(int $userPropertyId): ?array
    {
        global $db;
        return $db->fetchOne(
            'SELECT * FROM property_leases
             WHERE user_property_id = :upid AND status = \'active\' AND end_at > NOW()
             ORDER BY end_at DESC LIMIT 1',
            ['upid' => $userPropertyId]
        ) ?: null;
    }
}

if (!function_exists('tcGetCurrentResidence')) {
    function tcGetCurrentResidence(int $userId): array
    {
        $lease = tcPropertyGetActiveLeaseForTenant($userId);
        if ($lease) {
            $userProperty = tcPropertyGetUserProperty((int)$lease['user_property_id']);
            if ($userProperty) {
                return [
                    'mode' => 'tenant',
                    'user_property_id' => (int)$lease['user_property_id'],
                    'owner_user_id' => (int)($lease['landlord_user_id'] ?? 0),
                    'property_id' => (int)$userProperty['property_id'],
                    'lease' => $lease,
                ];
            }
        }

        global $db;
        $row = $db->fetchOne(
            'SELECT * FROM user_properties WHERE user_id = :uid AND is_primary = 1 LIMIT 1',
            ['uid' => $userId]
        );
        if ($row) {
            return [
                'mode' => 'owned',
                'user_property_id' => (int)$row['id'],
                'owner_user_id' => (int)$row['user_id'],
                'property_id' => (int)$row['property_id'],
                'lease' => null,
            ];
        }

        return [
            'mode' => 'none',
        ];
    }
}

if (!function_exists('tcPropertyGetOccupant')) {
    function tcPropertyGetOccupant(int $userPropertyId, int $userId): ?array
    {
        global $db;
        return $db->fetchOne(
            'SELECT * FROM property_occupants WHERE user_property_id = :upid AND user_id = :uid AND left_at IS NULL LIMIT 1',
            ['upid' => $userPropertyId, 'uid' => $userId]
        ) ?: null;
    }
}

if (!function_exists('tcUserHasOccupantAccess')) {
    function tcUserHasOccupantAccess(int $userId, int $userPropertyId): bool
    {
        $userProperty = tcPropertyGetUserProperty($userPropertyId);
        if ($userProperty && (int)$userProperty['user_id'] === $userId) {
            return true;
        }
        return (bool)tcPropertyGetOccupant($userPropertyId, $userId);
    }
}

if (!function_exists('tcOccupantPermissions')) {
    function tcOccupantPermissions(int $userId, int $userPropertyId): array
    {
        $userProperty = tcPropertyGetUserProperty($userPropertyId);
        if ($userProperty && (int)$userProperty['user_id'] === $userId) {
            return [
                'role' => 'owner',
                'can_use_vault' => true,
                'can_manage_staff' => true,
                'can_manage_upgrades' => true,
            ];
        }

        $occ = tcPropertyGetOccupant($userPropertyId, $userId);
        if (!$occ) {
            return [
                'role' => 'none',
                'can_use_vault' => false,
                'can_manage_staff' => false,
                'can_manage_upgrades' => false,
            ];
        }

        return [
            'role' => (string)($occ['role'] ?? 'occupant'),
            'can_use_vault' => (int)($occ['can_use_vault'] ?? 0) === 1,
            'can_manage_staff' => (int)($occ['can_manage_staff'] ?? 0) === 1,
            'can_manage_upgrades' => (int)($occ['can_manage_upgrades'] ?? 0) === 1,
        ];
    }
}

if (!function_exists('tcCanUseVault')) {
    function tcCanUseVault(int $userId, int $userPropertyId): bool
    {
        $userProperty = tcPropertyGetUserProperty($userPropertyId);
        if ($userProperty && (int)$userProperty['user_id'] === $userId) {
            return true;
        }

        $occ = tcPropertyGetOccupant($userPropertyId, $userId);
        if (!$occ) {
            return false;
        }

        $role = (string)($occ['role'] ?? '');
        if ($role === 'tenant') {
            return false;
        }

        return (int)($occ['can_use_vault'] ?? 0) === 1;
    }
}

if (!function_exists('tcPropertyCanUseVault')) {
    function tcPropertyCanUseVault(int $userId, int $userPropertyId): bool
    {
        return tcCanUseVault($userId, $userPropertyId);
    }
}

if (!function_exists('tcPropertyCanManageStaff')) {
    function tcPropertyCanManageStaff(int $userId, int $userPropertyId): bool
    {
        $permissions = tcOccupantPermissions($userId, $userPropertyId);
        return $permissions['can_manage_staff'] ?? false;
    }
}

if (!function_exists('tcPropertyGetUpgrades')) {
    function tcPropertyGetUpgrades(int $userPropertyId): array
    {
        global $db;
        return $db->fetchAll(
            'SELECT pu.*, uc.upgrade_key, uc.name AS upgrade_name, uc.description AS upgrade_description,
                    uc.happy_bonus, uc.vault_cap, uc.gym_gain_bonus_pct, uc.damage_bonus_pct,
                    uc.life_regen_bonus_pct, uc.travel_time_mult, uc.travel_cost_mult, uc.travel_item_bonus,
                    uc.max_level, uc.cost
             FROM property_upgrades pu
             JOIN property_upgrade_catalog uc ON uc.id = pu.upgrade_catalog_id
             WHERE pu.user_property_id = :upid
             ORDER BY uc.name ASC',
            ['upid' => $userPropertyId]
        ) ?: [];
    }
}

if (!function_exists('tcPropertyGetStaff')) {
    function tcPropertyGetStaff(int $userPropertyId): array
    {
        global $db;
        return $db->fetchAll(
            'SELECT ps.*, sc.staff_key, sc.name AS staff_name, sc.description AS staff_description,
                    sc.happy_bonus, sc.daily_cost, sc.cost_upfront
             FROM property_staff ps
             JOIN property_staff_catalog sc ON sc.id = ps.staff_catalog_id
             WHERE ps.user_property_id = :upid AND (ps.ended_at IS NULL OR ps.is_active = 1)
             ORDER BY sc.name ASC',
            ['upid' => $userPropertyId]
        ) ?: [];
    }
}

if (!function_exists('tcGetPropertyTotals')) {
    function tcGetPropertyTotals(int $userPropertyId): array
    {
        $userProperty = tcPropertyGetUserProperty($userPropertyId);
        if (!$userProperty) {
            return [];
        }

        $property = tcPropertyGetProperty((int)$userProperty['property_id']);
        if (!$property) {
            return [];
        }

        $upgrades = tcPropertyGetUpgrades($userPropertyId);
        $staff = tcPropertyGetStaff($userPropertyId);

        $baseHappy = tcPropertyBaseHappy($property);
        $upgradeHappy = 0;
        foreach ($upgrades as $upgrade) {
            $level = (int)($upgrade['level'] ?? 1);
            $upgradeHappy += (int)($upgrade['happy_bonus'] ?? 0) * max(1, $level);
        }
        $staffHappy = 0;
        foreach ($staff as $member) {
            $staffHappy += (int)($member['happy_bonus'] ?? 0);
        }
        $totalHappy = max(0, $baseHappy + $upgradeHappy + $staffHappy);

        $baseUpkeep = tcPropertyUpkeep($property);
        $staffUpkeep = 0.0;
        foreach ($staff as $member) {
            $staffUpkeep += (float)($member['daily_cost'] ?? 0);
        }

        $vaultCap = 0.0;
        $gymBonus = 0.0;
        $damageBonus = 0.0;
        $lifeRegen = 0.0;
        $travelTime = 1.0;
        $travelCost = 1.0;
        $travelItem = 0;

        foreach ($upgrades as $upgrade) {
            $vaultCap = max($vaultCap, (float)($upgrade['vault_cap'] ?? 0));
            $gymBonus += (float)($upgrade['gym_gain_bonus_pct'] ?? 0);
            $damageBonus += (float)($upgrade['damage_bonus_pct'] ?? 0);
            $lifeRegen += (float)($upgrade['life_regen_bonus_pct'] ?? 0);

            $timeMult = (float)($upgrade['travel_time_mult'] ?? 0);
            if ($timeMult > 0) {
                $travelTime = min($travelTime, $timeMult);
            }
            $costMult = (float)($upgrade['travel_cost_mult'] ?? 0);
            if ($costMult > 0) {
                $travelCost = min($travelCost, $costMult);
            }
            $travelItem = max($travelItem, (int)($upgrade['travel_item_bonus'] ?? 0));
        }

        return [
            'user_property' => $userProperty,
            'property' => $property,
            'upgrades' => $upgrades,
            'staff' => $staff,
            'total_happy' => $totalHappy,
            'base_upkeep_daily' => $baseUpkeep,
            'staff_upkeep_daily' => $staffUpkeep,
            'daily_upkeep_total' => $baseUpkeep + $staffUpkeep,
            'vault_cap' => $vaultCap,
            'perks' => [
                'gym_gain_bonus_pct' => $gymBonus,
                'damage_bonus_pct' => $damageBonus,
                'life_regen_bonus_pct' => $lifeRegen,
                'travel_time_mult' => $travelTime,
                'travel_cost_mult' => $travelCost,
                'travel_item_bonus' => $travelItem,
            ],
        ];
    }
}

if (!function_exists('tcCalcEffectiveHappy')) {
    function tcCalcEffectiveHappy(float $baseCost, int $totalHappy, float $upkeepDebt): int
    {
        $threshold = $baseCost * 0.10;
        if ($baseCost <= 0) {
            return max(0, $totalHappy);
        }

        if ($upkeepDebt <= $threshold) {
            return max(0, $totalHappy);
        }

        $ratio = (($upkeepDebt - $threshold) / $baseCost) * 2.5;
        $ratio = max(0.0, min(1.0, $ratio));
        return (int)max(0, floor($totalHappy * (1 - $ratio)));
    }
}

if (!function_exists('tcRecalcAndCacheResidence')) {
    function tcRecalcAndCacheResidence(int $userPropertyId): void
    {
        $totals = tcGetPropertyTotals($userPropertyId);
        if (!$totals) {
            return;
        }

        $userProperty = $totals['user_property'];
        $property = $totals['property'];
        $baseCost = tcPropertyCost($property);
        $upkeepDebt = (float)($userProperty['upkeep_debt'] ?? 0);
        $effectiveHappy = tcCalcEffectiveHappy($baseCost, (int)$totals['total_happy'], $upkeepDebt);
        $vaultCap = (float)($totals['vault_cap'] ?? 0);

        global $db;
        $db->execute(
            'UPDATE user_properties SET cached_effective_happy = :happy, last_happy_calc_at = NOW(), vault_cap = :cap WHERE id = :id',
            ['happy' => $effectiveHappy, 'cap' => $vaultCap, 'id' => $userPropertyId]
        );
    }
}

if (!function_exists('tcPropertyLogTransaction')) {
    function tcPropertyLogTransaction(int $userId, float $amount, string $type, array $meta): void
    {
        global $db;
        $db->execute(
            'INSERT INTO property_transactions (user_id, amount, type, meta_json, created_at)
             VALUES (:uid, :amount, :type, :meta, NOW())',
            [
                'uid' => $userId,
                'amount' => $amount,
                'type' => $type,
                'meta' => tcPropertyJson($meta),
            ]
        );
    }
}

if (!function_exists('tcChargeDailyUpkeepIfDue')) {
    function tcChargeDailyUpkeepIfDue(int $userPropertyId): void
    {
        $userProperty = tcPropertyGetUserProperty($userPropertyId);
        if (!$userProperty) {
            return;
        }

        $property = tcPropertyGetProperty((int)$userProperty['property_id']);
        if (!$property) {
            return;
        }

        $movedIn = !empty($userProperty['moved_in_at']);
        $lease = tcPropertyGetActiveLeaseForUserProperty($userPropertyId);
        if (!$movedIn && !$lease) {
            return;
        }

        $today = (new DateTime('today'))->format('Y-m-d');
        global $db;
        $existing = $db->fetchOne(
            'SELECT id FROM property_upkeep_ledger WHERE user_property_id = :upid AND ledger_date = :day LIMIT 1',
            ['upid' => $userPropertyId, 'day' => $today]
        );
        if ($existing) {
            return;
        }

        $totals = tcGetPropertyTotals($userPropertyId);
        if (!$totals) {
            return;
        }

        $charge = (float)($totals['daily_upkeep_total'] ?? 0);
        if ($charge < 0) {
            $charge = 0.0;
        }

        $db->execute(
            'INSERT INTO property_upkeep_ledger (user_property_id, amount, reason, ledger_date, created_at)
             VALUES (:upid, :amount, :reason, :day, NOW())',
            [
                'upid' => $userPropertyId,
                'amount' => $charge,
                'reason' => 'daily_upkeep',
                'day' => $today,
            ]
        );

        $db->execute(
            'UPDATE user_properties SET upkeep_debt = COALESCE(upkeep_debt, 0) + :amount WHERE id = :id',
            ['amount' => $charge, 'id' => $userPropertyId]
        );

        tcPropertyLogTransaction((int)$userProperty['user_id'], $charge, 'upkeep_charge', [
            'user_property_id' => $userPropertyId,
            'ledger_date' => $today,
        ]);

        tcRecalcAndCacheResidence($userPropertyId);
    }
}

if (!function_exists('tcPropertyTickForUser')) {
    function tcPropertyTickForUser(int $userId): void
    {
        $res = tcGetCurrentResidence($userId);
        if (($res['mode'] ?? 'none') === 'none') {
            return;
        }

        $userPropertyId = (int)($res['user_property_id'] ?? 0);
        if ($userPropertyId <= 0) {
            return;
        }

        tcChargeDailyUpkeepIfDue($userPropertyId);
    }
}

if (!function_exists('tcExpireLeasesIfNeeded')) {
    function tcExpireLeasesIfNeeded(): void
    {
        global $db;
        $expired = $db->fetchAll(
            'SELECT id, user_property_id FROM property_leases WHERE status = \'active\' AND end_at <= NOW()'
        ) ?: [];

        foreach ($expired as $lease) {
            $leaseId = (int)($lease['id'] ?? 0);
            $userPropertyId = (int)($lease['user_property_id'] ?? 0);
            if ($leaseId <= 0 || $userPropertyId <= 0) {
                continue;
            }
            $db->execute(
                'UPDATE property_leases SET status = \'ended\', ended_at = NOW() WHERE id = :id',
                ['id' => $leaseId]
            );
            $db->execute(
                'UPDATE property_occupants SET left_at = NOW() WHERE user_property_id = :upid AND role = \'tenant\' AND left_at IS NULL',
                ['upid' => $userPropertyId]
            );
        }
    }
}

if (!function_exists('tcPropertyLeaseEndAt')) {
    function tcPropertyLeaseEndAt(int $days): string
    {
        $dt = new DateTime('now');
        $dt->modify('+' . $days . ' days');
        $dt->setTime(3, 30, 0);
        return $dt->format('Y-m-d H:i:s');
    }
}

if (!function_exists('tcGetPropertyPerks')) {
    function tcGetPropertyPerks(int $userId): array
    {
        $residence = tcGetCurrentResidence($userId);
        if (($residence['mode'] ?? 'none') === 'none') {
            return [
                'gym_gain_bonus_pct' => 0.0,
                'damage_bonus_pct' => 0.0,
                'life_regen_bonus_pct' => 0.0,
                'travel_time_mult' => 1.0,
                'travel_cost_mult' => 1.0,
                'travel_item_bonus' => 0,
            ];
        }

        $totals = tcGetPropertyTotals((int)$residence['user_property_id']);
        if (!$totals) {
            return [
                'gym_gain_bonus_pct' => 0.0,
                'damage_bonus_pct' => 0.0,
                'life_regen_bonus_pct' => 0.0,
                'travel_time_mult' => 1.0,
                'travel_cost_mult' => 1.0,
                'travel_item_bonus' => 0,
            ];
        }

        return $totals['perks'];
    }
}

if (!function_exists('tcPropertyGetUpgradesSnapshot')) {
    function tcPropertyGetUpgradesSnapshot(int $userPropertyId): array
    {
        $upgrades = tcPropertyGetUpgrades($userPropertyId);
        $snapshot = [];
        foreach ($upgrades as $upgrade) {
            $snapshot[] = [
                'upgrade_key' => (string)($upgrade['upgrade_key'] ?? ''),
                'name' => (string)($upgrade['upgrade_name'] ?? ''),
                'level' => (int)($upgrade['level'] ?? 1),
            ];
        }
        return $snapshot;
    }
}

if (!function_exists('tcPropertyGetCurrentResidenceDetails')) {
    function tcPropertyGetCurrentResidenceDetails(int $userId): ?array
    {
        $res = tcGetCurrentResidence($userId);
        if (($res['mode'] ?? 'none') === 'none') {
            return null;
        }

        $userProperty = tcPropertyGetUserProperty((int)$res['user_property_id']);
        if (!$userProperty) {
            return null;
        }

        $property = tcPropertyGetProperty((int)$userProperty['property_id']);
        if (!$property) {
            return null;
        }

        $upgrades = tcPropertyGetUpgrades((int)$userProperty['id']);
        $staff = tcPropertyGetStaff((int)$userProperty['id']);

        return [
            'residence' => $res,
            'user_property' => $userProperty,
            'property' => $property,
            'upgrades' => $upgrades,
            'staff' => $staff,
        ];
    }
}
