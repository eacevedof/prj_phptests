<?php
namespace Misc\Shell;

final class ShellResponse
{
    public static function getInstance(): self
    {
        return new self();
    }

    public function getToken(array $output): string
    {
        if (!$output) return "";
        $response = json_decode($output[0], true);
        return $response["data"]["accessToken"] ?? "";
    }
}