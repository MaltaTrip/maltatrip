<?php

namespace maltatrip;

use PDO;

class DBConnect {
    private static $_singleton;
    private $_connection;

    private $USER = "root";
    private $PASSWORD = "TriP334_0mm";
    private $HOST = "localhost";
    private $DB_NAME = "maltatrip";
    private $OPTIONS = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    );

    public function __construct() {
        $this->_connection = new PDO(
            "mysql:host=$this->HOST;dbname=$this->DB_NAME",
            $this->USER,
            $this->PASSWORD,
            $this->OPTIONS);
    }

    public function getHandler() {
        return $this->_connection;
    }

    public static function getConnection() {
        if (self::$_singleton == null) {
            self::$_singleton = new DBConnect();
        }
        return self::$_singleton;
    }
}