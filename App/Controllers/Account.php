<?php


namespace App\Controllers;


use Core\Controller;

use Core\Error;
use Core\View;
use App\Models\User;

class Account extends Controller
{
    private $User;

    public function __construct()
    {
        $this->User = new User();
    }

    public function showAccount()
    {
        if (Controller::loginStatus()){
            $AccountInfo = array_unique(array_merge($this->User->getUserbyID($_SESSION['UserID']),$this->User->getAddressDataByID($_SESSION['UserID'])));
            View::renderTemplate('account.html',['UserInfo'=> $AccountInfo]);
        }
        else{
            View::renderTemplate('loginprompt.html');
        }
    }

    public function deleteAccount()
    {

       if($this->User->deleteAccount($_SESSION['UserID'])){
           session_destroy();
            View::renderTemplate('accountdelete.html');
       }
       else{
            return htmlspecialchars('error');
       }
    }

    public function changeAddressInformation()
    {
        print_r($newAddress=$_POST);
        echo $_SESSION['UserID'];
        $this->User->updateAddress($newAddress,$_SESSION['UserID']);
        header('Location: /account');
    }


    public function changeUserInformation()
    {
        print_r($newUserInfo=$_POST);
        $oldPWHashed = $this->User->getUserHash($_SESSION['UserID']);
        $newPWHashed = password_hash($_POST['newPassword'],PASSWORD_DEFAULT);
        if (password_verify($newUserInfo['oldPassword'],$oldPWHashed))
        {
            $this->User->insertNewPassword($newPWHashed,$_SESSION['UserID']);
        }
        $this->User->updateUserInfo($newUserInfo,$_SESSION['UserID']);
       // header('Location: /account');
    }



}