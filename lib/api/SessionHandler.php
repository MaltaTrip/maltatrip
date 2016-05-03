<?php
namespace maltatrip\api;


class SessionHandler {
    public static function checkSession() {
        if (!isset($_SESSION))
            session_start();
    }

    public static function addToSession($key, $value) {
        self::checkSession();
        $_SESSION[$key] = $value;
        return true;
    }

    public static function isLoggedIn() {
        self::checkSession();
        if ((isset($_SESSION['email']) && $_SESSION['email'] != '') ||
            isset($_COOKIE['MaltaTrip']) && $_COOKIE['MaltaTrip'] != '') {
            return true;
        }
        return false;
    }

    public static function logout(){
        self::checkSession();
        session_destroy();
        if (isset($_COOKIE['MaltaTrip']))  unset($_COOKIE['MaltaTrip']);
        return true;
    }

    public static function getSessionValue($key) {
        self::checkSession();
        return $_SESSION[$key];
    }
}