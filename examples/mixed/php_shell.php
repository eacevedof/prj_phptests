<?php
/**
 * @file: php_shell.php
 * @info: ejecutor de comandos shell
 */
include("vendor/autoload.php");
include "vendor/Misc/Shell/ShellAuth.php";
include "vendor/Misc/Shell/ShellResponse.php";

$config = include "vendor/Misc/Shell/shell-client.php";
use \Misc\Shell\ShellAuth;
use Misc\Shell\ShellResponse;

echo "<pre>";
$output = ShellAuth::getInstance()->getAuthToken(
    $config["dev-normon"]["auth"]
);



print_r($output);