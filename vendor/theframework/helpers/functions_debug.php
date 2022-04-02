<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.5.1
 * @file functions_debug.php 
 * @date 20-04-2017 17:57 (SPAIN)
 * @observations: Functions to print variables
 * @requires functions_string.php 1.0.2
 *  load:9
 */
//pr(__FILE__);// /var/www/wwwtheframework/the_framework/functions/functions_debug.php
//<editor-fold defaultstate="collapsed" desc="redundantes en index.php">
//hago esta comprobación para los casos en que theframework se use como mochila
if(!function_exists("errorson"))
{
    //error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
    function errorson($sType="all")
    {
        error_reporting(0);  
        ini_set("error_log",dirname(dirname(__FILE__))."/errorson.log");
        ini_set("display_errors",1);
        switch ($sType) 
        {
            case "e":
            case "error":
                error_reporting(E_ERROR);
            break;

            case "w":
            case "warning":
                error_reporting(E_WARNING);
            break;

            case "p":
            case "parse":
                error_reporting(E_PARSE);
            break;

            case "n":
            case "notice":
                error_reporting(E_NOTICE);
            break;

            case "a":
            case "all":
                error_reporting(E_ALL);
            break;
        
            //no
            default:
                //desactivar toda notificación de error
                error_reporting(0);                
                ini_set("display_errors",0);
            break;
        }
    }//errorson
}

if(!function_exists("pr"))
{
    function pr($var="",$sTitle=NULL)
    {
        if($sTitle)
            $sTitle=" $sTitle: ";

        if(!is_string($var))
            $var = var_export($var,TRUE);
        #F1E087
        $sTagPre = "<pre function=\"pr\" style=\"border:1px solid black;background:yellow; padding:0px; color:black; font-size:12px;\">\n";
        $sTagFinPre = "</pre>\n";    
        echo $sTagPre.$sTitle.$var.$sTagFinPre;
    }//function pr    
}

if(!function_exists("lg"))
{
    function lg($var="",$sTitle=NULL)
    {
        $sNow = date("Y-m-d_H:i:s");
        if($sTitle) $sTitle = "<<  $sTitle >>";
        $sTitle = PHP_EOL."$sNow: $sTitle";
        if(!is_string($var)) $var = var_export($var,1);
        if($var) $var = PHP_EOL.$var.PHP_EOL;
        $var = $sTitle.$var;

        $sPathFile = "";
        if(defined("TFW_PATH_FOLDER_LOG")) 
            $sPathFile .= TFW_PATH_FOLDER_LOG.TFW_DS."custom".TFW_DS;
        $sPathFile .= "tfwlog.log";

        $oCursor=fopen($sPathFile,"ab");
        $mxWritten = fwrite($oCursor,$var);
        if($mxWritten===false)
            fclose($oCursor);
        fclose($oCursor);
    }//funtion lg    
}
//</editor-fold>

function bug($var, $sVarName="var", $isDie=false)
{
    if(IS_DEBUG_ALLOWED || 
       (isset($_SESSION["tfw_user_identificator"]) && ($_SESSION["tfw_user_identificator"]==-10 || $_SESSION["tfw_user_identificator"]==1)))
    {    
        if(is_string($var))
        {
            $isSQL = false;
            $arSQLWords = array("select","from","inner join","insert into","update","delete");
            $sTmpVar = strtolower($var);
            foreach($arSQLWords as $sWord)
                //var_dump("word:$sWord, string:$sTmpVar",strpos($sWord,$sTmpVar));
                if(strpos($sTmpVar,$sWord)!==false){$isSQL=true; break;}

            //var_dump($isSQL);
            if($isSQL)
            {
                if(!strpos($var,"\nFROM"));
                    $var = str_replace("FROM","\nFROM",$var);
                if(!strpos($var,"\nINNER"));
                    $var = str_replace("INNER","\nINNER",$var);
                if(!strpos($var,"\nLEFT"));
                    $var = str_replace("LEFT","\nLEFT",$var);
                if(!strpos($var,"\nRIGHT"));
                    $var = str_replace("RIGHT","\nRIGHT",$var);
                if(!strpos($var,"\nWHERE"));
                    $var = str_replace("WHERE","\nWHERE",$var);
                if(!strpos($var,"\nAND"));
                    $var = str_replace("AND","\nAND",$var);
                if(!strpos($var,"\nORDER BY"));
                    $var = str_replace("ORDER BY","\nORDER BY",$var);
            }
        }
        $sTagPre = "<pre function=\"bug\" style=\"background:#CDE552; padding:0px; color:black; font-size:12px;\">\n";
        $sTagFinPre = "</pre>\n";
        $nombreVariable = $sTagPre ."VARIABLE <b>$sVarName</b>:";
        $nombreVariable .= $sTagFinPre;
        echo $nombreVariable;
        echo  "<pre style=\" background:#E2EDA8; font-size:12px; padding-left:10px; text-align:left; color:black; font-weight:normal; font-family: \'Courier New\', Courier, monospace !important;\">\n";
        var_dump($var);
        echo  "</pre>";

        if($isDie)die;  
    }
}//bug()

function bugpf($sKey)
{
    if($sKey=="")
    {
        $arPG = array();
        $arPG["FILES"] = $_FILES;
        bug($arPG,"FILES");
    }
    else
        bug($_FILES[$sKey],"\$_FILES[$sKey]");      
}//bugpf

function bugfileipath($sFilePath,$isDie=false)
{
    //if(is_firstchar($sFilePath,"/")||is_firstchar($sFilePath,"\\"))
        //remove_firstchar($sFilePath);
    //$sFilePath = DIRECTORY_SEPARATOR.$sFilePath;        
    
    $arPaths = explode(PATH_SEPARATOR,get_include_path());
    foreach($arPaths as $sDirPath)
    {
        $sTmpPath = $sDirPath.$sFilePath;
        //echo $sTmpPath."<br>";
        if(file_exists($sTmpPath))
        {    
            bug(TRUE,$sTmpPath,$isDie);
            return;
        }
    }
    bug(FALSE,$sFilePath,$isDie);
}//bugfileipath

function bugfile($sFilePath,$sVarName="", $isDie=false)
{
    if(!$sVarName) $sVarName = $sFilePath;
    bug(is_file($sFilePath),$sVarName,$isDie);
}//bugfile

function bugdir($sDirPath,$sVarName="var", $isDie=false)
{
    bug(is_dir($sDirPath),$sVarName,$isDie);
}//bugdir

function bugpg($sTitle="")
{
    $arPG = array();
    $arPG["POST"] = $_POST;
    $arPG["GET"] = $_GET;
    $arPG["FILES"] = $_FILES;
    bug($arPG,"$sTitle POST | GET | FILES");
}

function bugp($sKey="")
{
    if($sKey=="")
    {
        $arPG = array();
        $arPG["POST"] = $_POST;
        bug($arPG,"POST");
    }
    else
        bug($_POST[$sKey],"POST[$sKey]");    
}

function bugg($sKey="")
{
    if($sKey=="")
    {
        $arPG = array();
        $arPG["GET"] = $_GET;
        bug($arPG,"GET");    
    }
    else
        bug($_GET[$sKey],"GET[$sKey]");
}

function bugss($sKey="")
{
    if($sKey=="")
    {
        $arPG = array();
        $arPG["session_id()"] = session_id();
        $arPG["SESSION"] = $_SESSION;
        bug($arPG,"SESSION");    
    }
    else
        bug($_SESSION[$sKey],"SESSION[$sKey]");
}

function bugif($sTitle=""){bug(get_included_files(),"$sTitle included_files");}

function bugversion(){phpversion();}

function bugsysinfo()
{
    $sSysInfo = "DS: ".DIRECTORY_SEPARATOR." \n";
    $sSysInfo .= "LIB EXTENSION: ".PHP_SHLIB_SUFFIX." \n";
    $sSysInfo .= "PATH SEPARATOR: ".PATH_SEPARATOR." \n";
    $sSysInfo .= "SERVER OS: ".php_uname("s")." \n";
    //echo  // \
    //echo "- LSUFIX: ".PHP_SHLIB_SUFFIX;    // dll
    //echo "- PATH SEP: ".PATH_SEPARATOR;      // ;
    // 's': Operating system name. eg. FreeBSD.
    //'n': Host name. eg. localhost.example.com. 
    //echo php_uname();
    //echo PHP_OS;
    bug($sSysInfo);
}

/**
 * Bug cookies
 */
function bugck(){bug($_COOKIE,"cookie");}

function bugipath($sTitle=""){ bug(explode(PATH_SEPARATOR,get_include_path().$sTitle),"included path:");}

function bugcond($var,$isCheckCondition)
{
    //var_dump($isCheckCondition);
    if($isCheckCondition)
        bug($var);
    else 
        pr("isCheckCondition = FALSE");
}

function bugraw($var,$sVarName=NULL)
{
    $sReturn = "\n";
    if($sVarName)
        $sReturn .= "$sVarName: \n";

    $sReturn .= var_export($var,1);
    echo $sReturn;
}

function bugf($sKey="")
{
    if($sKey=="")
    {
        $arPG = array();
        $arPG["FILES"] = $_FILES;
        bug($arPG,"FILES");
    }
    else
        bug($_FILES[$sKey],"FILES[$sKey]");    
}

function bugex(Exception $oEx,$sTitle="exception")
{
    bug("code:{$oEx->getCode()},line:{$oEx->getLine()},file:{$oEx->getFile()},previous:{$oEx->getPrevious()}",$sTitle);
}

function bugconst()
{
    $arConsts = [
        "__CLASS__"=>__CLASS__,
        "__DIR__"=>__DIR__,
        "__FILE__"=>__FILE__,
        "__FUNCTION__"=>__FUNCTION__,
        "__LINE__"=>__LINE__,
        "__METHOD__"=>__METHOD__,
        "__METHOD__"=>__METHOD__,
        "__NAMESPACE__"=>__NAMESPACE__,
        "__TRAIT__"=>__TRAIT__,
    ];
    bug($arConsts,"CONSTANTS");
}

function s($sString){echo $sString;}