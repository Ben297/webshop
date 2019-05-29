<?php


namespace App\Models;


use Core\Model;

class Cart
{

    public static function InsertIntoBasket($ItemID,$Amount)
    {
        $dbh = Model::getPdo();

        $statement = $dbh->prepare("INSERT INTO webshop.basket (ItemID,Amount) VALUES ($ItemID, $Amount)");
        $statement->execute();
    }
}