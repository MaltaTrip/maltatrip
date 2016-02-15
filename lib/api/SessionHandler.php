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
        if (isset($_SESSION['email']) && $_SESSION['email'] != '') {
            return true;
        }
        return false;
    }
}