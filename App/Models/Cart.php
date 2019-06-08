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
            $basketItem['CookieID'] = $tempCookie->CookieID;
            $basketItem = Item::getItemByID($tempCookie->ItemID);
            $basketItem['Amount'] = $tempCookie->Amount;
            return $basketItem;
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

        print_r($tempCookie);

        if ($tempCookie = $Cookie->loadBasketCookie()) {
            if (empty($basketItem['CookieID'] = $tempCookie->CookieID)) {
                return bin2hex(random_bytes(16));
            } else {
                return $tempCookie->CookieID;
            }
        } else {
            return bin2hex(random_bytes(16));
        }
    }
}