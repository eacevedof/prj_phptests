<?php
/**
 * @file: php_di_gmpas.php
 * @info: di googlemaps http://php-di.org/doc/understanding-di.html
 */
include "vendor/autoload.php";
class GoogleMaps_Old
{
    public function getCoordinatesFromAddress($address) {
        // calls Google Maps webservice
    }
}
class OpenStreetMap_Old
{
    public function getCoordinatesFromAddress($address) {
        // calls OpenStreetMap webservice
    }
}

class StoreService_Old
{
    public function getStoreCoordinates($store) {
        $oGmaps = new GoogleMaps();
        // or $oGmaps = GoogleMaps::getInstance() if you use singletons
        return $oGmaps->getCoordinatesFromAddress($store->getAddress());
    }
}

//hay que desacoplar el código anterior
//Paso 1: interfaz
interface InterfaceGeolocationService 
{
    public function getCoordinatesFromAddress($address);
}

class IdentityStore
{
    public function getAddress()
    {
        return "this is an IdentityStore.address | ";
    }
}

class GoogleMaps implements InterfaceGeolocationService
{
    public function getCoordinatesFromAddress($address)
    {
        echo "GoogleMaps.getCoordinatesFromAddress: | $address ";
    }
}

class OpenStreetMap implements InterfaceGeolocationService
{
    public function getCoordinatesFromAddress($address)
    {
        echo "OpenStreetMap.getCoordinatesFromAddress: $address |";
    }    
}

class StoreService
{
    private $oIGeoService;
    
    //$oIGeoService puede ser: GoogleMaps o OpenStreetMap
    public function __construct(InterfaceGeolocationService $oIGeoService) {
        $this->oIGeoService = $oIGeoService;
    }
    
    public function getStoreCoordinates($store)
    {
        return $this->oIGeoService->getCoordinatesFromAddress($store->getAddress());
    }
}

$oGmaps = new GoogleMaps();
$storeservice = new StoreService($oGmaps);
$storeservice->getStoreCoordinates(new IdentityStore());
