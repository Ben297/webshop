<?php

namespace App\Controllers;
use Core\Controller;
use Core\View;
use App\Models\Cart;

class Basket extends Controller{

    public function ShowBasket()
    {

        View::renderTemplate('basket.html');
    }



}