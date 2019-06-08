<?php
namespace App\Models;


use Core\Model;


class Item extends \Core\Model {
    public $statement;
    public $dbh;
    /**
     * @return array
     *      */
    public static function getAllItems()
    {
        $dbh = Model::getPdo();

        $statement = $dbh->prepare("SELECT * FROM Item");
        $statement->execute();
        $result = $statement->fetchAll();
        return $result;

    }

    public static function getItemByID($id)
    {
        $dbh = Model::getPdo();
        $statement = $dbh->prepare("SELECT * FROM Item WHERE ID=$id");
        $statement->execute();
        $result = $statement->fetch();
        // removing overhead from array
        for ($i=0;$i<=5;$i++){
            unset($result[$i]);
        }
        print_r("RESULT");
        print_r($result);
        return $result;
    }

    public static function changeStock($id, $value)
    {
        $dbh = Model::getPdo();
        $statement = $dbh->prepare("UPDATE item SET Stock=$value WHERE ID=$id");
        $statement->execute();
        $result = $statement->fetch();
        return $result;
    }
}


/*
 * $this->dbh= Model::getPdo();
        $stmt =  $this->dbh->prepare('INSERT INTO Address VALUES (NULL,?,?,?,?,?,?)');
        $stmt->bindParam(1, $userID,\PDO::PARAM_INT);
        $stmt->bindParam(2, $address['streetname'],\PDO::PARAM_STR);
        $stmt->bindParam(3, $address['streetnr'],\PDO::PARAM_INT);
        $stmt->bindParam(4, $address['zip'],\PDO::PARAM_INT);
        $stmt->bindParam(5, $address['city'],\PDO::PARAM_STR);
        $stmt->bindParam(6, $address['country'],\PDO::PARAM_STR);
        return $stmt->execute();
 */