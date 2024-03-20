<?php
namespace Misc\Shell;

final class ShellResponse
{
    public static function getInstance(): self
    {
        return new self();
    }

    public function getTokenFromOutput(array $output): string
    {
        if (!$output) return "";
        $response = json_decode($output[0], true);
        return $response["data"]["accessToken"] ?? "";
    }

    public function saveTokenInCache(string $bearerToken, string $fileName): void
    {
        file_put_contents("./cache/$fileName.dat", $bearerToken);
    }

    public function getTokenFromCache(string $fileName): string
    {
        return file_get_contents("./cache/$fileName.dat");
    }
}