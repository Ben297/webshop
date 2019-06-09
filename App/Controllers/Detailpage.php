<?php


namespace App\Controllers;


use App\Models\Item;
use Core\Controller;
use Core\View;
use App\Models\BasketModel;
use App\Models\Cookie;

class Detailpage extends Controller
{

    protected  $route_params = null;
    private $Item;
    public function __construct($route_params)
    {
        parent::__construct($route_params);
        $this->Item = new Item();
    }

    public function showDetail()
    {
        View::renderTemplate('detailpage.html',["Item" => $this->Item->getItemByID($this->route_params['id'])]);
    }
}