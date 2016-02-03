<?php
use maltatrip\UserRestHandler;

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

    case "" :
        //404 - not found;
        break;
}

function fetchStringGET($stringName) {
    return filter_input(INPUT_GET, $stringName, FILTER_SANITIZE_STRING);
}