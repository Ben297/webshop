<?php


namespace App\Models;


use App\Models\Item;
use Core\Model;

use App\Models\Cookie;
use function PHPSTORM_META\type;

class Cart extends Model
{

    // Lädt den Inhalt des Warenkorbes, falls vorhanden - "False" wenn kein Warenkorb vorhanden
    public function loadBasketFromTempCookie()
    {
        $Cookie = new Cookie();
        if ($tempCookie = $Cookie->loadBasketCookie()) {
            return $tempCookie;
        } else {
            return false;
        }

    }

    // Schreibt die ProduktID, Menge und die CookieID (Warenkorb) in die Datenbank
    public static function InsertIntoBasket($ItemID, $Amount, $CookieID)
    {
        print_r("INSERTINTO BASKET - ".$CookieID);

        $dbh = Model::getPdo();
        $stmt = $dbh->prepare('INSERT INTO Basket (ID,ItemID,Amount,Cookie) VALUES (NULL,?, ?, ?)');
        $stmt->bindParam(1, $ItemID, \PDO::PARAM_INT);
        $stmt->bindParam(2, $Amount, \PDO::PARAM_INT);
        $stmt->bindParam(3, $CookieID, \PDO::PARAM_STR);
        $stmt->execute();
    }

    // Generiert zufällige Zahlenfolge als CookieID
    public static function generateCookieID()
    {
        $Cookie = new Cookie();

        if (!$tempCookie = $Cookie->loadBasketCookie()) {
            return bin2hex(random_bytes(16));
        } else {
            return $tempCookie;
        }
    }

    // Gibt alle Werte der betreffenden CookieID (Warenkorb) aus
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

    // Löscht ein spezifisches Item aus dem Warenkorb
    public static function deleteBasketItem($id)
    {
        $dbh = Model::getPdo();
        $stmt = $dbh->prepare("DELETE FROM basket WHERE ItemID=$id");
        $stmt->execute();
    }
}
