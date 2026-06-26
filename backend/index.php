<?php

// Require composer autoloader
require __DIR__ . '/vendor/autoload.php';

$router = new \Bramus\Router\Router();

require_once __DIR__. '/routes/routes.php';


$router->run();