<?php

namespace App\Controllers;
use Core\Controller;
use Core\View;

class Cart extends Controller{

    public function ShowCart()
    {
        print_r( $_COOKIE['TestCookie']);
        View::renderTemplate('cart.html');
    }



}