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
        $this->dbh= Model::getPdo();
        $stmt =  $this->dbh->prepare('INSERT INTO User VALUES (NULL,?,?,?,?,0,0)');
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

    /**
     * Function to update the Password
     * @param $password
     * @param $UserID
     */
    public function insertNewPassword($password,$UserID)
    {
        $this->dbh= Model::getPdo();
        $stmt =  $this->dbh->prepare('Update User Set Password = ? Where ID = ?');
        $stmt->bindParam(1, $password,\PDO::PARAM_STR);
        $stmt->bindParam(2, $UserID);

        echo $stmt->execute();

    }

    /**
     * Function to Insert the Address in Database when the user is registering
     * @param $address
     * @param $userID
     * @return bool
     */
    public function insertAddress($address,$userID)
    {
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

    /**
     * Function to update the User Address
     * @param $address
     * @param $userID
     * @return bool
     */
    public function updateAddress($address,$userID)
    {
        $this->dbh= Model::getPdo();
        $stmt =  $this->dbh->prepare('Update Address SET Streetname = ?,HouseNR = ?, ZipCode = ?,City = ?, Country = ? WHERE UserID = ?');
        $stmt->bindParam(1, $address['Streetname'],\PDO::PARAM_STR);
        $stmt->bindParam(2, $address['HouseNr'],\PDO::PARAM_INT);
        $stmt->bindParam(3, $address['ZipCode'],\PDO::PARAM_INT);
        $stmt->bindParam(4, $address['City'],\PDO::PARAM_STR);
        $stmt->bindParam(5, $address['Country'],\PDO::PARAM_STR);
        $stmt->bindParam(6, $userID,\PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Function to update the User Info
     * @param $userInfo
     * @param $userID
     * @return bool
     */
    public function updateUserInfo($userInfo,$userID)
    {
        $this->dbh= Model::getPdo();
        $stmt =  $this->dbh->prepare('Update User SET Email = ?, Firstname = ?,Lastname = ?,Password = ? WHERE ID = ?');
        $stmt->bindParam(1, $userInfo['Email'],\PDO::PARAM_STR);
        $stmt->bindParam(2, $userInfo['Firstname'],\PDO::PARAM_STR);
        $stmt->bindParam(3, $userInfo['Lastname'],\PDO::PARAM_STR);
        $stmt->bindParam(4, $userInfo['Password'],\PDO::PARAM_STR);
        $stmt->bindParam(5, $userID,\PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Check DB for Email existence
     * @param $email
     * @return bool
     */
    public function checkIFEmailExists($email)
    {
        $this->dbh = Model::getPdo();
        $stmt = $this->dbh->prepare('Select Email FROM User WHERE Email = ?');
        $stmt->bindParam(1,$email,\PDO::PARAM_STR);
        return $stmt->execute();
    }

    /**
     * Get UserID by email provided
     * @param $email
     * @return bool
     */
    public function getUserIDByEmail($email)
    {
        $this->dbh = Model::getPdo();
        $stmt = $this->dbh->prepare('Select ID FROM User WHERE Email = ? AND DeleteFlag != 1');
        $stmt->bindParam(1,$email,\PDO::PARAM_STR);
        if($stmt->execute()){
            $result = $stmt->fetch();
            return $result['ID'];
        }else{
            return FALSE;
        }
    }

    /**
     * Get the hashed User Password from the DB
     * @param $userID
     * @return mixed
     */
    public function getUserHash($userID)
    {
        $this->dbh = Model::getPdo();
        $stmt = $this->dbh->prepare('Select password From User WHERE id= ?');
        $stmt->bindParam(1,$userID,\PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();
        return  $result = $result['password'];
    }

    /**
     * Function to incremtn the LoginAttempt for existing User in the DB
     * @param $userID
     * @return bool
     */
    public function incrementLoginAttempt($userID)
    {
        $this->dbh = Model::getPdo();
        $stmt = $this->dbh->prepare('UPDATE User SET FailedLogins = FailedLogins+1 Where User.ID = ?');
        $stmt->bindParam(1,$userID,\PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Checks how muck login Attempts a User has made
     * @param $userID
     * @return mixed
     */
    public function checkFailedLogins($userID)
    {
        $this->dbh = Model::getPdo();
        $stmt = $this->dbh->prepare('SELECT FailedLogins FROM User WHERE User.ID = ? ');
        $stmt->bindParam(1,$userID,\PDO::PARAM_INT);
        $stmt->execute();
        $result =  $stmt->fetch();
        return $result['FailedLogins'];
    }

    /**
     * Function to clear the Login Attempts in the DB
     * @param $userID
     * @return bool
     */
    public function clearLoginAttempt($userID)
    {
        $this->dbh = Model::getPdo();
        $stmt = $this->dbh->prepare('UPDATE User SET FailedLogins = 0 Where User.ID = ?');
        $stmt->bindParam(1,$userID,\PDO::PARAM_INT);
        return $stmt->execute();
    }

    /**
     * Function to get the Userdata by the User Id fromt the DB
     * @param $userID
     * @return mixed
     */
    public function getUserByID($userID)
    {
        $this->dbh = Model::getPdo();
        $stmt = $this->dbh->prepare('Select * FROM User Where ID = ? LIMIT 1');
        $stmt->bindParam(1,$userID,\PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();

    }

    /**
     * Function to get the current User Address with the User ID
     * @param $userID
     * @return mixed
     */
    public function getAddressDataByID($userID)
    {
        $this->dbh = Model::getPdo();
        $stmt = $this->dbh->prepare('Select * FROM Address Where UserID = ? ');
        $stmt->bindParam(1,$userID,\PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    /**
     * Function to flag aa Account as deleted in the Database
     * @param $userID
     * @return bool
     */
    public function deleteAccountFromDB($userID)
    {
        $this->dbh = Model::getPdo();
        $stmt = $this->dbh->prepare('Update User SET DeleteFlag = 1 WHERE ID = ? ');
        $stmt->bindParam(1,$userID,\PDO::PARAM_INT);
        return $stmt->execute();
    }
}