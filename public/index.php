<?php
session_start();

// Define constantes
define('ROOT', dirname(__DIR__));
define('APP', ROOT . '/app');
define('VIEWS', APP . '/views');
define('CONTROLLERS', APP . '/controllers');
define('MODELS', APP . '/models');

// Autoload de classes
spl_autoload_register(function () {
     = [
        APP . '/core/' .  . '.php',
        APP . '/controllers/' .  . '.php',
        APP . '/models/' .  . '.php',
        APP . '/config/' .  . '.php',
    ];
    
    foreach ( as ) {
        if (file_exists()) {
            require_once ;
            return;
        }
    }
});

// Inicia o roteador
 = new Router();
->run();
