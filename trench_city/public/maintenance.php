<?php
require_once __DIR__ . '/../core/bootstrap.php';
requireLogin(true);
require_once __DIR__ . '/../includes/tc_header.php';

$tc_page_title = 'Maintenance - Trench City';

?>
<?php
$maintenanceHead = <<<'HTML'
<style>
        .tc-prelogin nav.tc-prelogin-header {
            padding: 12px clamp(16px, 2vw, 28px);
            min-height: 64px;
        }

        .tc-prelogin .tc-prelogin-header .tc-brand-logo {
            width: 160px;
            max-height: 60px;
        }

        .tc-prelogin .tc-prelogin-header .tc-header-actions {
            gap: 0.5rem;
        }

        .tc-maintenance {
            min-height: calc(100vh - 70px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1.5rem 1.25rem 2.5rem;
        }

        .tc-maintenance-inner {
            text-align: center;
            max-width: 920px;
        }

        .tc-maintenance-image {
            width: min(820px, 92vw);
            height: auto;
            margin: 1.5rem auto 0;
            display: block;
            border-radius: 18px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.6);
        }

        .tc-maintenance-title {
            color: var(--tc-text-primary);
            font-size: clamp(2rem, 4vw, 3rem);
            margin: 0.75rem 0 0.5rem;
            letter-spacing: var(--tc-tracking-tight);
        }

        .tc-maintenance-subtitle {
            color: var(--tc-text-secondary);
            font-size: 1.05rem;
            margin: 0 auto;
            max-width: 620px;
        }
    </style>
HTML;

tcRenderPageStart([
    'mode' => 'prelogin',
    'head_html' => $maintenanceHead,
    'header' => [
        'mode' => 'prelogin',
        'actions' => [
            ['label' => 'Back', 'href' => '/dashboard.php', 'class' => 'tc-btn tc-btn-secondary'],
            ['label' => 'Logout', 'href' => '/logout.php', 'class' => 'tc-btn tc-btn-secondary'],
            ['label' => 'Contact us', 'href' => 'mailto:admin@trenchmade.co.uk', 'class' => 'tc-btn tc-btn-primary'],
        ],
    ],
]);
?>
<main class="tc-maintenance">
            <div class="tc-maintenance-inner">
                <h1 class="tc-maintenance-title">Maintenance Mode</h1>
                <p class="tc-maintenance-subtitle">
                    The streets are closed while we tune the city. Please check back soon.
                </p>

                <img
                    class="tc-maintenance-image"
                    src="/assets/imgs/maintenance_mode.png"
                    alt="Maintenance Mode"
                />
            </div>
        </main>
    <?php tcRenderPageEnd(['mode' => 'prelogin']); ?>




