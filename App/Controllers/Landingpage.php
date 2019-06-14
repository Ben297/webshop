<?php

namespace App\Controllers;

use Core\Controller;
use Core\Helper;
use \Core\View;
use App\Models\Item;


/**
 * Home controller
 *
 * PHP version 7.0
 */
class Landingpage extends Controller
{
    private $items=[];
    private $Item;

    public function __construct($route_params)
    {
        $this->Item = new Item();
    }

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {

        Helper::checkSessionTime();
        Helper::updateSessionTimeout();
        $this->items =  $this->Item->getAllItems();
        foreach ($this->items as $ItemArray){
            foreach ($ItemArray as $key => $value){
                $ItemArray[$key] = filter_var($value,FILTER_SANITIZE_SPECIAL_CHARS);
            }
            $ITEMS[] = $ItemArray;
        }
        View::renderTemplate('landingpage.html', ['Items'=> $ITEMS]);
    }
}
