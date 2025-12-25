<?php
/**
 * Unified header renderer for prelogin, postlogin, and maintenance modes.
 */

if (!function_exists('tcRenderHeader')) {
    function tcRenderHeader(array $config = []): void
    {
        // ONE SOURCE OF TRUTH (keeps every header/logo identical across modes)
        $TC_HEADER_HEIGHT_PX = 112; // consistent height everywhere
        $TC_LOGO_HEIGHT_PX   = 93;  // MUST match postlogin logo size everywhere

        $mode = $config['mode'] ?? 'prelogin';

        if ($mode === 'postlogin') {
            $user = $config['user'] ?? null;
            $userId = $config['user_id'] ?? null;

            if ($userId === null && function_exists('currentUserId')) {
                $userId = currentUserId();
            }

            if (!$user && $userId && function_exists('getUser')) {
                $user = getUser($userId);
            }

            $displayName = $user['username'] ?? 'Citizen';
            $displayLevel = isset($user['level']) ? (int)$user['level'] : null;

            if ($userId && function_exists('regenerateUserBars')) {
                $bars = regenerateUserBars($userId);
            } elseif ($userId && function_exists('getUserBars')) {
                $bars = getUserBars($userId);
            } else {
                $bars = null;
            }

            $regenTimers = null;
            if ($userId && function_exists('getBarRegenTimers')) {
                $regenTimers = getBarRegenTimers($userId);
            }

            $energyCurrent = (int)($bars['energy_current'] ?? 0);
            $energyMax     = (int)($bars['energy_max'] ?? 100);

            $nerveCurrent  = (int)($bars['nerve_current'] ?? 0);
            $nerveMax      = (int)($bars['nerve_max'] ?? 15);

            $happyCurrent  = (int)($bars['happy_current'] ?? 0);
            $happyMax      = (int)($bars['happy_max'] ?? 100);

            $lifeCurrent   = (int)($bars['life_current'] ?? 0);
            $lifeMax       = (int)($bars['life_max'] ?? 100);

            $userLevel = (int)($user['level'] ?? 0);

            // This value is XP in your current schema usage.
            // If you later add a true "points" column, swap it here (do not relabel without changing source).
            $userXP = (int)($user['xp'] ?? 0);

            $userCash = (float)($user['cash'] ?? 0);
            $userBank = (float)($user['bank_balance'] ?? 0);

            $brandHref       = $config['brand_href'] ?? '/dashboard.php';
            $showThemeToggle = $config['show_theme_toggle'] ?? true;

            $themeIconSun  = $config['theme_icon_sun'] ?? '☀';
            $themeIconMoon = $config['theme_icon_moon'] ?? '🌙';

            $energyPct = ($energyMax > 0) ? min(100, ($energyCurrent / $energyMax) * 100) : 0;
            $nervePct  = ($nerveMax > 0) ? min(100, ($nerveCurrent / $nerveMax) * 100) : 0;
            $happyPct  = ($happyMax > 0) ? min(100, ($happyCurrent / $happyMax) * 100) : 0;
            $lifePct   = ($lifeMax > 0) ? min(100, ($lifeCurrent / $lifeMax) * 100) : 0;

            $energySeconds   = ($energyCurrent < $energyMax && $regenTimers) ? (int)($regenTimers['energy_seconds'] ?? 0) : 0;
            $energyFormatted = ($energyCurrent < $energyMax && $regenTimers) ? (string)($regenTimers['energy_formatted'] ?? '00:00') : '00:00';

            $nerveSeconds   = ($nerveCurrent < $nerveMax && $regenTimers) ? (int)($regenTimers['nerve_seconds'] ?? 0) : 0;
            $nerveFormatted = ($nerveCurrent < $nerveMax && $regenTimers) ? (string)($regenTimers['nerve_formatted'] ?? '00:00') : '00:00';

            $happySeconds   = ($happyCurrent < $happyMax && $regenTimers) ? (int)($regenTimers['happy_seconds'] ?? 0) : 0;
            $happyFormatted = ($happyCurrent < $happyMax && $regenTimers) ? (string)($regenTimers['happy_formatted'] ?? '00:00') : '00:00';

            $lifeSeconds   = ($lifeCurrent < $lifeMax && $regenTimers) ? (int)($regenTimers['life_seconds'] ?? 0) : 0;
            $lifeFormatted = ($lifeCurrent < $lifeMax && $regenTimers) ? (string)($regenTimers['life_formatted'] ?? '00:00') : '00:00';
            ?>
            <header class="tc-app-header" style="height: <?php echo (int)$TC_HEADER_HEIGHT_PX; ?>px; box-sizing: border-box;">
                <div class="tc-header-meta">
                    <span class="tc-header-username"><?php echo htmlspecialchars($displayName, ENT_QUOTES, 'UTF-8'); ?></span>
                    <?php if ($displayLevel !== null): ?>
                        <span class="tc-header-level">Lv. <?php echo $displayLevel; ?></span>
                    <?php endif; ?>
                </div>

                <div class="tc-header-stats-container tc-header-stats--left">
                    <div class="tc-header-stat-wrapper">
                        <div class="tc-header-stat-box">
                            <span class="tc-header-stat-name">ENERGY</span>
                            <span class="tc-header-stat-value"><?php echo $energyCurrent; ?> / <?php echo $energyMax; ?></span>
                            <div class="tc-header-stat-bar">
                                <div class="tc-header-stat-fill tc-header-stat-fill--energy" style="width: <?php echo $energyPct; ?>%;"></div>
                            </div>
                        </div>
                        <span class="tc-header-stat-timer" data-bar="energy" data-label="Energy" data-seconds="<?php echo $energySeconds; ?>">
                            Energy: [<?php echo htmlspecialchars($energyFormatted, ENT_QUOTES, 'UTF-8'); ?>] Remaining...
                        </span>
                    </div>

                    <div class="tc-header-stat-wrapper">
                        <div class="tc-header-stat-box">
                            <span class="tc-header-stat-name">NERVE</span>
                            <span class="tc-header-stat-value"><?php echo $nerveCurrent; ?> / <?php echo $nerveMax; ?></span>
                            <div class="tc-header-stat-bar">
                                <div class="tc-header-stat-fill tc-header-stat-fill--nerve" style="width: <?php echo $nervePct; ?>%;"></div>
                            </div>
                        </div>
                        <span class="tc-header-stat-timer" data-bar="nerve" data-label="Nerve" data-seconds="<?php echo $nerveSeconds; ?>">
                            Nerve: [<?php echo htmlspecialchars($nerveFormatted, ENT_QUOTES, 'UTF-8'); ?>] Remaining...
                        </span>
                    </div>

                    <div class="tc-header-stat-wrapper">
                        <div class="tc-header-stat-box">
                            <span class="tc-header-stat-name">HAPPY</span>
                            <span class="tc-header-stat-value"><?php echo $happyCurrent; ?> / <?php echo $happyMax; ?></span>
                            <div class="tc-header-stat-bar">
                                <div class="tc-header-stat-fill tc-header-stat-fill--happy" style="width: <?php echo $happyPct; ?>%;"></div>
                            </div>
                        </div>
                        <span class="tc-header-stat-timer" data-bar="happy" data-label="Happy" data-seconds="<?php echo $happySeconds; ?>">
                            Happy: [<?php echo htmlspecialchars($happyFormatted, ENT_QUOTES, 'UTF-8'); ?>] Remaining...
                        </span>
                    </div>

                    <div class="tc-header-stat-wrapper">
                        <div class="tc-header-stat-box">
                            <span class="tc-header-stat-name">LIFE</span>
                            <span class="tc-header-stat-value"><?php echo $lifeCurrent; ?> / <?php echo $lifeMax; ?></span>
                            <div class="tc-header-stat-bar">
                                <div class="tc-header-stat-fill tc-header-stat-fill--life" style="width: <?php echo $lifePct; ?>%;"></div>
                            </div>
                        </div>
                        <span class="tc-header-stat-timer" data-bar="life" data-label="Life" data-seconds="<?php echo $lifeSeconds; ?>">
                            Life: [<?php echo htmlspecialchars($lifeFormatted, ENT_QUOTES, 'UTF-8'); ?>] Remaining...
                        </span>
                    </div>
                </div>

                <div class="tc-brand-group">
                    <a class="tc-brand" href="<?php echo htmlspecialchars($brandHref, ENT_QUOTES, 'UTF-8'); ?>">
                        <img
                            class="tc-brand-logo"
                            src="/assets/imgs/logo.png"
                            alt="Trench City"
                            style="height: <?php echo (int)$TC_LOGO_HEIGHT_PX; ?>px !important; width: auto !important; max-height: none !important; max-width: none !important; display: block;"
                            data-theme-logo
                            data-dark-logo="/assets/imgs/logo.png"
                            data-light-logo="/assets/imgs/logo.png"
                        />
                    </a>
                </div>

                <div class="tc-header-stats-container tc-header-stats--right">
                    <div class="tc-header-stat-wrapper">
                        <div class="tc-header-stat-box">
                            <span class="tc-header-stat-name">LEVEL</span>
                            <span class="tc-header-stat-value"><?php echo number_format($userLevel); ?></span>
                            <div class="tc-header-stat-bar" style="visibility: hidden;"><div class="tc-header-stat-fill" style="width: 0%;"></div></div>
                        </div>
                        <span class="tc-header-stat-timer" aria-hidden="true" style="visibility: hidden;">&nbsp;</span>
                    </div>

                    <div class="tc-header-stat-wrapper">
                        <div class="tc-header-stat-box">
                            <span class="tc-header-stat-name">XP</span>
                            <span class="tc-header-stat-value"><?php echo number_format($userXP); ?></span>
                            <div class="tc-header-stat-bar" style="visibility: hidden;"><div class="tc-header-stat-fill" style="width: 0%;"></div></div>
                        </div>
                        <span class="tc-header-stat-timer" aria-hidden="true" style="visibility: hidden;">&nbsp;</span>
                    </div>

                    <div class="tc-header-stat-wrapper">
                        <div class="tc-header-stat-box">
                            <span class="tc-header-stat-name">CASH</span>
                            <span class="tc-header-stat-value">£<?php echo number_format($userCash, 2); ?></span>
                            <div class="tc-header-stat-bar" style="visibility: hidden;"><div class="tc-header-stat-fill" style="width: 0%;"></div></div>
                        </div>
                        <span class="tc-header-stat-timer" aria-hidden="true" style="visibility: hidden;">&nbsp;</span>
                    </div>

                    <div class="tc-header-stat-wrapper">
                        <div class="tc-header-stat-box">
                            <span class="tc-header-stat-name">BANK</span>
                            <span class="tc-header-stat-value">£<?php echo number_format($userBank, 2); ?></span>
                            <div class="tc-header-stat-bar" style="visibility: hidden;"><div class="tc-header-stat-fill" style="width: 0%;"></div></div>
                        </div>
                        <span class="tc-header-stat-timer" aria-hidden="true" style="visibility: hidden;">&nbsp;</span>
                    </div>
                </div>

                <div class="tc-header-actions">
                    <?php if ($showThemeToggle): ?>
                        <label class="tc-theme-switch" aria-label="Toggle theme">
                            <input type="checkbox" data-theme-toggle aria-label="Toggle between light and dark mode">
                            <span class="tc-theme-switch-slider">
                                <span class="tc-theme-switch-icon tc-theme-switch-icon--sun"><?php echo htmlspecialchars($themeIconSun, ENT_QUOTES, 'UTF-8'); ?></span>
                                <span class="tc-theme-switch-icon tc-theme-switch-icon--moon"><?php echo htmlspecialchars($themeIconMoon, ENT_QUOTES, 'UTF-8'); ?></span>
                            </span>
                        </label>
                    <?php endif; ?>

                    <a class="tc-header-action" href="/mail.php" aria-label="Mail" title="Mail">
                        <span class="tc-header-icon" aria-hidden="true"><img src="/assets/imgs/icons_32/mail.PNG" alt="" /></span>
                        <span class="tc-header-label">Mail</span>
                    </a>

                    <a class="tc-header-action" href="/settings.php" aria-label="Account settings" title="Account">
                        <span class="tc-header-icon" aria-hidden="true"><img src="/assets/imgs/icons_32/settings.PNG" alt="" /></span>
                        <span class="tc-header-label">Account</span>
                    </a>

                    <a class="tc-header-action" href="/logout.php" aria-label="Logout" title="Logout">
                        <span class="tc-header-icon" aria-hidden="true"><img src="/assets/imgs/icons_32/logout.PNG" alt="" /></span>
                        <span class="tc-header-label">Logout</span>
                    </a>
                </div>
            </header>
            <?php
            return;
        }

        $headerClass      = $config['header_class'] ?? 'tc-app-header tc-prelogin-header';
        $showBrand        = $config['show_brand'] ?? true;
        $brandHref        = $config['brand_href'] ?? '/';
        $showThemeToggle  = $config['show_theme_toggle'] ?? true;

        $themeIconSun  = $config['theme_icon_sun'] ?? '☀';
        $themeIconMoon = $config['theme_icon_moon'] ?? '🌙';

        $actions = $config['actions'] ?? [];
        ?>
        <nav class="<?php echo htmlspecialchars($headerClass, ENT_QUOTES, 'UTF-8'); ?>" style="height: <?php echo (int)$TC_HEADER_HEIGHT_PX; ?>px; box-sizing: border-box;">
            <?php if ($showBrand): ?>
                <div class="tc-brand-group">
                    <a class="tc-brand" href="<?php echo htmlspecialchars($brandHref, ENT_QUOTES, 'UTF-8'); ?>">
                        <img
                            class="tc-brand-logo"
                            src="/assets/imgs/logo.png"
                            alt="Trench City"
                            style="height: <?php echo (int)$TC_LOGO_HEIGHT_PX; ?>px !important; width: auto !important; max-height: none !important; max-width: none !important; display: block;"
                            data-theme-logo
                            data-dark-logo="/assets/imgs/logo.png"
                            data-light-logo="/assets/imgs/logo.png"
                        />
                    </a>
                </div>
            <?php endif; ?>

            <div class="tc-header-actions">
                <?php if ($showThemeToggle): ?>
                    <label class="tc-theme-switch" aria-label="Toggle theme">
                        <input type="checkbox" data-theme-toggle aria-label="Toggle between light and dark mode">
                        <span class="tc-theme-switch-slider">
                            <span class="tc-theme-switch-icon tc-theme-switch-icon--sun"><?php echo htmlspecialchars($themeIconSun, ENT_QUOTES, 'UTF-8'); ?></span>
                            <span class="tc-theme-switch-icon tc-theme-switch-icon--moon"><?php echo htmlspecialchars($themeIconMoon, ENT_QUOTES, 'UTF-8'); ?></span>
                        </span>
                    </label>
                <?php endif; ?>

                <?php foreach ($actions as $action): ?>
                    <?php
                    $label = (string)($action['label'] ?? '');
                    $href  = (string)($action['href'] ?? '#');
                    $class = (string)($action['class'] ?? 'tc-btn tc-btn-secondary');
                    $title = (string)($action['title'] ?? $label);
                    ?>
                    <a
                        class="<?php echo htmlspecialchars($class, ENT_QUOTES, 'UTF-8'); ?>"
                        href="<?php echo htmlspecialchars($href, ENT_QUOTES, 'UTF-8'); ?>"
                        title="<?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?>"
                        aria-label="<?php echo htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?>"
                    >
                        <?php echo htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        </nav>
        <?php
    }
}

if (!function_exists('tcRenderPageStart')) {
    function tcRenderPageStart(array $config = []): void
    {
        $mode = $config['mode'] ?? 'prelogin';
        $title = $config['title'] ?? ($GLOBALS['tc_page_title'] ?? 'Trench City');
        $includePreloginCss = $config['include_prelogin_css'] ?? ($mode !== 'postlogin');
        $bodyClass = $config['body_class'] ?? (($mode === 'postlogin') ? 'tc-app' : 'tc-app tc-prelogin');
        $headerConfig = $config['header'] ?? null;
        $headHtml = $config['head_html'] ?? '';
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="theme-color" content="#05070B" />
    <title><?php echo htmlspecialchars((string)$title, ENT_QUOTES, 'UTF-8'); ?></title>
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
    <?php if ($includePreloginCss): ?>
        <link rel="stylesheet" href="/assets/css/prelogin-header.css" />
    <?php endif; ?>
    <?php if (!empty($headHtml)) { echo $headHtml; } ?>
    <script defer src="/assets/js/tc-global.js"></script>
</head>
<body class="<?php echo htmlspecialchars($bodyClass, ENT_QUOTES, 'UTF-8'); ?>">
<?php
        if ($mode === 'postlogin') {
            echo '<div class="tc-app-shell">';
            $user = $config['user'] ?? ($GLOBALS['user'] ?? null);
            tcRenderHeader(['mode' => 'postlogin', 'user' => $user]);

            $announcement = function_exists('tc_get_global_announcement') ? tc_get_global_announcement() : null;
            if ($announcement) {
                $announcementType = $announcement['type'] ?? 'info';
                $alertClass = 'alert';
                if ($announcementType === 'warning') {
                    $alertClass = 'alert alert-warning';
                } elseif ($announcementType === 'success') {
                    $alertClass = 'alert alert-success';
                } else {
                    $alertClass = 'alert alert-info';
                }
                ?>
                <div style="padding: 0 1.5rem; margin-top: 1rem;">
                    <div class="<?php echo $alertClass; ?>">
                        <div class="alert-content">
                            <div class="alert-message">
                                <?php if (!empty($announcement['title'])): ?>
                                    <strong><?php echo htmlspecialchars($announcement['title'], ENT_QUOTES, 'UTF-8'); ?></strong><br />
                                <?php endif; ?>
                                <?php echo nl2br(htmlspecialchars($announcement['message'], ENT_QUOTES, 'UTF-8')); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
            <script>
            (function() {
                const timers = document.querySelectorAll('.tc-header-stat-timer');
                if (timers.length === 0) return;

                function formatTime(seconds) {
                    const mins = Math.floor(seconds / 60);
                    const secs = seconds % 60;
                    return mins.toString().padStart(2, '0') + ':' + secs.toString().padStart(2, '0');
                }

                function updateTimers() {
                    let shouldReload = false;

                    timers.forEach(timer => {
                        const label = (timer.dataset.label || timer.dataset.bar || '').toString();
                        let seconds = parseInt(timer.dataset.seconds, 10);

                        if (!Number.isFinite(seconds) || seconds < 0) seconds = 0;

                        if (seconds > 0) {
                            seconds--;
                            timer.dataset.seconds = seconds.toString();
                            timer.textContent = label + ': [' + formatTime(seconds) + '] Remaining...';

                            if (seconds === 0) {
                                shouldReload = true;
                            }
                        } else {
                            timer.textContent = label + ': [00:00] Remaining...';
                        }
                    });

                    if (shouldReload) {
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    }
                }

                setInterval(updateTimers, 1000);
            })();
            </script>
            <div class="tc-app-layout">
                <aside class="tc-sidebar" data-sidebar>
                    <?php include __DIR__ . '/postlogin-sidebar.php'; ?>
                </aside>
                <div class="tc-sidebar-overlay" aria-hidden="true"></div>
                <div class="tc-main-column">
            <?php
        } else {
            echo '<div class="page">';
            if (is_array($headerConfig)) {
                tcRenderHeader($headerConfig);
            }
        }
    }
}

if (!function_exists('tcRenderPageEnd')) {
    function tcRenderPageEnd(array $config = []): void
    {
        $mode = $config['mode'] ?? 'prelogin';

        if ($mode === 'postlogin') {
            echo '</div>'; // .tc-main-column
            echo '</div>'; // .tc-app-layout
            echo '</div>'; // .tc-app-shell
            echo '</body></html>';
            return;
        }

        echo '</div>'; // .page
        echo '</body></html>';
    }
}

