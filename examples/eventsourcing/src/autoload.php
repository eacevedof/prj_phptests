<?php
$pathappds = dirname(__FILE__).DIRECTORY_SEPARATOR;
spl_autoload_register(function(string $nsclass) use ($pathappds) {
    //nsclass: App\\Blog\\Infrastructure\\PostController
    $nsclass = str_replace(["App\\","\\"],["","/"], $nsclass);
    $nsclass .= ".php";
    $pathclass = realpath("$pathappds$nsclass");
    if (is_file($pathclass)) include_once($pathclass);
});