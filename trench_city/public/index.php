<?php
require_once '/var/www/trench_city/core/bootstrap.php';
if (session_status() === PHP_SESSION_NONE) session_start();

// Redirect to dashboard if already logged in
if (!empty($_SESSION['user_id'])) {
    header('Location: /dashboard.php');
    exit;
}

/**
 * Live stats (no schema changes)
 * - Registered players: users COUNT(*)
 * - Newest recruit: best-effort via users columns
 * - Online now: prefer users last_active/last_seen; fallback to session mtimes
 * - Active today: prefer users last_active/last_seen; else "—"
 */
$tc_stats = [
    'registered'   => null,
    'online'       => null,
    'newest_name'  => null,
    'active_today' => null,
];

function tc_fmt_int($v) {
    return (is_numeric($v)) ? number_format((int)$v) : '—';
}
function tc_h($s) {
    return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8');
}
function tc_detect_users_meta($db) {
    $meta = [
        'cols' => [],
        'pk' => null,
        'username_col' => null,
        'created_col' => null,
        'last_active_col' => null,
    ];

    $rows = $db->fetchAll("
        SELECT COLUMN_NAME, DATA_TYPE, COLUMN_KEY
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'users'
    ");

    foreach ($rows as $r) {
        $name = $r['COLUMN_NAME'] ?? null;
        if (!$name) continue;
        $meta['cols'][$name] = [
            'type' => strtolower((string)($r['DATA_TYPE'] ?? '')),
            'key'  => (string)($r['COLUMN_KEY'] ?? ''),
        ];
        if (!$meta['pk'] && (($r['COLUMN_KEY'] ?? '') === 'PRI')) {
            $meta['pk'] = $name;
        }
    }

    $username_candidates = ['username', 'user_name', 'display_name', 'name', 'handle'];
    foreach ($username_candidates as $c) {
        if (isset($meta['cols'][$c])) { $meta['username_col'] = $c; break; }
    }

    $created_candidates = ['created_at', 'created_on', 'registered_at', 'register_date', 'joined_at', 'join_date', 'created', 'date_created'];
    foreach ($created_candidates as $c) {
        if (isset($meta['cols'][$c])) { $meta['created_col'] = $c; break; }
    }

    $last_active_candidates = ['last_active', 'last_seen', 'last_action', 'last_login', 'updated_at', 'updated_on', 'last_activity'];
    foreach ($last_active_candidates as $c) {
        if (isset($meta['cols'][$c])) { $meta['last_active_col'] = $c; break; }
    }

    return $meta;
}

try {
    // Registered players
    $tc_stats['registered'] = (int)$db->fetchOne("SELECT COUNT(*) AS c FROM users")['c'];

    // Column detection
    $meta = tc_detect_users_meta($db);

    // Newest recruit
    if ($meta['username_col']) {
        $order = [];
        if ($meta['created_col']) $order[] = "`{$meta['created_col']}` DESC";
        if ($meta['pk']) $order[] = "`{$meta['pk']}` DESC";
        if (!$order) $order[] = "`{$meta['username_col']}` DESC";
        $order_sql = implode(', ', $order);

        $row = $db->fetchOne("SELECT `{$meta['username_col']}` AS u FROM users ORDER BY {$order_sql} LIMIT 1");
        if (!empty($row['u'])) $tc_stats['newest_name'] = (string)$row['u'];
    }

    // Online + Active today
    if ($meta['last_active_col']) {
        $type = $meta['cols'][$meta['last_active_col']]['type'] ?? '';
        $is_epoch = in_array($type, ['int','bigint','mediumint','smallint','tinyint'], true);

        if ($is_epoch) {
            $row = $db->fetchOne("
                SELECT COUNT(*) AS c
                FROM users
                WHERE `{$meta['last_active_col']}` >= UNIX_TIMESTAMP(NOW() - INTERVAL 5 MINUTE)
            ");
            $tc_stats['online'] = isset($row['c']) ? (int)$row['c'] : null;

            $row2 = $db->fetchOne("
                SELECT COUNT(*) AS c
                FROM users
                WHERE `{$meta['last_active_col']}` >= UNIX_TIMESTAMP(NOW() - INTERVAL 1 DAY)
            ");
            $tc_stats['active_today'] = isset($row2['c']) ? (int)$row2['c'] : null;
        } else {
            $row = $db->fetchOne("
                SELECT COUNT(*) AS c
                FROM users
                WHERE `{$meta['last_active_col']}` >= (NOW() - INTERVAL 5 MINUTE)
            ");
            $tc_stats['online'] = isset($row['c']) ? (int)$row['c'] : null;

            $row2 = $db->fetchOne("
                SELECT COUNT(*) AS c
                FROM users
                WHERE `{$meta['last_active_col']}` >= (NOW() - INTERVAL 1 DAY)
            ");
            $tc_stats['active_today'] = isset($row2['c']) ? (int)$row2['c'] : null;
        }
    } else {
        // Fallback: session mtimes for online now
        $savePath = (string)ini_get('session.save_path');
        if (strpos($savePath, ';') !== false) {
            $parts = explode(';', $savePath);
            $savePath = trim(end($parts));
        }
        $savePath = trim($savePath);
        if ($savePath === '') $savePath = sys_get_temp_dir();

        $online = 0;
        $cutoff = time() - 300; // 5 minutes
        $files = @glob(rtrim($savePath, '/').'/sess_*');
        if (is_array($files)) {
            foreach ($files as $f) {
                $mt = @filemtime($f);
                if ($mt !== false && $mt >= $cutoff) $online++;
            }
            $tc_stats['online'] = $online;
        }
        // active_today stays "—" without DB signal
    }
} catch (Throwable $e) {
    // Keep landing page stable on any failure
}

/**
 * Top features (Torn-style click-to-read)
 * Pure UI/JS; no schema requirements.
 */
$tc_top_features = [
    [
        'key' => 'gym',
        'label' => 'Gym',
        'title' => 'Gym Training',
        'desc' => 'Build real stats the hard way. Every session counts, every gain changes how you move in the city.',
        'icon' => 'gym',
    ],
    [
        'key' => 'crimes',
        'label' => 'Crimes',
        'title' => 'Crimes & Progression',
        'desc' => 'Work your nerve, learn the routes, and level up your game. Easy money gets you noticed — big money gets you hunted.',
        'icon' => 'crimes',
    ],
    [
        'key' => 'combat',
        'label' => 'Combat',
        'title' => 'Combat',
        'desc' => 'Hit first or get hit. Respect is taken, retaliation is remembered, and mistakes cost life.',
        'icon' => 'weapon',
    ],
    [
        'key' => 'factions',
        'label' => 'Factions',
        'title' => 'Factions & Wars',
        'desc' => 'Find your people or get swallowed. Chains, raids, territory pressure - when it kicks off, you\'ll want a flag behind you.',
        'icon' => 'faction',
    ],
    [
        'key' => 'jobs',
        'label' => 'Jobs',
        'title' => 'Jobs',
        'desc' => 'Start legit if you want. Climb, unlock perks, and turn steady work into leverage.',
        'icon' => 'jobs',
    ],
    [
        'key' => 'companies',
        'label' => 'Companies',
        'title' => 'Companies',
        'desc' => 'Build something that prints. Hire players, run upgrades, and turn a small outfit into a serious operation.',
        'icon' => 'companies',
    ],
    [
        'key' => 'inventory',
        'label' => 'Items',
        'title' => 'Items & Inventory',
        'desc' => 'Hold what matters. Consumables, boosts, gear — the right item at the right time changes everything.',
        'icon' => 'inventory',
    ],
    [
        'key' => 'properties',
        'label' => 'Properties',
        'title' => 'Properties',
        'desc' => 'Upgrade your base, secure your position, and build stability in a city that loves to take.',
        'icon' => 'properties',
    ],
    [
        'key' => 'casino',
        'label' => 'Casino',
        'title' => 'Casino',
        'desc' => 'Risk sharp, win loud. The house always watches — but the city respects nerve.',
        'icon' => 'casino',
    ],
    [
        'key' => 'market',
        'label' => 'Market',
        'title' => 'Markets & Money',
        'desc' => 'Stack cash, trade smart, and move product. Money makes doors open — and makes enemies appear.',
        'icon' => 'market',
    ],
    [
        'key' => 'missions',
        'label' => 'Missions',
        'title' => 'Missions',
        'desc' => 'Stories with consequences. Do the work, earn the reward, and unlock the next problem waiting for you.',
        'icon' => 'missions',
    ],
    [
        'key' => 'city',
        'label' => 'City',
        'title' => 'The City',
        'desc' => 'Everything connects. Every system feeds the next — your choices shape your route through London.',
        'icon' => 'city',
    ],
];

$tc_page_title = 'Trench City | Secure Access';
require_once '/var/www/trench_city/includes/tc_header.php';
tcRenderPageStart(['mode' => 'prelogin']);
?>
        <style>
            /* Landing polish (layout/spacing only; theme tokens/components unchanged) */
            .tc-landing-shell{
                max-width: 1120px;
                margin: 0 auto;
                padding: clamp(28px, 4vw, 56px) 16px 72px;
            }
            .tc-landing-nav{
                position: sticky;
                top: 0;
                z-index: 50;
            }
            .tc-landing-grid{
                display: grid;
                grid-template-columns: 1.15fr .85fr;
                gap: 22px;
                align-items: start;
            }
            @media (max-width: 980px){
                .tc-landing-grid{ grid-template-columns: 1.15fr .85fr; }
                .tc-landing-shell{ padding-bottom: 56px; }
            }
            .tc-landing-grid > .tc-card{
                padding: 30px;
            }
            .tc-card.hero{
                padding: 34px;
            }
            .tc-card.hero .eyebrow{
                display: inline-block;
                letter-spacing: .08em;
                text-transform: uppercase;
                opacity: .85;
                margin-bottom: 10px;
            }
            .tc-card.hero h1{
                margin: 10px 0 14px;
                line-height: 1.08;
                letter-spacing: -0.02em;
            }
            .tc-card.hero p{
                margin: 0 0 14px;
                max-width: 62ch;
            }
            .tc-card.hero p:last-of-type{
                margin-bottom: 0;
            }
            .tc-card.hero .actions{
                margin-top: 18px;
                display: flex;
                gap: 12px;
                flex-wrap: wrap;
                align-items: center;
            }
            .tc-card h2{
                margin-top: 0;
                margin-bottom: 10px;
            }
            .tc-card p{
                margin-top: 0;
                margin-bottom: 16px;
            }
            .pill-list{
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
            }

            /* Top features (Torn-style click-to-read) */
            .tc-landing-features{
                margin-top: 18px;
                padding: 22px 26px;
            }
            .tc-landing-features-header{
                display: flex;
                align-items: baseline;
                justify-content: space-between;
                gap: 16px;
                margin-bottom: 14px;
            }
            .tc-landing-features-wrap{
                display: grid;
                grid-template-columns: 1fr 1.1fr;
                gap: 18px;
                align-items: start;
            }
            @media (max-width: 980px){
                .tc-landing-features-wrap{ grid-template-columns: 1fr 1.1fr; }
            }
            .tc-feature-grid{
                display: grid;
                grid-template-columns: repeat(6, minmax(0, 1fr));
                gap: 10px;
            }
            @media (max-width: 980px){
                .tc-feature-grid{ grid-template-columns: repeat(6, minmax(0, 1fr)); }
            }
            @media (max-width: 520px){
                .tc-feature-grid{ grid-template-columns: repeat(6, minmax(0, 1fr)); }
            }
            .tc-feature-tile{
                appearance: none;
                border: 1px solid rgba(255,255,255,0.23);
                background: rgba(0,0,0,0.25);
                border-radius: 14px;
                padding: 10px 8px;
                cursor: pointer;
                text-align: center;
                display: grid;
                gap: 8px;
                align-content: start;
                transition: transform .12s ease, border-color .12s ease;
                color: inherit;
            }
            @media (hover:hover){
                .tc-feature-tile:hover{ transform: translateY(-1px); }
            }
            .tc-feature-tile.is-active{
                border-color: rgba(255,255,255,0.33);
                transform: translateY(-1px);
            }
            .tc-feature-icon{
                width: 34px;
                height: 34px;
                margin: 0 auto;
                display: grid;
                place-items: center;
                border-radius: 12px;
                border: none;
                background: transparent;
            }
            .tc-feature-icon svg{
                width: 18px;
                height: 18px;
                display: block;
                opacity: .92;
            }
            .tc-feature-label{
                font-size: 12px;
                opacity: .88;
                line-height: 1.1;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            .tc-feature-detail{
                border: 1px solid rgba(255,255,255,0.21);
                background: rgba(0,0,0,0.21);
                border-radius: 16px;
                padding: 16px 16px 14px;
            }
            .tc-feature-detail h3{
                margin: 0 0 8px;
                letter-spacing: -0.01em;
            }
            .tc-feature-detail p{
                margin: 0;
                opacity: .92;
                max-width: 70ch;
            }

            /* Live stats */
            .tc-landing-news{
                margin-top: 18px;
                padding: 22px 26px;
            }
            .tc-landing-news-header{
                display: flex;
                align-items: baseline;
                justify-content: space-between;
                gap: 16px;
                margin-bottom: 10px;
            }
            .tc-landing-news-header h3{
                letter-spacing: -0.01em;
            }
            .tc-landing-news-list{
                list-style: none;
                padding: 0;
                margin: 0;
            }
            .tc-landing-news-list li{
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 18px;
                padding: 12px 0;
                border-top: 1px solid rgba(255,255,255,0.21);
            }
            .tc-landing-news-list li:first-child{
                border-top: 0;
            }
            .tc-landing-news-list .tc-stat-value{
                font-variant-numeric: tabular-nums;
                white-space: nowrap;
                opacity: .95;
            }
            .tc-landing-news-list strong{
                font-weight: 600;
            }

            /* Subtle “pop” without changing theme */
            .tc-landing-grid > .tc-card,
            .tc-landing-features,
            .tc-landing-news{
                transition: transform .15s ease, box-shadow .15s ease;
            }
            @media (hover:hover){
                .tc-landing-grid > .tc-card:hover{
                    transform: translateY(-2px);
                }
            }

            .tc-landing-footer{
                padding: 26px 16px 36px;
            }
            .tc-landing-footer-links{
                gap: 18px;
            }
        </style>

        <?php
        tcRenderHeader([
            'mode' => 'prelogin',
            'header_class' => 'tc-app-header tc-prelogin-header tc-landing-nav',
            'brand_group' => true,
            'actions' => [
                ['label' => 'Sign in', 'href' => '/login.php', 'class' => 'tc-btn tc-btn-secondary'],
                ['label' => 'Create account', 'href' => '/register.php', 'class' => 'tc-btn tc-btn-primary'],
            ],
        ]);
        ?>


        <main class="tc-prelogin-main tc-landing">
            <div class="tc-landing-shell">
                <div class="tc-landing-grid">
                    <section class="tc-card hero">
                        <span class="eyebrow">Private entry • SFT Official</span>
                        <h1>Welcome to the Heart of Trench City</h1>
                        <p>
                            London doesn’t sleep — it watches. Neon cuts through fog, shutters drop early, and quiet deals decide who eats. In Trench City, reputation is earned the hard way, and every move leaves a mark.
                        </p>
                        <p>
                            Step inside, pick your lane, and build your name. Sign in to unlock the real city: train your stats, run your work, stack your money, and take what you can hold.
                        </p>
                        <div class="actions">
                            <a class="tc-btn tc-btn-primary" href="/register.php">Get started</a>
                            <a class="tc-btn tc-btn-secondary" href="/login.php">Already have an account</a>
                        </div>
                    </section>

                    <section class="tc-card">
                        <h2>What you get</h2>
                        <p>A full grind from street level to serious power — progression you can feel, choices that matter, and a city that remembers what you do.</p>
                        <div class="pill-list" style="margin-bottom:14px;">
                            <span class="pill">Gym & battle stats</span>
                            <span class="pill">Crimes & nerve</span>
                            <span class="pill">Combat & retaliation</span>
                        </div>
                        <div class="pill-list">
                            <span class="pill">Factions & wars</span>
                            <span class="pill">Jobs & companies</span>
                            <span class="pill">Items, cash & markets</span>
                        </div>
                    </section>
                </div>

                <section class="tc-card tc-landing-features" aria-label="Top features">
                    <div class="tc-landing-features-header">
                        <h3 style="margin:0;">Top features</h3>
                        <span class="tc-text-muted">Tap a feature to read it</span>
                    </div>

                    <div class="tc-landing-features-wrap">
                        <div class="tc-feature-grid" id="tcFeatureGrid">
                            <?php foreach ($tc_top_features as $i => $f): ?>
                                <button
                                    type="button"
                                    class="tc-feature-tile<?php echo ($i === 0 ? ' is-active' : ''); ?>"
                                    data-feature-key="<?php echo tc_h($f['key']); ?>"
                                    aria-pressed="<?php echo ($i === 0 ? 'true' : 'false'); ?>"
                                >
                                    <span class="tc-feature-icon emoji-icon" aria-hidden="true">
                                        <img src="/assets/imgs/icons_32/<?php echo tc_h($f['icon']); ?>.PNG" alt="<?php echo tc_h($f['label']); ?>" />
                                    </span>
                                    <span class="tc-feature-label"><?php echo tc_h($f['label']); ?></span>
                                </button>
                            <?php endforeach; ?>
                        </div>

                        <div class="tc-feature-detail" id="tcFeatureDetail" aria-live="polite">
                            <h3 id="tcFeatureTitle"><?php echo tc_h($tc_top_features[0]['title']); ?></h3>
                            <p id="tcFeatureDesc"><?php echo tc_h($tc_top_features[0]['desc']); ?></p>
                        </div>
                    </div>
                </section>

                <section class="tc-card tc-landing-news">
                    <div class="tc-landing-news-header">
                        <h3 style="margin:0;">Live stats</h3>
                        <span class="tc-text-muted">City status</span>
                    </div>
                    <ul class="tc-landing-news-list">
                        <li>
                            <span><strong>Registered players</strong></span>
                            <span class="tc-stat-value"><?php echo tc_fmt_int($tc_stats['registered']); ?></span>
                        </li>
                        <li>
                            <span><strong>Online now</strong></span>
                            <span class="tc-stat-value"><?php echo tc_fmt_int($tc_stats['online']); ?></span>
                        </li>
                        <li>
                            <span><strong>Newest recruit</strong></span>
                            <span class="tc-stat-value"><?php echo ($tc_stats['newest_name'] ? tc_h($tc_stats['newest_name']) : '—'); ?></span>
                        </li>
                        <li>
                            <span><strong>Active today</strong></span>
                            <span class="tc-stat-value"><?php echo tc_fmt_int($tc_stats['active_today']); ?></span>
                        </li>
                    </ul>
                </section>
            </div>
        </main>

        <script>
            (function(){
                const features = <?php echo json_encode(array_reduce($tc_top_features, function($acc, $f){
                    $acc[$f['key']] = [
                        'title' => $f['title'],
                        'desc'  => $f['desc'],
                    ];
                    return $acc;
                }, []), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); ?>;

                const grid = document.getElementById('tcFeatureGrid');
                const titleEl = document.getElementById('tcFeatureTitle');
                const descEl  = document.getElementById('tcFeatureDesc');

                if (!grid || !titleEl || !descEl) return;

                function setActive(btn){
                    const key = btn.getAttribute('data-feature-key');
                    const data = features[key];
                    if (!data) return;

                    const buttons = grid.querySelectorAll('.tc-feature-tile');
                    buttons.forEach(b => {
                        b.classList.remove('is-active');
                        b.setAttribute('aria-pressed', 'false');
                    });

                    btn.classList.add('is-active');
                    btn.setAttribute('aria-pressed', 'true');

                    titleEl.textContent = data.title;
                    descEl.textContent  = data.desc;
                }

                grid.addEventListener('click', function(e){
                    const btn = e.target.closest('.tc-feature-tile');
                    if (!btn) return;
                    setActive(btn);
                });

                grid.addEventListener('keydown', function(e){
                    const btn = e.target.closest('.tc-feature-tile');
                    if (!btn) return;
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        setActive(btn);
                    }
                });
            })();
        </script>
<?php require_once '/var/www/trench_city/includes/prelogin-footer.php'; ?>




