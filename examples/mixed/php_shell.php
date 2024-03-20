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

echo "<pre>";
$output = ShellAuth::getInstance()->getAuthToken(
    $config["dev-normon"]["auth"]
);
$json = json_decode($output[0], true);

print_r($output);