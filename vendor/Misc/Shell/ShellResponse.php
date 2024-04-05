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
        $dir = __DIR__;
        file_put_contents("$dir/cache/$fileName.dat", $bearerToken);
    }

    public function getTokenFromCache(string $fileName): string
    {
        $dir = __DIR__;
        return file_get_contents("$dir/cache/$fileName.dat");
    }

    public function printOutputHtml(array $output): void
    {
        echo "<pre>";
        foreach ($output as $line)
            print_r($line);
    }

    public function printRawOutput(array $output): void
    {
        foreach ($output as $line)
            echo $line.PHP_EOL;
    }

    public function printJsonHealth(array $healthOutput): void
    {
        $now = date("Y-m-d H:i:s");
        foreach ($healthOutput as $line) {
            $arJson = json_decode($line, true);
            $httpCode = $arJson["code"] ?? "no code";
            $message = $arJson["message"] ?? "no message";
            $version = $arJson["data"]["version"] ?? "no version";
            echo "health on {$now}: {$version}" . PHP_EOL;
        }
    }
}