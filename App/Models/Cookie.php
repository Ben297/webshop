<?php
namespace App\Models;
use Core\Model;

class Cookie extends Model
{
    protected $cookieValue;

    /**
     * Insert Data into Cookie
     * @param $cookieName
     * @param $cookieValue
     */
    public static function saveBasketCookie($cookieName, $cookieValue)
    {
        BasketModel::InsertIntoBasket($cookieValue['ItemID'], $cookieValue['Amount'], $cookieValue['CookieID']);
        setcookie($cookieName, $cookieValue['CookieID'], time() + (86400 * 30), "/");
    }

    /**
     * Deletes the Cookie
     * @param $cookieName
     */
    public function deleteBasketCookie($cookieName)
    {
        setcookie($cookieName, NULL, -1, '/');
    }

    /**
     * Checks if Cookie is set
     * @return bool|mixed
     */
    public function loadBasketCookie()
    {
        if(!isset($_COOKIE['TempBasket'])) {
         return false;
        } else {
            return $_COOKIE['TempBasket'];
        }
    }
}
