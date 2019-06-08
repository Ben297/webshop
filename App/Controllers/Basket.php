<?php

namespace App\Controllers;

use Core\Controller;
use Core\View;
use App\Models\Cart;
use App\Models\Cookie;

class Basket extends Controller
{

    public function showBasket()
    {

        $basket = new Cart();
        $basketData = array();
        array_push($basketData, $basket->loadBasketFromTempCookie());

        print_r($basketData);

        View::renderTemplate('basket.html', ['BasketItem' => $basketData]);
    }

    public function deleteArticle()
    {
        Cookie::deleteBasketCookie('TempBasket');
        View::renderTemplate('basket.html');
    }


}