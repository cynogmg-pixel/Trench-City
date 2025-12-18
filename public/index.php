<?php
require_once '/var/www/trench_city/core/bootstrap.php';
if (session_status() === PHP_SESSION_NONE) session_start();

// Redirect to dashboard if already logged in
if (!empty($_SESSION['user_id'])) {
    header('Location: /dashboard.php');
    exit;
}

$tc_page_title = 'Trench City | Secure Access';
require_once '/var/www/trench_city/includes/prelogin-header.php';
?>
        <nav class="tc-app-header tc-prelogin-header">
            <div class="tc-brand-group">
                <a class="tc-brand" href="/">
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
                    <span class="tc-theme-icon tc-theme-icon--sun" aria-hidden="true">&#9728;</span>
                    <span class="tc-theme-icon tc-theme-icon--moon" aria-hidden="true">&#9790;</span>
                </button>
            </div>
            <div class="tc-header-actions">
                <a class="tc-btn tc-btn-secondary" href="/login.php">Sign in</a>
                <a class="tc-btn tc-btn-primary" href="/register.php">Create account</a>
            </div>
        </nav>

        <main class="tc-prelogin-main">
            <div class="tc-prelogin-grid">
                <section class="tc-card hero">
                    <span class="eyebrow">Secure access for SFT Official</span>
                    <h1>Welcome to the Heart of Trench City</h1>
                    <p>
                        The city never sleeps. Neon lights flicker over dark alleys, deals are made in shadows, and every corner hides a story waiting to be written. Here, power is earned, alliances are forged, and reputation is currency.
                    </p>
                    <p>
                        Step inside, carve your path, and make your mark - but remember, only those who log in can unlock the secrets, control the resources, and shape the chaos that pulses through these streets. Visitors can watch the game unfold from the edge, catching glimpses of danger, ambition, and opportunity - and get a taste of the world that awaits when they join.
                    </p>
                    <p>
                        Trench City isn't just a place - it's a challenge, a playground, and a battlefield for those bold enough to rise. Are you ready to claim your place in its story?
                    </p>
                    <div class="actions">
                        <a class="tc-btn tc-btn-primary" href="/register.php">Get started</a>
                        <a class="tc-btn tc-btn-secondary" href="/login.php">Already have an account</a>
                    </div>
                    <div class="pill-list" style="margin-top:18px;">
                        <span class="pill">Role-aware access</span>
                        <span class="pill">Session guarded</span>
                        <span class="pill">Nginx root: /public</span>
                        <span class="pill">Fast entry</span>
                    </div>
                </section>

                <section class="tc-card">
                    <h2>What you get</h2>
                    <p>Direct visitors to login or registration and keep core files outside the public root.</p>
                    <div class="pill-list" style="margin-bottom:14px;">
                        <span class="pill">Dedicated login</span>
                        <span class="pill">Dedicated register</span>
                        <span class="pill">Clear CTAs</span>
                    </div>
                    <div class="pill-list">
                        <span class="pill">Ready for PHP-FPM</span>
                        <span class="pill">Works on nginx 1.18+</span>
                        <span class="pill">Single stylesheet</span>
                    </div>
                </section>
            </div>
        </main>

        <footer>
            Trench City - secure entry point for SFT Official.
        </footer>
<?php require_once '/var/www/trench_city/includes/prelogin-footer.php'; ?>
