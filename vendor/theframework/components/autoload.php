<?php
//components autoload
//autoload.php 1.0.0
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
    //Array ( [0] => TheFramework [1] => Components [2] => Db [3] => ComponentMssql )
    $arClass = explode("\\",$sNSClassName);
    $sClassName = end($arClass);
    $sClassName = str_replace("Component","",$sClassName);
    $sClassName = strtolower($sClassName);
    $sClassName = "component_$sClassName.php";
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

