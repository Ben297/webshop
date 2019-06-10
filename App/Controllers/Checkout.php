<?php


namespace App\Controllers;


use App\Models\BasketModel;
use App\Models\Cookie;
use App\Models\Item;
use App\Models\Payment;
use Core\Controller;
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
    private $Orderdetail=[];
    private $Items=[];
    public function __construct()
    {
        $this->User = new User();
        $this->Order = new Order();
        $this->Cart = new BasketModel();
        $this->Cookie = new Cookie();
        $this->Item = new Item();
    }
    public function showOrderAddress()
    {
        if (Controller::loginStatus()){
            $AddressInfo = $this->User->getAddressDataByID($_SESSION['UserID']);
            $this->creatOrder($AddressInfo);
            $AddressInfo = $this->User->getAddressDataByID($_SESSION['UserID']);

            View::renderTemplate('orderaddress.html',['AddressInfo' => $AddressInfo]);
        }
        else{
            View::renderTemplate('loginprompt.html');
        }

    }

    private function creatOrder($AddressInfo)
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

    public function confirmPaymentMethod()
    {
        $this->Order->addPaymentMethodToOrder($_POST['paymentMethod'],$_SESSION['OrderID']);
        header('Location: /showOrderOverview');
    }


}