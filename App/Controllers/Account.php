<?php


namespace App\Controllers;


use App\Models\Order;
use Core\Controller;

use Core\Error;
use Core\Helper;
use Core\View;
use App\Models\User;

class Account extends Controller
{
    private $User;
    private $Order;

    public function __construct()
    {
        $this->User = new User();
        $this->Order = new Order();
    }

    public function showAccount()
    {
        if (Controller::loginStatus()){
            $AccountInfo = array_unique(array_merge($this->User->getUserbyID($_SESSION['UserID']),$this->User->getAddressDataByID($_SESSION['UserID'])));
            $OrderInfo = $this->Order->getAllOrdersByUserID($_SESSION['UserID']);
            View::renderTemplate('account.html',['UserInfo'=> $AccountInfo,'OrderInfo' => $OrderInfo]);
        }
        else{
            View::renderTemplate('loginprompt.html');
        }
    }

    public function deleteAccount()
    {

       if($this->User->deleteAccountFromDB($_SESSION['UserID'])){
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
        if (Helper::checkCSRF()) {
            $newAddress = $_POST;
            $oldData = $this->User->getAddressDataByID($_SESSION['UserID']);
            foreach ($newAddress as $key => $value) {
                if (empty($value)) {
                    $newAddress[$key] = $oldData[$key];
                }
            }
            if ($this->User->updateAddress($newAddress, $_SESSION['UserID'])) {
                header('Location: /account');
            }
        }else{
            throw new \Error('Invalid CSRF-Token');
        }
    }

    /*
     * TODO DOes not work yet
     */
    public function changeUserInformation()
    {
        if (Helper::checkCSRF()) {
            $newUserInfo = $_POST;
            $oldPWHashed = $this->User->getUserHash($_SESSION['UserID']);
            if (password_verify($newUserInfo['OldPassword'], $oldPWHashed)) {
                $oldData = $this->User->getUserByID($_SESSION['UserID']);
                foreach ($newUserInfo as $key => $value) {
                    print_r($key);
                    print_r($value);
                    if (!isset($key['NewPassword'])) {
                        continue;
                    }
                    if (empty($value)) {
                        echo $value = $oldData[$key];
                    }
                }
                $this->User->updateUserInfo($newUserInfo, $_SESSION['UserID']);
                if (isset($newUserInfo['NewPassword'])) {
                    $newPWHashed = password_hash($_POST['NewPassword'], PASSWORD_DEFAULT);
                    $this->User->insertNewPassword($newPWHashed, $_SESSION['UserID']);
                }
                //header('Location: /account');
            } else {
                $_SESSION['newpw'] = $newUserInfo['NewPassword'];
                $_SESSION['UserInfoChange'] = FALSE;
                //header('Location: /account');
            }
        }

       // header('Location: /account');
    }



}