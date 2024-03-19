<?php
namespace Misc\Shell;

include_once "ShellExec.php";
use Misc\Shell\ShellExec;

final class ShellAuth
{
    private array $commands = [];

    public static function getInstance(): self
    {
        return new self();
    }

    public function getAuthToken(array $auth): array
    {
        $shelExec = ShellExec::getInstance();
        $shelExec
            ->addCmd("curl --location '{$auth["url"]}'")
            ->addCmd("--header 'Content-Type: application/json'")
            ->addCmd("--header 'X-Requested-With: application/xml'")
            ->addCmd("--data-raw {
                \"email\": \"{$auth["username"]}\",
                \"password\": \"{$auth["password"]}\"
            }")
        ;
        $shelExec->exec();
        $shelExec->debugCmds();
        return $shelExec->output();
    }
}