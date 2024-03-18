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
            ->addCmd("git --versio;")
            ->addCmd("pwd;")
            ->addCmd("ls -lat")
            ->addCmd("| grep dr")
            ->exec()
;
echo $result["result_code"]."<br/>";

foreach ($result["output"] as $output)
    echo "$output<br/>";