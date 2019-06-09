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
           die("Error: There is NO Account with this ID");
       }
    }
    /*
     * change the Address Information
     * If the User does not add new Value to Key -> retrive the old one and insert it again
     * probably not the best solution
     */
    public function changeAddressInformation()
    {
        $newAddress=$_POST;
        $oldData = $this->User->getAddressDataByID($_SESSION['UserID']);
        foreach ($newAddress as $key => $value) {
            if (empty($value)) {
                $newAddress[$key] = $oldData[$key];
            }
        }
        if($this->User->updateAddress($newAddress,$_SESSION['UserID'])){
            header('Location: /account');
        }
    }

    /*
     * TODO DOes not work yet
     */
    public function changeUserInformation()
    {
        $newUserInfo=$_POST;
        $oldPWHashed = $this->User->getUserHash($_SESSION['UserID']);
        if (password_verify($newUserInfo['OldPassword'],$oldPWHashed))
        {
            $oldData = $this->User->getUserByID($_SESSION['UserID']);
            foreach ($newUserInfo as $key => $value) {
                if (empty($value)) {
                    if(empty($newUserInfo['NewPassword'])){
                        continue;
                    }
                    $newUserInfo[$key] = $oldData[$key];
                }
            }
            $this->User->updateUserInfo($newUserInfo,$_SESSION['UserID']);
            if(empty($newUserInfo['NewPassword'])){

            }else{
                $newPWHashed = password_hash($_POST['NewPassword'],PASSWORD_DEFAULT);
                $this->User->insertNewPassword($newPWHashed,$_SESSION['UserID']);
            }
            header('Location: /account');
        }else{
            return 'geht nicht';
        }


       // header('Location: /account');
    }



}