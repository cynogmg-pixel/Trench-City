<?php
$section_title = $section_title ?? 'Admin Section';
$section_description = $section_description ?? '';
$section_features = $section_features ?? [];
$section_notes = $section_notes ?? [];
?>
<div class="tc-card">
    <div style="padding: 1.5rem;">
        <h2 style="color: #D4AF37; margin-top: 0;"><?php echo htmlspecialchars($section_title, ENT_QUOTES, 'UTF-8'); ?></h2>
        <?php if ($section_description !== ''): ?>
            <p style="color: #9CA3AF; margin-top: 0;"><?php echo htmlspecialchars($section_description, ENT_QUOTES, 'UTF-8'); ?></p>
        <?php endif; ?>

        <?php if ($section_features): ?>
            <ul style="margin: 0; padding-left: 1.25rem; color: #D1D5DB;">
                <?php foreach ($section_features as $feature): ?>
                    <li style="margin-bottom: 0.35rem;"><?php echo htmlspecialchars($feature, ENT_QUOTES, 'UTF-8'); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <?php if ($section_notes): ?>
            <div style="margin-top: 1rem;">
                <?php foreach ($section_notes as $note): ?>
                    <div style="color: #FCD34D; font-size: 0.9rem;"><?php echo htmlspecialchars($note, ENT_QUOTES, 'UTF-8'); ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
