<?php
/**
 * @file: php_shell.php
 * @info: ejecutor de comandos shell
 */

include "vendor/Misc/Shell/ShellRequest.php";
include "vendor/Misc/Shell/ShellResponse.php";
$config = include "vendor/Misc/Shell/shell-client.php";

use Misc\Shell\ShellRequest;
use Misc\Shell\ShellResponse;

const KEY_ENV = "dev-normon";
$config = $config[KEY_ENV];

$request = ShellRequest::getInstance();
$response = ShellResponse::getInstance();

$bearerToken = $response->getTokenFromCache(KEY_ENV);
if (!$bearerToken) {
    $output = $request->getAuthTokenByCurl($config["auth"]);
    $bearerToken = $response->getTokenFromOutput($output);
    $response->saveTokenInCache($bearerToken, KEY_ENV);
}

if (!$bearerToken = $response->getTokenFromCache(KEY_ENV))
    exit("no token");

$output = $request->postCommandByCurl([
    "url" => $config["shell"]["url"],
    "bearerToken" => $bearerToken,
    "sectoken" => $config["shell"]["sectoken"],
    "command" => "ls -lat",
]);

$response->printOutputHtml($output);