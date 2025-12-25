<?php
header('Content-Type: text/plain');
echo "APP_ENV: " . getenv('APP_ENV') . PHP_EOL;
echo "REDIS_HOST: " . getenv('REDIS_HOST') . PHP_EOL;
echo "REDIS_PORT: " . getenv('REDIS_PORT') . PHP_EOL;
echo "REDIS_PASS: " . (getenv('REDIS_PASS') ? '[SET]' : '[MISSING]') . PHP_EOL;
echo "USER: " . get_current_user() . PHP_EOL;
echo "php_sapi_name: " . php_sapi_name() . PHP_EOL;
?>

