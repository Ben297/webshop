<?php


namespace App\Models;


use Core\Model;

class Payment extends Model
{

    public static function getPaymentMethods(){
        $dbh = Model::getPdo();
        $stmt = $dbh->prepare('Select * FROM PaymentMethod ');
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }
    public static function getPaymentMethodByOrderID($orderID){
        $dbh = Model::getPdo();
        $stmt = $dbh->prepare('Select PaymentMethodID FROM Orders WHERE ID = ?');
        $stmt->bindParam(1,$orderID, \PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result;
    }
}