<?php


namespace App\Models;


use Core\Model;
use PDO;

class BasketModel extends Model
{

    /**
     * Inserts the CookieID into Database and updates data
     * @param $ItemID
     * @param $Amount
     * @param $CookieID
     */
    public static function InsertIntoBasket($ItemID, $Amount, $CookieID)
    {
        $dbh = Model::getPdo();

        $stmt = $dbh->prepare("SELECT Amount FROM Basket WHERE ItemID= ? AND Cookie= ?");
        $stmt->bindParam(1, $ItemID, PDO::PARAM_INT);
        $stmt->bindParam(2, $CookieID, PDO::PARAM_STR);
        $stmt->execute();

        // if the product is already in the basket then update the amount
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

    /**
     * generates CookieID
     * @return bool|mixed|string
     */
    public static function generateCookieID()
    {
        $Cookie = new Cookie();

        if (!$tempCookie = $Cookie->loadBasketCookie()) {
            $strongCrypto = TRUE;
            return md5(openssl_random_pseudo_bytes(32,$strongCrypto));
        } else {
            return $tempCookie;
        }
    }

    // Left join between basket table and item (product) table
    // returns Product, Availability, Quantity Price from Table Item as well as the CookieID and the Amount from Table Basket
    // joins them to a tuple
    public static function getAllBasketItems($CookieID)
    {
        $dbh = Model::getPdo();
        $stmt = $dbh->prepare('SELECT Item.*, Basket.Cookie, Basket.Amount FROM Item LEFT JOIN Basket ON Item.ID = Basket.ItemID WHERE Cookie = ?');
        $stmt->bindParam(1, $CookieID, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    /**
     * Checks if Cookie is set and returns the ID
     * @return mixed|null
     */
    public static function getBasketCookieId()
    {
        if (isset($_COOKIE['TempBasket'])) {
            return $_COOKIE['TempBasket'];
        } else {
            return null;
        }
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

    // updates the amount of the item within the basket
    public static function updateBasketItem($ItemID, $Amount)
    {
        $dbh = Model::getPdo();
        $CookieID = self::getBasketCookieId();

        $stmt = $dbh->prepare("UPDATE Basket SET Amount = ? WHERE ItemID= ? AND Cookie= ?");
        $stmt->bindParam(1, $Amount, PDO::PARAM_INT);
        $stmt->bindParam(2, $ItemID, PDO::PARAM_INT);
        $stmt->bindParam(3, $CookieID, PDO::PARAM_STR);
        $stmt->execute();
    }

    public static function deleteBasketItem($id)
    {
        $dbh = Model::getPdo();
        $CookieID = self::getBasketCookieId();

        $stmt = $dbh->prepare("DELETE FROM Basket WHERE ItemID= ? AND Cookie= ?");
        $stmt->bindParam(1, $id, PDO::PARAM_INT);
        $stmt->bindParam(2, $CookieID, PDO::PARAM_STR);
        $stmt->execute();
    }
}
