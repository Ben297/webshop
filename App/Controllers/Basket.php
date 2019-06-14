<?php

namespace App\Controllers;

use App\Models\Item;
use Core\Controller;
use Core\Helper;
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
        $basketItems = [];

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
        }else{
            View::renderTemplate('basket.html');
        }
    }

    /**
     * Add Dog to BasketCookie
     * Redirect to Basket
     */
    public function addToBasket()
    {
        if (Helper::checkCSRF()) {
            $CookieData = ['ItemID' => $_POST['ItemID'], 'Amount' => $_POST['Amount'], 'CookieID' => BasketModel::generateCookieID()];
            //Cart::InsertIntoBasket($ItemID,$Amount);
            Cookie::saveBasketCookie('TempBasket', $CookieData);
            header('Location: /basket');
        }else
            throw new \Error('Invalid CRSF-Token');

    }

    // deletes a specific BasketItem then redirect to Basket
    public function deleteArticle()
    {
        if (Helper::checkCSRF()){
            BasketModel::deleteBasketItem($_REQUEST['productId']);
            self::showBasket();
        }else
        throw new \Error('Invalid CRSF-Token');

    }

    // updates the amount
    public function updateArticle()
    {
        if (Helper::checkCSRF()) {
            $Item = new Item();

            //validate content
            $productAmount = trim($_REQUEST['productAmount']);
            $productId = trim($_REQUEST['productId']);

            //sanitize content
            $productAmount = strip_tags($productAmount);
            $productId = strip_tags($productId);
            //
            $productAmount = htmlspecialchars($productAmount);
            $productId = htmlspecialchars($productId);

            $stock = $Item->getItemByID($productId);

            if ($productAmount > $stock['Stock']) {

                echo "<div class='alert alert-danger alert-dismissible fade show'><strong>Out of Stock!</strong>
            <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button></div>";

                self::showBasket();
            } else {
                BasketModel::updateBasketItem($_REQUEST['productId'], $_REQUEST['productAmount']);

                echo "<div class='alert alert-success alert-dismissible fade show'><strong>Added to shopping cart!</strong>
            <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button></div>";

                self::showBasket();
            }
        }else{
            throw new \Error('Invalid CRSF-Token');
        }
    }
}