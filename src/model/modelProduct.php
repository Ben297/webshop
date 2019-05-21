<?php


class Product{

private $servername = "127.0.0.1";
private $username = "Horst";
private $password = "Horst";

public static function db_connect($servername, $username, $password) {
        try {
            $conn = new PDO("mysql:host=$servername;dbname=myDB", $username, $password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connected successfully";
            return $conn;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }





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