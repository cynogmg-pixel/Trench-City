<?php
require_once __DIR__ . '/../core/bootstrap.php';

echo "<div style='background:#020617;color:#cba135;font-family:monospace;padding:15px;border-radius:8px;'>";
echo "<h2>🛡️ TRENCH CITY SECURITY TEST</h2>";

// CSRF
$csrf = csrf_token();
echo "<strong>CSRF Token:</strong> $csrf<br>";
echo "<strong>CSRF Check:</strong> " . (csrf_check($csrf) ? "✅ Valid" : "❌ Invalid") . "<br>";

// Nonce
$nonce = nonce_generate();
echo "<br><strong>Nonce:</strong> $nonce<br>";
echo "<strong>Nonce Verify:</strong> " . (nonce_verify($nonce) ? "✅ OK" : "❌ FAIL") . "<br>";

// Signed Request
$payload = ['user' => 'TrenchCity', 'role' => 'Architect'];
$signed = sign_request($payload);
$verify = verify_request($signed);
echo "<br><strong>Signed Payload:</strong><pre style='color:#7bdcb5;'>" . json_encode($verify, JSON_PRETTY_PRINT) . "</pre>";

echo "<br>✅ <strong>Security system operational.</strong></div>";
