<?php
/**
 * TRENCH CITY - DESIGN SYSTEM TEST PAGE
 * Use this page to test and preview all TC design components
 */

require_once __DIR__ . '/../core/bootstrap.php';
requireLogin();

$userId = currentUserId();
$user = getUser($userId);

$tc_page_title = 'Design System - Trench City';
include __DIR__ . '/../includes/tc_header.php';
tcRenderPageStart(['mode' => 'postlogin']);
?>

<!-- Main Content -->
<div class="main-content">
    <div class="content-wrapper">

        <!-- Page Header -->
        <div class="tc-content-header">
            <h1 class="tc-title">Design System</h1>
            <p class="tc-subtitle">Preview all Trench City components and styles</p>
        </div>

        <!-- Colors Section -->
        <div class="tc-card">
            <div class="tc-card-header">
                <h2 class="tc-card-title">Color Palette</h2>
            </div>
            <div class="tc-card-body">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem;">
                    <div style="background: #D4AF37; padding: 2rem; border-radius: 8px; text-align: center; color: #000;">
                        <strong>Gold Primary</strong><br>#D4AF37
                    </div>
                    <div style="background: #10B981; padding: 2rem; border-radius: 8px; text-align: center;">
                        <strong>Success</strong><br>#10B981
                    </div>
                    <div style="background: #EF4444; padding: 2rem; border-radius: 8px; text-align: center;">
                        <strong>Danger</strong><br>#EF4444
                    </div>
                    <div style="background: #F59E0B; padding: 2rem; border-radius: 8px; text-align: center;">
                        <strong>Warning</strong><br>#F59E0B
                    </div>
                    <div style="background: #3B82F6; padding: 2rem; border-radius: 8px; text-align: center;">
                        <strong>Info</strong><br>#3B82F6
                    </div>
                </div>
            </div>
        </div>

        <!-- Typography Section -->
        <div class="tc-card">
            <div class="tc-card-header">
                <h2 class="tc-card-title">Typography</h2>
            </div>
            <div class="tc-card-body">
                <h1 class="tc-title">Title (tc-title)</h1>
                <h2 class="tc-heading">Heading (tc-heading)</h2>
                <h3 class="tc-subheading">Subheading (tc-subheading)</h3>
                <p class="tc-text">Body text (tc-text) - The quick brown fox jumps over the lazy dog.</p>
                <p class="tc-text-sm">Small text (tc-text-sm) - Additional details and captions.</p>
                <p class="tc-text-muted">Muted text (tc-text-muted) - Secondary information.</p>
            </div>
        </div>

        <!-- Buttons Section -->
        <div class="tc-card">
            <div class="tc-card-header">
                <h2 class="tc-card-title">Buttons</h2>
            </div>
            <div class="tc-card-body">
                <div style="display: flex; gap: 1rem; flex-wrap: wrap; margin-bottom: 1rem;">
                    <button class="tc-btn tc-btn-primary">Primary Button</button>
                    <button class="tc-btn tc-btn-secondary">Secondary Button</button>
                    <button class="tc-btn tc-btn-success">Success Button</button>
                    <button class="tc-btn tc-btn-danger">Danger Button</button>
                    <button class="tc-btn tc-btn-warning">Warning Button</button>
                    <button class="tc-btn tc-btn-info">Info Button</button>
                </div>
                <div style="display: flex; gap: 1rem; flex-wrap: wrap; margin-bottom: 1rem;">
                    <button class="tc-btn tc-btn-primary tc-btn-sm">Small Primary</button>
                    <button class="tc-btn tc-btn-secondary tc-btn-sm">Small Secondary</button>
                    <button class="tc-btn tc-btn-primary tc-btn-lg">Large Primary</button>
                </div>
                <button class="tc-btn tc-btn-primary tc-btn-block">Block Button (Full Width)</button>
            </div>
        </div>

        <!-- Cards Section -->
        <div class="tc-card">
            <div class="tc-card-header">
                <h2 class="tc-card-title">Cards</h2>
            </div>
            <div class="tc-card-body">
                <div class="tc-grid tc-grid-3">
                    <div class="tc-card">
                        <h3 class="tc-card-title">Card Title</h3>
                        <p class="tc-text">Standard card with content</p>
                    </div>
                    <div class="tc-card tc-card-hover">
                        <h3 class="tc-card-title">Hover Card</h3>
                        <p class="tc-text">This card has hover effect (tc-card-hover)</p>
                    </div>
                    <div class="tc-card tc-card-gold">
                        <h3 class="tc-card-title">Gold Card</h3>
                        <p class="tc-text">Premium card with gold accent (tc-card-gold)</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alerts Section -->
        <div class="tc-card">
            <div class="tc-card-header">
                <h2 class="tc-card-title">Alerts & Messages</h2>
            </div>
            <div class="tc-card-body">
                <div class="tc-alert tc-alert-success">
                    <strong>Success!</strong> This is a success message.
                </div>
                <div class="tc-alert tc-alert-danger">
                    <strong>Error!</strong> This is an error message.
                </div>
                <div class="tc-alert tc-alert-warning">
                    <strong>Warning!</strong> This is a warning message.
                </div>
                <div class="tc-alert tc-alert-info">
                    <strong>Info!</strong> This is an informational message.
                </div>
            </div>
        </div>

        <!-- Progress Bars Section -->
        <div class="tc-card">
            <div class="tc-card-header">
                <h2 class="tc-card-title">Progress Bars</h2>
            </div>
            <div class="tc-card-body">
                <div style="margin-bottom: 1.5rem;">
                    <label class="tc-label">Energy (75%)</label>
                    <div class="tc-bar-wrapper">
                        <div class="tc-bar-fill tc-bar-energy" style="width: 75%;">
                            <span class="tc-bar-text">75%</span>
                        </div>
                    </div>
                </div>
                <div style="margin-bottom: 1.5rem;">
                    <label class="tc-label">Nerve (50%)</label>
                    <div class="tc-bar-wrapper">
                        <div class="tc-bar-fill tc-bar-nerve" style="width: 50%;">
                            <span class="tc-bar-text">50%</span>
                        </div>
                    </div>
                </div>
                <div style="margin-bottom: 1.5rem;">
                    <label class="tc-label">Health (90%)</label>
                    <div class="tc-bar-wrapper">
                        <div class="tc-bar-fill tc-bar-life" style="width: 90%;">
                            <span class="tc-bar-text">90%</span>
                        </div>
                    </div>
                </div>
                <div>
                    <label class="tc-label">Happy (60%)</label>
                    <div class="tc-bar-wrapper">
                        <div class="tc-bar-fill tc-bar-happy" style="width: 60%;">
                            <span class="tc-bar-text">60%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grid System Section -->
        <div class="tc-card">
            <div class="tc-card-header">
                <h2 class="tc-card-title">Grid System</h2>
            </div>
            <div class="tc-card-body">
                <h3 class="tc-subheading">2 Columns (tc-grid-2)</h3>
                <div class="tc-grid tc-grid-2" style="margin-bottom: 2rem;">
                    <div class="tc-card"><p class="tc-text">Column 1</p></div>
                    <div class="tc-card"><p class="tc-text">Column 2</p></div>
                </div>

                <h3 class="tc-subheading">3 Columns (tc-grid-3)</h3>
                <div class="tc-grid tc-grid-3" style="margin-bottom: 2rem;">
                    <div class="tc-card"><p class="tc-text">Column 1</p></div>
                    <div class="tc-card"><p class="tc-text">Column 2</p></div>
                    <div class="tc-card"><p class="tc-text">Column 3</p></div>
                </div>

                <h3 class="tc-subheading">4 Columns (tc-grid-4)</h3>
                <div class="tc-grid tc-grid-4">
                    <div class="tc-card"><p class="tc-text">Column 1</p></div>
                    <div class="tc-card"><p class="tc-text">Column 2</p></div>
                    <div class="tc-card"><p class="tc-text">Column 3</p></div>
                    <div class="tc-card"><p class="tc-text">Column 4</p></div>
                </div>
            </div>
        </div>

        <!-- Forms Section -->
        <div class="tc-card">
            <div class="tc-card-header">
                <h2 class="tc-card-title">Form Elements</h2>
            </div>
            <div class="tc-card-body">
                <form>
                    <div class="tc-form-group">
                        <label class="tc-label" for="input1">Text Input</label>
                        <input type="text" id="input1" class="tc-input" placeholder="Enter text...">
                    </div>

                    <div class="tc-form-group">
                        <label class="tc-label" for="select1">Select Dropdown</label>
                        <select id="select1" class="tc-select">
                            <option>Option 1</option>
                            <option>Option 2</option>
                            <option>Option 3</option>
                        </select>
                    </div>

                    <div class="tc-form-group">
                        <label class="tc-label" for="textarea1">Textarea</label>
                        <textarea id="textarea1" class="tc-textarea" rows="4" placeholder="Enter message..."></textarea>
                    </div>

                    <div class="tc-form-group">
                        <label class="tc-checkbox">
                            <input type="checkbox">
                            <span>Checkbox option</span>
                        </label>
                    </div>

                    <button type="button" class="tc-btn tc-btn-primary">Submit Form</button>
                </form>
            </div>
        </div>

        <!-- Tables Section -->
        <div class="tc-card">
            <div class="tc-card-header">
                <h2 class="tc-card-title">Tables</h2>
            </div>
            <div class="tc-card-body">
                <table class="tc-table">
                    <thead>
                        <tr>
                            <th>Player</th>
                            <th>Level</th>
                            <th>Cash</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Player1</td>
                            <td>10</td>
                            <td class="tc-text-success">$50,000</td>
                            <td><span class="tc-badge tc-badge-success">Online</span></td>
                        </tr>
                        <tr>
                            <td>Player2</td>
                            <td>8</td>
                            <td class="tc-text-success">$35,000</td>
                            <td><span class="tc-badge tc-badge-danger">Offline</span></td>
                        </tr>
                        <tr>
                            <td>Player3</td>
                            <td>15</td>
                            <td class="tc-text-success">$125,000</td>
                            <td><span class="tc-badge tc-badge-success">Online</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Badges Section -->
        <div class="tc-card">
            <div class="tc-card-header">
                <h2 class="tc-card-title">Badges</h2>
            </div>
            <div class="tc-card-body">
                <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                    <span class="tc-badge tc-badge-primary">Primary</span>
                    <span class="tc-badge tc-badge-success">Success</span>
                    <span class="tc-badge tc-badge-danger">Danger</span>
                    <span class="tc-badge tc-badge-warning">Warning</span>
                    <span class="tc-badge tc-badge-info">Info</span>
                    <span class="tc-badge tc-badge-gold">Gold</span>
                </div>
            </div>
        </div>

        <!-- Stats Display Section -->
        <div class="tc-card">
            <div class="tc-card-header">
                <h2 class="tc-card-title">Stats Display</h2>
            </div>
            <div class="tc-card-body">
                <div class="tc-stats-grid">
                    <div class="tc-stat-box">
                        <div class="tc-stat-label">Level</div>
                        <div class="tc-stat-value tc-text-gold">15</div>
                    </div>
                    <div class="tc-stat-box">
                        <div class="tc-stat-label">Cash</div>
                        <div class="tc-stat-value tc-text-success">$125,450</div>
                    </div>
                    <div class="tc-stat-box">
                        <div class="tc-stat-label">Bank</div>
                        <div class="tc-stat-value tc-text-success">$500,000</div>
                    </div>
                    <div class="tc-stat-box">
                        <div class="tc-stat-label">Total Stats</div>
                        <div class="tc-stat-value">250</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Utility Classes Section -->
        <div class="tc-card">
            <div class="tc-card-header">
                <h2 class="tc-card-title">Utility Classes</h2>
            </div>
            <div class="tc-card-body">
                <p class="tc-text-gold">Gold text (tc-text-gold)</p>
                <p class="tc-text-success">Success text (tc-text-success)</p>
                <p class="tc-text-danger">Danger text (tc-text-danger)</p>
                <p class="tc-text-warning">Warning text (tc-text-warning)</p>
                <p class="tc-text-info">Info text (tc-text-info)</p>
                <p class="tc-text-muted">Muted text (tc-text-muted)</p>
                <hr class="tc-divider">
                <p class="tc-text-center">Centered text (tc-text-center)</p>
                <p class="tc-font-bold">Bold text (tc-font-bold)</p>
            </div>
        </div>

    </div>
</div>

<?php include __DIR__ . '/../includes/postlogin-footer.php'; ?>
