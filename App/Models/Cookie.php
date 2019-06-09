<?php


namespace App\Models;


use Core\Model;

class Cookie extends Model
{

    protected $cookieValue;

    public static function saveBasketCookie($cookieName, $cookieValue)
    {


        print_r("FUNCTION saveBasketCookie");
        print_r($cookieValue);
        Cart::InsertIntoBasket($cookieValue['ItemID'], $cookieValue['Amount'], $cookieValue['CookieID']);
        setcookie($cookieName, json_encode($cookieValue['CookieID']), time() + (86400 * 30), "/");
    }

    public static function deleteBasketCookie($cookieName)
    {
        setcookie($cookieName, NULL, -1, '/');
    }

    public function loadBasketCookie()
    {
        print_r("FUNCTION loadBasketCookie   ");
        if(!isset($_COOKIE['TempBasket'])) {
         return false;

        } else {
            //echo "Value is: " . $_COOKIE['TempBasket'];
            print_r( json_decode($_COOKIE['TempBasket']));
            return json_decode($_COOKIE['TempBasket']);
        }

    }
}
