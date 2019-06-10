<?php


namespace App\Controllers;

use App\Models\User;
use Core\View;
use App\Models\Session;
use http\Header;
use mysql_xdevapi\Result;
use Twig\Node\IfNode;

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
        if (isset($_SESSION['LoginStatus']))
            header('Location: /account');
        else
        View::renderTemplate('register.html');
    }

    public function showLoginForm()
    {
        if (isset($_SESSION['LoginStatus']))
            header('Location: /account');
        else
        View::renderTemplate('login.html');
    }

    /**
     * Function to Register the User and validate the input of the User
     * TODO Validate the user input
     */
    public function registerUser()
    {
        $userData['email'] = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $result = $this->User->checkIFEmailExists($userData['email']);
        if ($result == 1){
            $_SESSION['UserEmail'] = true;
            header('Location: /register');
        }
        $_SESSION['UserEmail'] = false;
        $userData['firstname'] =filter_var($_POST['firstname'], FILTER_SANITIZE_STRING);
        $userData['lastname'] =filter_var($_POST['lastname'], FILTER_SANITIZE_STRING);
        $userData['password'] = password_hash($_POST['password'],PASSWORD_DEFAULT);
        $userData['streetname'] =filter_var($_POST['streetname'], FILTER_SANITIZE_STRING);
        $userData['houseNr'] =filter_var($_POST['houseNr'], FILTER_SANITIZE_STRING);
        $userData['zipCode'] =filter_var($_POST['zipCode'], FILTER_SANITIZE_NUMBER_INT);
        $userData['city'] =filter_var($_POST['city'], FILTER_SANITIZE_STRING);
        $userData['country'] =filter_var($_POST['country'], FILTER_SANITIZE_STRING);
        $userID = $this->User->insertUser($userData);
        $this->User->insertAddress($userData,$userID);
        //header('Location: ../basket');
    }

    /***
     * Login Function
     * First it filters the Input
     * TODO Check if User exists
     *
     */
    public function login()
    {
        $password = $_POST['password'];
        $email = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
        $userID = $this->User->getUserIDByEmail($email);
        $userPWHashed = $this->User->getUserHash($userID);
        if($this->validatePassword($password,$userPWHashed,$userID)){
            session_regenerate_id(true);
            $_SESSION['LoginStatus'] = TRUE;
            $_SESSION['UserID']=$userID;
            $_SESSION['LoginTime']=time();
            $this->User->clearLoginAttempt($_SESSION['UserID']);
            header('Location: /');
        }else{
            $this->User->incrementLoginAttempt($userID);
            $failedLogins = $this->User->checkFailedLogins($_SESSION['UserID']);
            if ($failedLogins>5)
                $_SESSION['LoginAttempts'] = $failedLogins;
                header('Location: /login');
        }
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
        }else {
           return False;
        }
    }

    private function checkCSFRToken($userID){
        if (empty($_SESSION['CSFR_Token'])){
        $_SESSION['CSFR_Token'] = $this->generateSessionID();
        Session::insertSessionID($_SESSION['CSFR_Token'],$userID);
        }else{
            return hash_equals($_SESSION['CSFR_Token'],Session::getSessionHash($userID));
        }
    }

    private function generateSessionID()
    {
        return md5(openssl_random_pseudo_bytes(32));
    }

    public function show404()
    {
        View::renderTemplate('404.html');
    }

}