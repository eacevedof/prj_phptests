<?php

namespace App\Shared\Infrastructure\Kafka;

final class Kafka
{
    public function produce($content, string $title=""): void
    {
        if(!is_string($content)) $content = var_export($content, 1);
        $path = dirname(__FILE__).DIRECTORY_SEPARATOR."kafka.log";
        $final = [];
        if($title) $final[] = $title;
        $final[] = $content;
        file_put_contents($path, implode("\n", $final), FILE_APPEND);
    }
}