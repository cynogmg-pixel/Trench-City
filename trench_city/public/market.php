<?php
/**
 * TRENCH CITY - MARKET
 * Buy and sell items, weapons, and equipment
 */

require_once __DIR__ . '/../core/bootstrap.php';
requireLogin();
if (function_exists('tc_is_ops_flag_enabled') && function_exists('tc_render_postlogin_notice')) {
    if (tc_is_ops_flag_enabled('freeze_economy') || tc_is_ops_flag_enabled('disable_market') || tc_is_ops_flag_enabled('disable_trading')) {
        if (function_exists('tc_redirect_maintenance')) {
            tc_redirect_maintenance();
        } else {
            tc_render_postlogin_notice('Market Offline', 'Market access is temporarily disabled by admin action.');
        }
    }
}

$userId = currentUserId();
$user = getUser($userId);
$db = getDB();

if (!$user || !$db) {
    header('Location: /login.php');
    exit;
}

$success = '';
$errors = [];
$activeTab = $_GET['tab'] ?? 'browse';

// Handle Buy Item
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buy_item'])) {
    $csrf = $_POST['csrf_token'] ?? '';
    if (!csrf_check($csrf)) {
        $errors[] = 'Invalid session. Please try again.';
    }

    $itemId = (int)($_POST['item_id'] ?? 0);

    if (empty($errors) && $itemId > 0) {
        $item = $db->fetchOne("SELECT * FROM market_items WHERE id = :id AND is_active = 1", ['id' => $itemId]);

        if (!$item) {
            $errors[] = 'Item not found.';
        } elseif ($item['min_level'] > ($user['level'] ?? 1)) {
            $errors[] = "You need to be level {$item['min_level']} to buy this item.";
        } elseif (($user['cash'] ?? 0) < $item['base_price']) {
            $errors[] = 'Not enough cash!';
        } else {
            $db->beginTransaction();
            try {
                $db->execute("UPDATE users SET cash = cash - :cost WHERE id = :id", [
                    'cost' => $item['base_price'],
                    'id' => $userId
                ]);

                $existing = $db->fetchOne(
                    "SELECT * FROM user_inventory WHERE user_id = :uid AND item_id = :iid",
                    ['uid' => $userId, 'iid' => $itemId]
                );

                if ($existing) {
                    $db->execute("UPDATE user_inventory SET quantity = quantity + 1 WHERE id = :id", ['id' => $existing['id']]);
                } else {
                    $db->execute("INSERT INTO user_inventory (user_id, item_id, quantity) VALUES (:uid, :iid, 1)",
                        ['uid' => $userId, 'iid' => $itemId]);
                }

                $db->execute(
                    "INSERT INTO market_transactions (user_id, item_id, transaction_type, quantity, price_per_unit, total_price)
                     VALUES (:uid, :iid, 'buy', 1, :price, :price)",
                    ['uid' => $userId, 'iid' => $itemId, 'price' => $item['base_price']]
                );

                $db->commit();
                $success = "Purchased {$item['name']} for \$" . number_format($item['base_price']) . "!";
                $user = getUser($userId);
            } catch (Exception $e) {
                $db->rollback();
                $errors[] = 'Purchase failed. Please try again.';
            }
        }
    }
}

// Handle Equip Item
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['equip_item'])) {
    $csrf = $_POST['csrf_token'] ?? '';
    if (!csrf_check($csrf)) {
        $errors[] = 'Invalid session. Please try again.';
    }

    $inventoryId = (int)($_POST['inventory_id'] ?? 0);

    if (empty($errors) && $inventoryId > 0) {
        $inventoryItem = $db->fetchOne(
            "SELECT i.*, m.category FROM user_inventory i
             JOIN market_items m ON i.item_id = m.id
             WHERE i.id = :id AND i.user_id = :uid",
            ['id' => $inventoryId, 'uid' => $userId]
        );

        if (!$inventoryItem) {
            $errors[] = 'Item not found.';
        } else {
            $db->beginTransaction();
            try {
                // Unequip other items in same category (only one weapon/armor/vehicle equipped at a time)
                if (in_array($inventoryItem['category'], ['weapon', 'armor', 'vehicle'])) {
                    $db->execute(
                        "UPDATE user_inventory i
                         JOIN market_items m ON i.item_id = m.id
                         SET i.equipped = 0
                         WHERE i.user_id = :uid AND m.category = :cat",
                        ['uid' => $userId, 'cat' => $inventoryItem['category']]
                    );
                }

                // Equip the item
                $db->execute("UPDATE user_inventory SET equipped = 1 WHERE id = :id", ['id' => $inventoryId]);

                $db->commit();
                $success = 'Item equipped successfully!';
            } catch (Exception $e) {
                $db->rollback();
                $errors[] = 'Failed to equip item. Please try again.';
            }
        }
    }
}

// Handle Unequip Item
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['unequip_item'])) {
    $csrf = $_POST['csrf_token'] ?? '';
    if (!csrf_check($csrf)) {
        $errors[] = 'Invalid session. Please try again.';
    }

    $inventoryId = (int)($_POST['inventory_id'] ?? 0);

    if (empty($errors) && $inventoryId > 0) {
        $inventoryItem = $db->fetchOne(
            "SELECT * FROM user_inventory WHERE id = :id AND user_id = :uid",
            ['id' => $inventoryId, 'uid' => $userId]
        );

        if (!$inventoryItem) {
            $errors[] = 'Item not found.';
        } else {
            $db->execute("UPDATE user_inventory SET equipped = 0 WHERE id = :id", ['id' => $inventoryId]);
            $success = 'Item unequipped successfully!';
        }
    }
}

// Handle Sell Item
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['sell_item'])) {
    $csrf = $_POST['csrf_token'] ?? '';
    if (!csrf_check($csrf)) {
        $errors[] = 'Invalid session. Please try again.';
    }

    $inventoryId = (int)($_POST['inventory_id'] ?? 0);

    if (empty($errors) && $inventoryId > 0) {
        $inventoryItem = $db->fetchOne(
            "SELECT i.*, m.name, m.base_price
             FROM user_inventory i
             JOIN market_items m ON i.item_id = m.id
             WHERE i.id = :id AND i.user_id = :uid",
            ['id' => $inventoryId, 'uid' => $userId]
        );

        if (!$inventoryItem) {
            $errors[] = 'Item not found.';
        } else {
            $sellPrice = floor($inventoryItem['base_price'] * 0.6);
            $db->beginTransaction();
            try {
                $db->execute("UPDATE users SET cash = cash + :earned WHERE id = :id", [
                    'earned' => $sellPrice,
                    'id' => $userId
                ]);

                if ($inventoryItem['quantity'] == 1) {
                    $db->execute("DELETE FROM user_inventory WHERE id = :id", ['id' => $inventoryId]);
                } else {
                    $db->execute("UPDATE user_inventory SET quantity = quantity - 1 WHERE id = :id", ['id' => $inventoryId]);
                }

                $db->execute(
                    "INSERT INTO market_transactions (user_id, item_id, transaction_type, quantity, price_per_unit, total_price)
                     VALUES (:uid, :iid, 'sell', 1, :price, :price)",
                    ['uid' => $userId, 'iid' => $inventoryItem['item_id'], 'price' => $sellPrice]
                );

                $db->commit();
                $success = "Sold {$inventoryItem['name']} for \$" . number_format($sellPrice) . "!";
                $user = getUser($userId);
            } catch (Exception $e) {
                $db->rollback();
                $errors[] = 'Sale failed. Please try again.';
            }
        }
    }
}

// Get market items
$category = $_GET['category'] ?? 'all';
$categoryFilter = $category !== 'all' ? "AND category = :cat" : "";
$params = $category !== 'all' ? ['cat' => $category] : [];

$marketItems = $db->fetchAll(
    "SELECT * FROM market_items WHERE is_active = 1 {$categoryFilter} ORDER BY category, base_price ASC",
    $params
);

// Get user inventory
$inventory = $db->fetchAll(
    "SELECT i.*, m.name, m.description, m.category, m.base_price, m.icon
     FROM user_inventory i
     JOIN market_items m ON i.item_id = m.id
     WHERE i.user_id = :uid
     ORDER BY m.category, m.name",
    ['uid' => $userId]
);

// Get transaction history
$transactions = $db->fetchAll(
    "SELECT t.*, m.name, m.icon
     FROM market_transactions t
     JOIN market_items m ON t.item_id = m.id
     WHERE t.user_id = :uid
     ORDER BY t.created_at DESC
     LIMIT 20",
    ['uid' => $userId]
);

$tc_page_title = 'Market - Trench City';
include __DIR__ . '/../includes/tc_header.php';
tcRenderPageStart(['mode' => 'postlogin']);
?>

<!-- Main Content -->
<div class="main-content">
    <div class="content-wrapper">

        <!-- Page Header -->
        <div class="content-header">
            <h1 class="content-title">🏪 Black Market</h1>
            <p class="content-description">
                Your Cash: <span style="color: #10B981; font-weight: bold;">$<?= number_format($user['cash'] ?? 0) ?></span>
            </p>
        </div>

        <!-- Messages -->
        <?php if ($success): ?>
            <div style="margin-top: 2rem; padding: 1rem 1.5rem; background: rgba(16, 185, 129, 0.25);
                        border-left: 4px solid #10B981; border-radius: 0.5rem; color: #10B981;">
                ✓ <?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($errors)): ?>
            <div style="margin-top: 2rem; padding: 1rem 1.5rem; background: rgba(239, 68, 68, 0.25);
                        border-left: 4px solid #EF4444; border-radius: 0.5rem; color: #EF4444;">
                <?php foreach ($errors as $error): ?>
                    <div>⨯ <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Tabs -->
        <div style="margin-top: 2rem; border-bottom: 2px solid #1F2937; display: flex; gap: 1rem;">
            <a href="?tab=browse" style="padding: 1rem 1.5rem; text-decoration: none; color: <?= $activeTab === 'browse' ? '#D4AF37' : '#9CA3AF' ?>;
               border-bottom: 3px solid <?= $activeTab === 'browse' ? '#D4AF37' : 'transparent' ?>; font-weight: 600;">
                🛒 Browse
            </a>
            <a href="?tab=inventory" style="padding: 1rem 1.5rem; text-decoration: none; color: <?= $activeTab === 'inventory' ? '#D4AF37' : '#9CA3AF' ?>;
               border-bottom: 3px solid <?= $activeTab === 'inventory' ? '#D4AF37' : 'transparent' ?>; font-weight: 600;">
                🎒 Inventory (<?= count($inventory) ?>)
            </a>
            <a href="?tab=history" style="padding: 1rem 1.5rem; text-decoration: none; color: <?= $activeTab === 'history' ? '#D4AF37' : '#9CA3AF' ?>;
               border-bottom: 3px solid <?= $activeTab === 'history' ? '#D4AF37' : 'transparent' ?>; font-weight: 600;">
                📜 History
            </a>
        </div>

        <?php if ($activeTab === 'browse'): ?>
            <!-- Category Filter -->
            <div style="margin-top: 2rem; display: flex; gap: 0.5rem; flex-wrap: wrap;">
                <a href="?tab=browse&category=all" style="padding: 0.5rem 1rem; background: <?= $category === 'all' ? '#D4AF37' : '#1F2937' ?>;
                   color: <?= $category === 'all' ? '#0F172A' : '#9CA3AF' ?>; text-decoration: none; border-radius: 0.5rem; font-size: 0.9rem; font-weight: 500;">
                    All Items
                </a>
                <a href="?tab=browse&category=weapon" style="padding: 0.5rem 1rem; background: <?= $category === 'weapon' ? '#D4AF37' : '#1F2937' ?>;
                   color: <?= $category === 'weapon' ? '#0F172A' : '#9CA3AF' ?>; text-decoration: none; border-radius: 0.5rem; font-size: 0.9rem; font-weight: 500;">
                    🔫 Weapons
                </a>
                <a href="?tab=browse&category=armor" style="padding: 0.5rem 1rem; background: <?= $category === 'armor' ? '#D4AF37' : '#1F2937' ?>;
                   color: <?= $category === 'armor' ? '#0F172A' : '#9CA3AF' ?>; text-decoration: none; border-radius: 0.5rem; font-size: 0.9rem; font-weight: 500;">
                    🛡️ Armor
                </a>
                <a href="?tab=browse&category=vehicle" style="padding: 0.5rem 1rem; background: <?= $category === 'vehicle' ? '#D4AF37' : '#1F2937' ?>;
                   color: <?= $category === 'vehicle' ? '#0F172A' : '#9CA3AF' ?>; text-decoration: none; border-radius: 0.5rem; font-size: 0.9rem; font-weight: 500;">
                    🚗 Vehicles
                </a>
                <a href="?tab=browse&category=consumable" style="padding: 0.5rem 1rem; background: <?= $category === 'consumable' ? '#D4AF37' : '#1F2937' ?>;
                   color: <?= $category === 'consumable' ? '#0F172A' : '#9CA3AF' ?>; text-decoration: none; border-radius: 0.5rem; font-size: 0.9rem; font-weight: 500;">
                    💊 Consumables
                </a>
            </div>

            <!-- Market Items Grid -->
            <div style="margin-top: 2rem; display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
                <?php foreach ($marketItems as $item): ?>
                    <div class="tc-card">
                        <div style="padding: 1.5rem;">
                            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                                <div>
                                    <div style="font-size: 2rem; margin-bottom: 0.5rem;"><?= htmlspecialchars($item['icon'], ENT_QUOTES, 'UTF-8') ?></div>
                                    <h3 style="color: #D4AF37; margin-bottom: 0.25rem; font-size: 1.1rem;"><?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?></h3>
                                    <div style="color: #6B7280; font-size: 0.85rem; text-transform: uppercase;"><?= $item['category'] ?></div>
                                </div>
                                <div style="text-align: right;">
                                    <div style="color: #10B981; font-size: 1.25rem; font-weight: bold;">$<?= number_format($item['base_price']) ?></div>
                                    <?php if ($item['min_level'] > 1): ?>
                                        <div style="color: #9CA3AF; font-size: 0.85rem;">Lvl <?= $item['min_level'] ?>+</div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <p style="color: #9CA3AF; font-size: 0.9rem; margin-bottom: 1rem; line-height: 1.4;"><?= htmlspecialchars($item['description'], ENT_QUOTES, 'UTF-8') ?></p>

                            <?php if ($item['strength_bonus'] > 0 || $item['defense_bonus'] > 0): ?>
                                <div style="margin-bottom: 1rem; padding: 0.5rem; background: #1F2937; border-radius: 0.5rem;">
                                    <?php if ($item['strength_bonus'] > 0): ?>
                                        <div style="color: #F59E0B; font-size: 0.85rem;">💪 +<?= $item['strength_bonus'] ?> Strength</div>
                                    <?php endif; ?>
                                    <?php if ($item['defense_bonus'] > 0): ?>
                                        <div style="color: #3B82F6; font-size: 0.85rem;">🛡️ +<?= $item['defense_bonus'] ?> Defense</div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($item['min_level'] > ($user['level'] ?? 1)): ?>
                                <button disabled style="width: 100%; padding: 0.75rem; background: #374151; color: #6B7280;
                                       border: none; border-radius: 0.5rem; font-weight: 600; cursor: not-allowed;">
                                    🔒 Requires Level <?= $item['min_level'] ?>
                                </button>
                            <?php elseif (($user['cash'] ?? 0) < $item['base_price']): ?>
                                <button disabled style="width: 100%; padding: 0.75rem; background: #374151; color: #6B7280;
                                       border: none; border-radius: 0.5rem; font-weight: 600; cursor: not-allowed;">
                                    💰 Not Enough Cash
                                </button>
                            <?php else: ?>
                                <form method="post" style="margin: 0;">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') ?>" />
                                    <input type="hidden" name="buy_item" value="1" />
                                    <input type="hidden" name="item_id" value="<?= $item['id'] ?>" />
                                    <button type="submit" style="width: 100%; padding: 0.75rem; background: #D4AF37; color: #0F172A;
                                           border: none; border-radius: 0.5rem; font-weight: 600; cursor: pointer;">
                                        🛒 Buy Now
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php elseif ($activeTab === 'inventory'): ?>
            <div style="margin-top: 2rem;">
                <?php if (empty($inventory)): ?>
                    <div class="tc-card" style="text-align: center; padding: 3rem 2rem; color: #9CA3AF;">
                        <div style="font-size: 3rem; margin-bottom: 1rem;">🎒</div>
                        <p>Your inventory is empty. Visit the market to buy items!</p>
                        <a href="?tab=browse" style="display: inline-block; margin-top: 1rem; padding: 0.75rem 1.5rem;
                           background: #D4AF37; color: #0F172A; text-decoration: none; border-radius: 0.5rem; font-weight: 600;">
                            Browse Market
                        </a>
                    </div>
                <?php else: ?>
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
                        <?php foreach ($inventory as $item): ?>
                            <div class="tc-card">
                                <div style="padding: 1.5rem;">
                                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                                        <div>
                                            <div style="font-size: 2rem; margin-bottom: 0.5rem;"><?= htmlspecialchars($item['icon'], ENT_QUOTES, 'UTF-8') ?></div>
                                            <h3 style="color: #D4AF37; margin-bottom: 0.25rem;"><?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?></h3>
                                            <div style="color: #6B7280; font-size: 0.85rem;">
                                                Quantity: <?= $item['quantity'] ?>
                                                <?php if ($item['equipped']): ?>
                                                    <span style="color: #10B981; margin-left: 0.5rem;">✓ Equipped</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div style="text-align: right;">
                                            <div style="color: #10B981; font-size: 1rem; font-weight: bold;">
                                                Sell: $<?= number_format(floor($item['base_price'] * 0.6)) ?>
                                            </div>
                                        </div>
                                    </div>

                                    <p style="color: #9CA3AF; font-size: 0.9rem; margin-bottom: 1rem;"><?= htmlspecialchars($item['description'], ENT_QUOTES, 'UTF-8') ?></p>

                                    <?php if (in_array($item['category'], ['weapon', 'armor', 'vehicle'])): ?>
                                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; margin-bottom: 0.5rem;">
                                            <?php if ($item['equipped']): ?>
                                                <form method="post" style="margin: 0;">
                                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') ?>" />
                                                    <input type="hidden" name="unequip_item" value="1" />
                                                    <input type="hidden" name="inventory_id" value="<?= $item['id'] ?>" />
                                                    <button type="submit" style="width: 100%; padding: 0.5rem; background: #EF4444; color: #F9FAFB;
                                                           border: none; border-radius: 0.5rem; font-weight: 600; cursor: pointer; font-size: 0.9rem;">
                                                        Unequip
                                                    </button>
                                                </form>
                                            <?php else: ?>
                                                <form method="post" style="margin: 0;">
                                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') ?>" />
                                                    <input type="hidden" name="equip_item" value="1" />
                                                    <input type="hidden" name="inventory_id" value="<?= $item['id'] ?>" />
                                                    <button type="submit" style="width: 100%; padding: 0.5rem; background: #10B981; color: #F9FAFB;
                                                           border: none; border-radius: 0.5rem; font-weight: 600; cursor: pointer; font-size: 0.9rem;">
                                                        Equip
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                            <form method="post" style="margin: 0;">
                                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') ?>" />
                                                <input type="hidden" name="sell_item" value="1" />
                                                <input type="hidden" name="inventory_id" value="<?= $item['id'] ?>" />
                                                <button type="submit" style="width: 100%; padding: 0.5rem; background: #374151; color: #F9FAFB;
                                                       border: none; border-radius: 0.5rem; font-weight: 600; cursor: pointer; font-size: 0.9rem;">
                                                    Sell
                                                </button>
                                            </form>
                                        </div>
                                    <?php else: ?>
                                        <form method="post" style="margin: 0;">
                                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8') ?>" />
                                            <input type="hidden" name="sell_item" value="1" />
                                            <input type="hidden" name="inventory_id" value="<?= $item['id'] ?>" />
                                            <button type="submit" style="width: 100%; padding: 0.75rem; background: #374151; color: #F9FAFB;
                                                   border: none; border-radius: 0.5rem; font-weight: 600; cursor: pointer;">
                                                💰 Sell (60% value)
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

        <?php else: ?>
            <div class="tc-card" style="margin-top: 2rem;">
                <div style="padding: 1.5rem;">
                    <h2 style="color: #D4AF37; margin-bottom: 1.5rem;">Recent Transactions</h2>
                    <?php if (empty($transactions)): ?>
                        <div style="text-align: center; padding: 2rem; color: #9CA3AF;">No transaction history yet.</div>
                    <?php else: ?>
                        <div style="overflow-x: auto;">
                            <table style="width: 100%; border-collapse: collapse;">
                                <thead>
                                    <tr style="border-bottom: 2px solid #374151;">
                                        <th style="padding: 1rem; text-align: left; color: #9CA3AF;">Item</th>
                                        <th style="padding: 1rem; text-align: center; color: #9CA3AF;">Type</th>
                                        <th style="padding: 1rem; text-align: right; color: #9CA3AF;">Amount</th>
                                        <th style="padding: 1rem; text-align: right; color: #9CA3AF;">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($transactions as $trans): ?>
                                        <tr style="border-bottom: 1px solid #1F2937;">
                                            <td style="padding: 1rem;">
                                                <div style="display: flex; align-items: center; gap: 0.5rem;">
                                                    <span style="font-size: 1.5rem;"><?= htmlspecialchars($trans['icon'], ENT_QUOTES, 'UTF-8') ?></span>
                                                    <span style="color: #F9FAFB;"><?= htmlspecialchars($trans['name'], ENT_QUOTES, 'UTF-8') ?></span>
                                                </div>
                                            </td>
                                            <td style="padding: 1rem; text-align: center;">
                                                <?= $trans['transaction_type'] === 'buy' ? '<span style="color: #EF4444;">📥 Buy</span>' : '<span style="color: #10B981;">📤 Sell</span>' ?>
                                            </td>
                                            <td style="padding: 1rem; text-align: right;">
                                                <span style="color: <?= $trans['transaction_type'] === 'buy' ? '#EF4444' : '#10B981' ?>; font-weight: 600;">
                                                    <?= $trans['transaction_type'] === 'buy' ? '-' : '+' ?>$<?= number_format($trans['total_price']) ?>
                                                </span>
                                            </td>
                                            <td style="padding: 1rem; text-align: right; color: #9CA3AF; font-size: 0.9rem;">
                                                <?= date('M j, g:i A', strtotime($trans['created_at'])) ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>

<?php include __DIR__ . '/../includes/postlogin-footer.php'; ?>




