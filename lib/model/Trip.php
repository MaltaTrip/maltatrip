<?php
namespace maltatrip\model;

use PDO;
use Polyline;

class Trip {
    private $_conn;

    public function __construct() {
        $this->_conn = DBConnect::getConnection();
    }

    public function createTrip($from, $to, $pickupDate, $returnDate, $frequency, $nPass, $routeLines) {
        $st = $this->_conn->getHandler()->prepare("INSERT INTO Trip 
                  (fromPlace, toPlace, pickupDate, returnDate, frequency, nPass) VALUES 
                  (:fromPlace, :toPlace, :pickupDate, :returnDate, :frequency, :nPass)");
        $st->bindParam(':fromPlace', $from);
        $st->bindParam(':toPlace', $to);
        $st->bindParam(':pickupDate', $pickupDate);
        $st->bindParam(':returnDate', $returnDate);
        $st->bindParam(':frequency', $frequency);
        $st->bindParam(':nPass', $nPass);
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
            Trip.id, Trip.fromPlace, Trip.toPlace, Trip.returnDate, Trip.frequency, Trip.nPass, TripRoute.encodedLatLng
        FROM
            Trip
            JOIN TripRoute ON TripRoute.tripId = Trip.id
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
                $processedTrip->returnDate = $tripToday->returnDate;
                $processedTrip->frequency = $tripToday->frequency;
                $processedTrip->nPass = $tripToday->nPass;
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

    private function trunc($value, $precision=2) {
        $value = ( string )$value;

        preg_match( "/(-+)?\d+(\.\d{1,".$precision."})?/" , $value, $matches );

        return $matches[0];
    }
    
}