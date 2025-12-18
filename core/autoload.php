<?php
/**
 * ======================================================
 *  TRENCH CITY AUTOLOADER
 *  Dynamically includes class files
 * ======================================================
 */
spl_autoload_register(function($class) {
    $paths = [
        __DIR__ . '/models/' . $class . '.php',
        __DIR__ . '/controllers/' . $class . '.php',
        __DIR__ . '/libraries/' . $class . '.php',
    ];
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});
