<?php


class Product
{


    public static function connection()
    {
        $servername = "localhost";
        $username = "Jeder";
        $password = "";
        $dbname = "test";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {
            echo "DB Connection established!";
            return $conn;
        }
    }

    public static function getProducts()
    {
        $products = array();

        $conn = self::connection();
        $sql = "SELECT ID, ItemName, Description, Price, Stock, ImgPath FROM Item";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                print_r($row);
            }
            return $products;
        } else {
            echo "No entries!";
            return -1;
        }

        $conn->close();
    }

    public static function getProduct($id)
    {

        $conn = self::connection();
        $sql = "SELECT ID, ItemName, Description, Price, Stock, ImgPath FROM Item";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                if ($id == $row["ID"]) {
                    return $row;
                } else {
                    echo "Value not found!";
                    return -1;
                }
            }
        }

        $conn->close();
    }

    public static function createProduct($itemName, $description, $price, $stock, $img)
    {

        $conn = self::connection();
        $sql = "INSERT INTO Item (ItemName, Description, Price, Stock, ImgPath)
                VALUES ($itemName, $description, $price, $stock, $img)";

        if ($conn->query($sql) === TRUE) {
            echo "Successful";
            return 1;
        } else {
            echo "FAILURE";
            return -1;
        }

        $conn->close();
    }

    public static function updateProduct($id, $itemName, $description, $price, $stock, $img)
    {

        $conn = self::connection();
        $sql = "UPDATE Item SET ItemName='$itemName', Description='$description', Price='$$price', Stock='$stock', ImgPath='$img' WHERE ID='$id'";

        if ($conn->query($sql) === TRUE) {
            echo "Successful";
            return 1;
        } else {
            echo "FAILURE";
            return -1;
        }

        $conn->close();
    }

    public static function deleteProduct($id)
    {

        $conn = self::connection();
        $sql = "DELETE FROM Item WHERE ID='$id'";

        if ($conn->query($sql) === TRUE) {
            echo "Successful";
            return 1;
        } else {
            echo "FAILURE";
            return -1;
        }

        $conn->close();
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