<?php
namespace App\Models;


use Core\Model;


class Item extends Model {
    public $statement;
    public $dbh;

    /**
     * Get All Items from the DB to display on the landingpage
     * @return array
     **/
    public function getAllItems()
    {
        $this->dbh = Model::getPdo();
        $statement = $this->dbh->prepare("SELECT * FROM Item");
        $statement->execute();
        $result = $statement->fetchAll();
        return $result;

    }

    /**
     * Get one specific Item via its ID from the DB
     * @param $itemID
     * @return mixed
     */
    public function getItemByID($itemID)
    {
        $this->dbh = Model::getPdo();
        $stmt = $this->dbh->prepare("SELECT * FROM Item WHERE ID=?");
        $stmt->bindParam(1,$itemID,\PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();
        // removing overhead from array
        for ($i=0;$i<=5;$i++){
            unset($result[$i]);
        }
        return $result;
    }

    /**
     * Get Stock of specific Item via its ID from the DB
     * @param $itemID
     * @return mixed
     */
    public function getStock($itemID)
    {
        $this->dbh = Model::getPdo();
        $stmt =  $this->dbh->prepare('SELECT Stock FROM  Item  WHERE ID = ?');
        $stmt->bindParam(1,$itemID,\PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    /**
     * Reduce Stock in DB after completeion of Order
     * @param $deduction
     * @param $itemID
     * @return bool
     */
    public function reduceStock($deduction,$itemID)
    {
        $this->dbh = Model::getPdo();
        $stmt =  $this->dbh->prepare('UPDATE Item SET Stock = Stock - ? WHERE ID = ?');
        $stmt->bindParam(1,$deduction,\PDO::PARAM_INT);
        $stmt->bindParam(2,$itemID,\PDO::PARAM_INT);
        return $stmt->execute();
    }
}