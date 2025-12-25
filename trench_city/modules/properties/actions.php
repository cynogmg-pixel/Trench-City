<?php
declare(strict_types=1);

require_once __DIR__ . '/../../core/bootstrap.php';
requireLogin();

require_once __DIR__ . '/properties_service.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /properties.php');
    exit;
}

$action = $_POST['action'] ?? '';
$csrf = $_POST['csrf_token'] ?? '';
if (!csrf_check($csrf)) {
    $_SESSION['property_flash'] = ['type' => 'danger', 'message' => 'Invalid request token.'];
    header('Location: /properties.php');
    exit;
}

$userId = currentUserId();
$user = getUser($userId);
if (!$user) {
    header('Location: /login.php');
    exit;
}

global $db;

function tcPropertyFlash(string $type, string $message): void
{
    $_SESSION['property_flash'] = ['type' => $type, 'message' => $message];
}

function tcPropertyRedirect(): void
{
    $fallback = '/properties.php';
    $target = $_SERVER['HTTP_REFERER'] ?? $fallback;
    header('Location: ' . $target);
    exit;
}

function tcPropertyCharge(int $userId, float $amount, string $paySource = 'auto'): bool
{
    global $db;
    $row = $db->fetchOne('SELECT cash, bank_balance FROM users WHERE id = :id LIMIT 1', ['id' => $userId]);
    if (!$row) {
        return false;
    }

    $cash = (float)($row['cash'] ?? 0);
    $bank = (float)($row['bank_balance'] ?? 0);
    if (($cash + $bank) < $amount) {
        return false;
    }

    $useCash = 0.0;
    $useBank = 0.0;
    if ($paySource === 'cash') {
        if ($cash < $amount) {
            return false;
        }
        $useCash = $amount;
    } elseif ($paySource === 'bank') {
        if ($bank < $amount) {
            return false;
        }
        $useBank = $amount;
    } else {
        $useCash = min($cash, $amount);
        $remaining = $amount - $useCash;
        $useBank = max(0.0, $remaining);
    }

    $db->execute(
        'UPDATE users SET cash = cash - :cash, bank_balance = bank_balance - :bank WHERE id = :id',
        ['cash' => $useCash, 'bank' => $useBank, 'id' => $userId]
    );
    return true;
}

function tcPropertyCredit(int $userId, float $amount): void
{
    global $db;
    $db->execute(
        'UPDATE users SET cash = cash + :amount WHERE id = :id',
        ['amount' => $amount, 'id' => $userId]
    );
}

try {
    switch ($action) {
        case 'buy_estate_property': {
            $propertyId = (int)($_POST['property_id'] ?? 0);
            if ($propertyId <= 0) {
                throw new RuntimeException('Invalid property.');
            }

            $property = $db->fetchOne('SELECT * FROM properties WHERE id = :id AND is_active = 1 LIMIT 1', ['id' => $propertyId]);
            if (!$property) {
                throw new RuntimeException('Property unavailable.');
            }

            $cost = tcPropertyCost($property);
            if ($cost <= 0) {
                throw new RuntimeException('Invalid property cost.');
            }

            $db->beginTransaction();
            if (!tcPropertyCharge($userId, $cost, (string)($_POST['pay_source'] ?? 'auto'))) {
                $db->rollBack();
                throw new RuntimeException('Insufficient funds.');
            }

            $primary = $db->fetchOne('SELECT id FROM user_properties WHERE user_id = :uid AND is_primary = 1 LIMIT 1', ['uid' => $userId]);
            $isPrimary = $primary ? 0 : 1;
            if ($isPrimary === 1) {
                $db->execute('UPDATE user_properties SET is_primary = 0 WHERE user_id = :uid', ['uid' => $userId]);
            }

            $db->execute(
                'INSERT INTO user_properties (user_id, property_id, is_primary, moved_in_at, upkeep_debt, vault_balance, vault_cap, cached_effective_happy, last_happy_calc_at)
                 VALUES (:uid, :pid, :primary, :moved, 0, 0, 0, 0, NULL)',
                [
                    'uid' => $userId,
                    'pid' => $propertyId,
                    'primary' => $isPrimary,
                    'moved' => $isPrimary === 1 ? date('Y-m-d H:i:s') : null,
                ]
            );

            tcPropertyLogTransaction($userId, $cost, 'purchase', [
                'property_id' => $propertyId,
                'source' => 'estate_agents',
            ]);

            $db->commit();
            tcPropertyFlash('success', 'Property purchased successfully.');
            break;
        }

        case 'move_in': {
            $userPropertyId = (int)($_POST['user_property_id'] ?? 0);
            $userProperty = tcPropertyGetUserProperty($userPropertyId);
            if (!$userProperty || (int)$userProperty['user_id'] !== $userId) {
                throw new RuntimeException('Property not found.');
            }

            $listing = $db->fetchOne('SELECT id FROM property_listings WHERE user_property_id = :upid AND status = \'active\' LIMIT 1', ['upid' => $userPropertyId]);
            if ($listing) {
                throw new RuntimeException('Remove listing before moving in.');
            }

            $lease = tcPropertyGetActiveLeaseForUserProperty($userPropertyId);
            if ($lease) {
                throw new RuntimeException('Property has an active lease.');
            }

            $db->beginTransaction();
            $db->execute('UPDATE user_properties SET is_primary = 0 WHERE user_id = :uid', ['uid' => $userId]);
            $db->execute(
                'UPDATE user_properties SET is_primary = 1, moved_in_at = NOW() WHERE id = :id',
                ['id' => $userPropertyId]
            );
            $db->commit();

            tcRecalcAndCacheResidence($userPropertyId);
            tcPropertyFlash('success', 'You moved into the property.');
            break;
        }

        case 'list_for_sale': {
            $userPropertyId = (int)($_POST['user_property_id'] ?? 0);
            $price = (float)($_POST['price'] ?? 0);
            $userProperty = tcPropertyGetUserProperty($userPropertyId);
            if (!$userProperty || (int)$userProperty['user_id'] !== $userId) {
                throw new RuntimeException('Property not found.');
            }
            if ((int)($userProperty['is_primary'] ?? 0) === 1) {
                throw new RuntimeException('Cannot list your primary residence.');
            }
            if ($price <= 0) {
                throw new RuntimeException('Price must be greater than zero.');
            }

            $lease = tcPropertyGetActiveLeaseForUserProperty($userPropertyId);
            if ($lease) {
                throw new RuntimeException('Property has an active lease.');
            }

            $activeListing = $db->fetchOne('SELECT id FROM property_listings WHERE user_property_id = :upid AND status = \'active\' LIMIT 1', ['upid' => $userPropertyId]);
            if ($activeListing) {
                throw new RuntimeException('Property already listed.');
            }

            $db->execute(
                'INSERT INTO property_listings (user_property_id, price, status, created_at)
                 VALUES (:upid, :price, \'active\', NOW())',
                ['upid' => $userPropertyId, 'price' => $price]
            );

            tcPropertyFlash('success', 'Listing created.');
            break;
        }

        case 'cancel_listing': {
            $listingId = (int)($_POST['listing_id'] ?? 0);
            $listing = $db->fetchOne('SELECT pl.*, up.user_id AS owner_id FROM property_listings pl JOIN user_properties up ON up.id = pl.user_property_id WHERE pl.id = :id LIMIT 1', ['id' => $listingId]);
            if (!$listing || (int)$listing['owner_id'] !== $userId) {
                throw new RuntimeException('Listing not found.');
            }

            $db->execute('UPDATE property_listings SET status = \'cancelled\' WHERE id = :id', ['id' => $listingId]);
            tcPropertyFlash('success', 'Listing cancelled.');
            break;
        }

        case 'buy_listing': {
            $listingId = (int)($_POST['listing_id'] ?? 0);
            $listing = $db->fetchOne('SELECT * FROM property_listings WHERE id = :id AND status = \'active\' LIMIT 1', ['id' => $listingId]);
            if (!$listing) {
                throw new RuntimeException('Listing not available.');
            }

            $userProperty = tcPropertyGetUserProperty((int)$listing['user_property_id']);
            if (!$userProperty) {
                throw new RuntimeException('Property not found.');
            }

            $sellerId = (int)$userProperty['user_id'];
            if ($sellerId === $userId) {
                throw new RuntimeException('Cannot buy your own listing.');
            }

            $lease = tcPropertyGetActiveLeaseForUserProperty((int)$listing['user_property_id']);
            if ($lease) {
                throw new RuntimeException('Property has an active lease.');
            }

            $price = (float)($listing['price'] ?? 0);
            if ($price <= 0) {
                throw new RuntimeException('Invalid price.');
            }

            $db->beginTransaction();
            if (!tcPropertyCharge($userId, $price, (string)($_POST['pay_source'] ?? 'auto'))) {
                $db->rollBack();
                throw new RuntimeException('Insufficient funds.');
            }
            tcPropertyCredit($sellerId, $price);

            $db->execute('UPDATE user_properties SET user_id = :buyer, is_primary = 0, moved_in_at = NULL WHERE id = :upid', [
                'buyer' => $userId,
                'upid' => (int)$listing['user_property_id'],
            ]);
            $db->execute('UPDATE property_listings SET status = \'sold\' WHERE id = :id', ['id' => $listingId]);
            $db->execute('UPDATE property_occupants SET left_at = NOW() WHERE user_property_id = :upid', ['upid' => (int)$listing['user_property_id']]);

            tcPropertyLogTransaction($userId, $price, 'purchase', [
                'listing_id' => $listingId,
                'seller_id' => $sellerId,
            ]);
            tcPropertyLogTransaction($sellerId, $price, 'sale', [
                'listing_id' => $listingId,
                'buyer_id' => $userId,
            ]);

            $db->commit();
            tcPropertyFlash('success', 'Property purchased.');
            break;
        }

        case 'create_rental_offer': {
            $userPropertyId = (int)($_POST['user_property_id'] ?? 0);
            $days = (int)($_POST['days'] ?? 0);
            $price = (float)($_POST['price_upfront'] ?? 0);

            $userProperty = tcPropertyGetUserProperty($userPropertyId);
            if (!$userProperty || (int)$userProperty['user_id'] !== $userId) {
                throw new RuntimeException('Property not found.');
            }
            if ((int)($userProperty['is_primary'] ?? 0) === 1) {
                throw new RuntimeException('Cannot rent your primary residence.');
            }
            if ($days <= 0 || $days > 100) {
                throw new RuntimeException('Invalid days.');
            }
            if ($price <= 0) {
                throw new RuntimeException('Invalid price.');
            }

            $listing = $db->fetchOne('SELECT id FROM property_listings WHERE user_property_id = :upid AND status = \'active\' LIMIT 1', ['upid' => $userPropertyId]);
            if ($listing) {
                throw new RuntimeException('Property is listed for sale.');
            }

            $lease = tcPropertyGetActiveLeaseForUserProperty($userPropertyId);
            if ($lease) {
                throw new RuntimeException('Property already leased.');
            }

            $snapshot = tcPropertyGetUpgradesSnapshot($userPropertyId);
            $db->execute(
                'INSERT INTO property_rental_offers (user_property_id, price_upfront, days, included_upgrades_json, status, created_at)
                 VALUES (:upid, :price, :days, :json, \'active\', NOW())',
                [
                    'upid' => $userPropertyId,
                    'price' => $price,
                    'days' => $days,
                    'json' => tcPropertyJson($snapshot),
                ]
            );

            tcPropertyFlash('success', 'Rental offer created.');
            break;
        }

        case 'accept_rental_offer': {
            $offerId = (int)($_POST['offer_id'] ?? 0);
            $offer = $db->fetchOne('SELECT * FROM property_rental_offers WHERE id = :id AND status = \'active\' LIMIT 1', ['id' => $offerId]);
            if (!$offer) {
                throw new RuntimeException('Offer not available.');
            }

            $userProperty = tcPropertyGetUserProperty((int)$offer['user_property_id']);
            if (!$userProperty) {
                throw new RuntimeException('Property not found.');
            }

            $ownerId = (int)$userProperty['user_id'];
            if ($ownerId === $userId) {
                throw new RuntimeException('Cannot rent your own property.');
            }

            $existingLease = tcPropertyGetActiveLeaseForUserProperty((int)$offer['user_property_id']);
            if ($existingLease) {
                throw new RuntimeException('Property already leased.');
            }

            $days = (int)($offer['days'] ?? 0);
            if ($days <= 0) {
                throw new RuntimeException('Invalid lease term.');
            }

            $totalDays = 0;
            $history = $db->fetchAll(
                'SELECT start_at, end_at FROM property_leases WHERE tenant_user_id = :uid AND user_property_id = :upid',
                ['uid' => $userId, 'upid' => (int)$offer['user_property_id']]
            ) ?: [];
            foreach ($history as $h) {
                $start = new DateTime((string)$h['start_at']);
                $end = new DateTime((string)$h['end_at']);
                $totalDays += (int)$start->diff($end)->days;
            }
            if (($totalDays + $days) > 100) {
                throw new RuntimeException('Lease would exceed 100 total days.');
            }

            $price = (float)($offer['price_upfront'] ?? 0);
            if ($price <= 0) {
                throw new RuntimeException('Invalid price.');
            }

            $db->beginTransaction();
            if (!tcPropertyCharge($userId, $price, (string)($_POST['pay_source'] ?? 'auto'))) {
                $db->rollBack();
                throw new RuntimeException('Insufficient funds.');
            }
            tcPropertyCredit($ownerId, $price);

            $startAt = (new DateTime('now'))->format('Y-m-d H:i:s');
            $endAt = tcPropertyLeaseEndAt($days);

            $db->execute(
                'INSERT INTO property_leases (user_property_id, tenant_user_id, landlord_user_id, offer_id, start_at, end_at, status, created_at)
                 VALUES (:upid, :tenant, :landlord, :offer, :start, :end, \'active\', NOW())',
                [
                    'upid' => (int)$offer['user_property_id'],
                    'tenant' => $userId,
                    'landlord' => $ownerId,
                    'offer' => $offerId,
                    'start' => $startAt,
                    'end' => $endAt,
                ]
            );

            $db->execute('UPDATE property_rental_offers SET status = \'accepted\' WHERE id = :id', ['id' => $offerId]);

            $existingOcc = tcPropertyGetOccupant((int)$offer['user_property_id'], $userId);
            if ($existingOcc) {
                $db->execute(
                    'UPDATE property_occupants SET role = \'tenant\', can_use_vault = 0, can_manage_staff = 1, left_at = NULL WHERE id = :id',
                    ['id' => (int)$existingOcc['id']]
                );
            } else {
                $db->execute(
                    'INSERT INTO property_occupants (user_property_id, user_id, role, can_use_vault, can_manage_staff, joined_at)
                     VALUES (:upid, :uid, \'tenant\', 0, 1, NOW())',
                    ['upid' => (int)$offer['user_property_id'], 'uid' => $userId]
                );
            }

            tcPropertyLogTransaction($userId, $price, 'rental_payment', [
                'offer_id' => $offerId,
                'landlord_id' => $ownerId,
            ]);
            tcPropertyLogTransaction($ownerId, $price, 'rental_income', [
                'offer_id' => $offerId,
                'tenant_id' => $userId,
            ]);

            $db->commit();
            tcPropertyFlash('success', 'Rental accepted.');
            break;
        }

        case 'extend_lease': {
            $leaseId = (int)($_POST['lease_id'] ?? 0);
            $days = (int)($_POST['days'] ?? 0);
            if ($days <= 0) {
                throw new RuntimeException('Invalid days.');
            }

            $lease = $db->fetchOne('SELECT * FROM property_leases WHERE id = :id LIMIT 1', ['id' => $leaseId]);
            if (!$lease) {
                throw new RuntimeException('Lease not found.');
            }
            if ((int)($lease['landlord_user_id'] ?? 0) !== $userId) {
                throw new RuntimeException('Not authorized.');
            }
            if ((string)($lease['status'] ?? '') !== 'active') {
                throw new RuntimeException('Lease not active.');
            }

            $start = new DateTime((string)$lease['start_at']);
            $currentEnd = new DateTime((string)$lease['end_at']);
            $newEnd = clone $currentEnd;
            $newEnd->modify('+' . $days . ' days');
            $newEnd->setTime(3, 30, 0);

            $totalDays = (int)$start->diff($newEnd)->days;
            if ($totalDays > 100) {
                throw new RuntimeException('Extension exceeds 100 total days.');
            }

            $db->execute('UPDATE property_leases SET end_at = :end WHERE id = :id', [
                'end' => $newEnd->format('Y-m-d H:i:s'),
                'id' => $leaseId,
            ]);

            tcPropertyLogTransaction($userId, 0, 'lease_extend', [
                'lease_id' => $leaseId,
                'extra_days' => $days,
            ]);
            tcPropertyFlash('success', 'Lease extended.');
            break;
        }

        case 'hire_staff': {
            $userPropertyId = (int)($_POST['user_property_id'] ?? 0);
            $staffCatalogId = (int)($_POST['staff_catalog_id'] ?? 0);
            if (!tcPropertyCanManageStaff($userId, $userPropertyId)) {
                throw new RuntimeException('Not authorized.');
            }

            $staffCatalog = $db->fetchOne('SELECT * FROM property_staff_catalog WHERE id = :id LIMIT 1', ['id' => $staffCatalogId]);
            if (!$staffCatalog) {
                throw new RuntimeException('Staff option not found.');
            }

            $roleKey = (string)($staffCatalog['staff_key'] ?? $staffCatalog['role'] ?? '');
            if ($roleKey !== '') {
                $existingRole = $db->fetchOne(
                    'SELECT ps.id FROM property_staff ps
                     JOIN property_staff_catalog sc ON sc.id = ps.staff_catalog_id
                     WHERE ps.user_property_id = :upid AND (ps.ended_at IS NULL OR ps.is_active = 1) AND sc.staff_key = :role
                     LIMIT 1',
                    ['upid' => $userPropertyId, 'role' => $roleKey]
                );
                if ($existingRole) {
                    throw new RuntimeException('Staff role already filled.');
                }
            }

            $existing = $db->fetchOne(
                'SELECT id FROM property_staff WHERE user_property_id = :upid AND staff_catalog_id = :sid AND (ended_at IS NULL OR is_active = 1) LIMIT 1',
                ['upid' => $userPropertyId, 'sid' => $staffCatalogId]
            );
            if ($existing) {
                throw new RuntimeException('Staff already hired.');
            }

            $db->execute(
                'INSERT INTO property_staff (user_property_id, staff_catalog_id, hired_by_user_id, hired_at, is_active)
                 VALUES (:upid, :sid, :uid, NOW(), 1)',
                ['upid' => $userPropertyId, 'sid' => $staffCatalogId, 'uid' => $userId]
            );

            tcPropertyLogTransaction($userId, (float)($staffCatalog['cost_upfront'] ?? 0), 'staff_hire', [
                'user_property_id' => $userPropertyId,
                'staff_catalog_id' => $staffCatalogId,
            ]);
            tcRecalcAndCacheResidence($userPropertyId);
            tcPropertyFlash('success', 'Staff hired.');
            break;
        }

        case 'fire_staff': {
            $staffId = (int)($_POST['staff_id'] ?? 0);
            $staff = $db->fetchOne('SELECT user_property_id, staff_catalog_id FROM property_staff WHERE id = :id LIMIT 1', ['id' => $staffId]);
            if (!$staff) {
                throw new RuntimeException('Staff not found.');
            }
            if (!tcPropertyCanManageStaff($userId, (int)$staff['user_property_id'])) {
                throw new RuntimeException('Not authorized.');
            }

            $db->execute('UPDATE property_staff SET ended_at = NOW(), is_active = 0 WHERE id = :id', ['id' => $staffId]);

            tcPropertyLogTransaction($userId, 0, 'staff_fire', [
                'user_property_id' => (int)$staff['user_property_id'],
                'staff_catalog_id' => (int)$staff['staff_catalog_id'],
            ]);
            tcRecalcAndCacheResidence((int)$staff['user_property_id']);
            tcPropertyFlash('success', 'Staff removed.');
            break;
        }

        case 'buy_upgrade': {
            $userPropertyId = (int)($_POST['user_property_id'] ?? 0);
            $upgradeCatalogId = (int)($_POST['upgrade_catalog_id'] ?? 0);
            $userProperty = tcPropertyGetUserProperty($userPropertyId);
            if (!$userProperty || (int)$userProperty['user_id'] !== $userId) {
                throw new RuntimeException('Not authorized.');
            }

            $upgrade = $db->fetchOne('SELECT * FROM property_upgrade_catalog WHERE id = :id LIMIT 1', ['id' => $upgradeCatalogId]);
            if (!$upgrade) {
                throw new RuntimeException('Upgrade not found.');
            }

            $requiredStaff = (string)($upgrade['requires_staff_role'] ?? '');
            if ($requiredStaff !== '') {
                $staffRole = $db->fetchOne(
                    'SELECT ps.id FROM property_staff ps
                     JOIN property_staff_catalog sc ON sc.id = ps.staff_catalog_id
                     WHERE ps.user_property_id = :upid AND (ps.ended_at IS NULL OR ps.is_active = 1) AND sc.staff_key = :role
                     LIMIT 1',
                    ['upid' => $userPropertyId, 'role' => $requiredStaff]
                );
                if (!$staffRole) {
                    throw new RuntimeException('Required staff not hired for this upgrade.');
                }
            }

            $current = $db->fetchOne('SELECT * FROM property_upgrades WHERE user_property_id = :upid AND upgrade_catalog_id = :cid LIMIT 1', [
                'upid' => $userPropertyId,
                'cid' => $upgradeCatalogId,
            ]);
            $currentLevel = $current ? (int)($current['level'] ?? 1) : 0;
            $maxLevel = (int)($upgrade['max_level'] ?? 1);
            if ($currentLevel >= $maxLevel) {
                throw new RuntimeException('Upgrade already maxed.');
            }

            $cost = (float)($upgrade['cost'] ?? 0);
            if ($cost <= 0) {
                throw new RuntimeException('Invalid upgrade cost.');
            }

            $db->beginTransaction();
            if (!tcPropertyCharge($userId, $cost, (string)($_POST['pay_source'] ?? 'auto'))) {
                $db->rollBack();
                throw new RuntimeException('Insufficient funds.');
            }

            if ($current) {
                $db->execute('UPDATE property_upgrades SET level = level + 1 WHERE id = :id', ['id' => (int)$current['id']]);
            } else {
                $db->execute(
                    'INSERT INTO property_upgrades (user_property_id, upgrade_catalog_id, level, installed_at)
                     VALUES (:upid, :cid, 1, NOW())',
                    ['upid' => $userPropertyId, 'cid' => $upgradeCatalogId]
                );
            }

            tcPropertyLogTransaction($userId, $cost, 'upgrade', [
                'upgrade_id' => $upgradeCatalogId,
                'user_property_id' => $userPropertyId,
            ]);

            $db->commit();
            tcRecalcAndCacheResidence($userPropertyId);
            tcPropertyFlash('success', 'Upgrade purchased.');
            break;
        }

        case 'pay_upkeep': {
            $amount = (float)($_POST['amount'] ?? 0);
            if ($amount <= 0) {
                throw new RuntimeException('Invalid amount.');
            }

            $res = tcGetCurrentResidence($userId);
            if (($res['mode'] ?? 'none') === 'none') {
                throw new RuntimeException('No residence found.');
            }

            $userPropertyId = (int)($res['user_property_id'] ?? 0);
            if ($userPropertyId <= 0) {
                throw new RuntimeException('Property not found.');
            }

            if (!tcUserHasOccupantAccess($userId, $userPropertyId)) {
                throw new RuntimeException('Not authorized.');
            }

            $db->beginTransaction();
            if (!tcPropertyCharge($userId, $amount, (string)($_POST['pay_source'] ?? 'auto'))) {
                $db->rollBack();
                throw new RuntimeException('Insufficient funds.');
            }

            $db->execute(
                'UPDATE user_properties SET upkeep_debt = GREATEST(0, COALESCE(upkeep_debt,0) - :amount) WHERE id = :id',
                ['amount' => $amount, 'id' => $userPropertyId]
            );

            tcPropertyLogTransaction($userId, $amount, 'upkeep_payment', [
                'user_property_id' => $userPropertyId,
            ]);

            $db->commit();
            tcRecalcAndCacheResidence($userPropertyId);
            tcPropertyFlash('success', 'Upkeep payment applied.');
            break;
        }

        case 'vault_deposit': {
            $amount = (float)($_POST['amount'] ?? 0);
            if ($amount <= 0) {
                throw new RuntimeException('Invalid amount.');
            }

            $res = tcGetCurrentResidence($userId);
            if (($res['mode'] ?? 'none') === 'none') {
                throw new RuntimeException('No residence found.');
            }

            $userPropertyId = (int)($res['user_property_id'] ?? 0);
            if (!tcCanUseVault($userId, $userPropertyId)) {
                throw new RuntimeException('Vault access denied.');
            }

            tcRecalcAndCacheResidence($userPropertyId);
            $userProperty = tcPropertyGetUserProperty($userPropertyId);
            if (!$userProperty) {
                throw new RuntimeException('Property not found.');
            }

            $vaultCap = (float)($userProperty['vault_cap'] ?? 0);
            $vaultBalance = (float)($userProperty['vault_balance'] ?? 0);
            if ($vaultCap > 0 && ($vaultBalance + $amount) > $vaultCap) {
                throw new RuntimeException('Vault capacity exceeded.');
            }

            $db->beginTransaction();
            if (!tcPropertyCharge($userId, $amount, (string)($_POST['pay_source'] ?? 'auto'))) {
                $db->rollBack();
                throw new RuntimeException('Insufficient funds.');
            }
            $db->execute('UPDATE user_properties SET vault_balance = vault_balance + :amount WHERE id = :id', [
                'amount' => $amount,
                'id' => $userPropertyId,
            ]);

            tcPropertyLogTransaction($userId, $amount, 'vault_deposit', [
                'user_property_id' => $userPropertyId,
            ]);
            $db->commit();
            tcPropertyFlash('success', 'Vault deposit complete.');
            break;
        }

        case 'vault_withdraw': {
            $amount = (float)($_POST['amount'] ?? 0);
            if ($amount <= 0) {
                throw new RuntimeException('Invalid amount.');
            }

            $res = tcGetCurrentResidence($userId);
            if (($res['mode'] ?? 'none') === 'none') {
                throw new RuntimeException('No residence found.');
            }

            $userPropertyId = (int)($res['user_property_id'] ?? 0);
            if (!tcCanUseVault($userId, $userPropertyId)) {
                throw new RuntimeException('Vault access denied.');
            }

            $userProperty = tcPropertyGetUserProperty($userPropertyId);
            if (!$userProperty) {
                throw new RuntimeException('Property not found.');
            }
            $vaultBalance = (float)($userProperty['vault_balance'] ?? 0);
            if ($vaultBalance < $amount) {
                throw new RuntimeException('Insufficient vault balance.');
            }

            $db->beginTransaction();
            $db->execute('UPDATE user_properties SET vault_balance = vault_balance - :amount WHERE id = :id', [
                'amount' => $amount,
                'id' => $userPropertyId,
            ]);
            $db->execute('UPDATE users SET cash = cash + :amount WHERE id = :id', ['amount' => $amount, 'id' => $userId]);

            tcPropertyLogTransaction($userId, $amount, 'vault_withdraw', [
                'user_property_id' => $userPropertyId,
            ]);

            $db->commit();
            tcPropertyFlash('success', 'Vault withdrawal complete.');
            break;
        }

        case 'toggle_spouse_vault': {
            $userPropertyId = (int)($_POST['user_property_id'] ?? 0);
            $spouseId = (int)($_POST['spouse_user_id'] ?? 0);
            $canUseVault = (int)($_POST['can_use_vault'] ?? 0);

            $userProperty = tcPropertyGetUserProperty($userPropertyId);
            if (!$userProperty || (int)$userProperty['user_id'] !== $userId) {
                throw new RuntimeException('Not authorized.');
            }
            if ($spouseId <= 0) {
                throw new RuntimeException('Invalid spouse user.');
            }

            $existing = tcPropertyGetOccupant($userPropertyId, $spouseId);
            if ($existing) {
                $db->execute(
                    'UPDATE property_occupants SET role = \'spouse\', can_use_vault = :vault, can_manage_staff = 1, left_at = NULL WHERE id = :id',
                    ['vault' => $canUseVault, 'id' => (int)$existing['id']]
                );
            } else {
                $db->execute(
                    'INSERT INTO property_occupants (user_property_id, user_id, role, can_use_vault, can_manage_staff, joined_at)
                     VALUES (:upid, :uid, \'spouse\', :vault, 1, NOW())',
                    ['upid' => $userPropertyId, 'uid' => $spouseId, 'vault' => $canUseVault]
                );
            }

            tcPropertyFlash('success', 'Spouse permissions updated.');
            break;
        }

        default:
            throw new RuntimeException('Unknown action.');
    }
} catch (Throwable $e) {
    if ($db && $db->inTransaction()) {
        $db->rollBack();
    }
    tcPropertyFlash('danger', $e->getMessage());
}

tcPropertyRedirect();
