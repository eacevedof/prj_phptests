<?php
//components autoload
//autoload.php 1.0.0
$sPathRoot = dirname(__FILE__);
$sPathInclude = get_include_path().PATH_SEPARATOR.$sPathRoot;
set_include_path($sPathInclude);

spl_autoload_register(function($sNSClassName)
{
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

