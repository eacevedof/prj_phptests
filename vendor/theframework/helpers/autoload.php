<?php
//autoload.php 2.0.0
$sPathRoot = dirname(__FILE__);
if(!defined("IS_DEBUG_ALLOWED"))define("IS_DEBUG_ALLOWED",1);
include_once("functions_debug.php");

$sPathInclude = get_include_path().PATH_SEPARATOR.$sPathRoot;
set_include_path($sPathInclude);
//pr(get_include_path(),"sPathInclude");//die;
spl_autoload_register(function($sNameSpacePath)
{
    //si se utiliza algo como: use Theframework\Helpers\HelperDiv
    if(strstr($sNameSpacePath,"TheFramework\Helpers"))
    {
        pr($sNameSpacePath,"classname");//DIE;
        include("array_helpers.php");
        $arExplode = explode("\\",$sNameSpacePath);
        //pr($arExplode,"arExplode");
        $sClassName = (isset($arExplode[2])?$arExplode[2]:$arExplode[0]);

        //bug($sNameSpacePath,"classname to include");
        if(isset($arHelpers[$sClassName]))
        {
            $sFileName = $arHelpers[$sClassName].".php";
            pr("file to include: $sFileName");
            include_once($sFileName);
            //bug($isIncluded,"isIncluded:$sFileName");
        }
        else
        {
            pr("theframework.helpers.autoload: $sNameSpacePath");
            die();
        }
    }
});//spl_autoload_register

