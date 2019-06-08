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

        print_r("FUNCTION: showBasket                \n");
        print_r("BasketItem: " . $basketItem);


        if ($basketItem==false){
            print_r("false");
            View::renderTemplate('basket.html');
        }else {
            print_r("true");
            View::renderTemplate('basket.html', ['BasketItem' => $basketItem]);
        }
    }

        public function deleteArticle()
    {
        Cookie::deleteBasketCookie('TempBasket');
        View::renderTemplate(   'basket.html');
    }



}