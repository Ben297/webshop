<?php


namespace App\Controllers;

use App\Models\User;
use Core\Controller;
use Core\Error;
use Core\Helper;
use Core\View;
use App\Models\Session;

class Authentication extends Controller
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
     * - checks CSRF-Token
     * - checks if Email already exists
     * - Insert User in Database if Email does not exists otherwise redirect to register Form
     */
    public function registerUser()
    {
        if (Helper::checkCSRF()) {
            if(!preg_match("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^",$_POST['email'])){
            $userData['email'] = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $result = $this->User->checkIFEmailExists($userData['email']);
            if ($result == 1) {
                $_SESSION['UserEmail'] = true;
                header('Location: /register');
            }
            $_SESSION['UserEmail'] = false;
            $userID = $this->User->insertUser($userData);
            $this->User->insertAddress($userData, $userID);
            header('Location: ../basket');
        }}
    }

    /***
     * Login Function
     * - Checks valid CSRF-Token
     * - Search for user by email
     * - hash old PW if User exists
     * - Verifies Password
     * - If User exists and Password is correct
     *      -> regenerate sessionID
     *      -> Set LoginStatus True
     *      -> Set serID
     *      -> Redirect Landingpage
     * - Else Increase LoginAttempts in Session for No Account and in DB for User with Account
     */
    public function login()
    {
        if (Helper::checkCSRF()) {
                $userID = $this->User->getUserIDByEmail($_POST['email']);
                $userPWHashed = $this->User->getUserHash($userID);
                $userPW = password_verify($_POST['password'], $userPWHashed);
                $_SESSION['UserID'] = $userID;
                if ($userID&&$userPW) {
                    session_regenerate_id(TRUE);
                    $_SESSION['LoginStatus'] = TRUE;
                    $_SESSION['UserID'] = $userID;
                    $_SESSION['LoginTime'] = time();
                    $_SESSION['AccountExisits'] = TRUE;
                    $this->User->clearLoginAttempt($_SESSION['UserID']);
                    header('Location: /');
                } else {
                    $_SESSION['AccountExisits'] = FALSE;
                    $this->User->incrementLoginAttempt($userID);
                    if (empty($_SESSION['LoginAttemptsNoAccount'])){
                        $_SESSION['LoginAttemptsNoAccount']=1;
                    }else{
                        $_SESSION['LoginAttemptsNoAccount'] = ++$_SESSION['LoginAttemptsNoAccount'];
                    }
                    $failedLogins = $this->User->checkFailedLogins($_SESSION['UserID']);
                    if ($failedLogins||$_SESSION['LoginAttemptsNoAccount'] > 5) {
                        $_SESSION['LoginAttempts'] = $failedLogins;
                    }
                    header('Location: /login');
                }
            }
        else {
            throw new \Error("CSRF Token ivalid");
        }
    }
    /*
     * destroys the Session and redirects to Landingpage
     */
    public function logout()
    {
        session_destroy();
        header('Location: /');
    }
    /*
     * Function for showing a 404 Page if ShowErrorFlag is false in config
     */
    public function show404()
    {
        View::renderTemplate('404.html');
    }

}