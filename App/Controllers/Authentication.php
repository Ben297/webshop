<?php

namespace App\Controllers;
use App\Models\User;
use Core\Controller;
use Core\Helper;
use Core\View;

class Authentication extends Controller
{
    private $User;

    public function __construct()
    {
        $this->User = new User();
    }

    /*
     * default Action to show the Register Form
     * cannot be accessed when User is logged in
     */
    public function showRegistrationForm()
    {
        if (!empty($_SESSION['LoginStatus']))
            header('Location: /account');
        else
        View::renderTemplate('register.html');
    }

    /*
     * default Action to show the Login Form
     * cannot be accessed when User is logged in
     */
    public function showLoginForm()
    {
        if (!empty($_SESSION['LoginStatus']))
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
            //check if submitted Data is not empty - redirct if Data empty
            foreach ($_POST as $input){
                if(Helper::check($input)==FALSE)
                    $_SESSION['missingInputRegistration'] = TRUE;
                    header('Location: /register');
            }
            //Validate EmailAddress
            $validEmail = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
            $emailExists = $this->User->checkIFEmailExists($validEmail);
            if ($validEmail==FALSE) {
                $_SESSION['validEmail'] = FALSE;
                header('Location: /register');
            }
            if($emailExists==TRUE) {
                $_SESSION['emailExists'] = TRUE;
                header('Location: /register');
            }
            $userData = $_POST;
            $userData['password'] = password_hash($_POST['password'],PASSWORD_DEFAULT);
            $userID = $this->User->insertUser($userData);
            $this->User->insertAddress($userData, $userID);

            //clear possible flags after successful registration
            unset($_SESSION['UserEmail']);
            unset($_SESSION['emailExists']);
            unset($_SESSION['missingInputRegistration']);
            //Login the User
            $_SESSION['UserID']= $userID;
            $_SESSION['LoginStatus']= TRUE;
            $_SESSION['LoginTime'] = time();
            header('Location: ../basket');
        }else{
            throw new \Error("CSRF Token ivalid");
        }
    }

     /*
     * Login Function
     * - Checks valid CSRF-Token
     * - Search for user by email
     * - hash old PW if User exists
     * - Verifies Password
     * - If User exists and Password is correct
     *      -> regenerate sessionID
     *      -> Set LoginStatus True
     *      -> Set serID
     *      -> Redirect to Landingpage
     * - Else Increase LoginAttempts in Session for No Account and in DB for User with Account
     */
    public function login()
    {
        if (Helper::checkCSRF()) {
                $userID = $this->User->getUserIDByEmail($_POST['email']);
                if($userID==TRUE){
                    $this->User->incrementLoginAttempt($userID);
                    $failedLogins = $this->User->checkFailedLogins($userID);
                    $_SESSION['LoginAttempts'] = $failedLogins;
                    header('Location: /login');
                }
                $userPWHashed = $this->User->getUserHash($userID);
                $userPW = password_verify($_POST['password'], $userPWHashed);
                $_SESSION['UserID'] = $userID;
                if ($userID&&$userPW) {
                    session_regenerate_id(TRUE);
                    $_SESSION['LoginStatus'] = TRUE;
                    $_SESSION['UserID'] = $userID;
                    $_SESSION['LoginTime'] = time();
                    unset($_SESSION['LoginAttempts']);
                    unset($_SESSION['LoginAttemptsNoAccount']);
                    $this->User->clearLoginAttempt($_SESSION['UserID']);
                    header('Location: /');
                } else {
                    if (empty($_SESSION['LoginAttemptsNoAccount'])){
                        $_SESSION['LoginAttemptsNoAccount']=1;
                    }else{
                        $_SESSION['LoginAttemptsNoAccount'] = ++$_SESSION['LoginAttemptsNoAccount'];
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

    public function show500()
    {
        View::renderTemplate('500.html');
    }

    /*
     * Function to render a Prompt when the Session expired
     */
    public function showSessionexpired()
    {
        View::renderTemplate('sessionexpired.html');
    }

}