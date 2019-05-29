<?php


namespace App\Controllers;


use App\Models\Item;
use Core\Controller;
use Core\View;
use App\Models\Cart;

class Detailpage extends Controller
{
    protected  $route_params = null;
    protected $item ;
    public function ShowDetail()
    {
        $this->item = Item::getItemByID($this->route_params['id']);
        View::renderTemplate('detailpage.html',["Item" => $this->item]);
    }

    public function addToCart()
    {
        $ItemID = $_POST['ItemID'];
        $Amount = $_POST['Amount'];
        Cart::InsertIntoBasket($ItemID,$Amount);
        View::renderTemplate('basket.html',["Basket"=>[$ItemID,$Amount]]);
    }
    public function setCookie()
    {
        $value = 'something from somewhere';
        setcookie("TestCookie", $value);
        echo 'Cookie Set';
        print_r( $_COOKIE['TestCookie']);
        View::renderTemplate('detailpage.html');
    }
}