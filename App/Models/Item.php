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

        $statement = $dbh->prepare("SELECT * FROM item");
        $statement->execute();

          $result = $statement->fetchAll();
        return $result;

    }

    public static function getItemByID($id){
        $dbh = Model::getPdo();
        $statement = $dbh->prepare("SELECT * FROM item Where ID=$id");
        $statement->execute();
        $result = $statement->fetchAll();
        return $result;
    }
}