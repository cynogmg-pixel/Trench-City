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

$tc_page_title = 'Property Rentals - Trench City';
include __DIR__ . '/../../includes/tc_header.php';
tcRenderPageStart(['mode' => 'postlogin']);

$flash = $_SESSION['property_flash'] ?? null;
unset($_SESSION['property_flash']);

tcExpireLeasesIfNeeded();
tcPropertyTickForUser($userId);

global $db;
$offers = $db->fetchAll(
    'SELECT pr.*, p.name AS property_name, p.base_happy, up.user_id AS owner_id
     FROM property_rental_offers pr
     JOIN user_properties up ON up.id = pr.user_property_id
     JOIN properties p ON p.id = up.property_id
     WHERE pr.status = \'active\'
     ORDER BY pr.created_at DESC'
) ?: [];

$myOffers = $db->fetchAll(
    'SELECT pr.*, p.name AS property_name
     FROM property_rental_offers pr
     JOIN user_properties up ON up.id = pr.user_property_id
     JOIN properties p ON p.id = up.property_id
     WHERE up.user_id = :uid
     ORDER BY pr.created_at DESC',
    ['uid' => $userId]
) ?: [];

$myLeases = $db->fetchAll(
    'SELECT pl.*, p.name AS property_name
     FROM property_leases pl
     JOIN user_properties up ON up.id = pl.user_property_id
     JOIN properties p ON p.id = up.property_id
     WHERE pl.tenant_user_id = :uid OR pl.landlord_user_id = :uid
     ORDER BY pl.end_at DESC',
    ['uid' => $userId]
) ?: [];

$owned = tcPropertyGetOwnedProperties($userId);
?>

<div class="main-content">
    <div class="content-wrapper">
        <div class="content-header">
            <h1 class="content-title">Rentals</h1>
            <p class="content-description">Browse available rentals or manage your offers.</p>
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
                <h2 class="tc-widget-title">Browse Rentals</h2>
            </div>
            <div class="tc-widget-body">
                <?php if (!$offers): ?>
                    <p class="tc-widget-text">No rental offers are available.</p>
                <?php else: ?>
                    <table class="tc-table-compact">
                        <thead>
                            <tr>
                                <th>Property</th>
                                <th>Happy</th>
                                <th>Days</th>
                                <th>Upfront</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($offers as $offer): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars((string)$offer['property_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo (int)($offer['base_happy'] ?? 0); ?></td>
                                    <td><?php echo (int)($offer['days'] ?? 0); ?></td>
                                    <td><?php echo formatCash((float)($offer['price_upfront'] ?? 0)); ?></td>
                                    <td>
                                        <form method="post" action="/modules/properties/actions.php">
                                            <input type="hidden" name="action" value="accept_rental_offer" />
                                            <input type="hidden" name="offer_id" value="<?php echo (int)$offer['id']; ?>" />
                                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>" />
                                            <button class="tc-btn tc-btn-primary" type="submit">Rent</button>
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
                <h2 class="tc-widget-title">Create Rental Offer</h2>
            </div>
            <div class="tc-widget-body">
                <?php if (!$owned): ?>
                    <p class="tc-widget-text">You do not own any properties to rent out.</p>
                <?php else: ?>
                    <form method="post" action="/modules/properties/actions.php">
                        <input type="hidden" name="action" value="create_rental_offer" />
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
                            <label>Days</label>
                            <input class="form-control" type="number" name="days" min="1" max="100" />
                        </div>
                        <div class="tc-form-row">
                            <label>Price upfront</label>
                            <input class="form-control" type="number" name="price_upfront" min="1" step="1" />
                        </div>
                        <button class="tc-btn tc-btn-secondary" type="submit">Create offer</button>
                    </form>
                <?php endif; ?>
            </div>
        </section>

        <section class="tc-widget tc-widget-hero">
            <div class="tc-widget-header">
                <h2 class="tc-widget-title">My Rentals</h2>
            </div>
            <div class="tc-widget-body">
                <?php if (!$myLeases): ?>
                    <p class="tc-widget-text">No active leases found.</p>
                <?php else: ?>
                    <table class="tc-table-compact">
                        <thead>
                            <tr>
                                <th>Property</th>
                                <th>Status</th>
                                <th>Ends</th>
                                <th>Extend</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($myLeases as $lease): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars((string)$lease['property_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars((string)($lease['status'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars((string)($lease['end_at'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td>
                                        <?php if ((int)($lease['landlord_user_id'] ?? 0) === $userId && (string)($lease['status'] ?? '') === 'active'): ?>
                                            <form method="post" action="/modules/properties/actions.php">
                                                <input type="hidden" name="action" value="extend_lease" />
                                                <input type="hidden" name="lease_id" value="<?php echo (int)$lease['id']; ?>" />
                                                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>" />
                                                <input class="form-control" type="number" name="days" min="1" max="100" style="max-width:120px; display:inline-block;" />
                                                <button class="tc-btn tc-btn-secondary" type="submit">Extend</button>
                                            </form>
                                        <?php endif; ?>
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
