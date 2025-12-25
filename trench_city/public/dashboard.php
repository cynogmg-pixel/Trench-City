<?php
/**
 * TRENCH CITY - PLAYER DASHBOARD
 * Main post-login dashboard entry point
 */

require_once __DIR__ . '/../core/bootstrap.php';
requireLogin();

require __DIR__ . '/../modules/player/dashboard_shell.php';
