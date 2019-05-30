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
        $basketItem = $basket->loadBasketFromTempCookie();
        if ($basketItem==false){
            View::renderTemplate('basket.html');
        }else {
            View::renderTemplate('basket.html', ['BasketItem' => $basketItem]);
        }
    }

        public function deleteArticle()
    {
        Cookie::deleteBasketCookie('TempBasket');
        View::renderTemplate(   'basket.html');
    }



}