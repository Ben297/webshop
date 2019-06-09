<?php
session_start([
    'name' => "session",
    'cookie_secure' => false,
    'cookie_httponly' => true,
    'cookie_lifetime' => 0,
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

$router->add('register',['controller' => 'Authentication', 'action' => 'showRegistrationForm']);
$router->add('register/registerUser',['controller' => 'Authentication', 'action' => 'registerUser']);
$router->add('login',['controller'=> 'Authentication', 'action' => 'showLoginForm']);
$router->add('login/login',['controller'=> 'Authentication', 'action' => 'login']);
$router->add('logout',['controller'=> 'Authentication', 'action' => 'logout']);

$router->add('loginprompt');
$router->add('failedLogin');
$router->add('basket', ['controller' => 'Basket', 'action' => 'showBasket']);
$router->add('basket/deleteArticle', ['controller' => 'Basket', 'action' => 'deleteArticle']);
$router->add('detailpage/ShowDetail/addToCart', ['controller' => 'Detailpage', 'action' => 'addToCart']);
$router->add('account', ['controller' => 'Account', 'action' => 'showAccount']);
$router->add('deleteAccount',['controller'=> 'Account', 'action' => 'deleteAccount']);
$router->add('changeAddressInformation', ['controller' => 'Account','action'=>'changeAddressInformation']);
$router->add('changeUserInformation', ['controller' => 'Account','action'=>'changeUserInformation']);


//order
$router->add('showOrderAddress', ['controller' => 'Checkout','action'=>'showOrderAddress']);
$router->add('showOrderPayment', ['controller' => 'Checkout','action'=>'showOrderPayment']);
$router->add('showOrderOverview', ['controller' => 'Checkout','action'=>'showOrderOverview']);
$router->add('confirmPaymentMethod', ['controller' => 'Checkout','action'=>'confirmPaymentMethod']);

$router->dispatch($_SERVER['QUERY_STRING']);
