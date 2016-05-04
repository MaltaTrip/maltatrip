<?php
spl_autoload_register(function ($name) {
    include_once '../vendor/emcconville/google-map-polyline-encoding-tool/src/Polyline.php';
    $name = str_replace('maltatrip\\', 'lib\\', $name);
    $filename = '../' . str_replace('\\', '/', $name) . '.php';
    if (file_exists($filename)) {
        include($filename);
    }
});

use maltatrip\api\UserRestHandler as UserRestHandler;
use maltatrip\api\TripRestHandler as TripRestHandler;

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



    case "getLoggedInUser":
        $userRestHandler = new UserRestHandler();
        $userRestHandler->getLoggedInUser();
        break;

    case "loginUser":
        // to handle REST url /user/login/
        $userRestHandler = new UserRestHandler();
        $email = fetchStringPOST('email');
        $password = fetchStringPOST('password');
        $remember = fetchStringPOST('remember');
        $userRestHandler->getLogin($email, $password, $remember);
        break;

    case "registerUser":
        $userRestHandler = new UserRestHandler();
        $name = fetchStringPOST('name');
        $surname = fetchStringPOST('surname');
        $locality = fetchStringPOST('locality');
        $email = fetchStringPOST('email');
        $password = fetchStringPOST('password');

        $userRestHandler->getRegister($name, $surname,$locality,$email, $password);
        break;

    case "updateUser":
        // to handle REST url /user/updateUser/
        $userRestHandler = new UserRestHandler();
        $name = fetchStringPOST('name');
        $surname = fetchStringPOST('surname');
        $locality = fetchStringPOST('locality');
        $email = fetchStringPOST('email');
        $password = fetchStringPOST('password');
        $id = fetchStringPOST('id');
        $userRestHandler->getUpdate($name, $surname,$locality,$email, $password, $id);
        break;

    case "userTrips":
        // to handle REST url /user/updateUser/
        $tripRestHandler = new TripRestHandler();
        $tripRestHandler->getUserTrips();
        break;

    case "checkLoggedIn":
        // to handle REST url /user/loggedin/
        $userRestHandler = new UserRestHandler();
        $userRestHandler->checkLoggedIn();
        break;

    case "logout":
        $userRestHandler = new UserRestHandler();
        $userRestHandler->logout();
        break;
    
    case "createTrip":
        // to handle REST Url /trip/create/
        $tripRestHandler = new TripRestHandler();
        $from = fetchStringPOST('from');
        $to = fetchStringPOST('to');
        $pickupDate = fetchStringPOST('pickup_date');
        $returnDate = fetchStringPOST('return_date');
        $frequency = fetchStringPOST('frequency');
        $nPass = fetchStringPOST('nPass');
        $routeLines = $_POST['routeLines'];
        $tripRestHandler->insertTrip($from, $to, $pickupDate, $returnDate, $frequency, $nPass, $routeLines);
        break;

    case "searchTrip":
        // to handle REST Url /trip/search/
        $tripRestHandler = new TripRestHandler();
        $from = fetchStringPOST('from');
        $to = fetchStringPOST('to');
        $date = fetchStringPOST('pickup_date');
        $routeLines = $_POST['routeLines'];
        $tripRestHandler->searchTrip($from, $to, $date, $routeLines);
        break;

    case "contactDriver":
        // to handle REST Url /trip/contactDriver/<id>
        $tripRestHandler = new TripRestHandler();
        $tripId = fetchStringGET('tripId');
        $from = fetchStringPOST('from');
        $to = fetchStringPOST('to');
        $date = fetchStringPOST('pickup_date');
        $tripRestHandler->getEmailInfo($tripId, $from, $to, $date);
        break;

    case "emailDriver":
        // to handle REST Url /trip/emailDriver/
        $tripRestHandler = new TripRestHandler();
        $emailContent = $_POST['email'];
        $tripRestHandler->emailDriver($emailContent);
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