<?php


namespace App\Models;


use App\Models\Item;
use Core\Model;

use App\Models\Cookie;
use function PHPSTORM_META\type;

class Cart extends Model
{

    // Loads the content out of the Basket, returns "false" in case of no basket
    public function loadBasketFromTempCookie()
    {
        $Cookie = new Cookie();
        if ($tempCookie = $Cookie->loadBasketCookie()) {
            return $tempCookie;
        } else {
            return false;
        }

    }

    // writes ProductID, Amount and CookieID in the database
    public static function InsertIntoBasket($ItemID, $Amount, $CookieID)
    {
        print_r("INSERTINTO BASKET - " . $CookieID);

        $dbh = Model::getPdo();

        print_r("SELECT STATEMENT -> ");
        print_r($CookieID);
        $stmt = $dbh->prepare("SELECT Amount FROM Basket WHERE ItemID= ? AND Cookie= ?");
        $stmt->bindParam(1, $ItemID, \PDO::PARAM_INT);
        $stmt->bindParam(2, $CookieID, \PDO::PARAM_STR);
        $stmt->execute();

        if($stmt->rowCount()) {
            print_r("->TRUE<-");
            $result = $stmt->fetch();

            print_r("UPDATE STATEMENT -> ");
            $Amount += $result['Amount'];
            print_r($Amount);

            $stmt = $dbh->prepare("UPDATE Basket SET Amount = ? WHERE ItemID= ? AND Cookie= ?" );
            $stmt->bindParam(1, $Amount, \PDO::PARAM_INT);
            $stmt->bindParam(2, $ItemID, \PDO::PARAM_INT);
            $stmt->bindParam(3, $CookieID, \PDO::PARAM_STR);
            $stmt->execute();


        } else {
            print_r("->FALSE<-");
            print_r($stmt->fetch());
            print_r("INSERT STATEMENT ->");
            $stmt = $dbh->prepare('INSERT INTO Basket (ID,ItemID,Amount,Cookie) VALUES (NULL,?, ?, ?)');
            $stmt->bindParam(1, $ItemID, \PDO::PARAM_INT);
            $stmt->bindParam(2, $Amount, \PDO::PARAM_INT);
            $stmt->bindParam(3, $CookieID, \PDO::PARAM_STR);
            $stmt->execute();
        }
        /*
        print_r("INSERT STATEMENT");
        $stmt = $dbh->prepare('INSERT INTO Basket (ID,ItemID,Amount,Cookie) VALUES (NULL,?, ?, ?)');
        $stmt->bindParam(1, $ItemID, \PDO::PARAM_INT);
        $stmt->bindParam(2, $Amount, \PDO::PARAM_INT);
        $stmt->bindParam(3, $CookieID, \PDO::PARAM_STR);
        $stmt->execute();
        */
    }

    // Generates a random 16 lenght string as CookieID
    public static function generateCookieID()
    {
        $Cookie = new Cookie();

        if (!$tempCookie = $Cookie->loadBasketCookie()) {
            return bin2hex(random_bytes(16));
        } else {
            return $tempCookie;
        }
    }

    // Left join between basket table and item (product) table
    // returns Product, Availability, Quantity Price from Table Item aswell as the CookieID and the Amount from Table Basket
    // joins them to a tuple
    public static function getAllBasketItems($CookieID)
    {
        $dbh = Model::getPdo();
        print_r($CookieID);
        $stmt = $dbh->prepare('SELECT Item.*, Basket.Cookie, Basket.Amount FROM Item LEFT JOIN Basket ON Item.ID = Basket.ItemID WHERE Cookie = ?');
        $stmt->bindParam(1, $CookieID, \PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll();
        print_r($result);
        return $result;
    }

    // deletes a specific BasketItem
    public static function deleteBasketItem($id)
    {
        $dbh = Model::getPdo();
        $stmt = $dbh->prepare("DELETE FROM basket WHERE ItemID= ? ");
        $stmt->bindParam(1, $id, \PDO::PARAM_INT);
        $stmt->execute();
    }
}
