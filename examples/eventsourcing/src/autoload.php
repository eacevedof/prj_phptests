<?php
$thispath = dirname(__FILE__);
set_include_path(get_include_path().PATH_SEPARATOR.$thispath);
spl_autoload_register(function(string $pathnsclass) {
    $pathnsclass = str_replace(["App\\","\\"],["","/"], $pathnsclass);
    $pathnsclass .= ".php";
    include_once $pathnsclass;
});