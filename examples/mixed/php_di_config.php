<?php
/**
 * @file: php_di_config.php
 * @info: container configuration http://php-di.org/doc/container-configuration.html
 */
include "vendor/autoload.php";

class IdentityStore
{
    public function getAddress()
    {
        return "this is an IdentityStore.address | ";
    }
}

interface IfGeolocationService 
{
    public function getCoordinatesFromAddress($address);
}

class GoogleMaps implements IfGeolocationService
{
    public function getCoordinatesFromAddress($address)
    {
        echo "GoogleMaps.getCoordinatesFromAddress: | $address ";
    }
}

class OpenStreetMap implements IfGeolocationService
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
    public function __construct(IfGeolocationService $oIGeoService) {
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

use DI\Container;

$container = new Container();
//se le indica que si hay que inyectar una instancia de I, sea GoogleMaps y no OpenStreetMap
$container->set("IfGeolocationService", DI\create("GoogleMaps"));

$storeservice2 = $container->get("StoreService");
$storeservice2->getStoreCoordinates(new IdentityStore());
