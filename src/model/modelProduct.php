<?php


class Product{

    //Array wird später durch Datenbankzugriff ersetzt - Gibt alle Produkte aus der DB zurück

    public static $products = array(
        array("id"=>0 ,"name"=>"Staubsauger", "description"=>"Super Staubsauger"),
        array("id"=>1 ,"name"=>"Staubsaugerbeutel", "description"=>"Super Staubsaugerbeutel"),
        array("id"=>2 ,"name"=>"Staubsaugerduft", "description"=>"Super Staubsauger-Anti-Stink")
    );

    public static function getProducts(){
        return self::$products;
    }

    //Mit angebe der Produkt-ID wird ein bestimmtes Produkt aus der DB geholt

    public static function getProduct($id){

        $products = array(
            array("id"=>0 ,"name"=>"Staubsauger", "description"=>"Super Staubsauger"),
            array("id"=>1 ,"name"=>"Staubsaugerbeutel", "description"=>"Super Staubsaugerbeutel"),
            array("id"=>2 ,"name"=>"Staubsaugerduft", "description"=>"Super Staubsauger-Anti-Stink")
        );

        if(array_key_exists((int)$id, $products)){
            return self::$products[$id];
        }else{
            return null;
        }

    }

}
