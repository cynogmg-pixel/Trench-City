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

$tc_page_title = 'Property Market - Trench City';
include __DIR__ . '/../../includes/tc_header.php';
tcRenderPageStart(['mode' => 'postlogin']);

$flash = $_SESSION['property_flash'] ?? null;
unset($_SESSION['property_flash']);

tcExpireLeasesIfNeeded();
tcPropertyTickForUser($userId);

global $db;
$listings = $db->fetchAll(
    'SELECT pl.*, up.user_id AS owner_id, p.name AS property_name, p.tier AS property_tier, p.base_happy AS property_happy
     FROM property_listings pl
     JOIN user_properties up ON up.id = pl.user_property_id
     JOIN properties p ON p.id = up.property_id
     WHERE pl.status = \'active\'
     ORDER BY pl.created_at DESC'
) ?: [];

$owned = tcPropertyGetOwnedProperties($userId);
?>

<div class="main-content">
    <div class="content-wrapper">
        <div class="content-header">
            <h1 class="content-title">Property Market</h1>
            <p class="content-description">List or purchase properties from other players.</p>
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
                <h2 class="tc-widget-title">Active Listings</h2>
            </div>
            <div class="tc-widget-body">
                <?php if (!$listings): ?>
                    <p class="tc-widget-text">No listings are active right now.</p>
                <?php else: ?>
                    <table class="tc-table-compact">
                        <thead>
                            <tr>
                                <th>Property</th>
                                <th>Tier</th>
                                <th>Happy</th>
                                <th>Price</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($listings as $listing): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars((string)$listing['property_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo (int)($listing['property_tier'] ?? 0); ?></td>
                                    <td><?php echo (int)($listing['property_happy'] ?? 0); ?></td>
                                    <td><?php echo formatCash((float)($listing['price'] ?? 0)); ?></td>
                                    <td>
                                        <form method="post" action="/modules/properties/actions.php">
                                            <input type="hidden" name="action" value="buy_listing" />
                                            <input type="hidden" name="listing_id" value="<?php echo (int)$listing['id']; ?>" />
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

        <section class="tc-widget tc-widget-hero">
            <div class="tc-widget-header">
                <h2 class="tc-widget-title">List Your Property</h2>
            </div>
            <div class="tc-widget-body">
                <?php if (!$owned): ?>
                    <p class="tc-widget-text">You do not own any properties to list.</p>
                <?php else: ?>
                    <form method="post" action="/modules/properties/actions.php">
                        <input type="hidden" name="action" value="list_for_sale" />
                        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>" />
                        <div class="tc-form-row">
                            <label>Property</label>
                            <select class="form-control" name="user_property_id">
                                <?php foreach ($owned as $prop): ?>
                                    <option value="<?php echo (int)$prop['id']; ?>"><?php echo htmlspecialchars((string)$prop['property_name'], ENT_QUOTES, 'UTF-8'); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="tc-form-row">
                            <label>Price</label>
                            <input class="form-control" type="number" name="price" min="1" step="1" />
                        </div>
                        <button class="tc-btn tc-btn-secondary" type="submit">Create listing</button>
                    </form>
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
