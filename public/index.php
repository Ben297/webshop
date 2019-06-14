<?php
session_start([
    'name' => "session",
    'cookie_secure' => false,
    'cookie_httponly' => true,
    'cookie_lifetime' => 0,
    'sid_length' => 192,
    'sid_bits_per_character' => 6,
]);


if (empty($_SESSION['csrf_token'])) {
    $crypto_strong = true;
    $_SESSION['csrf_token'] = md5(openssl_random_pseudo_bytes(32,$crypto_strong));
}

// Block all iframes and other frames
// See: https://www.owasp.org/index.php/OWASP_Secure_Headers_Project#xcto
header('X-Frame-Options: sameorigin');
header('X-XSS-Protection: 1');
header('Content-Security-Policy: script-src: \'self\'');

// Set a csp policy to block restrict everything to default src and completely block all js from being executed.
// Reports violations to report-uri service.
//header("Content-Security-Policy: default-src 'self' ; script-src 'none' ; report-uri https://1a58aa2f218b3abc3e2b4c5161d1bfc7.report-uri.com/r/d/csp/enforce ;");

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
$router->add('basket/updateArticle', ['controller' => 'Basket', 'action' => 'updateArticle']);
$router->add('addToBasket', ['controller' => 'Basket', 'action' => 'addToBasket']);
$router->add('account', ['controller' => 'Account', 'action' => 'showAccount']);
$router->add('deleteAccount',['controller'=> 'Account', 'action' => 'deleteAccount']);
$router->add('changeAddressInformation', ['controller' => 'Account','action'=>'changeAddressInformation']);
$router->add('changeUserInformation', ['controller' => 'Account','action'=>'changeUserInformation']);
$router->add('404', ['controller' => 'Authentication','action'=>'show404']);
//order
$router->add('showOrderAddress', ['controller' => 'Checkout','action'=>'showOrderAddress']);
$router->add('showOrderPayment', ['controller' => 'Checkout','action'=>'showOrderPayment']);
$router->add('showOrderOverview', ['controller' => 'Checkout','action'=>'showOrderOverview']);
$router->add('showOrderConfirm', ['controller' => 'Checkout','action'=>'showOrderConfirm']);
$router->add('confirmPaymentMethod', ['controller' => 'Checkout','action'=>'confirmPaymentMethod']);
$router->add('showSessionexpired',['controller' => 'Authentication','action'=>'showSessionexpired']);

$router->dispatch($_SERVER['QUERY_STRING']);
