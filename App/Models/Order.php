<?php


namespace App\Models;


use Core\Model;
use PDO;

class Order extends Model
{
    /**
     * Creates new Order in DB returns ID of order if Successful otherwise returns false
     * @param $userID
     * @return bool|string
     */
    public function createNewOrder($userID)
    {
        $this->dbh = Model::getPdo();
        $stmt = $this->dbh->prepare('INSERT INTO Orders (UserID,OrderDate,OrderStatus) VALUES (?,CURRENT_TIMESTAMP,2)');
        $stmt->bindParam(1, $userID, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return $this->dbh->lastInsertId();
        } else {
            return false;
        }
    }

    /**
     * @param $orderID
     * @return mixed
     */
    public function getOrderInfo($orderID)
    {
        $this->dbh = Model::getPdo();
        $stmt = $this->dbh->prepare('SELECT * FROM Orders WHERE ID = ?');
        $stmt->bindParam(1, $orderID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    /**
     *
     * @param $totalPrice
     * @param $orderID
     * @return bool
     */
    public function insertTotalPrice($totalPrice, $orderID)
    {
        $this->dbh = Model::getPdo();
        $stmt = $this->dbh->prepare('UPDATE Orders SET TotalPrice = ? WHERE ID = ?');
        $stmt->bindParam(1, $totalPrice, PDO::PARAM_STR);
        $stmt->bindParam(2, $orderID, PDO::PARAM_INT);
        return $stmt->execute();

    }

    public function getOrderDetailsByID($orderID)
    {
        $this->dbh = Model::getPdo();
        $stmt = $this->dbh->prepare('SELECT * FROM Order_Details WHERE OrderID = ?');
        $stmt->bindParam(1, $orderID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function deleteOrderDetailByID($detailID)
    {
        $this->dbh = Model::getPdo();
        $stmt = $this->dbh->prepare('Delete  FROM Order_Details WHERE ID = ?');
        $stmt->bindParam(1, $detailID, PDO::PARAM_INT);
        return $stmt->execute();

    }

    public function insertOrderDetails($orderDetailInfo, $orderID)
    {
        $this->dbh = Model::getPdo();
        $stmt = $this->dbh->prepare('INSERT INTO Order_Details VALUES (NULL,?,?,?,?)');
        $stmt->bindParam(1, $orderID, PDO::PARAM_INT);
        $stmt->bindParam(2, $orderDetailInfo['ID'], PDO::PARAM_INT);
        $stmt->bindParam(3, $orderDetailInfo['Amount'], PDO::PARAM_INT);
        $stmt->bindParam(4, $orderDetailInfo['TotalPrice'], PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function addAddressToOrder($addressID, $orderID)
    {
        $this->dbh = Model::getPdo();
        $stmt = $this->dbh->prepare('UPDATE Orders SET AddressID = ? WHERE ID = ?');
        $stmt->bindParam(1, $addressID, PDO::PARAM_INT);
        $stmt->bindParam(2, $orderID, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function addPaymentMethodToOrder($PaymentID, $orderID)
    {
        $this->dbh = Model::getPdo();
        $stmt = $this->dbh->prepare('UPDATE Orders SET PaymentMethodID = ? WHERE ID = ?');
        $stmt->bindParam(1, $PaymentID, PDO::PARAM_INT);
        $stmt->bindParam(2, $orderID, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function changeOrderStatus($orderStatus, $orderID)
    {
        $this->dbh = Model::getPdo();
        $stmt = $this->dbh->prepare('UPDATE Orders SET OrderStatus = ? WHERE ID = ?');
        $stmt->bindParam(1, $orderStatus, PDO::PARAM_INT);
        $stmt->bindParam(2, $orderID, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getOrderStatus($orderID)
    {
        $this->dbh = Model::getPdo();
        $stmt = $this->dbh->prepare('SELECT OrderStatus FROM Orders WHERE ID = ?');
        $stmt->bindParam(1, $orderID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function getAllOrdersByUserID($userID)
    {
        $this->dbh = Model::getPdo();
        $stmt = $this->dbh->prepare('SELECT * FROM Orders WHERE UserID = ?');
        $stmt->bindParam(1, $userID, PDO::PARAM_INT);
        $stmt->execute();
        $rowCount = $stmt->rowCount();
        $result = $stmt->fetchAll();
        for ($i=0;$i<$rowCount;$i++){
            foreach ($result[$i] as $key => $value)
            if(is_int($key)){
                unset($result[$i][$key]);
            }
        }
        return $result;
    }

    public function getItemAmountByID($orderID)
    {
        $this->dbh = Model::getPdo();
        $stmt = $this->dbh->prepare('SELECT ItemAmount,ItemID FROM Order_Details WHERE OrderID = ?');
        $stmt->bindParam(1, $orderID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();

    }
}