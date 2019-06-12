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
}