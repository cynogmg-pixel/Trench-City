<?php
declare(strict_types=1);

require_once __DIR__ . '/../../core/bootstrap.php';
requireLogin();

require_once __DIR__ . '/properties_helpers.php';

$userId = currentUserId();
$user = getUser($userId);
if (!$user) {
    header('Location: /login.php');
    exit;
}

$tc_page_title = 'Manage Property - Trench City';
include __DIR__ . '/../../includes/tc_header.php';
tcRenderPageStart(['mode' => 'postlogin']);

$flash = $_SESSION['property_flash'] ?? null;
unset($_SESSION['property_flash']);

tcExpireLeasesIfNeeded();
tcPropertyTickForUser($userId);

$userPropertyId = isset($_GET['user_property_id']) ? (int)$_GET['user_property_id'] : 0;
if ($userPropertyId <= 0) {
    $res = tcGetCurrentResidence($userId);
    $userPropertyId = $res ? (int)$res['user_property_id'] : 0;
}

$userProperty = $userPropertyId ? tcPropertyGetUserProperty($userPropertyId) : null;
$property = $userProperty ? tcPropertyGetProperty((int)$userProperty['property_id']) : null;

$canManageStaff = $userProperty ? tcPropertyCanManageStaff($userId, $userPropertyId) : false;
$isOwner = $userProperty && (int)$userProperty['user_id'] === $userId;

$upgrades = $userProperty ? tcPropertyGetUpgrades($userPropertyId) : [];
$staff = $userProperty ? tcPropertyGetStaff($userPropertyId) : [];

global $db;

$upgradeCatalog = $property ? $db->fetchAll(
    'SELECT * FROM property_upgrade_catalog WHERE property_id = :pid ORDER BY name ASC',
    ['pid' => (int)$property['id']]
) : [];

$staffCatalog = $property ? $db->fetchAll(
    'SELECT * FROM property_staff_catalog WHERE property_id = :pid ORDER BY name ASC',
    ['pid' => (int)$property['id']]
) : [];
?>

<div class="main-content">
    <div class="content-wrapper">
        <div class="content-header">
            <h1 class="content-title">Manage Property</h1>
            <p class="content-description">Upgrades, staff, and permissions.</p>
        </div>

        <?php if (!empty($flash['type'])): ?>
            <div class="alert alert-<?php echo htmlspecialchars((string)$flash['type'], ENT_QUOTES, 'UTF-8'); ?>">
                <div class="alert-content">
                    <div class="alert-message"><?php echo htmlspecialchars((string)($flash['message'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></div>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!$property): ?>
            <section class="tc-widget tc-widget-hero">
                <div class="tc-widget-body">
                    <p class="tc-widget-text">No property selected.</p>
                </div>
            </section>
        <?php else: ?>
            <section class="tc-widget tc-widget-hero">
                <div class="tc-widget-header">
                    <h2 class="tc-widget-title"><?php echo htmlspecialchars((string)$property['name'], ENT_QUOTES, 'UTF-8'); ?></h2>
                </div>
                <div class="tc-widget-body">
                    <table class="tc-table-compact">
                        <tbody>
                            <tr>
                                <th>Tier</th>
                                <td><?php echo (int)($property['tier'] ?? 0); ?></td>
                            </tr>
                            <tr>
                                <th>Base Happy</th>
                                <td><?php echo (int)($property['base_happy'] ?? 0); ?></td>
                            </tr>
                            <tr>
                                <th>Daily Upkeep</th>
                                <td><?php echo formatCash((float)tcPropertyUpkeep($property)); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <?php if ($isOwner): ?>
                <section class="tc-widget tc-widget-hero">
                    <div class="tc-widget-header">
                        <h2 class="tc-widget-title">Upgrades</h2>
                    </div>
                    <div class="tc-widget-body">
                        <?php if (!$upgradeCatalog): ?>
                            <p class="tc-widget-text">No upgrades available for this property.</p>
                        <?php else: ?>
                            <table class="tc-table-compact">
                                <thead>
                                    <tr>
                                        <th>Upgrade</th>
                                        <th>Level</th>
                                        <th>Cost</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($upgradeCatalog as $upgrade): ?>
                                        <?php
                                            $currentLevel = 0;
                                            foreach ($upgrades as $u) {
                                                if ((int)$u['upgrade_catalog_id'] === (int)$upgrade['id']) {
                                                    $currentLevel = (int)($u['level'] ?? 1);
                                                }
                                            }
                                        ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars((string)$upgrade['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td><?php echo $currentLevel; ?></td>
                                            <td><?php echo formatCash((float)($upgrade['cost'] ?? 0)); ?></td>
                                            <td>
                                                <form method="post" action="/modules/properties/actions.php">
                                                    <input type="hidden" name="action" value="buy_upgrade" />
                                                    <input type="hidden" name="upgrade_catalog_id" value="<?php echo (int)$upgrade['id']; ?>" />
                                                    <input type="hidden" name="user_property_id" value="<?php echo (int)$userPropertyId; ?>" />
                                                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>" />
                                                    <button class="tc-btn tc-btn-secondary" type="submit">Purchase</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                </section>
            <?php endif; ?>

            <?php if ($canManageStaff): ?>
                <section class="tc-widget tc-widget-hero">
                    <div class="tc-widget-header">
                        <h2 class="tc-widget-title">Staff</h2>
                    </div>
                    <div class="tc-widget-body">
                        <?php if (!$staffCatalog): ?>
                            <p class="tc-widget-text">No staff available for this property.</p>
                        <?php else: ?>
                            <table class="tc-table-compact">
                                <thead>
                                    <tr>
                                        <th>Staff</th>
                                        <th>Daily Cost</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($staffCatalog as $member): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars((string)$member['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td><?php echo formatCash((float)($member['daily_cost'] ?? 0)); ?></td>
                                            <td>
                                                <form method="post" action="/modules/properties/actions.php">
                                                    <input type="hidden" name="action" value="hire_staff" />
                                                    <input type="hidden" name="staff_catalog_id" value="<?php echo (int)$member['id']; ?>" />
                                                    <input type="hidden" name="user_property_id" value="<?php echo (int)$userPropertyId; ?>" />
                                                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>" />
                                                    <button class="tc-btn tc-btn-secondary" type="submit">Hire</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>

                        <?php if ($staff): ?>
                            <div style="margin-top: 1rem;">
                                <h3 class="tc-widget-title">Current Staff</h3>
                                <table class="tc-table-compact">
                                    <thead>
                                        <tr>
                                            <th>Staff</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($staff as $hire): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars((string)$hire['staff_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td>
                                                    <form method="post" action="/modules/properties/actions.php">
                                                        <input type="hidden" name="action" value="fire_staff" />
                                                        <input type="hidden" name="staff_id" value="<?php echo (int)$hire['id']; ?>" />
                                                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>" />
                                                        <button class="tc-btn tc-btn-secondary" type="submit">Fire</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>
            <?php endif; ?>

            <?php if ($isOwner): ?>
                <section class="tc-widget tc-widget-hero">
                    <div class="tc-widget-header">
                        <h2 class="tc-widget-title">Spouse Permissions</h2>
                    </div>
                    <div class="tc-widget-body">
                        <form method="post" action="/modules/properties/actions.php">
                            <input type="hidden" name="action" value="toggle_spouse_vault" />
                            <input type="hidden" name="user_property_id" value="<?php echo (int)$userPropertyId; ?>" />
                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>" />
                            <div class="tc-form-row">
                                <label>Spouse User ID</label>
                                <input class="form-control" type="number" name="spouse_user_id" min="1" />
                            </div>
                            <div class="tc-form-row">
                                <label>Vault Access</label>
                                <select class="form-control" name="can_use_vault">
                                    <option value="0">Disabled</option>
                                    <option value="1">Enabled</option>
                                </select>
                            </div>
                            <button class="tc-btn tc-btn-secondary" type="submit">Update</button>
                        </form>
                    </div>
                </section>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<?php
if (function_exists('tcRenderPageEnd')) {
    tcRenderPageEnd(['mode' => 'postlogin']);
}
?>
