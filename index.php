<?php
/**
 * index.php 3.0.0
 */
function addto_incpath($sPath)
{
    if(is_dir($sPath))
    {
        $arPaths = explode(PATH_SEPARATOR,get_include_path());
        $arPaths[] = $sPath;
        $arPaths = array_unique($arPaths);
        $sPathInclude = implode(PATH_SEPARATOR,$arPaths);
        set_include_path($sPathInclude);
    }
    else
        echo "<pre> not a dir <b>: $sPath";
}

define("DS",DIRECTORY_SEPARATOR);
define("TFW_DOCROOT",$_SERVER["DOCUMENT_ROOT"]);
define("TFW_DOCROOTDS",TFW_DOCROOT.DS);

$arPaths["examples"] = TFW_DOCROOTDS."examples".DS;
$arPaths["components"] = TFW_DOCROOTDS."examples".DS."components";
$arPaths["helpers"] = TFW_DOCROOTDS."examples".DS."helpers";
$arPaths["mixed"] = TFW_DOCROOTDS."examples".DS."mixed";

$arPaths = array_map(function($sPath){
    return realpath($sPath);
},$arPaths);

foreach($arPaths as $sPath)
    addto_incpath($sPath);

if(!$_GET)
{

    $arExamples["components"] = array_filter(scandir($arPaths["components"]),function($sFileName){
        return !in_array($sFileName,[".",".."]) && strstr($sFileName,".php");
    });
    $arExamples["components"]["path"] = $arPaths["components"];
    $arExamples["helpers"] = array_filter(scandir($arPaths["helpers"]),function($sFileName){
        return !in_array($sFileName,[".",".."]) && strstr($sFileName,".php");
    });   
    $arExamples["helpers"]["path"] = $arPaths["helpers"];
    $arExamples["mixed"] = array_filter(scandir($arPaths["mixed"]),function($sFileName){
        return !in_array($sFileName,[".",".."]) && strstr($sFileName,".php");
    });
    $arExamples["mixed"]["path"] = $arPaths["mixed"];
    //var_dump($arExamples);
    
    $sLast = "";
    $arHtml = "";
    foreach($arExamples as $sType=>$arExample)
    {
        if($sLast!=$sType)
            
 
    }

}
