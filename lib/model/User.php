<?php

namespace maltatrip\model;

use PDO;

class User {
    private $_conn;

    public function __construct()
    {
        $this->_conn = DBConnect::getConnection();
    }

    public function getAllUsers() {
        $st = $this->_conn->getHandler()->prepare("SELECT * FROM User");
        $st->execute();
        return $st->fetchAll(PDO::FETCH_OBJ);
    }

    public function getUser($userId) {
        $st = $this->_conn->getHandler()->prepare("SELECT * FROM user WHERE user.id = :id");
        $st->bindParam(':id', $userId);
        $st->execute();
        return $st->fetch(PDO::FETCH_OBJ);
    }

    public function getLogin($email, $password) {
        $st = $this->_conn->getHandler()->prepare("SELECT * FROM User WHERE User.email = :email and User.password= :password");
        $st->bindParam(':email', $email);
        $st->bindParam(':password', $password);
        $st->execute();
        return $st->fetch(PDO::FETCH_OBJ);
    }

    public function insertUser($name,$surname, $locality, $email, $password) {
        $st = $this->_conn->getHandler()->prepare("INSERT INTO User(name,surname,locality,email,password) VALUES (?,?,?,?,?)");
        $st->bindParam(1, $name);
        $st->bindParam(2, $surname);
        $st->bindParam(3, $locality);
        $st->bindParam(4, $email);
        $st->bindParam(5, $password);
        $st->execute();
        return $st->rowCount();
    }
}