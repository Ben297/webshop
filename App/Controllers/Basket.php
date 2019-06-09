<?php

namespace App\Controllers;
use Core\Controller;
use Core\View;
use App\Models\Cart;
use App\Models\Cookie;

class Basket extends Controller{

    public function showBasket()
    {

        $basket = new Cart();
        $basketItems = $basket->getAllBasketItems($_COOKIE['TempBasket']);

        if ($basketItems==false){
            print_r("false");
            View::renderTemplate('basket.html');
        }else {
            print_r("true");
            View::renderTemplate('basket.html', ['BasketItems' => $basketItems]);
        }
    }

        public function deleteArticle()
    {
        Cookie::deleteBasketCookie('TempBasket');
        View::renderTemplate(   'basket.html');
    }

}