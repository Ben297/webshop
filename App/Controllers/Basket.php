<?php

namespace App\Controllers;

use App\Models\Item;
use Core\Controller;
use Core\View;
use App\Models\BasketModel;
use App\Models\Cookie;

class Basket extends Controller
{
    private $Basket;

    public function __construct($route_params)
    {
        parent::__construct($route_params);
        $this->Basket = new BasketModel();
    }

    public function showBasket()
    {
        // If BasketCookie is set then get Content of the Cookie
        // If BasketCookie isnt set then redirect to landingpage (special case - only cookie is deleted while
        // user is in basket view
        $totalPrice = 0;
        if (isset($_COOKIE['TempBasket'])) {
            $count = 0;
            foreach ($this->Basket->getAllBasketItems($_COOKIE['TempBasket']) as $Item){
                $Item['Price'] = $Item['Amount']*$Item['Price'];
                $totalPrice += $Item['Price'];
                echo '<pre>';
                print_r($basketItems[$count]= $Item);
                echo '</pre>';
                $count++;
            }

            View::renderTemplate('basket.html', ['BasketItems' => $basketItems,'TotalPrice' => $totalPrice]);
        } else {
            View::renderTemplate('basket.html');
        }
    }

    /**
     * Add Dog to BasketCookie
     * Redirect to Basket
     */
    public function addToBasket()
    {
        $CookieData = ['ItemID'=> $_POST['ItemID'], 'Amount'=> $_POST['Amount'], 'CookieID'=> BasketModel::generateCookieID() ];
        //Cart::InsertIntoBasket($ItemID,$Amount);
        Cookie::saveBasketCookie('TempBasket',$CookieData);
        header('Location: /basket');

    }

    // deletes a specific BasketItem then redirect to Basket
    public function deleteArticle($id)
    {
        BasketModel::deleteBasketItem($id);


        $basketItems = $this->Basket->getAllBasketItems($_COOKIE['TempBasket']);

        if ($basketItems == false) {
            View::renderTemplate('basket.html');
        } else {
            View::renderTemplate('basket.html', ['BasketItems' => $basketItems]);
        }
    }

}