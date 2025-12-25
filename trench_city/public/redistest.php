<?php
require '/var/www/trenchcity/core/bootstrap.php';
$r = redis();

if ($r) {
    echo "✅ Redis connected: PONG = " . $r->ping();
} else {
    echo "❌ Redis connection failed.";
}

