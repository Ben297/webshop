<?php


namespace App\Models;

use Core\Model;

class Payment extends Model
{
    /**
     * get all Payment Methods from the DB
     * @return array
     */
    public static function getPaymentMethods(){
        $dbh = Model::getPdo();
        $stmt = $dbh->prepare('Select * FROM PaymentMethod ');
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    /**
     * get current PaymentMethod for an Order
     * @param $orderID
     * @return mixed
     */
    public static function getPaymentMethodByOrderID($orderID){
        $dbh = Model::getPdo();
        $stmt = $dbh->prepare('Select PaymentMethodID FROM Orders WHERE ID = ?');
        $stmt->bindParam(1,$orderID, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result;
    }
}