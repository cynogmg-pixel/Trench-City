<?php
/**
 * DESIGN TEST PAGE
 * Visual testing page for UI elements, styles, and components
 */

// Bootstrap and authentication
require_once __DIR__ . '/../core/bootstrap.php';
requireLogin();

$tc_page_title = 'Design Test - Trench City';
include __DIR__ . '/../includes/tc_header.php';
tcRenderPageStart(['mode' => 'postlogin']);
?>

<!-- Main Content -->
<div class="main-content">
    <div class="content-wrapper">

        <!-- Page Header -->
        <div class="content-header">
            <h1 class="content-title">Design Test Laboratory</h1>
            <p class="content-description">Choose your preferred styles and components</p>
        </div>

        <!-- BUTTONS SECTION -->
        <div class="page-section">
            <div class="section-header">
                <h2 class="section-title">Button Styles</h2>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Option A - Solid Buttons</h3>
                </div>
                <div class="card-body">
                    <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                        <button class="btn-test-a btn-test-a-primary">Primary Action</button>
                        <button class="btn-test-a btn-test-a-secondary">Secondary</button>
                        <button class="btn-test-a btn-test-a-success">Success</button>
                        <button class="btn-test-a btn-test-a-danger">Danger</button>
                        <button class="btn-test-a btn-test-a-gold">Gold Premium</button>
                    </div>
                </div>
            </div>

            <div class="card" style="margin-top: 1rem;">
                <div class="card-header">
                    <h3 class="card-title">Option B - Gradient Buttons</h3>
                </div>
                <div class="card-body">
                    <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                        <button class="btn-test-b btn-test-b-primary">Primary Action</button>
                        <button class="btn-test-b btn-test-b-secondary">Secondary</button>
                        <button class="btn-test-b btn-test-b-success">Success</button>
                        <button class="btn-test-b btn-test-b-danger">Danger</button>
                        <button class="btn-test-b btn-test-b-gold">Gold Premium</button>
                    </div>
                </div>
            </div>

            <div class="card" style="margin-top: 1rem;">
                <div class="card-header">
                    <h3 class="card-title">Option C - Outline Buttons</h3>
                </div>
                <div class="card-body">
                    <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                        <button class="btn-test-c btn-test-c-primary">Primary Action</button>
                        <button class="btn-test-c btn-test-c-secondary">Secondary</button>
                        <button class="btn-test-c btn-test-c-success">Success</button>
                        <button class="btn-test-c btn-test-c-danger">Danger</button>
                        <button class="btn-test-c btn-test-c-gold">Gold Premium</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- TYPOGRAPHY SECTION -->
        <div class="page-section" style="margin-top: 2rem;">
            <div class="section-header">
                <h2 class="section-title">Typography</h2>
            </div>

            <div class="grid grid-2">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Option A - Sans-Serif (Inter)</h3>
                    </div>
                    <div class="card-body font-option-a">
                        <h1 style="margin-bottom: 0.5rem;">Heading Level 1</h1>
                        <h2 style="margin-bottom: 0.5rem;">Heading Level 2</h2>
                        <h3 style="margin-bottom: 0.5rem;">Heading Level 3</h3>
                        <p>This is body text in Inter font. Clean, modern, and highly readable for UI elements and long-form content.</p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Option B - Serif (Merriweather)</h3>
                    </div>
                    <div class="card-body font-option-b">
                        <h1 style="margin-bottom: 0.5rem;">Heading Level 1</h1>
                        <h2 style="margin-bottom: 0.5rem;">Heading Level 2</h2>
                        <h3 style="margin-bottom: 0.5rem;">Heading Level 3</h3>
                        <p>This is body text in Merriweather font. Classic, elegant, and sophisticated for a premium feel.</p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Option C - Monospace (Roboto Mono)</h3>
                    </div>
                    <div class="card-body font-option-c">
                        <h1 style="margin-bottom: 0.5rem;">Heading Level 1</h1>
                        <h2 style="margin-bottom: 0.5rem;">Heading Level 2</h2>
                        <h3 style="margin-bottom: 0.5rem;">Heading Level 3</h3>
                        <p>This is body text in Roboto Mono font. Technical, retro, and gives a hacker/cyberpunk aesthetic.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- CARD BORDERS SECTION -->
        <div class="page-section" style="margin-top: 2rem;">
            <div class="section-header">
                <h2 class="section-title">Card Border Styles</h2>
            </div>

            <div class="grid grid-3">
                <div class="card border-option-a">
                    <div class="card-header">
                        <h3 class="card-title">Option A - Subtle Border</h3>
                    </div>
                    <div class="card-body">
                        <p>Thin, subtle border with slight transparency. Minimal and clean appearance.</p>
                    </div>
                </div>

                <div class="card border-option-b">
                    <div class="card-header">
                        <h3 class="card-title">Option B - Gold Accent</h3>
                    </div>
                    <div class="card-body">
                        <p>Visible gold border with glow effect. Premium and luxurious feel.</p>
                    </div>
                </div>

                <div class="card border-option-c">
                    <div class="card-header">
                        <h3 class="card-title">Option C - Gradient Border</h3>
                    </div>
                    <div class="card-body">
                        <p>Gradient border effect with animated glow. Modern and dynamic appearance.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- BACKGROUND PATTERNS SECTION -->
        <div class="page-section" style="margin-top: 2rem;">
            <div class="section-header">
                <h2 class="section-title">Card Background Styles</h2>
            </div>

            <div class="grid grid-2">
                <div class="card bg-option-a">
                    <div class="card-header">
                        <h3 class="card-title">Option A - Solid Dark</h3>
                    </div>
                    <div class="card-body">
                        <p>Pure solid background with subtle transparency. Clean and straightforward.</p>
                        <div style="margin-top: 1rem; padding: 1rem; background: rgba(255,255,255,0.2); border-radius: 4px;">
                            <strong>Cash:</strong> $5,000,000
                        </div>
                    </div>
                </div>

                <div class="card bg-option-b">
                    <div class="card-header">
                        <h3 class="card-title">Option B - Gradient Dark</h3>
                    </div>
                    <div class="card-body">
                        <p>Subtle gradient background. Adds depth and dimension to cards.</p>
                        <div style="margin-top: 1rem; padding: 1rem; background: rgba(255,255,255,0.2); border-radius: 4px;">
                            <strong>Cash:</strong> $5,000,000
                        </div>
                    </div>
                </div>

                <div class="card bg-option-c">
                    <div class="card-header">
                        <h3 class="card-title">Option C - Pattern Overlay</h3>
                    </div>
                    <div class="card-body">
                        <p>Subtle geometric pattern overlay. Adds texture and visual interest.</p>
                        <div style="margin-top: 1rem; padding: 1rem; background: rgba(255,255,255,0.2); border-radius: 4px;">
                            <strong>Cash:</strong> $5,000,000
                        </div>
                    </div>
                </div>

                <div class="card bg-option-d">
                    <div class="card-header">
                        <h3 class="card-title">Option D - Noise Texture</h3>
                    </div>
                    <div class="card-body">
                        <p>Film grain noise texture. Vintage and gritty aesthetic.</p>
                        <div style="margin-top: 1rem; padding: 1rem; background: rgba(255,255,255,0.2); border-radius: 4px;">
                            <strong>Cash:</strong> $5,000,000
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- INPUT FIELDS SECTION -->
        <div class="page-section" style="margin-top: 2rem;">
            <div class="section-header">
                <h2 class="section-title">Input Field Styles</h2>
            </div>

            <div class="grid grid-2">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Option A - Minimal</h3>
                    </div>
                    <div class="card-body">
                        <input type="text" class="input-option-a" placeholder="Enter username...">
                        <textarea class="input-option-a" rows="3" placeholder="Enter message..." style="margin-top: 0.5rem;"></textarea>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Option B - Gold Focus</h3>
                    </div>
                    <div class="card-body">
                        <input type="text" class="input-option-b" placeholder="Enter username...">
                        <textarea class="input-option-b" rows="3" placeholder="Enter message..." style="margin-top: 0.5rem;"></textarea>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Option C - Underline</h3>
                    </div>
                    <div class="card-body">
                        <input type="text" class="input-option-c" placeholder="Enter username...">
                        <textarea class="input-option-c" rows="3" placeholder="Enter message..." style="margin-top: 0.5rem;"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- ICON STYLES SECTION -->
        <div class="page-section" style="margin-top: 2rem;">
            <div class="section-header">
                <h2 class="section-title">Icon Display Styles</h2>
            </div>

            <div class="grid grid-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Option A - Flat Icons</h3>
                    </div>
                    <div class="card-body">
                        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                            <div class="icon-option-a"><img src="/assets/imgs/icons_32/profile.PNG" alt="Profile"></div>
                            <div class="icon-option-a"><img src="/assets/imgs/icons_32/inventory.PNG" alt="Inventory"></div>
                            <div class="icon-option-a"><img src="/assets/imgs/icons_32/weapon.PNG" alt="Weapon"></div>
                            <div class="icon-option-a"><img src="/assets/imgs/icons_32/bank.PNG" alt="Bank"></div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Option B - Circled Icons</h3>
                    </div>
                    <div class="card-body">
                        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                            <div class="icon-option-b"><img src="/assets/imgs/icons_32/profile.PNG" alt="Profile"></div>
                            <div class="icon-option-b"><img src="/assets/imgs/icons_32/inventory.PNG" alt="Inventory"></div>
                            <div class="icon-option-b"><img src="/assets/imgs/icons_32/weapon.PNG" alt="Weapon"></div>
                            <div class="icon-option-b"><img src="/assets/imgs/icons_32/bank.PNG" alt="Bank"></div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Option C - Glowing Icons</h3>
                    </div>
                    <div class="card-body">
                        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                            <div class="icon-option-c"><img src="/assets/imgs/icons_32/profile.PNG" alt="Profile"></div>
                            <div class="icon-option-c"><img src="/assets/imgs/icons_32/inventory.PNG" alt="Inventory"></div>
                            <div class="icon-option-c"><img src="/assets/imgs/icons_32/weapon.PNG" alt="Weapon"></div>
                            <div class="icon-option-c"><img src="/assets/imgs/icons_32/bank.PNG" alt="Bank"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Custom Test Styles -->
<style>
/* ==================================
   BUTTON STYLES
   ================================== */

/* Option A - Solid Buttons */
.btn-test-a {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 6px;
    font-weight: 600;
    font-size: 0.9375rem;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-test-a-primary {
    background: #3B82F6;
    color: white;
}

.btn-test-a-primary:hover {
    background: #2563EB;
    transform: translateY(-2px);
}

.btn-test-a-secondary {
    background: #6B7280;
    color: white;
}

.btn-test-a-secondary:hover {
    background: #4B5563;
}

.btn-test-a-success {
    background: #10B981;
    color: white;
}

.btn-test-a-success:hover {
    background: #059669;
}

.btn-test-a-danger {
    background: #EF4444;
    color: white;
}

.btn-test-a-danger:hover {
    background: #DC2626;
}

.btn-test-a-gold {
    background: #D4AF37;
    color: #0F172A;
}

.btn-test-a-gold:hover {
    background: #F5C451;
}

/* Option B - Gradient Buttons */
.btn-test-b {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.9375rem;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.btn-test-b::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.45), transparent);
    transition: left 0.5s ease;
}

.btn-test-b:hover::before {
    left: 100%;
}

.btn-test-b-primary {
    background: linear-gradient(135deg, #3B82F6, #1D4ED8);
    color: white;
}

.btn-test-b-secondary {
    background: linear-gradient(135deg, #6B7280, #374151);
    color: white;
}

.btn-test-b-success {
    background: linear-gradient(135deg, #10B981, #047857);
    color: white;
}

.btn-test-b-danger {
    background: linear-gradient(135deg, #EF4444, #B91C1C);
    color: white;
}

.btn-test-b-gold {
    background: linear-gradient(135deg, #F5C451, #D4AF37);
    color: #0F172A;
}

/* Option C - Outline Buttons */
.btn-test-c {
    padding: 0.75rem 1.5rem;
    border: 2px solid;
    border-radius: 6px;
    background: transparent;
    font-weight: 600;
    font-size: 0.9375rem;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-test-c-primary {
    border-color: #3B82F6;
    color: #3B82F6;
}

.btn-test-c-primary:hover {
    background: #3B82F6;
    color: white;
}

.btn-test-c-secondary {
    border-color: #6B7280;
    color: #9CA3AF;
}

.btn-test-c-secondary:hover {
    background: #6B7280;
    color: white;
}

.btn-test-c-success {
    border-color: #10B981;
    color: #10B981;
}

.btn-test-c-success:hover {
    background: #10B981;
    color: white;
}

.btn-test-c-danger {
    border-color: #EF4444;
    color: #EF4444;
}

.btn-test-c-danger:hover {
    background: #EF4444;
    color: white;
}

.btn-test-c-gold {
    border-color: #D4AF37;
    color: #D4AF37;
}

.btn-test-c-gold:hover {
    background: #D4AF37;
    color: #0F172A;
}

/* ==================================
   TYPOGRAPHY
   ================================== */

.font-option-a {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
}

.font-option-b {
    font-family: 'Merriweather', Georgia, serif;
}

.font-option-c {
    font-family: 'Roboto Mono', 'Courier New', monospace;
}

/* ==================================
   CARD BORDERS
   ================================== */

.border-option-a {
    border: 1px solid rgba(75, 85, 99, 0.55);
}

.border-option-b {
    border: 2px solid #D4AF37;
    box-shadow: 0 0 20px rgba(212, 175, 55, 0.35);
}

.border-option-c {
    border: 2px solid transparent;
    background-image:
        linear-gradient(rgba(17, 24, 39, 0.9), rgba(17, 24, 39, 0.9)),
        linear-gradient(135deg, #D4AF37, #3B82F6, #D4AF37);
    background-origin: border-box;
    background-clip: padding-box, border-box;
}

/* ==================================
   BACKGROUNDS
   ================================== */

.bg-option-a {
    background: rgba(17, 24, 39, 0.9);
}

.bg-option-b {
    background: linear-gradient(135deg, rgba(17, 24, 39, 0.9), rgba(31, 41, 55, 0.9));
}

.bg-option-c {
    background:
        linear-gradient(rgba(17, 24, 39, 0.9), rgba(17, 24, 39, 0.9)),
        repeating-linear-gradient(
            45deg,
            transparent,
            transparent 10px,
            rgba(212, 175, 55, 0.18) 10px,
            rgba(212, 175, 55, 0.18) 20px
        );
}

.bg-option-d {
    background: rgba(17, 24, 39, 0.9);
    position: relative;
}

.bg-option-d::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 400 400' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noiseFilter'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' /%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noiseFilter)' opacity='0.05'/%3E%3C/svg%3E");
    pointer-events: none;
    opacity: 0.4;
}

/* ==================================
   INPUT FIELDS
   ================================== */

.input-option-a,
.input-option-b,
.input-option-c {
    width: 100%;
    padding: 0.75rem 1rem;
    font-size: 0.9375rem;
    color: #F9FAFB;
    background: rgba(31, 41, 55, 0.65);
    transition: all 0.2s ease;
    font-family: inherit;
}

.input-option-a {
    border: 1px solid rgba(75, 85, 99, 0.65);
    border-radius: 6px;
}

.input-option-a:focus {
    outline: none;
    border-color: rgba(75, 85, 99, 0.9);
    background: rgba(31, 41, 55, 0.85);
}

.input-option-b {
    border: 2px solid rgba(75, 85, 99, 0.45);
    border-radius: 8px;
}

.input-option-b:focus {
    outline: none;
    border-color: #D4AF37;
    background: rgba(31, 41, 55, 0.85);
    box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.25);
}

.input-option-c {
    border: none;
    border-bottom: 2px solid rgba(75, 85, 99, 0.65);
    border-radius: 0;
    background: transparent;
}

.input-option-c:focus {
    outline: none;
    border-bottom-color: #D4AF37;
    background: rgba(31, 41, 55, 0.35);
}

/* ==================================
   ICON STYLES
   ================================== */

.icon-option-a,
.icon-option-b,
.icon-option-c {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}

.icon-option-a img {
    width: 32px;
    height: 32px;
    opacity: 0.8;
}

.icon-option-a:hover img {
    opacity: 1;
}

.icon-option-b {
    background: rgba(212, 175, 55, 0.25);
    border-radius: 50%;
    border: 2px solid rgba(212, 175, 55, 0.45);
}

.icon-option-b img {
    width: 24px;
    height: 24px;
}

.icon-option-b:hover {
    background: rgba(212, 175, 55, 0.35);
    border-color: rgba(212, 175, 55, 0.65);
    transform: scale(1.1);
}

.icon-option-c {
    background: rgba(31, 41, 55, 0.65);
    border-radius: 8px;
}

.icon-option-c img {
    width: 28px;
    height: 28px;
    filter: drop-shadow(0 0 8px rgba(212, 175, 55, 0.45));
}

.icon-option-c:hover {
    background: rgba(212, 175, 55, 0.3);
}

.icon-option-c:hover img {
    filter: drop-shadow(0 0 12px rgba(212, 175, 55, 0.75));
}
</style>

</body>
</html>




