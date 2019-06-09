<?php


namespace App\Controllers;


use App\Models\Payment;
use Core\Controller;
use Core\View;
use App\Models\User;
use App\Models\Order;

class Checkout extends Controller
{
    private $User;
    private $Order;
    public function __construct()
    {
        $this->User = new User();
        $this->Order = new Order();
    }
    public function showOrderAddress()
    {
        if (Controller::loginStatus()){
            $this->Order->addAddressToOrder(1,1);
            $AddressInfo = $this->User->getAddressDataByID($_SESSION['UserID']);
            View::renderTemplate('orderaddress.html',['AddressInfo' => $AddressInfo]);
        }
        else{
            View::renderTemplate('loginprompt.html');
        }

    }

    public function showOrderPayment()
    {
        if (Controller::loginStatus()){
            $PaymentInfo = Payment::getPaymentMethods();
            $OrderPaymentMethod = Payment::getOrderPaymentMethod(1);
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
        $this->Order->addPaymentMethodToOrder($_POST['paymentMethod'],1);
        header('Location: /showOrderOverview');
    }


}