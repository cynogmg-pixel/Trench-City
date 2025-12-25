<?php
define('TRENCH_CITY', true);
require_once __DIR__ . '/../core/db.php';

try {
    if (tc_db_check()) {
        echo "✅ Database connection successful to: " . DB_NAME;
    } else {
        echo "❌ Database check failed.";
    }
} catch (Exception $e) {
    echo "Error: " . htmlspecialchars($e->getMessage());
}

