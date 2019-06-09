<?php


namespace App\Models;




use Core\Model;

class Order extends Model
{
    public function createNewOrder($orderInfo)
    {
        $this->dbh = Model::getPdo();
        $stmt = $this->dbh->prepare('INSERT INTO Orders (UserID,TotalPrice,OrderDate,OrderStatus) VALUES (?,?,CURRENT_TIMESTAMP,2)');
        $stmt->bindParam(1,$orderInfo['UserID'],\PDO::PARAM_INT);
        $stmt->bindParam(2,$orderInfo['TotalPrice'],\PDO::PARAM_STR);
        if($stmt->execute()){
            return $this->dbh->lastInsertId();
        }else{
            return false;
        }
    }

    public function insertOrderDetails($orderDetailInfo,$orderID)
    {
        $this->dbh = Model::getPdo();
        $stmt = $this->dbh->prepare('INSERT INTO Order_Details VALUES (NULL,?,?,?,?)');
        $stmt->bindParam(1,$orderID,\PDO::PARAM_INT);
        $stmt->bindParam(2,$orderDetailInfo['ItemID'],\PDO::PARAM_INT);
        $stmt->bindParam(3,$orderDetailInfo['Amount'],\PDO::PARAM_INT);
        $stmt->bindParam(4,$orderDetailInfo['TotalPrice'],\PDO::PARAM_STR);
        return $stmt->execute();
    }

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