<?php


class Product{

    //Array wird später durch Datenbankzugriff ersetzt - Gibt alle Produkte aus der DB zurück

    public static $products = array(
        array("name"=>"Staubsauger", "description"=>"Super Staubsauger"),
        array("name"=>"Staubsaugerbeutel", "description"=>"Super Staubsaugerbeutel"),
        array("name"=>"Staubsaugerduft", "description"=>"Super Staubsauger-Anti-Stink")
    );

    public static function getProducts(){
        return self::$products;
    }

    //Mit angebe der Produkt-ID wird ein bestimmtes Produkt aus der DB geholt
/*
    public static function getProduct($id){
        if(array_key_exists($id, $this->products)){
            return self::$products[$id];
        }else{
            return null;
        }

    }
*/
}