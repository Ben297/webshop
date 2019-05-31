<?php

namespace App\Configuration;

class Config
{

    /**
     * Database host
     * @var string
     */
    const DB_HOST = 'localhost';

    /**
     * Database name
     * @var string
     */
    const DB_NAME = 'webshop';

    /**
     * Database user
     * @var string
     */
    const DB_USER = 'Nadine';

    /**
     * Database password
     * @var string
     */
    const DB_PASSWORD = 'bla';

    /**
     * Show or hide error messages on screen
     * @var boolean
     */
    const SHOW_ERRORS = true;
}

//set prefix for sessions
define('SESSION_PREFIX','splendr_');