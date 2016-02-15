<?php

namespace maltatrip\api;

use SimpleXMLElement;

/*
A simple RESTful webservices base class
*/
class SimpleRest {

    private $httpVersion = "HTTP/1.1";

    public function setHttpHeaders($contentType, $statusCode){

        $statusMessage = $this -> getHttpStatusMessage($statusCode);

        header($this->httpVersion. " ". $statusCode ." ". $statusMessage);
        header("Content-Type:". $contentType);
    }

    public function getHttpStatusMessage($statusCode){
        $httpStatus = array(
            100 => 'Continue',
            101 => 'Switching Protocols',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => '(Unused)',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported');
        return ($httpStatus[$statusCode]) ? $httpStatus[$statusCode] : $httpStatus[500];
    }

    public function emitResponse($rawData, $entityName, $errorMessage) {
        if(empty($rawData)) {
            $statusCode = 404;
            $rawData = array('error' => $errorMessage);
        } else {
            $statusCode = 200;
        }

        $requestContentType = $_SERVER['HTTP_ACCEPT'];
        $this->setHttpHeaders($requestContentType, $statusCode);

        if(strpos($requestContentType,'application/json') !== false){
            $response = $this->encodeJson($rawData);
        } else if(strpos($requestContentType,'text/html') !== false){
            $response = $this->encodeHtml($rawData);
        } else if(strpos($requestContentType,'application/xml') !== false){
            $response = $this->encodeXml($rawData, $entityName);
        } else {
            //Default is to echo JSON
            $response = $this->encodeJson($rawData);
        }
        echo $response;
    }

    public function encodeHtml($responseData) {

        $htmlResponse = "<table border='1'>";

        if (!is_scalar($responseData)) {
            foreach($responseData as $key=>$value) {
                $htmlResponse .= "<tr><td>". $key. "</td><td>". $value. "</td></tr>";
            }
        } else {
            $htmlResponse .= "<tr><td>Response</td><td>". $responseData. "</td></tr>";
        }
        $htmlResponse .= "</table>";
        return $htmlResponse;
    }

    public function encodeJson($responseData) {
        $jsonResponse = json_encode($responseData);
        return $jsonResponse;
    }

    public function encodeXml($responseData, $entityName) {
        $xml = new SimpleXMLElement("<?xml version=\"1.0\"?><$entityName></$entityName>");
        if (!is_scalar($responseData)) {
            foreach ($responseData as $key => $value) {
                $xml->addChild($key, $value);
            }
        } else {
            $xml->addChild("Response", $responseData);
        }
        return $xml->asXML();
    }
}