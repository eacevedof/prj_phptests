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
//Paso 1: interfaz, se extrae un mismo comportamiento (método esperado en el cliente) en una interfaz
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

//El cliente, ahora esta acoplado al comportamiento y no al tipo
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

use DI\Container;

$container = new Container();
//se le indica que si hay que inyectar una instancia de I, sea GoogleMaps y no OpenStreetMap
$container->set("InterfaceGeolocationService", DI\create("GoogleMaps"));

$storeservice2 = $container->get("StoreService");
$storeservice2->getStoreCoordinates(new IdentityStore());

/*
error:
( ! ) Fatal error: Uncaught DI\Definition\Exception\InvalidDefinition: Entry "StoreService" cannot be resolved: Entry "InterfaceGeolocationService" cannot be resolved: the class is not instantiable Full definition: Object ( class = #NOT INSTANTIABLE# InterfaceGeolocationService lazy = false ) Full definition: Object ( class = StoreService lazy = false __construct( $oIGeoService = get(InterfaceGeolocationService) ) ) in /home/vagrant/code/prj_phptests/vendor/php-di/php-di/src/Definition/Exception/InvalidDefinition.php on line 18
( ! ) DI\Definition\Exception\InvalidDefinition: Entry "StoreService" cannot be resolved: Entry "InterfaceGeolocationService" cannot be resolved: the class is not instantiable Full definition: Object ( class = #NOT INSTANTIABLE# InterfaceGeolocationService lazy = false ) Full definition: Object ( class = StoreService lazy = false __construct( $oIGeoService = get(InterfaceGeolocationService) ) ) in /home/vagrant/code/prj_phptests/vendor/php-di/php-di/src/Definition/Exception/InvalidDefinition.php on line 18

el ejemplo en la página está mal. Hay que configurar el container antes de llamar a StoreService
*/