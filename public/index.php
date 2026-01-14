<?php
session_start();

// Define constantes
define('ROOT', dirname(__DIR__));
define('APP', ROOT . '/app');
define('VIEWS', APP . '/views');
define('CONTROLLERS', APP . '/controllers');
define('MODELS', APP . '/models');
define('CORE', APP . '/core');
define('CONFIG', APP . '/config');

// Autoload de classes
spl_autoload_register(function ($class) {
    $paths = [
        CORE . '/' . $class . '.php',
        CONTROLLERS . '/' . $class . '.php',
        MODELS . '/' . $class . '.php',
        CONFIG . '/' . $class . '.php',
    ];

    foreach ($paths as $file) {
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Inicia o roteador
$router = new Router();
$router->run();
