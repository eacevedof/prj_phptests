<?php
/**
 * @file: php_shell.php
 * @info: ejecutor de comandos shell
 */
include("vendor/autoload.php");

use Misc\Shell;

$shell = Shell::getInstance();
$result = $shell
            ->addCmd("ls -lat")
            ->exec()
;

print_r($result);