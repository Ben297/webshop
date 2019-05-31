<?php

class Session {

    public static function csrf()
    {
        if (empty($_SESSION['csrf'])) {
            $strongCrypto = true;
            $_SESSION['csrf'] = md5(openssl_random_pseudo_bytes(32, $strongCrypto));
        }
        return $_SESSION['csrf'];
    }

    private static $_sessionStarted = false;

    public static function init() {
        if (self::$_sessionStarted == false) {
            session_start();
            self::$_sessionStarted = true;
        }
    }

    public static function set($key, $value) {
        return $_SESSION[SESSION_PREFIX . $key] = $value;
    }

    public static function get($key, $secondkey = false) {
        if ($secondkey == true) {
            if (isset($_SESSION[SESSION_PREFIX . $key][$secondkey])) {
                return $_SESSION[SESSION_PREFIX . $key][$secondkey];
            }
        } else {
            if (isset($_SESSION[SESSION_PREFIX . $key])) {
                return $_SESSION[SESSION_PREFIX . $key];
            }
        }
        return false;
    }

    public static function display() {
        return $_SESSION;
    }

    public static function clear($key) {
        unset($_SESSION[SESSION_PREFIX . $key]);
    }

    public static function destroy() {
        if (self::$_sessionStarted == true) {
            session_unset();
            session_destroy();
        }
    }

}
