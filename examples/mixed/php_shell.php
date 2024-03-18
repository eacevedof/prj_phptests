<?php
/**
 * @file: php_shell.php
 * @info: ejecutor de comandos shell
 */
include("vendor/autoload.php");
include "vendor/Misc/shell.php";

use \Misc\Shell;

$shell = Shell::getInstance();
$result = $shell
            ->addCmd("ls -lat")
            ->addCmd("")
            ->exec()
;
foreach ($result["output"] as $output)
    echo $output;