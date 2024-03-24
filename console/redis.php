<?php

if ($argc < 2) {
    echo "Usage: php redis.php <command>\n";
    exit(1);
}

$vendorShellDir = realpath(__DIR__."/../vendor/Misc/Shell");
include_once "{$vendorShellDir}/Exceptions/AbstractShellException.php";
include_once "{$vendorShellDir}/Exceptions/ShellExecException.php";
include_once "{$vendorShellDir}/ShellExec.php";
include_once "{$vendorShellDir}/ShellRequest.php";
include_once "{$vendorShellDir}/ShellResponse.php";

$config = include "{$vendorShellDir}/config/shell-client.php";

use Misc\Shell\{
    ShellRequest,
    ShellResponse,
};

const KEY_ENV = "dev";
if (!$config = $config[KEY_ENV])
    die("No config");

$shellRequest = ShellRequest::getInstance();
$shellResponse = ShellResponse::getInstance();

$bearerToken = $shellResponse->getTokenFromCache(KEY_ENV);
if (!$bearerToken) {
    $output = $shellRequest->getAuthTokenByCurl($config["auth"]);
    $bearerToken = $shellResponse->getTokenFromOutput($output);
    $shellResponse->saveTokenInCache($bearerToken, KEY_ENV);
}

if (!$bearerToken = $shellResponse->getTokenFromCache(KEY_ENV))
    exit("redis.php: empty auth token");

$output = $shellRequest->postRawByCurl([
    "url" => $config["redis"]["url"],
    "bearerToken" => $bearerToken,
    "sectoken" => $config["redis"]["sectoken"] ?? "",
    "action" => $argv[1] ?? "",
    "pattern" => $argv[2] ?? "",
]);

$shellResponse->printRawOutput($output);