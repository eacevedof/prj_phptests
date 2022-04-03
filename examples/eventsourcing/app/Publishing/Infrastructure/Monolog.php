<?php

namespace App\Publishing\Infrastructure;

final class Monolog
{
    public function log(string $content, string $title=""): void
    {
        $path = dirname(__FILE__).DIRECTORY_SEPARATOR."monolog.log";
        file_put_contents($path, $content);
    }
}