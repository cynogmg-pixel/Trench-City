<?php
require_once __DIR__ . '/../core/bootstrap.php';

echo "<div style='background:#020617;color:#cba135;font-family:monospace;padding:15px;border-radius:8px;'>";
echo "<h2>🧩 TRENCH CITY EXTENDED HELPERS TEST</h2>";

// Cache test
cache_set('test:key', ['user' => 'Trench', 'city' => 'Alpha'], 60);
$data = cache_get('test:key');
echo "<strong>Cache Write/Read:</strong> " . ($data ? '✅ OK (' . json_encode($data) . ')' : '❌ FAIL') . "<br>";

// Token test
$token = generate_token();
$verify = verify_token($token, $token);
echo "<strong>Token Verify:</strong> " . ($verify ? '✅ OK' : '❌ FAIL') . "<br>";

// System info
echo "<br><strong>System Info:</strong><pre style='color:#7bdcb5;'>" . pretty_json(system_info()) . "</pre>";

echo "<br>✅ <strong>Extended helpers operational.</strong></div>";
