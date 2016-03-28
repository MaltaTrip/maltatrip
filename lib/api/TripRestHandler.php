<?php

namespace maltatrip\api;
use maltatrip\model\Trip as Trip;

class TripRestHandler extends SimpleRest {
    public function insertTrip($from, $to, $pickupDate, $returnDate, $frequency, $nPass, $routeLines) {
        $trip = new Trip();
        $rawData = $trip->createTrip($from, $to, $pickupDate, $returnDate, $frequency, $nPass, json_decode($routeLines));
        if ($rawData <= 0) {
            $rawData = null;
        }
        $this->emitResponse($rawData, 'trip', "Unable to insert trip: $from to $to");
    }

    public function searchTrip($from, $to, $date, $routeLines) {
        $trip = new Trip();
        $rawData = $trip->searchTrip($from, $to, $date, json_decode($routeLines));
        $this->emitResponse($rawData, 'trip', "No trips found");
    }
}