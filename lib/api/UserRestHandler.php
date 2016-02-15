<?php
namespace maltatrip\api;
use maltatrip\model\User as User;

class UserRestHandler extends SimpleRest {

    public function getUsers() {
        $user = new User();
        $rawData = $user->getAllUsers();
        $this->emitResponse($rawData, 'user', 'No users found');
    }

    public function getUser($userId) {
        $user = new User();
        $rawData = $user->getUser($userId);
        $this->emitResponse($rawData, 'user', "No such user: $userId");
    }

    public function getLogin($email, $password) {
        $user = new User();
        $rawData = $user->getLogin($email, $password);
        $this->emitResponse($rawData, 'user', "Invalid login for: $email");
    }
}