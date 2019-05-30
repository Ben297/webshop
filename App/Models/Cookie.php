<?php


namespace App\Models;


class Cookie
{

    protected $cookieValue;
    public static function saveBasketCookie($value)
    {
        $cookieName = 'TempBasket';
        $cookieValue = $value;
        setcookie($cookieName, json_encode($cookieValue), time() + (86400 * 30), "/");

    }
    public function loadBasketCookie()
    {
        if(!isset($_COOKIE['TempBasket'])) {
         echo 'is nicht da';

        } else {
            //echo "Value is: " . $_COOKIE['TempBasket'];
            print_r( json_decode($_COOKIE['TempBasket']));
            return json_decode($_COOKIE['TempBasket']);
        }
        
    }



}