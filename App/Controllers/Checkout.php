<?php


namespace App\Controllers;


use App\Models\BasketModel;
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
    public function __construct()
    {
        $this->User = new User();
        $this->Order = new Order();
        $this->Cart = new BasketModel();
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
        if(isset($_SESSION['OrderID'])) {
            $OrderInfo['UserID'] = $_SESSION['UserID'];
            $OrderInfo['TotalPrice'] = 500000;
            $_SESSION['OrderID'] = $this->Order->createNewOrder($OrderInfo);
            $this->Order->addAddressToOrder($AddressInfo['ID'],$_SESSION['OrderID']);
            $cookieID = $this->Cart->loadBasketFromTempCookie();

            $Items = $this->Cart->getAllBasketItems($cookieID);



            foreach ($Items as $Item)
            {
                echo '<pre>';
                print_r($Item=array_unique($Item));
                echo '</pre>';
                $this->Order->insertOrderDetails($Item,$_SESSION['OrderID']);
            }
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
        if (Controller::loginStatus()){
            View::renderTemplate('orderoverview.html');
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