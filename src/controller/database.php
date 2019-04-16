<?php
/**
 * Created by PhpStorm.
 * User: Bennet
 * Date: 26/03/2019
 * Time: 22:09
 */
$filename = "../config/config.ini";
$dbsettings = parse_ini_file($filename);
class database {
    // Hold the class instance.
    private static $instance = null;
    private $conn;
    // The db connection is established in the private constructor.
    private function __construct($dbsettings)
    {
        $host= $dbsettings['host'];
        $user = $dbsettings['user'];
        $pass = $dbsettings['password'];

        $this->conn = new PDO("mysql:host=$host", $user,$pass,
            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }

    public static function getInstance($dbsettings)
    {
        if(!self::$instance)
        {
            self::$instance = new database($dbsettings);
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->conn;
    }
}


