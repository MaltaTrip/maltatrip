<?php

namespace maltatrip;

use PDO;

class User {
    private $_conn;

    public function __construct()
    {
        $this->_conn = DBConnect::getConnection();
    }

    public function getAllUsers() {
        $st = $this->_conn->getHandler()->prepare("SELECT * FROM user");
        $st->execute();
        return $st->fetchAll(PDO::FETCH_OBJ);
    }

    public function getUser($userId) {
        $st = $this->_conn->getHandler()->prepare("SELECT * FROM user WHERE user.id = :id");
        $st->bindParam(':id', $userId);
        $st->execute();
        return $st->fetch(PDO::FETCH_OBJ);
    }
}