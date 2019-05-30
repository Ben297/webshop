<?php

namespace App\Controllers;
use Core\Controller;
use Core\View;
use App\Models\Cart;
use App\Models\Cookie;

class Basket extends Controller{

    public function ShowBasket()
    {

        $basket = new Cart();
        $basketItem = $basket->loadBasketFromTempCookie();

        View::renderTemplate('basket.html',['BasketItem'=> $basketItem]);
    }



}