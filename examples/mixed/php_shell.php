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

$bearerToken = ShellResponse::getInstance()->getTokenFromCache("dev-normon");
if (!$bearerToken) {
    $output = ShellAuth::getInstance()->getAuthToken(
        $config["dev-normon"]["auth"]
    );

}
echo "<pre>";
print_r($output);