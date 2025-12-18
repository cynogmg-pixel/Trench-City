<?php
/**
 * ======================================================
 *  ⚙️ TRENCH CITY HELPERS TEST (FINAL)
 *  Validates environment, DB, Redis, and helpers.
 *  URL: http://217.160.147.25/helptest.php
 *  Author: Architect
 * ======================================================
 */

require_once __DIR__ . '/../core/bootstrap.php';

// Begin HTML wrapper
echo "<div style='background:#020617;color:#cba135;font-family:monospace;padding:15px;border-radius:8px;'>";

echo "<h2>⚙️ TRENCH CITY HELPERS TEST</h2>";

// ENV checks
echo "<strong>Environment:</strong> " . app_env() . "<br>";
echo "<strong>is_dev:</strong> " . (is_dev() ? '✅ true' : '❌ false') . "<br>";
echo "<strong>is_alpha:</strong> " . (is_alpha() ? '✅ true' : '❌ false') . "<br>";
echo "<strong>is_prod:</strong> " . (is_prod() ? '✅ true' : '❌ false') . "<br>";

// UUID
echo "<br><strong>UUIDv4:</strong> " . uuidv4() . "<br>";

// Sanitize test
echo "<br><strong>Sanitize:</strong> " . str_sanitize('<script>alert(1)</script> Hello Trench City!') . "<br>";

// Hash + Verify
$testPass = 'Rianna2602';
$hash = tc_hash($testPass);
echo "<br><strong>Hash:</strong> " . substr($hash, 0, 20) . "...<br>";
echo "<strong>Verify:</strong> " . (tc_verify($testPass, $hash) ? '✅ OK' : '❌ FAIL') . "<br>";

// Rate limiting
$key = 'test:' . uuidv4();
$result = rate_limit($key, 3, 60);
echo "<br><strong>Rate Limit:</strong> " . ($result ? '✅ OK' : '❌ LIMIT HIT') . "<br>";

// Paths
echo "<br><strong>Core Path:</strong> " . core_path('config.php') . "<br>";
echo "<strong>Public Path:</strong> " . public_path('index.php') . "<br>";

// Live Redis + DB checks
$redis_ok = function_exists('tc_redis_check') ? tc_redis_check() : false;
$db_ok = function_exists('tc_db_check') ? tc_db_check() : false;

// JSON Summary
echo "<br><strong>Pretty JSON:</strong><pre style='color:#7bdcb5;'>" . pretty_json([
    'env'   => app_env(),
    'uuid'  => uuidv4(),
    'redis' => $redis_ok,
    'db'    => $db_ok,
]) . "</pre>";

// Time Helpers
echo "<br><strong>Now:</strong> " . now() . "<br>";
echo "<strong>Seconds Since (1 min ago):</strong> " . seconds_since(date('Y-m-d H:i:s', time() - 60)) . " sec<br>";

// Status Summary
if ($redis_ok && $db_ok) {
    echo "<br>✅ <strong>All systems operational — Trench City Core healthy.</strong>";
} elseif ($db_ok && !$redis_ok) {
    echo "<br>⚠️ <strong>DB connected, but Redis unavailable.</strong>";
} else {
    echo "<br>❌ <strong>Critical failure — check Redis or DB connections.</strong>";
}

echo "</div>";
?>
