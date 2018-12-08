<?php
//autoload in case you dont use composer require 
//autoload_nc.php 2.0.0
if(!defined("IS_DEBUG_ALLOWED")) define("IS_DEBUG_ALLOWED",1);
include_once("functions_debug.php");


$sPathRoot = dirname(__FILE__);
$sPathInclude = get_include_path().PATH_SEPARATOR.$sPathRoot;
set_include_path($sPathInclude);
//pr(get_include_path(),"sPathInclude");//die;
spl_autoload_register(function($sNameSpacePath)
{
    //bug($sNameSpacePath);
    $sPackage = "TheFramework\\Helpers\\";
    //si es un helper
    if(strstr($sNameSpacePath,$sPackage))
    {
        if(!defined("TFW_DS")) define("TFW_DS",DIRECTORY_SEPARATOR);
        $sPathSrc = dirname(__DIR__).TFW_DS."helpers".TFW_DS."src".TFW_DS;
        $sPathSrc = realpath($sPathSrc);

        $sNsPath = str_replace($sPackage,"",$sNameSpacePath);
        //bug($sNsPath);
        $sNsPath = str_replace("\\",TFW_DS,$sNsPath);

        $sPathClass = $sPathSrc.TFW_DS.$sNsPath.".php";
        //pr($sPathClass,"TO INCLUDE");
        include_once($sPathClass);
    }
});//spl_autoload_register

