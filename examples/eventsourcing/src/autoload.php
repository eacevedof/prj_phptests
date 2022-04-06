<?php
$pathappds = dirname(__FILE__);
set_include_path(get_include_path().":".$pathappds);
spl_autoload_register(function(string $nsclass) use ($pathappds) {
    $nsclass = str_replace(["App\\","\\"],["","/"], $nsclass);
    $nsclass .= ".php";
    include_once $nsclass;
});