<?php


namespace App\Controllers;


use App\Models\Item;
use Core\Controller;
use Core\Helper;
use Core\View;

class Detailpage extends Controller
{
    protected  $route_params = null;
    private $Item;

    public function __construct($route_params)
    {
        parent::__construct($route_params);
        $this->Item = new Item();
    }
    /*
     * Displays Detailpage with
     */
    public function showDetail()
    {
        Helper::checkSessionTime();
        Helper::updateSessionTimeout();
        View::renderTemplate('detailpage.html',["Item" => $this->Item->getItemByID($this->route_params['id'])]);
    }
}