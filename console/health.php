<?php

if ($argc < 2) {
    echo "Usage: php health.php <command>\n";
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
    ShellExec,
    ShellResponse,
};

$KEY_ENV = $argv[1];
if (!$config = $config[$KEY_ENV] ?? [])
    die("No config for $KEY_ENV");

$shellRequest = ShellRequest::getInstance();
$shellResponse = ShellResponse::getInstance();

$shell = ShellExec::getInstance();
$shell->addCommand($argv[2]);
$remoteCommand = $shell->getCommand();

$output = $shellRequest->postCommandByCurl([
    "url" => $config["health"]["url"],
    "command" => $remoteCommand,
]);

$shellResponse->printRawOutput($output);