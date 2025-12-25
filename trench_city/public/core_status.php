<?php
require_once __DIR__ . '/../core/bootstrap.php';
header('Content-Type: application/json');

echo pretty_json([
    'app'       => APP_NAME,
    'env'       => APP_ENV,
    'version'   => defined('APP_VERSION') ? APP_VERSION : 'unknown',
    'db'        => function_exists('tc_db_check') ? tc_db_check() : false,
    'redis'     => function_exists('tc_redis_check') ? tc_redis_check() : false,
    'system'    => system_info(),
]);
