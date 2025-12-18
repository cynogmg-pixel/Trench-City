<?php
/**
 * TRENCH CITY - BARS WIDGET
 * Reusable bars display widget showing Energy, Nerve, Happy, Life
 * with real-time regeneration support
 *
 * Usage:
 *   $bars = getUserBars($userId);
 *   include __DIR__ . '/widgets/bars_widget.php';
 */

if (!isset($bars) || !is_array($bars)) {
    echo '<div class="alert alert-danger">Error: Bars data not loaded</div>';
    return;
}

// Bar configuration
$barConfig = [
    'energy' => [
        'label' => 'Energy',
        'color' => 'energy',
        'icon' => '/assets/imgs/icons_32/energy-stats.PNG',
        'current' => (int)($bars['energy_current'] ?? 0),
        'max' => (int)($bars['energy_max'] ?? 100),
    ],
    'nerve' => [
        'label' => 'Nerve',
        'color' => 'nerve',
        'icon' => '/assets/imgs/icons_32/cooldowns.PNG',
        'current' => (int)($bars['nerve_current'] ?? 0),
        'max' => (int)($bars['nerve_max'] ?? 100),
    ],
    'happy' => [
        'label' => 'Happy',
        'color' => 'happy',
        'icon' => '/assets/imgs/icons_32/boosters.PNG',
        'current' => (int)($bars['happy_current'] ?? 0),
        'max' => (int)($bars['happy_max'] ?? 100),
    ],
    'life' => [
        'label' => 'Life',
        'color' => 'life',
        'icon' => '/assets/imgs/icons_32/hospital.PNG',
        'current' => (int)($bars['life_current'] ?? 0),
        'max' => (int)($bars['life_max'] ?? 100),
    ]
];

?>

<div class="bars-widget">
    <?php foreach ($barConfig as $barType => $config):
        $percentage = $config['max'] > 0 ? ($config['current'] / $config['max']) * 100 : 0;
        $isFull = $config['current'] >= $config['max'];
    ?>
    <div class="bar-container"
         data-bar-type="<?php echo $barType; ?>"
         data-bar-current="<?php echo $config['current']; ?>"
         data-bar-max="<?php echo $config['max']; ?>">

        <!-- Bar Label -->
        <div class="bar-label">
            <span class="bar-name">
                <span class="bar-icon"><img src="<?php echo $config['icon']; ?>" alt="<?php echo htmlspecialchars($config['label'], ENT_QUOTES, 'UTF-8'); ?>" /></span>
                <?php echo htmlspecialchars($config['label'], ENT_QUOTES, 'UTF-8'); ?>
            </span>
            <span class="bar-value">
                <?php echo number_format($config['current']); ?> / <?php echo number_format($config['max']); ?>
            </span>
        </div>

        <!-- Bar Wrapper -->
        <div class="bar-wrapper bar-<?php echo $config['color']; ?>">
            <div class="bar-fill" style="width: <?php echo min(100, $percentage); ?>%;">
                <span class="bar-text"><?php echo round($percentage); ?>%</span>
            </div>
        </div>

        <!-- Regeneration Timer -->
        <div class="bar-timer">
            <?php if ($isFull): ?>
                <span class="bar-timer-full">FULL</span>
            <?php else: ?>
                <span class="bar-timer-pending">Next: Not available yet</span>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<style>
/* Widget-specific styles (supplement tc-components.css) */
.bars-widget {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.bar-icon {
    margin-right: 0.5rem;
    font-size: 1rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 12px !important;
    height: 12px !important;
    overflow: hidden;
}

.bar-icon img {
    width: 12px !important;
    height: 12px !important;
    max-width: 12px !important;
    max-height: 12px !important;
    min-width: 12px !important;
    min-height: 12px !important;
    object-fit: contain;
    display: block;
    opacity: 0.85;
}

.bar-container {
    position: relative;
}

/* Ensure bars have proper spacing */
.bar-container:last-child {
    margin-bottom: 0;
}

/* Mobile optimization */
@media (max-width: 480px) {
    .bar-label {
        font-size: 0.8125rem;
    }

    .bar-value {
        font-size: 0.75rem;
    }

    .bar-wrapper {
        height: 20px;
    }

    .bar-timer {
        font-size: 0.6875rem;
    }
}
</style>
