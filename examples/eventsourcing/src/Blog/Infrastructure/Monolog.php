<?php

namespace App\Blog\Infrastructure;

final class Monolog
{
    public function log($content, string $title=""): void
    {
        if(!is_string($content)) $content = var_export($content, 1);
        $path = dirname(__FILE__).DIRECTORY_SEPARATOR."monolog.log";
        $final = [
            "",
            date("Y-m-d H:i:s"),
        ];
        if($title) $final[] = $title;
        $final[] = $content;
        file_put_contents($path, implode("\n", $final), FILE_APPEND);
    }
}