<?php


namespace App\Controllers;

use App\Models\Order;
use Core\Controller;
use Core\Helper;
use Core\View;
use App\Models\User;
use App\Models\Item;

class Account extends Controller
{
    private $User;
    private $Order;
    private  $Item;

    public function __construct()
    {
        $this->User = new User();
        $this->Order = new Order();
        $this->Item = new Item();
    }

    /*
     * default action for showing the Account Overview
     * checks SessionTime and LoginStatus
     * Gets User and Order Data from the DB and sanitizes it
     */
    public function showAccount()
    {
        Helper::checkSessionTime();
        Helper::updateSessionTimeout();
        $ALLOrderInfo = [];
        if (Controller::loginStatus()){
            $UserInfo = array_unique($this->User->getUserByID($_SESSION['UserID']));
            $AddressInfo = array_unique( $this->User->getAddressDataByID($_SESSION['UserID']));
            //Builds an Array with all Orders and the respective Order details
            $OrderInfo = $this->Order->getAllOrdersByUserID($_SESSION['UserID']);
            $indexOrders = 0;
            foreach ($OrderInfo as $SpecificOrder){
                 $orderDetails= $this->Order->getOrderDetailsByID($SpecificOrder['ID']);
                 $SpecificOrder['OrderName']='order'.$indexOrders;
                 $indexDetails = 0;
                 $OrderDetailsMerged=[];
                 foreach ($orderDetails as $orderDetail) {
                     $itemDetail = $this->Item->getItemByID( $orderDetail['ItemID']);
                     unset($itemDetail['ID']);
                     $OrderDetailsMerged[$indexDetails] = array_merge($orderDetail,$itemDetail);
                     $indexDetails++;
                 }
                $SpecificOrder['OrderDetails']=$OrderDetailsMerged ;
                $ALLOrderInfo[$indexOrders] =$SpecificOrder;
                    $indexOrders++;
            }
            $AccountData = array_merge($UserInfo,$AddressInfo);
            //Sanitizes AccountInformation(User+Address) for Output in Account Overview
            foreach ($AccountData as $key => $value){
                $AccountData[$key]=filter_var($value,FILTER_SANITIZE_SPECIAL_CHARS);
            }
            View::renderTemplate('account.html',['AccountData'=> $AccountData,'ALLOrderInfo'=> $ALLOrderInfo]);
        }
        else{
            $_SESSION['LoginStatus']= False;
            View::renderTemplate('loginprompt.html');
        }
    }

    /*
     * change the Address Information
     * If the User does not add new Value to Key -> retrieve the old one and insert it again
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
     * Function to Change Personal Data of a User in the Account Overview
     * Check CSRF-Token
     * validates old Password before changing the Data
     */
    public function changeUserInformation()
    {
        if (Helper::checkCSRF()) {
            $oldPWDB = $this->User->getUserHash([$_SESSION['UserID']]);
            if (Helper::check($_POST['OldPassword'])) {
                $_SESSION['passwordRequired'] = True;
                header('Location: /account');
            } elseif (password_verify($_POST['OldPassword'], $oldPWDB) == FALSE) {
                $_SESSION['passwordRequired'] = True;
                header('Location: /account');
            } else {
                $newUserData = $_POST;
                unset($newUserData['OldPassword']);
                unset($newUserData['csrf_token']);
                $oldUserData = $this->User->getUserByID($_SESSION['UserID']);
                foreach ($newUserData as $key => $value) {
                    //if no new password provided use old password
                    if ($key == 'NewPassword' && empty($value)) {
                        $newUserData['Password'] = $oldUserData['Password'];
                        break;
                    } //if new password hash new password
                    elseif ($key == 'NewPassword' && isset($value)) {
                        $newUserData['Password'] = password_hash($value, PASSWORD_DEFAULT);
                        break;
                    } elseif (empty($value)) {
                        $newUserData{$key} = $oldUserData[$key];
                    }
                }
                $this->User->updateUserInfo($newUserData, $_SESSION['UserID']);
                header('Location: /account');
            }
        }
    }

    /*
     * Flags an Account as deleted in the Database
     */
    public function deleteAccount()
    {
        $this->User->deleteAccountFromDB($_SESSION['UserID']);
        session_destroy();
        View::renderTemplate('accountdelete.html');
    }
}