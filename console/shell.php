<?php

if ($argc < 2) {
    echo "Usage: php shell.php <param1> <param2> ...\n";
    exit(1);
}

$vendorShellDir = realpath(__DIR__."/../vendor/Misc/Shell");
include_once "{$vendorShellDir}/ShellRequest.php";
include_once "{$vendorShellDir}/ShellResponse.php";
include_once "{$vendorShellDir}/ShellExec.php";
$config = include "{$vendorShellDir}/shell-client.php";

use Misc\Shell\{
    ShellRequest,
    ShellExec,
    ShellResponse
};

const KEY_ENV = "dev-normon";
$config = $config[KEY_ENV];

$request = ShellRequest::getInstance();
$response = ShellResponse::getInstance();

$bearerToken = $response->getTokenFromCache(KEY_ENV);
if (!$bearerToken) {
    $output = $request->getAuthToken($config["auth"]);
    $bearerToken = $response->getTokenFromOutput($output);
    $response->saveTokenInCache($bearerToken, KEY_ENV);
}

if (!$bearerToken = $response->getTokenFromCache(KEY_ENV))
    exit("no token");

$shell = ShellExec::getInstance();
foreach ($argv as $i => $cmd) {
    if ($i === 0) continue;
    $shell->addCmd($cmd);
}

$command = $shell->exec()->getCommand();

$output = $request->postCommand([
    "url" => $config["shell"]["url"],
    "bearerToken" => $bearerToken,
    "sectoken" => $config["shell"]["sectoken"],
    "command" => $command,
]);

$response->printOutput($output);