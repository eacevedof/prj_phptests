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
            ->addCmd("git --version;")
            ->addCmd("pwd;")
            ->addCmd("ls -lat")
            ->addCmd("| grep dr")
            ->exec()
;
foreach ($result["output"] as $output)
    echo "$output<br/>";