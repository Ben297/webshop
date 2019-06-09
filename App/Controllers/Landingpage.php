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
    public $items=[];

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {
        $this->items =  Item::getAllItems();
        print_r($_SESSION);
        View::renderTemplate('landingpage.html', ['Items'=> $this->items]);
    }
}
