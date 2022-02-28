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
$html[] = "<center><a href=\"https://escuela-it-master.eduardoaf.com/\"><b>escuela-it-master.eduardoaf.com</b></a></center>";
$html[] = "<a href=\"https://escuela.it/cursos/curso-fundamentos-del-software/estudiar\" target=\"_blank\">Cusso Fundamentos de Software Escuela It</a>";
$html[] = "<br/><br/>";
$html[] = "<a href=\"https://app.slack.com/client/T02S3KYD464/C02QZ9SPM9D\" target=\"_blank\">Slack Canal</a><br/>";
$html[] = "<hr/>";

$html[] = "<a href=\"https://github.com/USantaTecla-0-general/3-publicaciones/tree/master/USantaTecla\" target=\"_blank\">
            Repositorio USantaTecla-0-general/3-publicaciones
           </a>";
$html[] = "<br/><br/>";
$html[] = "<a href=\"https://github.com/USantaTecla-ed-mpds/0-iteraciones\" target=\"_blank\">
            Repositorio Master en Programación y Diseño Software (mpds)
           </a>";

$html[] = "<ol>";
foreach($allpaths as $path) {
    $pathweb = str_replace($thisdir, "", $path);
    $text = str_replace(["/","index.html"], [" ", ""], $pathweb);
    $text = trim($text);
    $html[] = "<li><a href=\"$pathweb\" target=\"_blank\">$text</a></li>";
}
$html[] = "</ol>";

$html[] = "<a href=\"https://usantateclams-s1j8471.slack.com/join/shared_invite/zt-12mp698rq-WJ~BXNOzcB5kfzFCgv0IzQ#/shared-invite/email\" target=\"_blank\">Slack</a><br/>";
$html[] = "<a href=\"https://github.com/eacevedof/prj_phptests/blob/master/examples/mixed/php_index_master_escuela_it.php\" target=\"_blank\">indexador en php</a><br/>";

echo implode("\n", $html);