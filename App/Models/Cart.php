<?php


namespace App\Models;


use App\Models\Item;
use Core\Model;

use App\Models\Cookie;
use function PHPSTORM_META\type;

class Cart
{
    public function loadBasketFromTempCookie(){
        $Cookie = new Cookie();

        //Wenn kein Inhalt im Cookie steht schreibe den Inhalt hinein
        if($tempCookie = $Cookie->loadBasketCookie()){
            $basketItem = Item::getItemByID($tempCookie->ItemID);
            $basketItem['Amount']=$tempCookie->Amount;
            return $basketItem;

        }else{
            return false;
        }
    }

    public static function InsertIntoBasket($ItemID,$Amount)
    {
        $dbh = Model::getPdo();

        $statement = $dbh->prepare("INSERT INTO webshop.basket (ItemID,Amount) VALUES ($ItemID, $Amount)");
        $statement->execute();
    }
}