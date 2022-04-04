<?php

namespace App\Blog\Infrastructure;

final class Monolog
{
    public function log(string $content, string $title=""): void
    {
        $path = dirname(__FILE__).DIRECTORY_SEPARATOR."monolog.log";
        $final = [
            "",
            date("Y-m-d H:i:s"),
            $title,
            $content
        ];
        file_put_contents($path, implode("\n", $final));
    }
}