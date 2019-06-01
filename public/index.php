<?php
session_start([
    'name' => "session",
    'cookie_secure' => false,
    'cookie_httponly' => true,
    'sid_length' => 192,
    'sid_bits_per_character' => 6,
]);

/**
 * Composer
 */
require dirname(__DIR__) . '/vendor/autoload.php';

/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

/**
 * Routing
 */
$router = new Core\Router();

// Add the routes
$router->add('', ['controller' => 'Landingpage', 'action' => 'index']);


//$router->add('detailpage/ShowDetail', ['controller' => 'Detailpage', 'action' => 'ShowDetail','id' => 1]);
$router->add('{controller}/{action}/{id:\d+}');

$router->add('registration',['controller' => 'Authentication', 'action' => 'showRegistrationForm']);
$router->add('registration/creatUser',['controller' => 'Authentication', 'action' => 'creatUser']);
$router->add('basket', ['controller' => 'Basket', 'action' => 'showBasket']);
$router->add('basket/deleteArticle', ['controller' => 'Basket', 'action' => 'deleteArticle']);
$router->add('detailpage/ShowDetail/addToCart', ['controller' => 'Detailpage', 'action' => 'addToCart']);


$router->dispatch($_SERVER['QUERY_STRING']);
