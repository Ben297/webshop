<?php


namespace App\Controllers;


use Core\Controller;
use Core\View;

class Detailpage extends Controller
{
    public $item=[];

    public function ShowDetail()
    {
        print_r($id = $this->route_params['id']);
        View::renderTemplate('detailpage.html',['test' => $id]);
    }


}