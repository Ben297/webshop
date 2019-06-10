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
        $basketItems = array();

        if (isset($_COOKIE['TempBasket'])) {
            $count = 0;
            foreach ($this->Basket->getAllBasketItems($_COOKIE['TempBasket']) as $Item) {
                $Item['Price'] = $Item['Amount'] * $Item['Price'];
                $totalPrice += $Item['Price'];
                $basketItems[$count] = $Item;
                $count++;
            }
            if ($basketItems == 0) {
                View::renderTemplate('basket.html');
            } else {
                View::renderTemplate('basket.html', ['BasketItems' => $basketItems, 'TotalPrice' => $totalPrice]);
            }
        }
    }

    /**
     * Add Dog to BasketCookie
     * Redirect to Basket
     */
    public function addToBasket()
    {
        $CookieData = ['ItemID' => $_POST['ItemID'], 'Amount' => $_POST['Amount'], 'CookieID' => BasketModel::generateCookieID()];
        //Cart::InsertIntoBasket($ItemID,$Amount);
        Cookie::saveBasketCookie('TempBasket', $CookieData);
        header('Location: /basket');

    }

    // deletes a specific BasketItem then redirect to Basket
    public function deleteArticle()
    {

        BasketModel::deleteBasketItem($_REQUEST['productId']);
        self::showBasket();
    }

    // updates the amount
    public function updateArticle()
    {
        $Item = new Item();

        //validate content
        $productAmount = trim($_REQUEST['productAmount']);

        //sanitize content
        $productAmount = strip_tags($productAmount);

        //
        $productAmount = htmlspecialchars($productAmount);


        $stock = $Item->getItemByID($_REQUEST['productId']);



        if ($productAmount > $stock['Stock']) {

            //Auslagern in die View? Oder so in Ordnung?


            echo "<div class='alert alert-danger alert-dismissible fade show'><strong>Out of Stock!</strong>
            <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button></div>";

            self::showBasket();
        } else {
            BasketModel::updateBasketItem($_REQUEST['productId'], $_REQUEST['productAmount']);

            echo "<div class='alert alert-success alert-dismissible fade show'><strong>Added to shopping cart!</strong>
            <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button></div>";

            self::showBasket();
        }




    }
}