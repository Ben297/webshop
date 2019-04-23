<?php

class Controller{

    private $request = null;
    private $template = '';

    public function __construct($request){
    $this->request = $request;
    $this->template = !empty($request['view']) ? $request['view'] : 'default';
    }

    public function display(){
        $view = new View();
        switch($this->template){
            case 'entry':
                $view->setTemplate('entry');
                $productid = $this->request['id'];
                $product = Product::getProduct($productid);
                $view->assign('name', $product['name']);
                $view->assign('description', $product['description']);
                break;

            case 'default':
            default:
                $products = Product::getProducts();
                $view->setTemplate('default');
                $view->assign('products', $products);
        }
        return $view->loadTemplate();
    }


}