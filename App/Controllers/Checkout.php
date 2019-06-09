<?php


namespace App\Controllers;


use App\Models\Payment;
use Core\Controller;
use Core\View;
use App\Models\User;

class Checkout extends Controller
{
    private $User;
    public function __construct()
    {
        $this->User = new User();
    }
    public function showOrderAddress()
    {
        if (Controller::loginStatus()){
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
            View::renderTemplate('orderpayment.html',['PaymentInfo' => $PaymentInfo]);
        }
        else{
            View::renderTemplate('loginprompt.html');
        }

    }public function showOrderOverview()
    {
        if (Controller::loginStatus()){

            View::renderTemplate('orderoverview.html');
        }
        else{
            View::renderTemplate('loginprompt.html');
        }

    }


}