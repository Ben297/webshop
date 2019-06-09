<?php


namespace App\Models;


use Core\Model;

class Cookie extends Model
{

    protected $cookieValue;

    // Schreibt ProduktID sowie Amount in die Datenbank, legt einen neuen Cookie mit der CookieID an
    public static function saveBasketCookie($cookieName, $cookieValue)
    {


        print_r("FUNCTION saveBasketCookie");
        print_r($cookieValue);
        Cart::InsertIntoBasket($cookieValue['ItemID'], $cookieValue['Amount'], $cookieValue['CookieID']);
        setcookie($cookieName, $cookieValue['CookieID'], time() + (86400 * 30), "/");
    }

    // Löscht den BasketCookie
    public static function deleteBasketCookie($cookieName)
    {
        setcookie($cookieName, NULL, -1, '/');
    }

    // Gibt false zurück wenn kein "TempBasket" Cookie gesetzt - sonst den Inhalt des Cookies
    public function loadBasketCookie()
    {
        print_r("FUNCTION loadBasketCookie   ");
        if(!isset($_COOKIE['TempBasket'])) {
         return false;

        } else {
            return $_COOKIE['TempBasket'];
        }

    }
}
