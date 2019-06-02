<?php


namespace App\Models;


use Core\Model;

class User extends Model
{
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

    public function insertAddress($address,$userID)
    {
        //print_r( $address);
        $this->dbh= Model::getPdo();
        $stmt =  $this->dbh->prepare('INSERT INTO Address VALUES (NULL,?,?,?,?,?,?)');
        $stmt->bindParam(1, $userID,\PDO::PARAM_INT);
        $stmt->bindParam(2, $address['streetname'],\PDO::PARAM_STR);
        $stmt->bindParam(3, $address['streetnr'],\PDO::PARAM_INT);
        $stmt->bindParam(4, $address['zip'],\PDO::PARAM_INT);
        $stmt->bindParam(5, $address['city'],\PDO::PARAM_STR);
        $stmt->bindParam(6, $address['country'],\PDO::PARAM_STR);
        return $stmt->execute();

    }

    public function getUserByEmail($email)
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
}