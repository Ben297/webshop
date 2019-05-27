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
        return $result;
    }
}