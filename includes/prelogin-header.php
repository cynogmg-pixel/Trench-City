<?php
/**
 * Prelogin header partial.
 * Uses absolute base path to reference assets outside /public when needed.
 */
if (!defined('TC_BASE_PATH')) {
    define('TC_BASE_PATH', '/var/www/trench_city');
}

$tc_page_title = $tc_page_title ?? 'Trench City';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="theme-color" content="#05070B" />
    <title><?php echo htmlspecialchars($tc_page_title, ENT_QUOTES, 'UTF-8'); ?></title>
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
    <link rel="stylesheet" href="/assets/css/prelogin-header.css" />
    <script defer src="/assets/js/tc-global.js"></script>
</head>
<body class="tc-app tc-prelogin">
<div class="page">
