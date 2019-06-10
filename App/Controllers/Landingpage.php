<?php

namespace App\Controllers;

use \Core\View;
use App\Models\Item;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class Landingpage extends \Core\Controller
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
        $this->items =  $this->Item->getAllItems();
        View::renderTemplate('landingpage.html', ['Items'=> $this->items]);
    }
}
