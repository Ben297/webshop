<?php


namespace App\Controllers;


use App\Models\User;
use Core\View;
use App\Models\Session;
use Twig\Error\RuntimeError;

class Authentication
{
    private $User;
    private $Session;

    public function __construct()
    {
        $this->User = new User();
        $this->Session = new Session();

    }

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
        $userData = $_POST;
        $userData['email'] = filter_var($userData['email'], FILTER_SANITIZE_EMAIL);
        $userData['password'] = password_hash($userData['password'],PASSWORD_DEFAULT);
        $userID = $this->User->insertUser($userData);
        $this->User->insertAddress($userData,$userID);
        header('Location: ../basket');

    }

    public function login()
    {
        $password = $_POST['password'];
        $email = $_POST['email'];
        $_SESSION['UserID'] = $this->User->getUserIDByEmail($email);
        $userPWHashed = $this->User->getUserHash($_SESSION['UserID']);
        $_SESSION['LoginStatus']= TRUE;
        $this->validatePassword($password,$userPWHashed,$_SESSION['UserID']);

    }

    public function logout()
    {
        session_destroy();
        header('Location: /');
    }

    private function validatePassword($password,$userPWHashed,$userID)
    {
        if (password_verify($password,$userPWHashed)){
           return True;
        }else{
            $this->User->incrementLoginAttempt($userID);
           echo $failedLogins = $this->User->checkFailedLogins($userID);
            if ($failedLogins > 3){
                View::renderTemplate('loginFail.html');
            }else{
                View::renderTemplate('login.html',['LoginAttempts' => $failedLogins]);
            }
        }

    }

    private function checkSession($userID){
        if (empty($_SESSION['ID'])){
        $_SESSION['ID'] = $this->generateSessionID();
        Session::insertSessionID($_SESSION['ID'],$userID);

        }elseif(!empty($_SESSION['ID'])){
            Session::getSessionID($userID);

        }




        print_r( $_SESSION);

    }

    private function generateSessionID()
    {
        return md5(openssl_random_pseudo_bytes(32));
    }

}