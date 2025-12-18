<?php
$current_page = basename($_SERVER['PHP_SELF'], '.php');

if (!function_exists('isActivePage')) {
    function isActivePage($page) {
        global $current_page;
        return $current_page === $page ? 'active' : '';
    }
}

$user = $user ?? null;
$userId = $user['id'] ?? null;

if (!$userId && function_exists('currentUserId')) {
    $userId = currentUserId();
}

if (!$user && $userId && function_exists('getUser')) {
    $user = getUser($userId);
}

$bars = null;
if ($userId && function_exists('getUserBars')) {
    $bars = getUserBars($userId) ?: null;
}

$cashDisplay = isset($user['cash']) ? formatCash((float)$user['cash']) : 'A�0';
$bankDisplay = isset($user['bank_balance']) ? formatCash((float)$user['bank_balance']) : 'A�0';
$levelDisplay = isset($user['level']) ? (int)$user['level'] : 0;
$pointsDisplay = isset($user['points']) ? number_format((int)$user['points']) : '�';
$displayName = $user['username'] ?? 'Citizen';

$barMap = [
    'energy' => 'Energy',
    'nerve' => 'Nerve',
    'happy' => 'Happy',
    'life' => 'Life',
];

$areasLinks = [
    ['label' => 'Home', 'href' => '/dashboard.php', 'page' => 'dashboard', 'icon' => '/assets/imgs/icons_32/profile.PNG'],
    ['label' => 'Items', 'href' => '/items.php', 'page' => 'items', 'icon' => '/assets/imgs/icons_32/inventory.PNG'],
    ['label' => 'City', 'href' => '/city.php', 'page' => 'city', 'icon' => '/assets/imgs/icons_32/city.PNG'],
    ['label' => 'Job', 'href' => '/jobs.php', 'page' => 'jobs', 'icon' => '/assets/imgs/icons_32/jobs.PNG'],
    ['label' => 'Gym', 'href' => '/gym.php', 'page' => 'gym', 'icon' => '/assets/imgs/icons_32/gym.PNG'],
    ['label' => 'Properties', 'href' => '/properties.php', 'page' => 'properties', 'icon' => '/assets/imgs/icons_32/properties.PNG'],
    ['label' => 'Education', 'href' => '/education.php', 'page' => 'education', 'icon' => '/assets/imgs/icons_32/skills.PNG'],
    ['label' => 'Crimes', 'href' => '/crimes.php', 'page' => 'crimes', 'icon' => '/assets/imgs/icons_32/crimes.PNG'],
    ['label' => 'Missions', 'href' => '/missions.php', 'page' => 'missions', 'icon' => '/assets/imgs/icons_32/missions.PNG'],
    ['label' => 'Newspaper', 'href' => '/newspaper.php', 'page' => 'newspaper', 'icon' => '/assets/imgs/icons_32/events.PNG'],
    ['label' => 'Jail', 'href' => '/jail.php', 'page' => 'jail', 'icon' => '/assets/imgs/icons_32/customs.PNG'],
    ['label' => 'Hospital', 'href' => '/hospital.php', 'page' => 'hospital', 'icon' => '/assets/imgs/icons_32/hospital.PNG'],
    ['label' => 'Casino', 'href' => '/casino.php', 'page' => 'casino', 'icon' => '/assets/imgs/icons_32/casino.PNG'],
    ['label' => 'Forums', 'href' => '/forums.php', 'page' => 'forums', 'icon' => '/assets/imgs/icons_32/messages.PNG'],
    ['label' => 'Hall of Fame', 'href' => '/hall_of_fame.php', 'page' => 'hall_of_fame', 'icon' => '/assets/imgs/icons_32/leaderboards.PNG'],
    ['label' => 'Faction', 'href' => '/factions.php', 'page' => 'factions', 'icon' => '/assets/imgs/icons_32/faction.PNG'],
    ['label' => 'Recruit Citizens', 'href' => '/recruit_citizens.php', 'page' => 'recruit_citizens', 'icon' => '/assets/imgs/icons_32/npcs.PNG'],
    ['label' => 'Calendar', 'href' => '/calendar.php', 'page' => 'calendar', 'icon' => '/assets/imgs/icons_32/timers.PNG'],
    ['label' => 'Elimination', 'href' => '/elimination.php', 'page' => 'elimination', 'icon' => '/assets/imgs/icons_32/hitman.PNG'],
    ['label' => 'Community Events', 'href' => '/community_events.php', 'page' => 'community_events', 'icon' => '/assets/imgs/icons_32/events.PNG'],
    ['label' => 'Rules', 'href' => '/rules.php', 'page' => 'rules', 'icon' => '/assets/imgs/icons_32/contracts.PNG'],
];

$listsLinks = [
    ['label' => 'Friends', 'href' => '/friends.php', 'page' => 'friends', 'icon' => '/assets/imgs/icons_32/friends.PNG'],
    ['label' => 'Enemies', 'href' => '/enemies.php', 'page' => 'enemies', 'icon' => '/assets/imgs/icons_32/hitman.PNG'],
    ['label' => 'Targets', 'href' => '/targets.php', 'page' => 'targets', 'icon' => '/assets/imgs/icons_32/alerts.PNG'],
];

$trenchCityLinks = [
    ['label' => 'Progression', 'href' => '/progression.php', 'page' => 'progression', 'icon' => '/assets/imgs/icons_32/statistics.PNG'],
    ['label' => 'Risk & Reward', 'href' => '/risk_reward.php', 'page' => 'risk_reward', 'icon' => '/assets/imgs/icons_32/achievements.PNG'],
    ['label' => 'Travel', 'href' => '/travel.php', 'page' => 'travel', 'icon' => '/assets/imgs/icons_32/travel.PNG'],
    ['label' => 'Stock / Points', 'href' => '/stock.php', 'page' => 'stock', 'icon' => '/assets/imgs/icons_32/economy-index.PNG'],
    ['label' => 'Companies', 'href' => '/companies.php', 'page' => 'companies', 'icon' => '/assets/imgs/icons_32/companies.PNG'],
    ['label' => 'Vehicles', 'href' => '/vehicles.php', 'page' => 'vehicles', 'icon' => '/assets/imgs/icons_32/vehicles.PNG'],
    ['label' => 'Inventory', 'href' => '/inventory.php', 'page' => 'inventory', 'icon' => '/assets/imgs/icons_32/inventory.PNG'],
    ['label' => 'Black Market', 'href' => '/black_market.php', 'page' => 'black_market', 'icon' => '/assets/imgs/icons_32/black-market.PNG'],
    ['label' => 'Admin', 'href' => '/admin.php', 'page' => 'admin', 'icon' => '/assets/imgs/icons_32/admin-staff.PNG'],
    ['label' => 'Admin Logs', 'href' => '/admin_logs.php', 'page' => 'admin_logs', 'icon' => '/assets/imgs/icons_32/logs-history.PNG'],
];

$extrasLinks = [
    ['label' => 'Combat', 'href' => '/combat.php', 'page' => 'combat', 'icon' => '/assets/imgs/icons_32/weapon.PNG'],
    ['label' => 'Bank', 'href' => '/bank.php', 'page' => 'bank', 'icon' => '/assets/imgs/icons_32/bank.PNG'],
    ['label' => 'Market', 'href' => '/market.php', 'page' => 'market', 'icon' => '/assets/imgs/icons_32/market.PNG'],
    ['label' => 'Mail', 'href' => '/mail.php', 'page' => 'mail', 'icon' => '/assets/imgs/icons_32/mail.PNG'],
    ['label' => 'Players', 'href' => '/players.php', 'page' => 'players', 'icon' => '/assets/imgs/icons_32/npcs.PNG'],
    ['label' => 'Profile', 'href' => '/profile.php', 'page' => 'profile', 'icon' => '/assets/imgs/icons_32/profile.PNG'],
    ['label' => 'Leaderboards', 'href' => '/leaderboards.php', 'page' => 'leaderboards', 'icon' => '/assets/imgs/icons_32/leaderboards.PNG'],
    ['label' => 'Account', 'href' => '/settings.php', 'page' => 'settings', 'icon' => '/assets/imgs/icons_32/settings.PNG'],
    ['label' => 'Logout', 'href' => '/logout.php', 'page' => 'logout', 'icon' => '/assets/imgs/icons_32/logout.PNG'],
];
?>
<div class="tc-sidebar-inner">
    <div class="tc-sidebar-info">
        <div class="tc-sidebar-user">
            <div class="tc-sidebar-user-name"><?php echo htmlspecialchars($displayName, ENT_QUOTES, 'UTF-8'); ?></div>
            <div class="tc-sidebar-user-meta">
                <span>Level <?php echo $levelDisplay; ?></span>
                <span>Points <?php echo htmlspecialchars($pointsDisplay, ENT_QUOTES, 'UTF-8'); ?></span>
            </div>
        </div>
        <div class="tc-sidebar-user-finance">
            <div>
                <small>Cash</small>
                <strong><?php echo htmlspecialchars($cashDisplay, ENT_QUOTES, 'UTF-8'); ?></strong>
            </div>
            <div>
                <small>Bank</small>
                <strong><?php echo htmlspecialchars($bankDisplay, ENT_QUOTES, 'UTF-8'); ?></strong>
            </div>
        </div>
        <?php if ($bars): ?>
            <div class="tc-sidebar-bars">
                <?php foreach ($barMap as $key => $label):
                    $currentKey = $key . '_current';
                    $maxKey = $key . '_max';
                    $current = isset($bars[$currentKey]) ? (int)$bars[$currentKey] : 0;
                    $max = isset($bars[$maxKey]) ? (int)$bars[$maxKey] : 0;
                    $percent = $max > 0 ? min(100, ($current / max($max, 1)) * 100) : 0;
                ?>
                    <div class="tc-mini-bar">
                        <div class="tc-mini-bar-header">
                            <span><?php echo htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?></span>
                            <span><?php echo $current; ?> / <?php echo $max; ?></span>
                        </div>
                        <div class="tc-mini-bar-track">
                            <span class="tc-mini-bar-fill tc-mini-bar-<?php echo $key; ?>" style="width: <?php echo $percent; ?>%"></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <div class="tc-sidebar-controls">
            <button class="tc-sidebar-collapse" type="button">
                <span class="tc-sidebar-collapse-icon" aria-hidden="true">◀</span>
                <span class="tc-sidebar-collapse-label">Collapse</span>
            </button>
            <button class="tc-theme-toggle" type="button" data-theme-toggle aria-label="Toggle theme">
                <span class="tc-theme-icon tc-theme-icon--sun" aria-hidden="true">☀</span>
                <span class="tc-theme-icon tc-theme-icon--moon" aria-hidden="true">🌙</span>
            </button>
        </div>
    </div>

    <div class="tc-sidebar-panel">
        <div class="tc-sidebar-section">
            <div class="tc-sidebar-section-title">Areas</div>
            <?php foreach ($areasLinks as $link): ?>
                <a href="<?php echo $link['href']; ?>" class="tc-sidebar-link <?php echo isActivePage($link['page']); ?>" data-label="<?php echo htmlspecialchars($link['label'], ENT_QUOTES, 'UTF-8'); ?>">
                    <span class="tc-sidebar-icon" aria-hidden="true"><img src="<?php echo $link['icon']; ?>" alt="<?php echo htmlspecialchars($link['label'], ENT_QUOTES, 'UTF-8'); ?>" /></span>
                    <span class="tc-sidebar-link-label"><?php echo htmlspecialchars($link['label'], ENT_QUOTES, 'UTF-8'); ?></span>
                </a>
            <?php endforeach; ?>
        </div>

        <div class="tc-sidebar-section">
            <div class="tc-sidebar-section-title">Lists</div>
            <?php foreach ($listsLinks as $link): ?>
                <a href="<?php echo $link['href']; ?>" class="tc-sidebar-link <?php echo isActivePage($link['page']); ?>" data-label="<?php echo htmlspecialchars($link['label'], ENT_QUOTES, 'UTF-8'); ?>">
                    <span class="tc-sidebar-icon" aria-hidden="true"><img src="<?php echo $link['icon']; ?>" alt="<?php echo htmlspecialchars($link['label'], ENT_QUOTES, 'UTF-8'); ?>" /></span>
                    <span class="tc-sidebar-link-label"><?php echo htmlspecialchars($link['label'], ENT_QUOTES, 'UTF-8'); ?></span>
                </a>
            <?php endforeach; ?>
        </div>

        <div class="tc-sidebar-section">
            <div class="tc-sidebar-section-title">Trench City</div>
            <?php foreach ($trenchCityLinks as $link): ?>
                <a href="<?php echo $link['href']; ?>" class="tc-sidebar-link <?php echo isActivePage($link['page']); ?>" data-label="<?php echo htmlspecialchars($link['label'], ENT_QUOTES, 'UTF-8'); ?>">
                    <span class="tc-sidebar-icon" aria-hidden="true"><img src="<?php echo $link['icon']; ?>" alt="<?php echo htmlspecialchars($link['label'], ENT_QUOTES, 'UTF-8'); ?>" /></span>
                    <span class="tc-sidebar-link-label"><?php echo htmlspecialchars($link['label'], ENT_QUOTES, 'UTF-8'); ?></span>
                </a>
            <?php endforeach; ?>
        </div>

        <div class="tc-sidebar-section">
            <div class="tc-sidebar-section-title">Extras</div>
            <?php foreach ($extrasLinks as $link): ?>
                <a href="<?php echo $link['href']; ?>" class="tc-sidebar-link <?php echo isActivePage($link['page']); ?>" data-label="<?php echo htmlspecialchars($link['label'], ENT_QUOTES, 'UTF-8'); ?>">
                    <span class="tc-sidebar-icon" aria-hidden="true"><img src="<?php echo $link['icon']; ?>" alt="<?php echo htmlspecialchars($link['label'], ENT_QUOTES, 'UTF-8'); ?>" /></span>
                    <span class="tc-sidebar-link-label"><?php echo htmlspecialchars($link['label'], ENT_QUOTES, 'UTF-8'); ?></span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</div>
