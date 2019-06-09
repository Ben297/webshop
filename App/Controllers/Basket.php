<?php

namespace App\Controllers;

use App\Models\Item;
use Core\Controller;
use Core\View;
use App\Models\Cart;
use App\Models\Cookie;

class Basket extends Controller
{

    public function showBasket()
    {

        $basket = new Cart();

        // If BasketCookie is set then get Content of the Cookie
        // If BasketCookie isnt set then redirect to landingpage (special case - only cookie is deleted while
        // user is in basket view

        if (isset($_COOKIE['TempBasket'])) {
            $basketItems = $basket->getAllBasketItems($_COOKIE['TempBasket']);
        } else {
            $this->items = Item::getAllItems();
            View::renderTemplate('landingpage.html', ['Items' => $this->items]);
        }

        // If Basket empty then render basket view without basketItems, if it isnt empty then render with basket items
        if ($basketItems == false) {
            View::renderTemplate('basket.html');
        } else {
            View::renderTemplate('basket.html', ['BasketItems' => $basketItems]);
        }
    }

    // deletes a specific BasketItem then redirect to Basket
    public function deleteArticle($id)
    {
        Cart::deleteBasketItem($id);

        $basket = new Cart();
        $basketItems = $basket->getAllBasketItems($_COOKIE['TempBasket']);

        if ($basketItems == false) {
            View::renderTemplate('basket.html');
        } else {
            View::renderTemplate('basket.html', ['BasketItems' => $basketItems]);
        }
    }

}