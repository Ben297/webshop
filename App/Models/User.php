<?php


namespace App\Models;


use Core\Model;

class User extends Model
{
    /**
     * @param $user
     * @return string
     * function to insert the user into the Database
     * return UserID or Error
     */
    public function insertUser($user)
    {
        //print_r( $user);
        $this->dbh= Model::getPdo();
        $stmt =  $this->dbh->prepare('INSERT INTO User VALUES (NULL,?,?,?,?,0)');
        $stmt->bindParam(1, $user['email'],\PDO::PARAM_STR);
        $stmt->bindParam(2, $user['password']);
        $stmt->bindParam(3, $user['firstname'],\PDO::PARAM_STR);
        $stmt->bindParam(4, $user['lastname'],\PDO::PARAM_STR);
        if($stmt->execute()){
             return $this->dbh->lastInsertId();
         }else{
             echo 'User could not be inserted';
         }


    }

    public function insertNewPassword($password,$UserID)
    {
        $this->dbh= Model::getPdo();
        $stmt =  $this->dbh->prepare('Update User Set Password = ? Where ID = ?');
        $stmt->bindParam(1, $password,\PDO::PARAM_STR);
        $stmt->bindParam(2, $UserID);

        echo $stmt->execute();

    }

    public function insertAddress($address,$userID)
    {
        //print_r( $address);
        $this->dbh= Model::getPdo();
        $stmt =  $this->dbh->prepare('INSERT INTO Address VALUES (NULL,?,?,?,?,?,?)');
        $stmt->bindParam(1, $userID,\PDO::PARAM_INT);
        $stmt->bindParam(2, $address['streetname'],\PDO::PARAM_STR);
        $stmt->bindParam(3, $address['houseNr'],\PDO::PARAM_INT);
        $stmt->bindParam(4, $address['zipCode'],\PDO::PARAM_INT);
        $stmt->bindParam(5, $address['city'],\PDO::PARAM_STR);
        $stmt->bindParam(6, $address['country'],\PDO::PARAM_STR);
        return $stmt->execute();

    }

    public function updateAddress($address,$userID)
    {
        $this->dbh= Model::getPdo();
        $stmt =  $this->dbh->prepare('Update Address SET Streetname = ?,HouseNR = ?, ZipCode = ?,City = ?, Country = ? WHERE UserID = ?');

        $stmt->bindParam(1, $address['streetname'],\PDO::PARAM_STR);
        $stmt->bindParam(2, $address['houseNr'],\PDO::PARAM_INT);
        $stmt->bindParam(3, $address['zipCode'],\PDO::PARAM_INT);
        $stmt->bindParam(4, $address['city'],\PDO::PARAM_STR);
        $stmt->bindParam(5, $address['country'],\PDO::PARAM_STR);
        $stmt->bindParam(6, $userID,\PDO::PARAM_INT);
        echo $stmt->execute();

    }

    public function updateUserInfo($userInfo,$userID)
    {
        echo $userID;
        $this->dbh= Model::getPdo();
        $stmt =  $this->dbh->prepare('Update User SET Email = ?, Firstname = ?,Lastname = ? WHERE ID = ?');
        $stmt->bindParam(1, $userInfo['email'],\PDO::PARAM_STR);
        $stmt->bindParam(2, $userInfo['firstname'],\PDO::PARAM_STR);
        $stmt->bindParam(3, $userInfo['lastname'],\PDO::PARAM_STR);
        $stmt->bindParam(4, $userID,\PDO::PARAM_INT);
        echo $stmt->execute();

    }


    public function getUserIDByEmail($email)
    {
        $this->dbh = Model::getPdo();
        $stmt = $this->dbh->prepare('Select ID FROM User WHERE Email = ?');
        $stmt->bindParam(1,$email,\PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['ID'];
    }

    public function getUserHash($ID)
    {
        $this->dbh = Model::getPdo();
        $stmt = $this->dbh->prepare('Select password From User WHERE id= ?');
        $stmt->bindParam(1,$ID,\PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();
        return  $result = $result['password'];
    }



    public function incrementLoginAttempt($ID)
    {
        $this->dbh = Model::getPdo();
        $stmt = $this->dbh->prepare('UPDATE User SET FailedLogins = FailedLogins+1 Where User.ID = ?');
        $stmt->bindParam(1,$ID,\PDO::PARAM_INT);
        $stmt->execute();
    }

    public function checkFailedLogins($ID)
    {
        $this->dbh = Model::getPdo();
        $stmt = $this->dbh->prepare('SELECT FailedLogins FROM User WHERE User.ID = ? ');
        $stmt->bindParam(1,$ID,\PDO::PARAM_INT);
        $stmt->execute();
        $result =  $stmt->fetch();
        return $result['FailedLogins'];
    }

    public function getUserByID($ID)
    {
        $this->dbh = Model::getPdo();
        $stmt = $this->dbh->prepare('Select * FROM User Where ID = ? LIMIT 1');
        $stmt->bindParam(1,$ID,\PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();

    }public function getAddressDataByID($ID)
    {
        $this->dbh = Model::getPdo();
        $stmt = $this->dbh->prepare('Select * FROM Address Where UserID = ? ');
        $stmt->bindParam(1,$ID,\PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }
}