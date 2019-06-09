<?php


namespace App\Controllers;


use Core\Controller;
use Core\View;
use App\Models\User;

class Checkout extends Controller
{
    public function showOrderAddress()
    {
        View::renderTemplate('orderaddress.html');
    }

}