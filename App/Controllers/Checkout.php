<?php


namespace App\Controllers;


use App\Models\BasketModel;
use App\Models\Cookie;
use App\Models\Item;
use App\Models\Payment;
use Core\Controller;
use Core\Helper;
use Core\View;
use App\Models\User;
use App\Models\Order;

class Checkout extends Controller
{
    private $User;
    private $Order;
    private $Cart;
    private $Cookie;
    private $Item;

    public function __construct()
    {
        $this->User = new User();
        $this->Order = new Order();
        $this->Cart = new BasketModel();
        $this->Cookie = new Cookie();
        $this->Item = new Item();
    }

    /*
     * Displays the Address to which the Order will be send
     * Change Button leads to the Account Overview, where you can change your Address
     * Creates Order in Database if none existing
     * Redirects to Login if you are not Logged In
     */
    public function showOrderAddress()
    {
        Helper::checkSessionTime();
        Helper::updateSessionTimeout();
        if (Controller::loginStatus()){
            $AddressInfo = $this->User->getAddressDataByID($_SESSION['UserID']);
            if (empty($_SESSION['OrderID'])){
                $this->createOrder($AddressInfo);
            }
            $AddressInfo = $this->User->getAddressDataByID($_SESSION['UserID']);
            foreach ($AddressInfo as $key => $value){
                $AddressInfo[$key]=filter_var($value,FILTER_SANITIZE_SPECIAL_CHARS);
            }
            View::renderTemplate('orderaddress.html',['AddressInfo' => $AddressInfo]);
        }
        else{
            View::renderTemplate('loginprompt.html');
        }
    }

    /*
     * Function to Create the Order in The Database
     */
    private function createOrder($AddressInfo)
    {
        $totalPrice = 0;
        if(empty($_SESSION['OrderID'])){
            $_SESSION['OrderID'] = $this->Order->createNewOrder($_SESSION['UserID']);
            $this->Order->addAddressToOrder($AddressInfo['ID'],$_SESSION['OrderID']);
            $cookieID = $this->Cart->loadBasketFromTempCookie();
            $Items = $this->Cart->getAllBasketItems($cookieID);
            foreach ($Items as $Item)
            {
                echo '<pre>';
                print_r($Item);
                $Item['TotalPrice']= $Item['Price']*$Item['Amount'];
                echo '</pre>';
                $this->Order->insertOrderDetails($Item,$_SESSION['OrderID']);
                $totalPrice += $Item['TotalPrice'];
            }
            $this->Order->insertTotalPrice($totalPrice,$_SESSION['OrderID']);
            return $totalPrice;
        }else{
            echo ' geht nicht';
        }

    }

    public function showOrderPayment()
    {
        Helper::checkSessionTime();
        Helper::updateSessionTimeout();
        if (Controller::loginStatus()){
            $PaymentInfo = Payment::getPaymentMethods();
            $OrderPaymentMethod = Payment::getOrderPaymentMethod($_SESSION['OrderID']);
            View::renderTemplate('orderpayment.html',['PaymentInfo' => $PaymentInfo,'OrderPaymentID' => $OrderPaymentMethod]);
        }
        else{
            View::renderTemplate('loginprompt.html');
        }


    }
    public function showOrderOverview()
    {
        Helper::checkSessionTime();
        Helper::updateSessionTimeout();
        $OdetailAndItems=[];
        $count = 0;
        if (Controller::loginStatus()){

            print_r($Order = $this->Order->getOrderInfo($_SESSION['OrderID']));
            $Orderdetails = $this->Order->getOrderDetails($_SESSION['OrderID']);

            foreach ($Orderdetails as $Orderdetail){
                $OdetailAndItems[$count] = array_unique(array_merge($Orderdetail,$this->Item->getItemByID($Orderdetail['ItemID'])));
                $count++;
            }
            View::renderTemplate('orderoverview.html',['Order'=> $Order,'Orderdetails' => $OdetailAndItems]);
        }
        else{
            View::renderTemplate('loginprompt.html');
        }

    }

    public function showOrderConfirm()
    {
        Helper::checkSessionTime();
        Helper::updateSessionTimeout();
        if (Controller::loginStatus()){
           if(isset($_SESSION['OrderID'])){
           $OrderStatus = $this->Order->getOrderStatus($_SESSION['OrderID']);
           echo $OrderStatus['OrderStatus'];
           if($OrderStatus['OrderStatus'] == 2){
               $OrderDetail = $this->Order->getItemAmountByID($_SESSION['OrderID']);
               foreach ($OrderDetail as $Item) {
                   $this->Item->reduceStock($Item['ItemAmount'], $Item['ItemID']);
               }
               $this->Order->changeOrderStatus(3, $_SESSION['OrderID']);
               unset($_SESSION['OrderID']);
               $this->Cookie->deleteBasketCookie('TempBasket');
           }
           }
            View::renderTemplate('orderconfirm.html');
        }
        else{
            View::renderTemplate('loginprompt.html');
        }
    }

    public function confirmPaymentMethod()
    {
        if (Helper::checkCSRF()){
        $this->Order->addPaymentMethodToOrder($_POST['paymentMethod'],$_SESSION['OrderID']);
        header('Location: /showOrderOverview');
        }else
            throw new \Error("CSRF Token ivalid");
    }


}