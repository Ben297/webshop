<?php


namespace App\Models;

use Core\Model;

class Session extends Model
{
    public static function  insertSessionID($sessionID,$UserID)
    {

        $dbh= Model::getPdo();
        $stmt =  $dbh->prepare('INSERT INTO Session VALUES (NULL,?,?,NULL)');
        $stmt->bindParam(1, $sessionID,\PDO::PARAM_STR);
        $stmt->bindParam(2, $UserID,\PDO::PARAM_INT);
        //$stmt->bindParam(3, TRUE,\PDO::PARAM_STR);
        if($stmt->execute()){
            return 'SessionID created';
        }else{
            echo 'SessionID could not be inserted could not be inserted';
        }
    }
    public static function getSessionID($userID){
        $dbh= Model::getPdo();
        $stmt =  $dbh->prepare('SELECT SessionID FROM Session WHERE UserID = ?');
        $stmt->bindParam(1, $userID,\PDO::PARAM_STR);
        if($stmt->execute()){
            return $stmt->fetch();
        }else{
            echo 'No Session for this User saved';
        }
    }


}

