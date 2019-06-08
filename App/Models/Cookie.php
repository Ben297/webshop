<?php


namespace App\Models;


class Cookie
{

    protected $cookieValue;

    public static function saveBasketCookie($cookieName, $cookieValue)
    {
        setcookie($cookieName, json_encode($cookieValue), time() + (86400 * 30), "/");
    }

    public static function deleteBasketCookie($cookieName)
    {
        setcookie($cookieName, NULL, -1, '/');
    }

    public static function loadBasketCookie()
    {
        if (!isset($_COOKIE['TempBasket'])) {
            return false;

        } else {
            return json_decode($_COOKIE['TempBasket']);
        }

    }


}