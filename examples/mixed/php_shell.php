<?php
/**
 * @file: php_shell.php
 * @info: ejecutor de comandos shell
 */
include("vendor/autoload.php");
include "vendor/Misc/Shell/ShellAuth.php";

$config = include "vendor/Misc/Shell/shell-client.php";
use \Misc\Shell\ShellAuth;

$output = ShellAuth::getInstance()->getAuthToken(
    $config["a"]["auth"]
);

print_r($output);