<?php
$admin_page = basename($_SERVER['PHP_SELF'] ?? '', '.php');
$admin_links = [
    ['label' => 'Dashboard', 'href' => '/admin/index.php', 'page' => 'index'],
    ['label' => 'Users', 'href' => '/admin/users.php', 'page' => 'users'],
    ['label' => 'User View', 'href' => '/admin/user_view.php', 'page' => 'user_view'],
    ['label' => 'User Edit', 'href' => '/admin/user_edit.php', 'page' => 'user_edit'],
    ['label' => 'Moderation', 'href' => '/admin/moderation.php', 'page' => 'moderation'],
    ['label' => 'Audit Logs', 'href' => '/admin/audit.php', 'page' => 'audit'],
    ['label' => 'Economy', 'href' => '/admin/economy.php', 'page' => 'economy'],
    ['label' => 'Anti-Cheat', 'href' => '/admin/anti_cheat.php', 'page' => 'anti_cheat'],
    ['label' => 'Support', 'href' => '/admin/support.php', 'page' => 'support'],
    ['label' => 'Content', 'href' => '/admin/content.php', 'page' => 'content'],
    ['label' => 'Config', 'href' => '/admin/config.php', 'page' => 'config'],
    ['label' => 'Jobs/Factions', 'href' => '/admin/jobs.php', 'page' => 'jobs'],
    ['label' => 'Items', 'href' => '/admin/items.php', 'page' => 'items'],
    ['label' => 'Live Ops', 'href' => '/admin/live_ops.php', 'page' => 'live_ops'],
    ['label' => 'Logs', 'href' => '/admin/logs.php', 'page' => 'logs'],
    ['label' => 'Developer Tools', 'href' => '/admin/dev_tools.php', 'page' => 'dev_tools'],
    ['label' => 'Security', 'href' => '/admin/security.php', 'page' => 'security'],
    ['label' => 'Data Tools', 'href' => '/admin/data_tools.php', 'page' => 'data_tools'],
    ['label' => 'Panic', 'href' => '/admin/panic.php', 'page' => 'panic'],
    ['label' => 'Growth', 'href' => '/admin/growth.php', 'page' => 'growth'],
    ['label' => 'System', 'href' => '/admin/system.php', 'page' => 'system'],
    ['label' => 'Maintenance', 'href' => '/admin/maintenance.php', 'page' => 'maintenance'],
];
?>
<div class="tc-card" style="margin: 1.5rem 0;">
    <div style="display: flex; flex-wrap: wrap; gap: 0.75rem;">
        <?php foreach ($admin_links as $link): ?>
            <?php $isActive = $admin_page === $link['page']; ?>
            <a class="btn <?php echo $isActive ? 'btn-primary' : 'btn-secondary'; ?> btn-sm" href="<?php echo $link['href']; ?>">
                <?php echo htmlspecialchars($link['label'], ENT_QUOTES, 'UTF-8'); ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>
