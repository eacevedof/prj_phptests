<?php
/**
 * @file: php_di_config_monolog.php
 * @info: definitions http://php-di.org/doc/php-definitions.html
 *        Esto sigo sin entenderlo, proxy cuando se define es un objeto muy grande y cuando se 
 *        llama a su método es más pequeño y supuestamente es para ahorrar memoria en la definición
 *          ^^ 
 *        Para usar Lazy y proxy se necesita: composer require ocramius/proxy-manager
 */
include "vendor/autoload.php";

class Foo
{
    //esto se crea en el proxy
    public function doSomething()
    {
    }
}

$builder = new \DI\ContainerBuilder();
$builder->addDefinitions([
    "Foo" => \DI\create()->lazy()
]);
$builder->enableCompilation(__DIR__ . "/tmp/compiled");
$builder->writeProxiesToFile(true, __DIR__ . "/tmp/proxies");
$container = $builder->build();

// $proxy is a Proxy object, it is not initialized
// It is very lightweight in memory
$proxy = $container->get('Foo');
print_r($proxy);
/*
ProxyManagerGeneratedProxy\__PM__\Foo\Generated4fabc338a08ffb0990168fa3109bf950 Object
(
    [valueHolder182f5:ProxyManagerGeneratedProxy\__PM__\Foo\Generated4fabc338a08ffb0990168fa3109bf950:private] => 
    [initializere2e16:ProxyManagerGeneratedProxy\__PM__\Foo\Generated4fabc338a08ffb0990168fa3109bf950:private] => Closure Object
        (
            [static] => Array
                (
                    [definition] => DI\Definition\ObjectDefinition Object
                        (
                            [name:DI\Definition\ObjectDefinition:private] => Foo
                            [className:protected] => 
                            [constructorInjection:protected] => 
                            [propertyInjections:protected] => Array
                                (
                                )

                            [methodInjections:protected] => Array
                                (
                                )

                            [lazy:protected] => 1
                            [classExists:DI\Definition\ObjectDefinition:private] => 1
                            [isInstantiable:DI\Definition\ObjectDefinition:private] => 1
                        )

                    [parameters] => Array
                        (
                        )

                )
*/

echo "<br/> proxy is instance of Foo?:";
echo ($proxy instanceof Foo); // true

// Calling a method on the proxy will initialize it
echo "<br/> calling proxy->doSomething() ... initializing Foo";
// Now the proxy is initialized, the real instance of Foo has been created and called
$proxy->doSomething();
echo "<br/><br/>";
//print_r($proxy);die; 

/*
ProxyManagerGeneratedProxy\__PM__\Foo\Generated4fabc338a08ffb0990168fa3109bf950 Object
(
    [valueHolder182f5:ProxyManagerGeneratedProxy\__PM__\Foo\Generated4fabc338a08ffb0990168fa3109bf950:private] => Foo Object()
    [initializere2e16:ProxyManagerGeneratedProxy\__PM__\Foo\Generated4fabc338a08ffb0990168fa3109bf950:private] => 
)
*/
