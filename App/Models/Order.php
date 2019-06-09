<?php


namespace App\Models;




use Core\Model;

class Order extends Model
{
    public function addAddressToOrder($addressID,$orderID)
    {
        $this->dbh = Model::getPdo();
        $stmt = $this->dbh->prepare('UPDATE Orders SET AddressID = ? WHERE ID = ?');
        $stmt->bindParam(1,$addressID,\PDO::PARAM_INT);
        $stmt->bindParam(2,$orderID,\PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function addPaymentMethodToOrder($PaymentID,$orderID)
    {
        $this->dbh = Model::getPdo();
        $stmt = $this->dbh->prepare('UPDATE Orders SET PaymentMethodID = ? WHERE ID = ?');
        $stmt->bindParam(1,$PaymentID,\PDO::PARAM_INT);
        $stmt->bindParam(2,$orderID,\PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getPaymentNameByID()
    {
        
    }

}