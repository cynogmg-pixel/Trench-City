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

$tc_page_title = 'Properties - Trench City';
include __DIR__ . '/../../includes/tc_header.php';
tcRenderPageStart(['mode' => 'postlogin']);

$flash = $_SESSION['property_flash'] ?? null;
unset($_SESSION['property_flash']);

tcExpireLeasesIfNeeded();
tcPropertyTickForUser($userId);
$details = tcPropertyGetCurrentResidenceDetails($userId);
$ownedProperties = tcPropertyGetOwnedProperties($userId);
$totals = $details ? tcGetPropertyTotals((int)$details['user_property']['id']) : null;
?>

<div class="main-content">
    <div class="content-wrapper">
        <div class="content-header">
            <h1 class="content-title">Properties</h1>
            <p class="content-description">Manage your residences, rentals, and upgrades.</p>
        </div>

        <?php if (!empty($flash['type'])): ?>
            <div class="alert alert-<?php echo htmlspecialchars((string)$flash['type'], ENT_QUOTES, 'UTF-8'); ?>">
                <div class="alert-content">
                    <div class="alert-message"><?php echo htmlspecialchars((string)($flash['message'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></div>
                </div>
            </div>
        <?php endif; ?>

        <div class="tc-dash-grid">
            <div class="tc-dash-main">
                <section class="tc-widget tc-widget-hero" data-widget-id="property-navigation">
                    <div class="tc-widget-header">
                        <h2 class="tc-widget-title">Property Actions</h2>
                        <button class="tc-widget-toggle" type="button" data-widget-toggle aria-expanded="true">-</button>
                    </div>
                    <div class="tc-widget-body">
                        <div class="tc-widget-actions" style="display:flex; flex-wrap:wrap; gap:0.5rem;">
                            <a class="tc-btn tc-btn-secondary" href="/manage_property.php">Manage</a>
                            <a class="tc-btn tc-btn-secondary" href="/estate_agents.php">Estate Agents</a>
                            <a class="tc-btn tc-btn-secondary" href="/selling_market.php">Market</a>
                            <a class="tc-btn tc-btn-secondary" href="/rentals.php">Rentals</a>
                        </div>
                    </div>
                </section>

                <section class="tc-widget tc-widget-hero">
                    <div class="tc-widget-header">
                        <h2 class="tc-widget-title">Current Residence</h2>
                    </div>
                    <div class="tc-widget-body">
                        <?php if (!$details): ?>
                            <p class="tc-widget-text">You do not currently have a residence.</p>
                        <?php else: ?>
                            <div class="tc-table-compact">
                                <table>
                                    <tbody>
                                        <tr>
                                            <th>Property</th>
                                            <td><?php echo htmlspecialchars((string)($details['property']['name'] ?? 'Unknown'), ENT_QUOTES, 'UTF-8'); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td><?php echo $details['residence']['mode'] === 'tenant' ? 'Leasing' : 'Owner'; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Effective Happy</th>
                                            <td><?php echo (int)($details['user_property']['cached_effective_happy'] ?? 0); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Total Happy</th>
                                            <td><?php echo $totals ? (int)($totals['total_happy'] ?? 0) : 0; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Daily Upkeep</th>
                                            <td><?php echo $totals ? formatCash((float)($totals['daily_upkeep_total'] ?? 0)) : formatCash(0); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Upkeep Debt</th>
                                            <td><?php echo formatCash((float)($details['user_property']['upkeep_debt'] ?? 0)); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Vault Balance</th>
                                            <td><?php echo formatCash((float)($details['user_property']['vault_balance'] ?? 0)); ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <?php if (!empty($details['residence']['lease'])): ?>
                                <div class="tc-widget-sub">
                                    <strong>Lease ends:</strong> <?php echo htmlspecialchars((string)($details['residence']['lease']['end_at'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>
                                </div>
                            <?php endif; ?>

                        <?php endif; ?>
                    </div>
                </section>

                <section class="tc-widget tc-widget-hero" data-widget-id="owned-properties">
                    <div class="tc-widget-header">
                        <h2 class="tc-widget-title">Owned Properties</h2>
                        <button class="tc-widget-toggle" type="button" data-widget-toggle aria-expanded="true">-</button>
                    </div>
                    <div class="tc-widget-body">
                        <?php if (!$ownedProperties): ?>
                            <p class="tc-widget-text">You do not own any properties yet.</p>
                        <?php else: ?>
                            <table class="tc-table-compact">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Tier</th>
                                        <th>Primary</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($ownedProperties as $prop): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars((string)$prop['property_name'], ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td><?php echo (int)($prop['property_tier'] ?? 0); ?></td>
                                            <td><?php echo (int)($prop['is_primary'] ?? 0) === 1 ? 'Yes' : 'No'; ?></td>
                                            <td>
                                                <form method="post" action="/modules/properties/actions.php" style="display:inline-block;">
                                                    <input type="hidden" name="action" value="move_in" />
                                                    <input type="hidden" name="user_property_id" value="<?php echo (int)$prop['id']; ?>" />
                                                    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>" />
                                                    <button class="tc-btn tc-btn-secondary" type="submit">Move in</button>
                                                </form>
                                                <a class="tc-btn tc-btn-primary" href="/manage_property.php?user_property_id=<?php echo (int)$prop['id']; ?>">Manage</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                </section>
            </div>

            <div class="tc-dash-side">
                <section class="tc-widget tc-widget-hero" data-widget-id="upkeep-actions">
                    <div class="tc-widget-header">
                        <h2 class="tc-widget-title">Upkeep</h2>
                        <button class="tc-widget-toggle" type="button" data-widget-toggle aria-expanded="true">-</button>
                    </div>
                    <div class="tc-widget-body">
                        <form method="post" action="/modules/properties/actions.php">
                            <input type="hidden" name="action" value="pay_upkeep" />
                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>" />
                            <div class="tc-form-row">
                                <label>Amount</label>
                                <input class="form-control" type="number" name="amount" min="1" step="1" />
                            </div>
                            <button class="tc-btn tc-btn-primary" type="submit">Pay upkeep</button>
                        </form>
                    </div>
                </section>

                <section class="tc-widget tc-widget-hero" data-widget-id="vault-actions">
                    <div class="tc-widget-header">
                        <h2 class="tc-widget-title">Vault</h2>
                        <button class="tc-widget-toggle" type="button" data-widget-toggle aria-expanded="true">-</button>
                    </div>
                    <div class="tc-widget-body">
                        <form method="post" action="/modules/properties/actions.php" style="margin-bottom:1rem;">
                            <input type="hidden" name="action" value="vault_deposit" />
                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>" />
                            <div class="tc-form-row">
                                <label>Deposit</label>
                                <input class="form-control" type="number" name="amount" min="1" step="1" />
                            </div>
                            <button class="tc-btn tc-btn-secondary" type="submit">Deposit</button>
                        </form>
                        <form method="post" action="/modules/properties/actions.php">
                            <input type="hidden" name="action" value="vault_withdraw" />
                            <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token(), ENT_QUOTES, 'UTF-8'); ?>" />
                            <div class="tc-form-row">
                                <label>Withdraw</label>
                                <input class="form-control" type="number" name="amount" min="1" step="1" />
                            </div>
                            <button class="tc-btn tc-btn-secondary" type="submit">Withdraw</button>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

<?php
if (function_exists('tcRenderPageEnd')) {
    tcRenderPageEnd(['mode' => 'postlogin']);
}
?>
