<?php
/**
 * index.php 5.0.0
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

//excluyo los que no quiero mostrar
$arForbidden = ["phpinfo"];

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

//si no es ni archivo ni contenido
if(!(isset($_GET["f"]) || isset($_GET["c"])))
{
    $sLast = "";
    $arHtml = [];
    $arHtml[] = "<h1><a href=\"/\">home</a></h1>";    
    $arHtml[] = "<h2>"
            . "<a href=\"https://github.com/eacevedof/prj_phptests\" target=\"_blank\">"
            . "github repo: prj_phptests</a>"
            . "</h2>";
    
    foreach($arExamples as $sType=>$arExample)
    {
        $arHtml[] = "<h3>examples/$sType:</h3>";
        foreach($arExample as $k=>$sFileName)
        {
            if($k=="path") continue;
            $sFileName = str_replace(".php","",$sFileName);
            $arHtml[] = "<li><a href=\"/?f=$sFileName\" target=\"_blank\">$sFileName</a> "
                    . "<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
                    . "<a href=\"/?c=$sFileName\" target=\"_blank\">$sFileName - content</a></li>";
        }//foreach($arExample)
    }//foreach($arExamples)
    echo implode("\n",$arHtml);
}
//hay parámetro f
elseif(isset($_GET["f"]) || isset($_GET["c"]))
{
    //die("dos");
    $isContent = FALSE;
    if(isset($_GET["f"])) $sF = strtolower(trim($_GET["f"]));       
    if(isset($_GET["c"]))
    {
        $sF = strtolower(trim($_GET["c"]));
        $isContent = TRUE;
    }
    
    $sFile = "$sF.php";
    $sKey = array_search($sFile,$arExamples["components"]);
    $sKey = ($sKey || array_search($sFile,$arExamples["helpers"]));
    $sKey = ($sKey || array_search($sFile,$arExamples["mixed"]));
    if(!$sKey)
    {
        echo "<pre> file not found<b>: $sFile </b> in examples <br/>";
        echo "<a href=\"/\"> home </a>";
        exit();
    }
    elseif(in_array($sF,$arForbidden))
    {
        echo "<pre> file forbidden<b>: $sF </b>";
        echo "<a href=\"/\"> home </a>";
        exit();
    }
    else
    {
        if($isContent)
        {
            $sFileContent = "";
            $sPathFile = $arExamples["components"]["path"].DS.$sFile;
            if(is_file($sPathFile) && !$sFileContent) $sFileContent= $sPathFile;
            $sPathFile = $arExamples["helpers"]["path"].DS.$sFile;
            if(is_file($sPathFile) && !$sFileContent) $sFileContent= $sPathFile;            
            $sPathFile = $arExamples["mixed"]["path"].DS.$sFile;
            if(is_file($sPathFile) && !$sFileContent) $sFileContent= $sPathFile;            
            
            $sContent = file_get_contents($sFileContent);
            echo "<pre>";
            echo htmlentities($sContent);
            
        }
        else
            include($sFile);        
    }
}
