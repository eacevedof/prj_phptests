<?php
//components autoload
//autoload.php 2.0.0
$sPathRoot = dirname(__FILE__).DIRECTORY_SEPARATOR;
//die("sPathRoot: $sPathRoot");//...tests\vendor\theframework\components
$arSubFolders[] = get_include_path();
$arSubFolders[] = $sPathRoot;//ruta de components
//subcarpetas dentro de components
$arSubFolders[] = $sPathRoot."console";
$arSubFolders[] = $sPathRoot."db";
$arSubFolders[] = $sPathRoot."db".DIRECTORY_SEPARATOR."integration";

$sPathInclude = implode(PATH_SEPARATOR,$arSubFolders);
set_include_path($sPathInclude);

spl_autoload_register(function($sNSClassName)
{
    $arClass = explode("\\",$sNSClassName);
    $sClassName = end($arClass);
    $sClassName = preg_replace("/(?<!^)([A-Z])/","_\\1",$sClassName);
    $sClassName = str_replace("Component","",$sClassName);
    $sClassName = strtolower($sClassName);
    //if(strstr($sClassName,"xp"))die($sClassName);
    $sClassName = "component$sClassName.php";
    if(stream_resolve_include_path($sClassName))
        include_once $sClassName;
    elseif(function_exists("lg"))
    {
        lg("Class not found: $sClassName");
    }
    else 
    {
        echo "Class not found: $sClassName";
    }
});//spl_autoload_register

