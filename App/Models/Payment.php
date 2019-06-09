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
}