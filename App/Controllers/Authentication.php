<?php


namespace App\Controllers;


use App\Models\User;
use Core\View;

class Authentication
{
    private $user;
    public function showRegistrationForm()
    {
        View::renderTemplate('register.html');
    }

    public function showLoginForm()
    {
        View::renderTemplate('login.html');
    }

    /**
     * Function to Register the User and validate the input of the User
     * TODO Validate the user input
     */
    public function creatUser()
    {
        $newUser =  new User();
        $userData = $_POST;
        $userData['password'] = password_hash($userData['password'],PASSWORD_DEFAULT);
        $userID = $newUser->insertUser($userData);
        $newUser->insertAddress($userData,$userID);
        header('Location: ../basket');

    }

    public function validateLogin()
    {
        $this->user = new User();
        $password = $_POST['password'];
        $email = $_POST['email'];
        $userID = $this->user->getUserByEmail($email);
        $userPWHashed = $this->user->getUserHash($userID);
        if (password_verify($password,$userPWHashed)){
            header('Location: ../basket');
        }else{
            $this->user->incrementLoginAttempt($userID);
           echo $failedLogins = $this->user->checkFailedLogins($userID);
            if ($failedLogins > 3){
                View::renderTemplate('loginFail.html');
            }else{
                View::renderTemplate('login.html',['LoginAttempts' => $failedLogins]);
            }
        }

    }

}