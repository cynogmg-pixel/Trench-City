<?php
/**
 * TRENCH CITY - PLAYER DASHBOARD MODULE
 * Module version of dashboard (for consistency with module structure)
 * This provides the same functionality as /public/dashboard.php
 * but can be accessed via module routing
 */

// Bootstrap and authentication
if (!defined('TRENCH_CITY')) {
    require_once __DIR__ . '/../../core/bootstrap.php';
}
requireLogin();

// Get current user data
$userId = currentUserId();
$user = getUser($userId);
$stats = getUserStats($userId);
$bars = getUserBars($userId);

// Validate data loaded
if (!$user) {
    header('Location: /login.php');
    exit;
}

// Calculate level and XP progress
$currentLevel = calculateLevel((int)($user['xp'] ?? 0));
$currentXP = (int)($user['xp'] ?? 0);
$nextLevel = $currentLevel + 1;
$xpForCurrentLevel = getXPForLevel($currentLevel);
$xpForNextLevel = getXPForLevel($nextLevel);
$xpProgress = $xpForNextLevel > $xpForCurrentLevel
    ? (($currentXP - $xpForCurrentLevel) / ($xpForNextLevel - $xpForCurrentLevel)) * 100
    : 100;

$lifeCurrent = (int)($bars['life_current'] ?? 0);
$lifeMax = (int)($bars['life_max'] ?? 0);
$lifeDisplay = $lifeMax > 0 ? number_format($lifeCurrent) . ' / ' . number_format($lifeMax) : '0 / 0';

$strength = (int)($stats['strength'] ?? 0);
$defense = (int)($stats['defense'] ?? 0);
$speed = (int)($stats['speed'] ?? 0);
$dexterity = (int)($stats['dexterity'] ?? 0);
$battleTotal = $strength + $defense + $speed + $dexterity;

// Page title
$tc_page_title = 'Dashboard - Trench City';

// Include header (if not already included)
if (!defined('TC_HEADER_LOADED')) {
    include __DIR__ . '/../../includes/tc_header.php';
    $headHtml = "\n"
        . "<link rel=\"stylesheet\" href=\"/assets/css/tc-tokens.css\" />\n"
        . "<link rel=\"stylesheet\" href=\"/assets/css/tc-themes.css\" />\n"
        . "<link rel=\"stylesheet\" href=\"/assets/css/tc-components.css\" />\n"
        . "<link rel=\"stylesheet\" href=\"/assets/css/tc-layout.css\" />\n"
        . "<link rel=\"stylesheet\" href=\"/assets/css/dashboard-header-topfix.css\" />\n";
    tcRenderPageStart([
        'mode' => 'postlogin',
        'head_html' => $headHtml,
        'body_class' => 'tc-app tc-page-dashboard'
    ]);
    define('TC_HEADER_LOADED', true);
}
?>

<!-- Main Content -->
<div class="main-content tc-page-dashboard">
    <div class="content-wrapper">

        <!-- Page Header -->
        <div class="content-header">
            <h1 class="content-title">Home</h1>
            <p class="content-description">Welcome back, <?php echo htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8'); ?>.</p>
        </div>

        <div class="tc-dash-grid">
            <div class="tc-dash-main">
                <section class="tc-widget tc-widget-hero" data-widget-id="tutorial">
                    <div class="tc-widget-header">
                        <h2 class="tc-widget-title">Home Tutorial</h2>
                        <div class="tc-widget-actions">
                            <button class="tc-tutorial-toggle" type="button" data-tutorial-toggle>Hide</button>
                            <button class="tc-widget-toggle" type="button" data-widget-toggle aria-expanded="true">-</button>
                        </div>
                    </div>
                    <div class="tc-widget-body tc-tutorial-body">
                        <p class="tc-widget-text">
                            Welcome to Trench City. Keep your bars full, train your stats, and build income.
                            Use the sidebar to move between core systems and return here to track your progress.
                        </p>
                    </div>
                </section>

                <section class="tc-widget tc-widget-hero" data-widget-id="general-info">
                    <div class="tc-widget-header">
                        <h2 class="tc-widget-title">General Information</h2>
                        <button class="tc-widget-toggle" type="button" data-widget-toggle aria-expanded="true">-</button>
                    </div>
                    <div class="tc-widget-body">
                        <table class="tc-table-compact">
                            <tbody>
                                <tr>
                                    <th>Name</th>
                                    <td><a class="tc-link" href="/profile.php"><?php echo htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8'); ?></a></td>
                                </tr>
                                <tr>
                                    <th>Money</th>
                                    <td><?php echo formatCash((float)($user['cash'] ?? 0)); ?></td>
                                </tr>
                                <tr>
                                    <th>Points</th>
                                    <td>0</td>
                                </tr>
                                <tr>
                                    <th>Level</th>
                                    <td><?php echo number_format($currentLevel); ?></td>
                                </tr>
                                <tr>
                                    <th>Rank</th>
                                    <td>Citizen</td>
                                </tr>
                                <tr>
                                    <th>Life</th>
                                    <td><?php echo $lifeDisplay; ?></td>
                                </tr>
                                <tr>
                                    <th>Age</th>
                                    <td>N/A</td>
                                </tr>
                                <tr>
                                    <th>Networth</th>
                                    <td>N/A</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

                <section class="tc-widget tc-widget-hero" data-widget-id="status-bars">
                    <div class="tc-widget-header">
                        <h2 class="tc-widget-title">Status Bars</h2>
                        <button class="tc-widget-toggle" type="button" data-widget-toggle aria-expanded="true">-</button>
                    </div>
                    <div class="tc-widget-body">
                        <?php if ($bars): ?>
                            <?php include __DIR__ . '/../../includes/widgets/bars_widget.php'; ?>
                        <?php else: ?>
                            <div class="alert alert-warning">
                                <div class="alert-content">
                                    <div class="alert-message">Bars data not available</div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>

                <section class="tc-widget tc-widget-hero" data-widget-id="battle-stats">
                    <div class="tc-widget-header">
                        <h2 class="tc-widget-title">Battle Stats</h2>
                        <button class="tc-widget-toggle" type="button" data-widget-toggle aria-expanded="true">-</button>
                    </div>
                    <div class="tc-widget-body">
                        <table class="tc-table-compact">
                            <tbody>
                                <tr>
                                    <th>Strength</th>
                                    <td><?php echo number_format($strength); ?></td>
                                </tr>
                                <tr>
                                    <th>Defense</th>
                                    <td><?php echo number_format($defense); ?></td>
                                </tr>
                                <tr>
                                    <th>Speed</th>
                                    <td><?php echo number_format($speed); ?></td>
                                </tr>
                                <tr>
                                    <th>Dexterity</th>
                                    <td><?php echo number_format($dexterity); ?></td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <td><?php echo number_format($battleTotal); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

                <section class="tc-widget tc-widget-hero" data-widget-id="working-stats">
                    <div class="tc-widget-header">
                        <h2 class="tc-widget-title">Working Stats</h2>
                        <button class="tc-widget-toggle" type="button" data-widget-toggle aria-expanded="true">-</button>
                    </div>
                    <div class="tc-widget-body">
                        <table class="tc-table-compact">
                            <tbody>
                                <tr>
                                    <th>Manual labor</th>
                                    <td>0</td>
                                </tr>
                                <tr>
                                    <th>Intelligence</th>
                                    <td>0</td>
                                </tr>
                                <tr>
                                    <th>Endurance</th>
                                    <td>0</td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <td>0 <span class="tc-note">Coming soon</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

                <section class="tc-widget tc-widget-hero" data-widget-id="skill-levels">
                    <div class="tc-widget-header">
                        <h2 class="tc-widget-title">Skill Levels</h2>
                        <button class="tc-widget-toggle" type="button" data-widget-toggle aria-expanded="true">-</button>
                    </div>
                    <div class="tc-widget-body">
                        <div class="tc-empty-state">No skills tracked yet.</div>
                    </div>
                </section>

                <section class="tc-widget tc-widget-hero" data-widget-id="latest-events">
                    <div class="tc-widget-header">
                        <h2 class="tc-widget-title">Latest Events</h2>
                        <button class="tc-widget-toggle" type="button" data-widget-toggle aria-expanded="true">-</button>
                    </div>
                    <div class="tc-widget-body">
                        <ul class="tc-list-compact">
                            <li>No recent events.</li>
                        </ul>
                    </div>
                </section>

                <section class="tc-widget tc-widget-hero" data-widget-id="latest-messages">
                    <div class="tc-widget-header">
                        <h2 class="tc-widget-title">Latest Messages</h2>
                        <button class="tc-widget-toggle" type="button" data-widget-toggle aria-expanded="true">-</button>
                    </div>
                    <div class="tc-widget-body">
                        <ul class="tc-list-compact">
                            <li>No new messages.</li>
                        </ul>
                    </div>
                </section>

                <section class="tc-widget tc-widget-hero" data-widget-id="latest-attacks">
                    <div class="tc-widget-header">
                        <h2 class="tc-widget-title">Latest Attacks</h2>
                        <button class="tc-widget-toggle" type="button" data-widget-toggle aria-expanded="true">-</button>
                    </div>
                    <div class="tc-widget-body">
                        <ul class="tc-list-compact">
                            <li>No attacks logged.</li>
                        </ul>
                    </div>
                </section>
            </div>

            <div class="tc-dash-side">
                <section class="tc-widget tc-widget-hero" data-widget-id="property-info">
                    <div class="tc-widget-header">
                        <h2 class="tc-widget-title">Property Information</h2>
                        <button class="tc-widget-toggle" type="button" data-widget-toggle aria-expanded="true">-</button>
                    </div>
                    <div class="tc-widget-body">
                        <div class="tc-property-media">
                            <img src="/assets/imgs/london.jpg" alt="Property" />
                        </div>
                        <table class="tc-table-compact">
                            <tbody>
                                <tr>
                                    <th>Property</th>
                                    <td>Safehouse</td>
                                </tr>
                                <tr>
                                    <th>Cost</th>
                                    <td>N/A</td>
                                </tr>
                                <tr>
                                    <th>Fees</th>
                                    <td>N/A</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

                <section class="tc-widget tc-widget-hero" data-widget-id="equipment">
                    <div class="tc-widget-header">
                        <h2 class="tc-widget-title">Equipped Weapons &amp; Armor</h2>
                        <button class="tc-widget-toggle" type="button" data-widget-toggle aria-expanded="true">-</button>
                    </div>
                    <div class="tc-widget-body">
                        <div class="tc-equip-grid">
                            <div class="tc-equip-slot">
                                <span>Primary</span>
                                <em>Empty</em>
                            </div>
                            <div class="tc-equip-slot">
                                <span>Secondary</span>
                                <em>Empty</em>
                            </div>
                            <div class="tc-equip-slot">
                                <span>Melee</span>
                                <em>Empty</em>
                            </div>
                            <div class="tc-equip-slot">
                                <span>Armor</span>
                                <em>Empty</em>
                            </div>
                            <div class="tc-equip-slot">
                                <span>Helmet</span>
                                <em>Empty</em>
                            </div>
                            <div class="tc-equip-slot">
                                <span>Accessory</span>
                                <em>Empty</em>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="tc-widget tc-widget-hero" data-widget-id="job-info">
                    <div class="tc-widget-header">
                        <h2 class="tc-widget-title">Job Information</h2>
                        <button class="tc-widget-toggle" type="button" data-widget-toggle aria-expanded="true">-</button>
                    </div>
                    <div class="tc-widget-body">
                        <table class="tc-table-compact">
                            <tbody>
                                <tr>
                                    <th>Job</th>
                                    <td>N/A</td>
                                </tr>
                                <tr>
                                    <th>Rank</th>
                                    <td>N/A</td>
                                </tr>
                                <tr>
                                    <th>Income</th>
                                    <td>N/A</td>
                                </tr>
                                <tr>
                                    <th>Job points</th>
                                    <td>0</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

                <section class="tc-widget tc-widget-hero" data-widget-id="faction-info">
                    <div class="tc-widget-header">
                        <h2 class="tc-widget-title">Faction Information</h2>
                        <button class="tc-widget-toggle" type="button" data-widget-toggle aria-expanded="true">-</button>
                    </div>
                    <div class="tc-widget-body">
                        <table class="tc-table-compact">
                            <tbody>
                                <tr>
                                    <th>Faction</th>
                                    <td>N/A</td>
                                </tr>
                                <tr>
                                    <th>Days in faction</th>
                                    <td>0</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

                <section class="tc-widget tc-widget-hero" data-widget-id="criminal-record">
                    <div class="tc-widget-header">
                        <h2 class="tc-widget-title">Criminal Record</h2>
                        <button class="tc-widget-toggle" type="button" data-widget-toggle aria-expanded="true">-</button>
                    </div>
                    <div class="tc-widget-body">
                        <table class="tc-table-compact">
                            <tbody>
                                <tr>
                                    <th>Theft</th>
                                    <td>0</td>
                                </tr>
                                <tr>
                                    <th>Fraud</th>
                                    <td>0</td>
                                </tr>
                                <tr>
                                    <th>Robbery</th>
                                    <td>0</td>
                                </tr>
                                <tr>
                                    <th>Assault</th>
                                    <td>0</td>
                                </tr>
                                <tr>
                                    <th>Cyber</th>
                                    <td>0</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </section>

                <section class="tc-widget tc-widget-hero" data-widget-id="personal-perks">
                    <div class="tc-widget-header">
                        <h2 class="tc-widget-title">Personal Perks</h2>
                        <button class="tc-widget-toggle" type="button" data-widget-toggle aria-expanded="true">-</button>
                    </div>
                    <div class="tc-widget-body">
                        <div class="tc-empty-state">You don't have any perks yet.</div>
                    </div>
                </section>
            </div>
        </div>

    </div>
</div>

<?php if (function_exists('tcRenderPageEnd')): ?>
    <?php tcRenderPageEnd(['mode' => 'postlogin']); ?>
<?php else: ?>
    </body>
    </html>
<?php endif; ?>