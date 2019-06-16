<?php

namespace Core;

use App\Configuration\Config;


abstract class Model
{

    private static $pdo;
    protected $dbh;
    /*
     * This function builds the connection to the Database and can be invoked in derived Classes
     * Load Database Credentials from Config File
     */
    protected static function getPdo()
    {
        if (self::$pdo === null) {
            self::$pdo = new \PDO('mysql:host=' . Config::DB_HOST . ';dbname=' . Config::DB_NAME . ';charset=utf8',
                Config::DB_USER, Config::DB_PASSWORD);
        }
        return self::$pdo;
    }
}
