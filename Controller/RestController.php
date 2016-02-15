<?php
spl_autoload_register(function ($name) {
    $name = str_replace('maltatrip\\', 'lib\\', $name);
    $filename = '../' . str_replace('\\', '/', $name) . '.php';
    include($filename);
});

use maltatrip\api\UserRestHandler as UserRestHandler;

if (filter_has_var(INPUT_GET, 'view'))
    $view = filter_input(INPUT_GET, 'view', FILTER_SANITIZE_STRING);

/*
Controls the RESTful services URL mapping
*/
switch($view){

    case "getUsers":
        // to handle REST Url /user/list/
        $userRestHandler = new UserRestHandler();
        $userRestHandler->getUsers();
        break;

    case "getUser":
        // to handle REST Url /user/list/<id>/
        $userRestHandler = new UserRestHandler();
        $userId = fetchStringGET('userId');
        $userRestHandler->getUser($userId);
        break;

    case "loginUser":
        // to handle REST url /user/login/
        $userRestHandler = new UserRestHandler();
        $email = fetchStringPOST('email');
        $password = fetchStringPOST('password');
        $userRestHandler->getLogin($email, $password);
        break;

    case "checkLoggedIn":
        // to handle REST url /user/loggedin/
        $userRestHandler = new UserRestHandler();
        $userRestHandler->checkLoggedIn();
        break;

    case "":
        //404 - not found;
        break;
}

function fetchStringGET($stringName) {
    return filter_input(INPUT_GET, $stringName, FILTER_SANITIZE_STRING);
}

function fetchStringPOST($stringName) {
    return filter_input(INPUT_POST, $stringName, FILTER_SANITIZE_STRING);
}