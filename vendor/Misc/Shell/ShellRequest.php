<?php
namespace Misc\Shell;

use Misc\Shell\ShellExec;

final class ShellRequest
{
    public static function getInstance(): self
    {
        return new self();
    }

    public function getAuthTokenByCurl(array $auth): array
    {
        $shelExec = ShellExec::getInstance();
        $jsonRaw = $this->getDataRawJson([
            "email" => $auth["username"],
            "password" => $auth["password"],
        ]);
        $shelExec
            ->addCommand("curl -s --location '{$auth["url"]}'")
            ->addCommand("--header 'Content-Type: application/json'")
            ->addCommand("--header 'X-Requested-With: application/xml'")
            ->addCommand("--data-raw '
            $jsonRaw
            '")
        ;
        $shelExec->exec();
        //$shelExec->printDebugCommand();
        return $shelExec->getOutput();
    }

    public function postCommandByCurl(array $cmdRequest): array
    {
        $shelExec = ShellExec::getInstance();
        $jsonRaw = $this->getDataRawJson([
            "sectoken" => $cmdRequest["sectoken"],
            "command" => $cmdRequest["command"],
        ]);
        $shelExec
            ->addCommand("curl -s --location '{$cmdRequest["url"]}'")
            ->addCommand("--header 'Content-Type: application/json'")
            ->addCommand("--header 'Authorization: Bearer {$cmdRequest["bearerToken"]}'")
            ->addCommand("--data-raw '
            $jsonRaw
            '")
        ;
        $shelExec->exec();
        //$shelExec->printDebugCommand();
        return $shelExec->getOutput();
    }
    
    public function postRawByCurl(array $postPayload): array
    {
        $shelExec = ShellExec::getInstance();
        $jsonRaw = $this->getDataRawJson($postPayload);
        $shelExec
            ->addCommand("curl -s --location '{$postPayload["url"]}'")
            ->addCommand("--header 'Content-Type: application/json'")
            ->addCommand("--header 'Authorization: Bearer {$postPayload["bearerToken"]}'")
            ->addCommand("--data-raw '
            $jsonRaw
            '")
        ;
        $shelExec->exec();
        //$shelExec->printDebugCommand();
        return $shelExec->getOutput();
    }
    
    public function getGetRequestNoAuth(string $httpUrl): array
    {
        $shelExec = ShellExec::getInstance();
        $shelExec
            ->addCommand("curl -s --location '{$httpUrl}'")
            ->addCommand("--header 'Content-Type: application/json'")
        ;
        $shelExec->exec();
        return $shelExec->getOutput();
    }

    private function getDataRawJson(array $dataRaw): string
    {
        return json_encode(
            $dataRaw,
            JSON_UNESCAPED_UNICODE |
            JSON_UNESCAPED_SLASHES |
            JSON_PRETTY_PRINT
        );
    }
}
