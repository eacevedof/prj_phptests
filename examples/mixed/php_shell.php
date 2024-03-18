<?php
/**
 * @file: php_di.php
 * @info: ensayos con el inyector de dependencias php-di 6.0: http://php-di.org/
 */
include("vendor/autoload.php");

use Misc\Shell;

$shell = Shell::getInstance();
$result = $shell
            ->addCmd("ls -lat")
            ->exec()
;

print_r($result);