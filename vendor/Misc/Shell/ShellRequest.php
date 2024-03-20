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
        $shelExec
            ->addCmd("curl --location '{$auth["url"]}'")
            ->addCmd("--header 'Content-Type: application/json'")
            ->addCmd("--header 'X-Requested-With: application/xml'")
            ->addCmd("--data-raw '{
                \"email\": \"{$auth["username"]}\",
                \"password\": \"{$auth["password"]}\"
            }'")
        ;
        $shelExec->exec();
        $shelExec->debugCmds();
        return $shelExec->getOutput();
    }

    public function postCommand(array $cmd): array
    {
        $shelExec = ShellExec::getInstance();
        $shelExec
            ->addCmd("curl --location '{$cmd["url"]}'")
            ->addCmd("--header 'Content-Type: application/json'")
            ->addCmd("--header 'Authorization: Bearer {$cmd["bearerToken"]}'")
            ->addCmd("--data-raw '{
                \"sectoken\": \"{$cmd["sectoken"]}\",
                \"command\": \"{$cmd["command"]}\"
            }'")
        ;
        $shelExec->exec();
        $shelExec->debugCmds();
        return $shelExec->getOutput();
    }
}

/*
curl --location 'http://local-normon.localhost:8100/api/v01/setting/change-notification-and-lang' \
--header 'Content-Type: application/json' \
--header 'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL2xvY2FsLW5vcm1vbi5sb2NhbGhvc3Q6ODEwMC9hcGkvdjAxL2F1dGgvbG9naW4iLCJpYXQiOjE3MTA5NjQ5MjEsImV4cCI6MTcxMDk3MjEyMSwibmJmIjoxNzEwOTY0OTIxLCJqdGkiOiJES0xiNDFDc3d3c2lXQjk5Iiwic3ViIjoiMTU5IiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.Ue5NcXAz7_bUVHmnQc450NUG85nDx4Y-KWbZqflHoo0' \
--header 'Cookie: laravel_session=t2iBWfolsrUDDVSJFBbP4hLabXIzYbF1VVu4QVYb' \
--data-raw '{
    "userEmail": "glluch@lacia.com",
    "emailNotifications": true,
    "employeesSettingLang": "es"
}'
 * */