<?php
/**
 *
 * curl async
 */

use Misc\Shell\Curl;
$curl = Curl::getInstance();
$curl
    ->setLogPath(__DIR__."/../../logs/debug")
    ->addFlag("s")
    //->setLocation("http://localhost:8080")
    ->setLocation("https://json.theframework.es/index.php?getfile=app_costumer.json")
    ->addHeader("Content-Type", "application/json")
    ->addDataRaw("name", "dimail")
    ->execAsync()
    ->printCurl()
;