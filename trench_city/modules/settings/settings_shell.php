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
$currentLevel = calculateLevel((int)$user['xp']);
$currentXP = (int)$user['xp'];
$nextLevel = $currentLevel + 1;
$xpForCurrentLevel = getXPForLevel($currentLevel);
$xpForNextLevel = getXPForLevel($nextLevel);
$xpProgress = $xpForNextLevel > $xpForCurrentLevel
    ? (($currentXP - $xpForCurrentLevel) / ($xpForNextLevel - $xpForCurrentLevel)) * 100
    : 100;

// Page title
$tc_page_title = 'Dashboard - Trench City';

// Include header (if not already included)
if (!defined('TC_HEADER_LOADED')) {
    include __DIR__ . '/../../includes/tc_header.php';
    tcRenderPageStart(['mode' => 'postlogin']);
    define('TC_HEADER_LOADED', true);
}
?>

<!-- Sidebar -->
<?php if (!defined('TC_SIDEBAR_LOADED')): ?>
    <?php include __DIR__ . '/../../includes/postlogin-sidebar.php'; ?>
    <?php define('TC_SIDEBAR_LOADED', true); ?>
<?php endif; ?>

<!-- Main Content -->
<div class="main-content">
    <div class="content-wrapper">

        <!-- Page Header -->
        <div class="content-header">
            <h1 class="content-title">Welcome back, <?php echo htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8'); ?></h1>
            <p class="content-description">Your criminal empire awaits</p>
        </div>

        <!-- Dashboard Grid -->
        <div class="grid grid-3">

            <!-- Player Snapshot Card -->
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Player Info</h2>
                </div>
                <div class="card-body">
                    <div style="margin-bottom: 1rem;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                            <span class="text-muted">Username</span>
                            <span class="font-bold"><?php echo htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8'); ?></span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                            <span class="text-muted">Level</span>
                            <span class="font-bold text-gold"><?php echo number_format($currentLevel); ?></span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                            <span class="text-muted">Cash</span>
                            <span class="font-bold text-success"><?php echo formatCash((float)($user['cash'] ?? 0)); ?></span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                            <span class="text-muted">Bank</span>
                            <span class="font-bold"><?php echo formatCash((float)($user['bank'] ?? 0)); ?></span>
                        </div>
                    </div>

                    <div class="divider"></div>

                    <!-- XP Progress -->
                    <div style="margin-top: 1rem;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                            <span class="text-muted" style="font-size: 0.875rem;">Experience</span>
                            <span class="text-muted" style="font-size: 0.875rem;"><?php echo number_format($currentXP); ?> XP</span>
                        </div>
                        <div class="bar-wrapper">
                            <div class="bar-fill bar-energy" style="width: <?php echo min(100, $xpProgress); ?>%;">
                                <span class="bar-text"><?php echo round($xpProgress); ?>%</span>
                            </div>
                        </div>
                        <div style="text-align: center; margin-top: 0.5rem; font-size: 0.75rem; color: #6B7280;">
                            <?php echo number_format($xpForNextLevel - $currentXP); ?> XP to Level <?php echo $nextLevel; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bars Card -->
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Status Bars</h2>
                </div>
                <div class="card-body">
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
            </div>

            <!-- Stats Card -->
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Combat Stats</h2>
                </div>
                <div class="card-body">
                    <?php if ($stats): ?>
                        <div style="display: grid; gap: 1rem;">
                            <!-- Strength -->
                            <div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                                    <span class="text-muted">Strength</span>
                                    <span class="font-bold"><?php echo number_format((int)($stats['strength'] ?? 0)); ?></span>
                                </div>
                                <div class="bar-wrapper" style="height: 8px;">
                                    <div class="bar-fill bar-life" style="width: <?php echo min(100, ((int)($stats['strength'] ?? 0) / 100)); ?>%;"></div>
                                </div>
                            </div>

                            <!-- Defense -->
                            <div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                                    <span class="text-muted">Defense</span>
                                    <span class="font-bold"><?php echo number_format((int)($stats['defense'] ?? 0)); ?></span>
                                </div>
                                <div class="bar-wrapper" style="height: 8px;">
                                    <div class="bar-fill bar-nerve" style="width: <?php echo min(100, ((int)($stats['defense'] ?? 0) / 100)); ?>%;"></div>
                                </div>
                            </div>

                            <!-- Speed -->
                            <div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                                    <span class="text-muted">Speed</span>
                                    <span class="font-bold"><?php echo number_format((int)($stats['speed'] ?? 0)); ?></span>
                                </div>
                                <div class="bar-wrapper" style="height: 8px;">
                                    <div class="bar-fill bar-happy" style="width: <?php echo min(100, ((int)($stats['speed'] ?? 0) / 100)); ?>%;"></div>
                                </div>
                            </div>

                            <!-- Dexterity -->
                            <div>
                                <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                                    <span class="text-muted">Dexterity</span>
                                    <span class="font-bold"><?php echo number_format((int)($stats['dexterity'] ?? 0)); ?></span>
                                </div>
                                <div class="bar-wrapper" style="height: 8px;">
                                    <div class="bar-fill bar-energy" style="width: <?php echo min(100, ((int)($stats['dexterity'] ?? 0) / 100)); ?>%;"></div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning">
                            <div class="alert-content">
                                <div class="alert-message">Stats data not available</div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        </div>

        <!-- Quick Actions Section -->
        <div class="page-section" style="margin-top: 2rem;">
            <div class="section-header">
                <h2 class="section-title">Quick Actions</h2>
            </div>

            <div class="grid grid-4">
                <!-- Crime -->
                <div class="card card-compact" style="text-align: center; cursor: pointer;" onclick="window.location.href='/crimes.php'">
                    <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">=+</div>
                    <h3 style="font-size: 1rem; font-weight: 600; color: #F9FAFB; margin-bottom: 0.25rem;">Crimes</h3>
                    <p style="font-size: 0.875rem; color: #9CA3AF; margin: 0;">Commit crimes</p>
                </div>

                <!-- Gym -->
                <div class="card card-compact" style="text-align: center; cursor: pointer;" onclick="window.location.href='/gym.php'">
                    <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">=ª</div>
                    <h3 style="font-size: 1rem; font-weight: 600; color: #F9FAFB; margin-bottom: 0.25rem;">Gym</h3>
                    <p style="font-size: 0.875rem; color: #9CA3AF; margin: 0;">Train stats</p>
                </div>

                <!-- City -->
                <div class="card card-compact" style="text-align: center; cursor: pointer;" onclick="window.location.href='/city.php'">
                    <div style="font-size: 2.5rem; margin-bottom: 0.5rem;"><Ù</div>
                    <h3 style="font-size: 1rem; font-weight: 600; color: #F9FAFB; margin-bottom: 0.25rem;">City</h3>
                    <p style="font-size: 0.875rem; color: #9CA3AF; margin: 0;">Explore the city</p>
                </div>

                <!-- Profile -->
                <div class="card card-compact" style="text-align: center; cursor: pointer;" onclick="window.location.href='/profile.php'">
                    <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">=d</div>
                    <h3 style="font-size: 1rem; font-weight: 600; color: #F9FAFB; margin-bottom: 0.25rem;">Profile</h3>
                    <p style="font-size: 0.875rem; color: #9CA3AF; margin: 0;">View profile</p>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Load CSS Assets (if not already loaded) -->
<?php if (!defined('TC_CSS_LOADED')): ?>
<link rel="stylesheet" href="/assets/css/tc-tokens.css">
<link rel="stylesheet" href="/assets/css/tc-themes.css">
<link rel="stylesheet" href="/assets/css/tc-components.css">
<link rel="stylesheet" href="/assets/css/tc-layout.css">
<?php define('TC_CSS_LOADED', true); ?>
<?php endif; ?>

<!-- Load JavaScript Assets (if not already loaded) -->
<?php if (!defined('TC_JS_LOADED')): ?>
<script src="/assets/js/tc-global.js"></script>
<?php define('TC_JS_LOADED', true); ?>
<?php endif; ?>

<!-- Custom Dashboard Styles -->
<style>
/* Dashboard-specific overrides and enhancements */
.card {
    height: 100%;
}

.quick-action-card {
    transition: all 0.3s ease;
}

.quick-action-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 16px rgba(212, 175, 55, 0.4);
    border-color: #D4AF37;
}

/* Ensure grid items are equal height */
.grid > .card {
    display: flex;
    flex-direction: column;
}

.card-body {
    flex: 1;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .grid-3,
    .grid-4 {
        grid-template-columns: 1fr;
    }
}

@media (min-width: 769px) and (max-width: 1024px) {
    .grid-3 {
        grid-template-columns: repeat(2, 1fr);
    }

    .grid-4 {
        grid-template-columns: repeat(2, 1fr);
    }
}
</style>

<?php if (!defined('TC_FOOTER_LOADED')): ?>
</body>
</html>
<?php define('TC_FOOTER_LOADED', true); ?>
<?php endif; ?>






