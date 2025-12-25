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

$tc_page_title = 'Estate Agents - Trench City';
include __DIR__ . '/../../includes/tc_header.php';
tcRenderPageStart(['mode' => 'postlogin']);

$flash = $_SESSION['property_flash'] ?? null;
unset($_SESSION['property_flash']);

tcExpireLeasesIfNeeded();
tcPropertyTickForUser($userId);

global $db;
$properties = $db->fetchAll('SELECT * FROM properties WHERE is_active = 1 ORDER BY tier ASC, id ASC') ?: [];
?>

<div class="main-content">
    <div class="content-wrapper">
        <div class="content-header">
            <h1 class="content-title">Estate Agents</h1>
            <p class="content-description">Purchase new properties from the market.</p>
        </div>

        <?php if (!empty($flash['type'])): ?>
            <div class="alert alert-<?php echo htmlspecialchars((string)$flash['type'], ENT_QUOTES, 'UTF-8'); ?>">
                <div class="alert-content">
                    <div class="alert-message"><?php echo htmlspecialchars((string)($flash['message'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></div>
                </div>
            </div>
        <?php endif; ?>

        <section class="tc-widget tc-widget-hero">
            <div class="tc-widget-header">
                <h2 class="tc-widget-title">Available Properties</h2>
            </div>
            <div class="tc-widget-body">
                <?php if (!$properties): ?>
                    <p class="tc-widget-text">No properties are available right now.</p>
                <?php else: ?>
                    <table class="tc-table-compact">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Tier</th>
                                <th>Base Happy</th>
                                <th>Daily Upkeep</th>
                                <th>Cost</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($properties as $property): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars((string)$property['name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo (int)($property['tier'] ?? 0); ?></td>
                                    <td><?php echo (int)($property['base_happy'] ?? 0); ?></td>
                                    <td><?php echo formatCash((float)tcPropertyUpkeep($property)); ?></td>
                                    <td><?php echo formatCash((float)tcPropertyCost($property)); ?></td>
                                    <td>
                                        <form method="post" action="/modules/properties/actions.php">
                                            <input type="hidden" name="action" value="buy_estate_property" />
                                            <input type="hidden" name="property_id" value="<?php echo (int)$property['id']; ?>" />
                                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>" />
                                            <button class="tc-btn tc-btn-primary" type="submit">Buy</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </section>
    </div>
</div>

<?php
if (function_exists('tcRenderPageEnd')) {
    tcRenderPageEnd(['mode' => 'postlogin']);
}
?>
