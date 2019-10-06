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

$contnbuilder = new \DI\ContainerBuilder();
$contnbuilder->addDefinitions([
    IfGeolocationService::class => DI\create("GoogleMaps")
]);
$contnbuilder->enableCompilation(__DIR__ . "/tmp/compiled");
$contnbuilder->writeProxiesToFile(true, __DIR__ . "/tmp/proxies");
$container = $contnbuilder->build();

$storeservice2 = $container->get("StoreService");
$storeservice2->getStoreCoordinates(new IdentityStore());

/*
Fatal error a causa de: 
    $container->set("IfGeolocationService", DI\create("GoogleMaps"));
Uncaught LogicException: You cannot set a definition at runtime on a compiled container. 
You can either put your definitions in a file, disable compilation 
or ->set() a raw value directly (PHP object, string, int, ...) instead of a PHP-DI definition. 
in /home/vagrant/code/prj_phptests/vendor/php-di/php-di/src/CompiledContainer.php on line 91
*/
