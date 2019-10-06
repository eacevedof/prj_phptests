<?php
/**
 * @file: php_di_definition_monolog.php
 * @info: definitions http://php-di.org/doc/php-definitions.html
 */
include "vendor/autoload.php";
/*
<?php

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// create a log channel
$log = new Logger('name');
$log->pushHandler(new StreamHandler('path/to/your.log', Logger::WARNING));

// add records to the log
$log->warning('Foo');
$log->error('Bar');
*/

//http://php-di.org/doc/autowiring.html
class Database
{
    public function __construct($dbHost, $dbPort)
    {
        // ...
    }

    public function setLogger(LoggerInterface $logger)
    {
        // ...
    }
}

$builder = new \DI\ContainerBuilder();
$definitions = [
    "path.to.your.log" => __DIR__."/tmp/logs/",
    
    //factoria
    "streamhandler" => function(\DI\Container $c){
        return new Monolog\Handler\StreamHandler($c->get("path.to.your.log"),Monolog\Logger::WARNING);
    },

    Monolog\Logger::class => DI\create()            
                ->constructor("nameoflog")
                ->method("pushHandler",DI\get("streamhandler")),
];

$builder->addDefinitions($definitions);
$builder->enableCompilation(__DIR__ . "/tmp/compiled");
$builder->writeProxiesToFile(true, __DIR__ . "/tmp/proxies");

$container = $builder->build();

$oLogger = $container->get("Monolog\Logger");
echo "oLogger<br/>";

print_r($oLogger);

