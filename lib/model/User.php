<?php

namespace maltatrip\model;

use PDO;

class User {
    private $_conn;

    public function __construct() {
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

    public function getUserByEmail($email) {
        $st = $this->_conn->getHandler()->prepare("SELECT * FROM User WHERE User.email = :email");
        $st->bindParam(':email', $email);
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

    public function updateUser($name,$surname, $locality, $email, $password,$id) {
        $st = $this->_conn->getHandler()->prepare("Update User set name=:n, surname=:s,locality=:l,email=:e,password=:p where userID=:uid");
        $st->bindParam(':n', $name);
        $st->bindParam(':s', $surname);
        $st->bindParam(':l', $locality);
        $st->bindParam(':e', $email);
        $st->bindParam(':p', $password);
        $st->bindParam(':uid', $id);
        $st->execute();
        return $st->rowCount();
    }
}