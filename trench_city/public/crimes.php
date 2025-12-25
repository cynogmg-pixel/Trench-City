<?php
/**
 * ===============================================================
 * TRENCH CITY - CRIMES PUBLIC ENTRY POINT
 * ===============================================================
 * Public-facing endpoint for the crimes system
 * Redirects to the crimes module shell
 *
 * Author: Architect
 * Version: 1.0.0
 * ===============================================================
 */

// Bootstrap the application
require_once __DIR__ . '/../core/bootstrap.php';

// Check authentication
requireLogin();

// Include the crimes shell module
require_once __DIR__ . '/../modules/crimes/crimes_shell.php';
