<?php
/**
 * @file: php_di_gmpas.php
 * @info: di googlemaps http://php-di.org/doc/understanding-di.html
 */
include "vendor/autoload.php";
class GoogleMaps
{
    public function getCoordinatesFromAddress($address) {
        // calls Google Maps webservice
    }
}
class OpenStreetMap
{
    public function getCoordinatesFromAddress($address) {
        // calls OpenStreetMap webservice
    }
}

class StoreService
{
    public function getStoreCoordinates($store) {
        $oGmaps = new GoogleMaps();
        // or $oGmaps = GoogleMaps::getInstance() if you use singletons
        return $oGmaps->getCoordinatesFromAddress($store->getAddress());
    }
}

