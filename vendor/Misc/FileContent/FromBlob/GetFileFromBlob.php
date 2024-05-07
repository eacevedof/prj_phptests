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
        $urlOk = "https://resources.theframework.es/eduardoaf.com/20200906/095050-logo-eduardoafcom_500.png";
        $urlBlob = "https://laciahubmassfileupload.blob.core.windows.net/miarco/26672%20barcode.gif?sp=racwdl&st=2024-04-30T07:00:00Z&se=2024-05-30T07:00:00Z&spr=https&sv=2022-11-02&sr=c&sig=4XihdXy6bdLL8Uz%2Fubh9%2BP49oi828tFW6Q8123HXVaQ%3D";
        
        $content = file_get_contents($urlBlob);
        bug($content,"content");
        file_put_contents("./upload/some-file.gif", $content);

        bug("done: $urlBlob");
    }

    public function withRedirect()
    {
        $url = "https://drive.google.com/file/d/1lP8sQ6I-r0C9W0Vn53RWtxopIj9OQwDo/view?usp=drive_link";

        $context = stream_context_create([
            "http" => [
                "follow_location" => false // Disable automatic redirection
            ]
        ]);

        $content = file_get_contents($url, false, $context);
        $metaData = stream_get_meta_data($context);

        $finalUrl = null;
        foreach ($metaData["wrapper_data"] as $header) {
            if (strpos($header, "Location: ") === 0) {
                $finalUrl = trim(substr($header, strlen("Location: ")));
                break;
            }
        }
        bug("final url: $finalUrl");
        //echo "Final URL: $finalUrl";
    }
}