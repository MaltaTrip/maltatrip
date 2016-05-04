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

    public function getEmailInfo($tripId, $from, $to, $date) {
        $trip = new Trip();
        $rawData = $trip->getEmailInfo($tripId, $from, $to, $date);
        $this->emitResponse($rawData, 'trip', 'No such trip');
    }

    public function emailDriver($emailContent) {
        $email = json_decode($emailContent);
        $headers = 'From: webmaster@maltatrip.net' . "\r\n" .
            "Reply-To: $email->from" . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
        mail($email->to, $email->subject, $email->body, $headers);
        $this->emitResponse("OK", "trip", "Could not send email");
    }

    public function getUserTrips() {
        $email = SessionHandler::getSessionValue('email');
        $trip = new Trip();
        $rawData = $trip->getUserTrips($email);

        $this->emitResponse($rawData, 'trip', "Unable to get trip info " );
    }
}