<?php
/**
 * Created by PhpStorm.
 * User: Bennet
 * Date: 26/03/2019
 * Time: 22:09
 */



function connectToDb (){
    $filename = '../config/config.ini';
     $dbsettings = parse_ini_file($filename);
     $host = $dbsettings['host'];
     $user = $dbsettings['user'];
     $password = $dbsettings['password'];

    try {
        $conn = new PDO("mysql:host=$host", $user, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected successfully";
    }
    catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }



}
