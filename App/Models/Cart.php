<?php


namespace App\Models;


use App\Models\Item;
use Core\Model;

use App\Models\Cookie;
use function PHPSTORM_META\type;

class Cart extends Model
{
    public function loadBasketFromTempCookie()
    {
        $Cookie = new Cookie();
        if ($tempCookie = $Cookie->loadBasketCookie()) {
            return $tempCookie;
        } else {
            return false;
        }

    }

    public static function InsertIntoBasket($ItemID, $Amount, $CookieID)
    {
        $dbh = Model::getPdo();

        $statement = $dbh->prepare("INSERT INTO webshop.basket (ItemID,Amount,Cookie) VALUES ($ItemID, $Amount, $CookieID)");
        $statement->execute();
    }

    public static function generateCookieID()
    {
        $Cookie = new Cookie();
        $tempCookie = $Cookie->loadBasketCookie();


        print_r("||||||||");
        print_r($tempCookie);
        print_r("||||||||");

        if (!$tempCookie = $Cookie->loadBasketCookie()) {
            return bin2hex(random_bytes(16));
        } else {
            return $tempCookie;
        }
    }
}