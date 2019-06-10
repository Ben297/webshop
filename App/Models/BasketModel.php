<?php


namespace App\Models;


use Core\Model;
use PDO;

class BasketModel extends Model
{

    // Loads the content out of the Basket, returns "false" in case of no basket
    public static function InsertIntoBasket($ItemID, $Amount, $CookieID)
    {
        $dbh = Model::getPdo();

        $stmt = $dbh->prepare("SELECT Amount FROM Basket WHERE ItemID= ? AND Cookie= ?");
        $stmt->bindParam(1, $ItemID, PDO::PARAM_INT);
        $stmt->bindParam(2, $CookieID, PDO::PARAM_STR);
        $stmt->execute();

        // if the is already in the basket then update the amount
        if ($stmt->rowCount()) {
            $result = $stmt->fetch();

            $Amount += $result['Amount'];

            $stmt = $dbh->prepare("UPDATE Basket SET Amount = ? WHERE ItemID= ? AND Cookie= ?");
            $stmt->bindParam(1, $Amount, PDO::PARAM_INT);
            $stmt->bindParam(2, $ItemID, PDO::PARAM_INT);
            $stmt->bindParam(3, $CookieID, PDO::PARAM_STR);
            $stmt->execute();

            // if the product isnt already in the basket then create a new record
        } else {

            $stmt = $dbh->prepare('INSERT INTO Basket (ID,ItemID,Amount,Cookie) VALUES (NULL,?, ?, ?)');
            $stmt->bindParam(1, $ItemID, PDO::PARAM_INT);
            $stmt->bindParam(2, $Amount, PDO::PARAM_INT);
            $stmt->bindParam(3, $CookieID, PDO::PARAM_STR);
            $stmt->execute();
        }
    }

    // writes ProductID, Amount and CookieID in the database

    public static function generateCookieID()
    {
        $Cookie = new Cookie();

        if (!$tempCookie = $Cookie->loadBasketCookie()) {
            return bin2hex(random_bytes(16));
        } else {
            return $tempCookie;
        }
    }

    // Generates a random 16 lenght string as CookieID

    public static function getAllBasketItems($CookieID)
    {
        $dbh = Model::getPdo();
        $stmt = $dbh->prepare('SELECT Item.*, Basket.Cookie, Basket.Amount FROM Item LEFT JOIN Basket ON Item.ID = Basket.ItemID WHERE Cookie = ?');
        $stmt->bindParam(1, $CookieID, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    // Left join between basket table and item (product) table
    // returns Product, Availability, Quantity Price from Table Item aswell as the CookieID and the Amount from Table Basket
    // joins them to a tuple

    public static function deleteBasketItem($id)
    {
        $dbh = Model::getPdo();
        $stmt = $dbh->prepare("DELETE FROM basket WHERE ItemID= ? ");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    // deletes a specific BasketItem

    public function loadBasketFromTempCookie()
    {
        $Cookie = new Cookie();
        if ($tempCookie = $Cookie->loadBasketCookie()) {
            return $tempCookie;
        } else {
            return false;
        }
    }
}
