<?php
namespace maltatrip\model;

use maltatrip\api\SessionHandler;
use PDO;
use Polyline;

class Trip {
    private $_conn;

    public function __construct() {
        $this->_conn = DBConnect::getConnection();
    }

    public function getUserTrips($email) {
        $st = $this->_conn->getHandler()->prepare("SELECT * FROM Trip where user=:u");
        $st->bindParam(':u', $email);
        $st->execute();
        return $st->fetchAll(PDO::FETCH_OBJ);
    }

    public function createTrip($from, $to, $pickupDate, $returnDate, $frequency, $nPass, $routeLines) {
        $st = $this->_conn->getHandler()->prepare("INSERT INTO Trip 
                  (fromPlace, toPlace, pickupDate, returnDate, frequency, nPass, user) VALUES 
                  (:fromPlace, :toPlace, :pickupDate, :returnDate, :frequency, :nPass, :user)");
        $st->bindParam(':fromPlace', $from);
        $st->bindParam(':toPlace', $to);
        $st->bindParam(':pickupDate', $pickupDate);
        $st->bindParam(':returnDate', $returnDate);
        $st->bindParam(':frequency', $frequency);
        $st->bindParam(':nPass', $nPass);
        $userEmail = SessionHandler::getSessionValue('email');
        $st->bindParam(':user', $userEmail);
        $st->execute();

        $tripId = $this->_conn->getHandler()->lastInsertId();
        $this->addTripRoute($tripId, $routeLines);

        return $st->rowCount();
    }

    private function addTripRoute($tripId, $routeLines) {
        $query = "INSERT INTO TripRoute (tripId, encodedLatLng) VALUES ";
        for ($i=0; $i<count($routeLines); $i++) {
            $query .= $i==0?"":",";
            $query .= " (:trip$i, :encodedLatLng$i) ";
        }

        $st = $this->_conn->getHandler()->prepare($query);
        for ($i=0; $i<count($routeLines); $i++) {
            $st->bindParam(":trip$i", $tripId);
            $st->bindParam(":encodedLatLng$i", $routeLines[$i]);
        }

        $st->execute();
    }

    public function searchTrip($from, $to, $date, $routeLines) {
        $startLoc = $routeLines[0];
        $endLoc = $routeLines[count($routeLines)-1];

        $st = $this->_conn->getHandler()->prepare("
        SELECT
            Trip.id, Trip.fromPlace, Trip.toPlace, Trip.pickupDate, Trip.returnDate, Trip.frequency, Trip.nPass, TripRoute.encodedLatLng,
            CONCAT(User.name, ' ',User.surname) AS 'driver', User.email AS 'driverEmail'
        FROM
            Trip
            JOIN TripRoute ON TripRoute.tripId = Trip.id 
            JOIN User ON User.email = Trip.user 
        WHERE
            DATE(Trip.pickupDate) = :pickup OR DATE(Trip.returnDate) = :pickup");
        $st->bindParam(':pickup', $date);
        $st->execute();
        $tripsToday = $st->fetchAll(PDO::FETCH_OBJ);
        $processedTrips = [];
        $tripsDone = [];
        foreach ($tripsToday as $tripToday) {
            if (!in_array($tripToday->id, $tripsDone)) {
                array_push($tripsDone, $tripToday->id);
                $processedTrip = new \stdClass();
                $processedTrip->id = $tripToday->id;
                $processedTrip->fromPlace = $tripToday->fromPlace;
                $processedTrip->toPlace = $tripToday->toPlace;
                $processedTrip->pickupDate = $tripToday->pickupDate;
                $processedTrip->returnDate = $tripToday->returnDate;
                $processedTrip->frequency = $tripToday->frequency;
                $processedTrip->nPass = $tripToday->nPass;
                $processedTrip->driver = $tripToday->driver;
                $processedTrip->driverEmail = $tripToday->driverEmail;
                $processedTrip->routes = [];
                foreach($tripsToday as $route) {
                    if ($route->id == $processedTrip->id) {
                        array_push($processedTrip->routes, $route->encodedLatLng);
                    }
                }
                array_push($processedTrips, $processedTrip);
            }
        }

        return $this->getIntersectingTrips($processedTrips, $startLoc, $endLoc);
    }

    private function getIntersectingTrips($tripsToday, $startLoc, $endLoc) {
        $startPoints = Polyline::Pair(Polyline::Decode($startLoc));
        $endPoints = Polyline::Pair(Polyline::Decode($endLoc));
        $intersectingTrips = [];
        foreach ($tripsToday as $trip) {
            $startMatch = false;
            $endMatch = false;
            //For each trip
            $tripRoutes = $trip->routes;
            foreach($tripRoutes as $tripRoute) {
                //For each road in that trip
                $routePoints = Polyline::Pair(Polyline::Decode($tripRoute));
                foreach($routePoints as $point) {
                    //For each point on that road
                    foreach($startPoints as $startPoint) {
                        if ($this->trunc($startPoint[0]) == $this->trunc($point[0]) && $this->trunc($startPoint[1]) == $this->trunc($point[1])) {
                            $startMatch = true;
                        }
                    }
                    foreach ($endPoints as $endPoint) {
                        if ($this->trunc($endPoint[0]) == $this->trunc($point[0]) && $this->trunc($endPoint[1]) == $this->trunc($point[1])) {
                            $endMatch = true;
                        }
                    }
                }
            }
            if ($startMatch && $endMatch) {
                array_push($intersectingTrips, $trip);
            }
        }
        return $intersectingTrips;
    }

    public function getEmailInfo($tripId, $from, $to, $date) {
        $st = $this->_conn->getHandler()->prepare("
        SELECT 
            Trip.fromPlace, Trip.toPlace, Trip.pickupDate, Trip.returnDate,
            User.email, User.name
        FROM
            Trip 
            JOIN User ON User.email = Trip.user
        WHERE
            Trip.id = :tripId");
        $st->bindParam(':tripId', $tripId);
        $st->execute();
        $tripInfo = $st->fetch(PDO::FETCH_OBJ);

        $st2 = $this->_conn->getHandler()->prepare("
        SELECT User.name, User.surname, User.email FROM User WHERE User.email = :userEmail");
        $userEmail = SessionHandler::getSessionValue('email');
        $st2->bindParam(':userEmail', $userEmail);
        $st2->execute();
        $userInfo = $st2->fetch(PDO::FETCH_OBJ);

        $emailString = <<<EMAIL
Dear $tripInfo->name,

This is a message from MaltaTrip.

You offered a trip on MaltaTrip from $tripInfo->fromPlace to $tripInfo->toPlace on $tripInfo->pickupDate returning $tripInfo->returnDate.

$userInfo->name $userInfo->surname would like a ride with you from $from to $to on $date.

If you are still available, please reply to this e-mail and confirm details with this user. Remember to arrange a 
pick-up point and a date and time. Giving the person your mobile number may help too, but this is at your 
discretion. 

Regards,

MaltaTrip Team
EMAIL;

        $resObject = new \stdClass();
        $resObject->from = $userInfo->email;
        $resObject->to = $tripInfo->email;
        $resObject->subject = "Ride request from MaltaTrip";
        $resObject->body = $emailString;
        return $resObject;
    }

    private function trunc($value, $precision=2) {
        $value = ( string )$value;

        preg_match( "/(-+)?\d+(\.\d{1,".$precision."})?/" , $value, $matches );

        return $matches[0];
    }
    
}