<?php
//autoload.php 1.1.1
$sPathRoot = dirname(__FILE__);
if(!defined("IS_DEBUG_ALLOWED"))define("IS_DEBUG_ALLOWED",1);
include_once("functions_debug.php");

$sPathInclude = get_include_path().PATH_SEPARATOR.$sPathRoot;
set_include_path($sPathInclude);
//pr(get_include_path(),"sPathInclude");//die;
spl_autoload_register(function($sNSClassName)
{
    //pr($sNSClassName,"classname");
    include("array_helpers.php");
    $arExplode = explode("\\",$sNSClassName);
    //pr($arExplode,"arExplode");
    $sClassName = (isset($arExplode[2])?$arExplode[2]:$arExplode[0]);

    //bug($sNSClassName,"classname to include");
    if(isset($arHelpers[$sClassName]))
    {
        $sFileName = $arHelpers[$sClassName].".php";
        //pr("file to include: $sFileName");
        include_once($sFileName);
        //bug($isIncluded,"isIncluded:$sFileName");
    }
    else
    {
        lg("theframework.helpers.autoload: $sNSClassName");
        //pr("theframework.helpers.autoload: $sNSClassName");
        //die();
    }
});//spl_autoload_register

