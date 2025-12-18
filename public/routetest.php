<?php
require_once __DIR__ . '/../core/bootstrap.php';

$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
header('Content-Type: application/json');

switch ($uri) {
    case 'api/ping':
        echo json_encode(['pong' => true, 'path' => $uri]);
        break;

    case 'api/env':
        echo json_encode([
            'env' => app_env(),
            'db' => function_exists('tc_db_check') ? tc_db_check() : false,
            'redis' => function_exists('tc_redis_check') ? tc_redis_check() : false
        ]);
        break;

    default:
        echo json_encode(['error' => 'Route not found', 'path' => $uri]);
}
