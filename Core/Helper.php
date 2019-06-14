<?php
namespace Core;

class Helper
{
    public static function checkCSRF()
    {
        if (!empty($_POST['csrf_token']))
            if (hash_equals($_SESSION['csrf_token'], $_POST['csrf_token']))
                return true;
            else
                return false;
        else
            return false;
    }

    public static function updateSessionTimeout()
    {
        $_SESSION['LAST_ACTIVITY'] = $_SERVER['REQUEST_TIME'];
    }

    public static function checkSessionTime()
    {
        $timeout_duration = 1800;
        if (isset($_SESSION['LAST_ACTIVITY']) &&
            ($_SERVER['REQUEST_TIME'] - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
            session_unset();
            session_destroy();
            session_start();
            header('Location: http://localhost/showSessionexpired');
            //View::renderTemplate('sessionexpired.html');
        }
    }
}
