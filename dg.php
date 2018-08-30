<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name dg 
 * @file dg.php 1.0.0
 * @date 12/08/2018
 * @observations
 *  https://github.com/eacevedof/prj_phptests/blob/master/dg.php
 */
class dg
{
    private static function wlog($mxContent,$sTitle="",$sFileName="")
    {
        $arContent = array();
        $arContent[] = "";//para que salte al principio
        $arContent[] = "-- [".date("H:i:s")."] --";
        //filename:
        if(!$sFileName) $sFileName = "log_".date("Ymd");
        $sFileName .= ".log";
        //dir:
        $sPath = __DIR__."/logs/";
        if(!is_dir($sPath)) $sPath = $_SERVER["DOCUMENT_ROOT"]."/logs/";
        if(!is_dir($sPath)) mkdir($sPath,0777);
        if(!is_dir($sPath)) $sPath = __DIR__."/";
        
        //fullpath:
        $sPathlog = $sPath.$sFileName;
        
        //content:
        if(trim($sTitle)!="") $arContent[]=$sTitle;
        $arContent[] = var_export($mxContent,1);
        
        $sContent = implode("\n",$arContent);
        //file_put_contents($sPathlog,$sContent);
        $oFopen = fopen($sPathlog,"a");
        fwrite($oFopen,$sContent);
        fclose($oFopen);
    }//wlog
    
    public static function p($var,$varname="")
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
        $nombreVariable = $sTagPre ."VARIABLE <b>$varname</b>:";
        $nombreVariable .= $sTagFinPre;
        echo $nombreVariable;
        echo  "<pre style=\" background:#E2EDA8; font-size:12px; padding-left:10px; text-align:left; color:black; font-weight:normal; font-family: \'Courier New\', Courier, monospace !important;\">\n";
        var_dump($var);
        echo  "</pre>";     
    }//p
    
    public static function l($var,$varname="")
    {
        self::wlog($var,$varname);
    }//l
    
    public static function ln($var,$varname="",$filename)
    {
        self::wlog($var,$varname,$filename);
    }//ln
    
    public static function pl($var,$varname="")
    {
        self::l($var,$varname);
        self::p($var,$varname);
    }//pl
    
}//class L

//use \L;

