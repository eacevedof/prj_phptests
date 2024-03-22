<?php
namespace Misc\Shell;

include_once "ShellExec.php";
use Misc\Shell\ShellExec;

final class ShellRequest
{
    public static function getInstance(): self
    {
        return new self();
    }

    public function getAuthToken(array $auth): array
    {
        $shelExec = ShellExec::getInstance();
        $jsonRaw = $this->getDataRawJson([
            "email" => $cmdRequest["username"],
            "password" => $cmdRequest["password"],
        ]);
        $shelExec
            ->addCmd("curl -s --location '{$auth["url"]}'")
            ->addCmd("--header 'Content-Type: application/json'")
            ->addCmd("--header 'X-Requested-With: application/xml'")
            ->addCmd("--data-raw '{
                \"email\": \"{$auth["username"]}\",
                \"password\": \"{$auth["password"]}\"
            }'")
        ;
        $shelExec->exec();
        //$shelExec->debugCmds();
        return $shelExec->getOutput();
    }

    public function postCommand(array $cmdRequest): array
    {
        $shelExec = ShellExec::getInstance();
        $jsonRaw = $this->getDataRawJson([
            "sectoken" => $cmdRequest["sectoken"],
            "command" => $cmdRequest["command"],
        ]);
        $shelExec
            ->addCmd("curl -s --location '{$cmdRequest["url"]}'")
            ->addCmd("--header 'Content-Type: application/json'")
            ->addCmd("--header 'Authorization: Bearer {$cmdRequest["bearerToken"]}'")
            ->addCmd("--data-raw '$jsonRaw'")
        ;
        $shelExec->exec();
        //$shelExec->debugCmds();
        return $shelExec->getOutput();
    }

    private function getDataRawJson(array $dataRaw): string
    {
        return json_encode($dataRaw, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
    }
}
