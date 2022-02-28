<?php
$thisdir = __DIR__;
$allpaths = [];

function d($var, $title="")
{
    $content = var_export($var,1);
    echo "<b>$title</b><pre>$content</pre>";
}

function dd($var, $title="")
{
    $content = var_export($var,1);
    echo "<b>$title</b><pre>$content</pre>";
    die;
}

function add_dir($path){
    global $allpaths;

    if (!is_dir($path)) return;
    $files = scandir($path);
    $files = array_filter($files, function($file){
        return !in_array($file, [".","..",".DS_Store"]);
    });
    if (!$files) return;
    //d($files,"to handle in $path");
    foreach($files as $file){
        $fullpath = $path."/".$file;
        if(is_file($fullpath) && $file=="index.html") {
            $allpaths[] = $fullpath;
            continue;
        }

        if(is_dir($fullpath)) add_dir($fullpath);
    }
}

add_dir($thisdir);

$html = [];
$html[] = "<a href=\"https://github.com/USantaTecla-0-general/3-publicaciones/tree/master/USantaTecla\" target=\"_blank\">
            Repositorio USantaTecla-0-general/3-publicaciones
           </a>";

$html[] = "<ol>";
foreach($allpaths as $path) {
    $pathweb = str_replace($thisdir, "", $path);
    $text = str_replace(["/","index.html"], [" ", ""], $pathweb);
    $text = trim($text);
    $html[] = "<li><a href=\"$pathweb\" target=\"_blank\">$text</a></li>";
}
$html[] = "</ol>";

$html[] = "<a href=\"https://github.com/eacevedof/prj_phptests/blob/master/examples/mixed/php_index_master_escuela_it.php\" target=\"_blank\">indexador en php</a>";
echo implode("\n", $html);