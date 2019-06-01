<?php


namespace App\Models;


use Core\Model;

class User extends Model
{
    public function insertUser($user)
    {
        //print_r( $user);
        $this->dbh= Model::getPdo();
        $stmt =  $this->dbh->prepare('INSERT INTO user VALUES (NULL ,?,?,?,?,0)');
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
        print_r( $address);
        $this->dbh= Model::getPdo();
        $stmt =  $this->dbh->prepare('INSERT INTO address VALUES (NULL ,?,?,?,?,?,?)');
        $stmt->bindParam(1, $userID,\PDO::PARAM_INT);
        $stmt->bindParam(2, $address['streetname'],\PDO::PARAM_STR);
        $stmt->bindParam(3, $address['streetnr'],\PDO::PARAM_INT);
        $stmt->bindParam(4, $address['zip'],\PDO::PARAM_INT);
        $stmt->bindParam(5, $address['city'],\PDO::PARAM_STR);
        $stmt->bindParam(6, $address['country'],\PDO::PARAM_STR);
        return $stmt->execute();

    }

}