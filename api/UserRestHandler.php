<?php

namespace maltatrip;

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
}