<?php
/**
 * Post-login header partial (Dark Luxury scaffold)
 */
if (!defined('TC_BASE_PATH')) {
    define('TC_BASE_PATH', '/var/www/trench_city');
}

$tc_page_title = $tc_page_title ?? 'Trench City';
$user = $user ?? null;
$userId = null;

if (function_exists('currentUserId')) {
    $userId = currentUserId();
    if (!$user && $userId) {
        $user = getUser($userId);
    }
}

$displayName = $user['username'] ?? 'Citizen';
$displayLevel = isset($user['level']) ? (int)$user['level'] : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="theme-color" content="#05070B" />
    <title><?php echo htmlspecialchars($tc_page_title, ENT_QUOTES, 'UTF-8'); ?></title>
    <script>
        (function() {
            var theme = 'dark';
            try {
                var stored = window.localStorage ? window.localStorage.getItem('tcTheme') : null;
                if (stored === 'light' || stored === 'dark') {
                    theme = stored;
                }
            } catch (err) {
                theme = 'dark';
            }
            document.documentElement.setAttribute('data-theme', theme);
        })();
    </script>
    <link rel="stylesheet" href="/assets/css/global.css" />
    <script defer src="/assets/js/tc-global.js"></script>
</head>
<body class="tc-app">
<div class="tc-app-shell">
    <header class="tc-app-header">
        <button class="tc-header-button tc-sidebar-toggle" type="button" aria-label="Toggle navigation">
            <span class="tc-burger"><span></span><span></span><span></span></span>
        </button>
        <div class="tc-brand-group">
            <a class="tc-brand" href="/dashboard.php">
                <img
                    class="tc-brand-logo"
                    src="/assets/imgs/logo_dark.png"
                    alt="Trench City"
                    data-theme-logo
                    data-dark-logo="/assets/imgs/logo_dark.png"
                    data-light-logo="/assets/imgs/logo_light.png"
                />
                <span class="tc-brand-word tc-brand-word--gold">TRENCH</span>
                <span class="tc-brand-word">CITY</span>
            </a>
            <button class="tc-theme-toggle" type="button" data-theme-toggle aria-label="Toggle color mode">
                <span class="tc-theme-icon tc-theme-icon--sun" aria-hidden="true">☀</span>
                <span class="tc-theme-icon tc-theme-icon--moon" aria-hidden="true">🌙</span>
            </button>
        </div>
        <div class="tc-header-meta">
            <span class="tc-header-username"><?php echo htmlspecialchars($displayName, ENT_QUOTES, 'UTF-8'); ?></span>
            <?php if ($displayLevel !== null): ?>
                <span class="tc-header-level">Lv. <?php echo $displayLevel; ?></span>
            <?php endif; ?>
        </div>
        <div class="tc-header-actions">
            <a class="tc-header-action" href="/mail.php">
                <span class="tc-header-icon" aria-hidden="true"><img src="/assets/imgs/icons_32/mail.PNG" alt="Mail" /></span>
                <span class="tc-header-label">Mail</span>
            </a>
            <a class="tc-header-action" href="/settings.php">
                <span class="tc-header-icon" aria-hidden="true"><img src="/assets/imgs/icons_32/settings.PNG" alt="Settings" /></span>
                <span class="tc-header-label">Account</span>
            </a>
            <a class="tc-header-action" href="/logout.php">
                <span class="tc-header-icon" aria-hidden="true"><img src="/assets/imgs/icons_32/logout.PNG" alt="Logout" /></span>
                <span class="tc-header-label">Logout</span>
            </a>
        </div>
    </header>
    <div class="tc-app-layout">
        <aside class="tc-sidebar" data-sidebar>
            <?php include __DIR__ . '/postlogin-sidebar.php'; ?>
        </aside>
        <div class="tc-sidebar-overlay" aria-hidden="true"></div>
        <div class="tc-main-column">
