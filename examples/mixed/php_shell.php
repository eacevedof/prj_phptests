<?php
/**
 * @file: php_shell.php
 * @info: ejecutor de comandos shell
 */
include("vendor/autoload.php");
include "vendor/Misc/Shell/ShellRequest.php";
include "vendor/Misc/Shell/ShellResponse.php";

$config = include "vendor/Misc/Shell/shell-client.php";
use Misc\Shell\ShellRequest;
use Misc\Shell\ShellResponse;

$request = ShellRequest::getInstance();
$response = ShellResponse::getInstance();

const KEY_ENV = "dev-normon";
$config = $config[KEY_ENV];

$bearerToken = $response->getTokenFromCache(KEY_ENV);
if (!$bearerToken) {
    $output = $request->getAuthToken($config["auth"]);
    $bearerToken = $response->getTokenFromOutput($output);
    $response->saveTokenInCache($bearerToken, KEY_ENV);
}

if (!$bearerToken = $response->getTokenFromCache(KEY_ENV))
    exit("no token");

$output = $request->postCommand([
    "url" => $config["shell"]["url"],
    "sectoken" => $config["shell"]["sectoken"],
    "command" => $config["shell"]["command"],
]);

$response->printOutput($output);