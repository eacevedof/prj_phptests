<?php
namespace Misc\FileContent\FromBlob;

final class GetFileFromBlob
{
    public static function getInstance(): self
    {
        return new self();
    }

    public function __invoke()
    {
        $url = "https://laciahubmassfileupload.blob.core.windows.net/miarco/26672%20barcode.gif?sp=racwdl&st=2024-04-30T07:00:00Z&se=2024-05-30T07:00:00Z&spr=https&sv=2022-11-02&sr=c&sig=4XihdXy6bdLL8Uz%2Fubh9%2BP49oi828tFW6Q8123HXVaQ%3D";
        
        $content = file_get_contents($url);
        file_put_contents("./upload/some-file.gif", $content);
    }
}