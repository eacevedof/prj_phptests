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
            ->addCmd("pwd;")
            ->addCmd("cd ../../;")
            ->addCmd("ls -lat")
            ->addCmd("| grep dr")
            ->exec()
;

echo "<pre>";
echo $result["result_code"]."<br/>";

foreach ($result["output"] as $output)
    echo "$output<br/>";