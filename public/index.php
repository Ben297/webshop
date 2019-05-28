<?php

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
$router->add('cart', ['controller' => 'Cart', 'action' => 'ShowCart']);
$router->add('detailpage/setCookie', ['controller' => 'Detailpage', 'action' => 'setCookie']);
$router->dispatch($_SERVER['QUERY_STRING']);
