<?php


namespace App\Controllers;


use App\Models\Item;
use Core\Controller;
use Core\View;
use App\Models\Cart;
use App\Models\Cookie;

class Detailpage extends Controller
{
    protected $route_params = null;
    protected $item;

    public function showDetail()
    {
        $this->item = Item::getItemByID($this->route_params['id']);
        View::renderTemplate('detailpage.html', ["Item" => $this->item]);
    }

    public function addToCart()
    {

        if (Cookie::loadBasketCookie());
        {
            $cartArray = [Cookie::loadBasketCookie()];
        }
        $CookieData = ['ItemID' => $_POST['ItemID'], 'Amount' => $_POST['Amount']];
        $mergeArray = array_merge($cartArray, $CookieData);
        print_r("CART ARRAY: \n");
        foreach ($mergeArray as $field)
            if ($field)
            print_r($field);

        Cookie::saveBasketCookie('TempBasket', $mergeArray);
        $this->items = Item::getAllItems();
        View::renderTemplate('landingpage.html', ['Items' => $this->items]);

    }

    public function setCookie()
    {
        $value = 'something from somewhere';
        setcookie("TestCookie", $value);
        echo 'Cookie Set';
        print_r($_COOKIE['TestCookie']);
        View::renderTemplate('detailpage.html');
    }
}


