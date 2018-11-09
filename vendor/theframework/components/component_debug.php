<?php
/**
* @author Eduardo Acevedo Farje.
* @link www.eduardoaf.com
* @version 1.2.6
* @name ComponentDebug 
* @file component_debug.php
* @date 03-11-2018 11:23 (SPAIN)
* @observations: Para poder escribir en archivos se debe tener permisos de escritura y/o
* lectura para IUSR_<SERVERNAME>
*  load:24
* @requires: functions_utils.php v1.0.10
*/
namespace TheFramework\Components;

class ComponentDebug
{
    private static $_isSqlsOn = false;
    private static $_isMessagesOn = false;
    private static $_isPhpInfoOn = false;
    private static $_isIncludedOn = false;
   
    private static $arMessages = array();
    private static $arSqls = array();
    private static $arIncluded = array();
   
   
    public static function config($isSqlsOn=false, $isMessagesOn=false, $isPhpInfoOn=false, $isIncludedOn=false)
    {
        self::$_isSqlsOn = $isSqlsOn;
        self::$_isMessagesOn = $isMessagesOn;
        self::$_isPhpInfoOn = $isPhpInfoOn;
        self::$_isIncludedOn = $isIncludedOn;
    }

    public static function set_sql($sSQL,$iCount=00,$fTime="")
    {
        if(self::$_isSqlsOn)
            self::$arSqls[] = array("sql"=>$sSQL,"count"=>$iCount,"time"=>$fTime);
    }
   
    public static function set_message($sMessage,$sTitle="")
    {
        if(self::$_isMessagesOn)
            self::$arMessages[] = array("Title"=>$sTitle,"Message"=>$sMessage);
    }
   
    public static function get_php_info(){if(self::$_isPhpInfoOn)return phpinfo();}
   
    public static function get_messages_in_array(){if(self::$_isMessagesOn) return self::$arMessages;}

    public static function get_messages_in_html_table(){if(self::$_isMessagesOn && !self::is_ajax_request()) echo self::build_html_table(self::$arMessages);}
   
    public static function get_sqls_in_array(){if(self::$_isSqlsOn) return self::$arSqls;}

    public static function get_sqls_in_html_table(){ if(self::$_isSqlsOn && !self::is_ajax_request()) echo self::build_html_table(self::$arSqls);}
    
    public static function set_messages_on($isMessagesOn){self::$_isMessagesOn = $isMessagesOn;}
    public static function set_sqls_on($isSqlsOn){self::$_isSqlsOn = $isSqlsOn;}
    public static function set_php_info_on($isPhpInfoOn){self::$_isPhpInfoOn = $isPhpInfoOn;}
    public static function is_php_info_on(){return self::$_isPhpInfoOn;}
    public static function is_sqls_on(){return self::$_isSqlsOn;}
    public static function is_messages_on(){return self::$_isMessagesOn;}
   
    public static function is_ajax_request()
    {
        //https://stackoverflow.com/questions/2579254/does-serverhttp-x-requested-with-exist-in-php-or-not
        $header = isset($_SERVER["HTTP_X_REQUESTED_WITH"]) ? $_SERVER["HTTP_X_REQUESTED_WITH"] : null;
        return ($header === "XMLHttpRequest");
    } 
    
    private static function build_html_tr_header($arArray=array())
    {
        $sHtmlTrHd = "";
        if(!empty($arArray))
        {    
            $sHtmlTrHd .="<tr><th>Nº</th>\n";

            $arRow = $arArray[0];
            foreach($arRow as $sTitle=>$sValue)
                $sHtmlTrHd .= "<th>$sTitle</th>\n";
            $sHtmlTrHd .= "</tr>\n";
        }
        return $sHtmlTrHd;
    }
   
    private static function get_style_td_background($iRow,$asError=0)
    {
        if(!$asError)
        {
            if(($iRow%2)==0)
                return "clsTrEven";
            else 
                return "clsTrUneven";
        }
        return "clsTrError";
    }
   
    private static function build_style()
    {
        $sSytle = "<style type=\"text/css\">";
        $sSytle .= "table#tblDebug
        {
            font-size:14px!important; 
            width:1000px;
            border-collapse: collapse!important;
            margin-bottom: 0;
            overflow:auto;
            font-weight:normal; 
            font-family: 'Courier New', Courier, monospace !important;
        }
        table#tblDebug tr td 
        {
            border: 1px solid black;
            padding-bottom: 0;
        }
        table#tblDebug tr td pre
        {
            line-height:normal!important;
            padding:0;
            margin:0;
            border:0;
        }
        table#tblDebug tr th
        {
            border:1px solid black;
            background-color: #F29A02;
            color:black;
        }
        .clsTrEven
        {
            background-color: #e9eaeb;
            color: black;
        }

        .clsTrUneven
        {
            background-color: #ECF71D;
            color: black;
        }

        .clsTrError
        {
            background-color: #F92104;
            color: white;
        }
        .clsTrList
        {
            background-color: #00CE41;/*verde*/
            color: white;
        }
        .clsTrHighlight
        {
            background-color: #55A9FC;/*celeste*/
            color: white;
        }
        .clsTrSession
        {
            background-color: #554455;/*not used*/
            color: white;
        }
        ";
        $sSytle .= "</style>";
        return $sSytle;
    }
    
    private static function build_html_table($arArray=array())
    {
        if(isset($_SESSION["componentdebug"]) && is_array($_SESSION["componentdebug"]))
        {
            //bug($_SESSION["componentdebug"]);
            $arArray = array_merge($_SESSION["componentdebug"],$arArray);
            $_SESSION["componentdebug"] = NULL;
        }
        if(isset($_POST["componentdebug"]) && is_array($_POST["componentdebug"]))
        {
            $arArray = array_merge($_POST["componentdebug"],$arArray);
            $_POST["componentdebug"] = NULL;
        }        
        
        $sHtmlTable = "";
        if(!empty($arArray))
        {
            $sHtmlTable .= self::build_style();
            $sHtmlTable .= "<table id=\"tblDebug\">\n";
            $sHtmlTable .= self::build_html_tr_header($arArray);
            foreach($arArray as $iRow=>$arRow)
            {
                $isError=0;
                //bug($arRow);
                if(isset($arRow["count"]) && $arRow["count"]=="-1")
                { 
                    $isError=1;
                    $arRow["count"]="ERROR";
                }
                $sTdStyle = self::get_style_td_background($iRow,$isError);
                $sHtmlTable .= "<tr>\n";
                $sHtmlTable .= "<td class=\"$sTdStyle\" >$iRow</td>\n";
                foreach($arRow as $sFieldValue)
                {
                    //si se aplican tags de html se mejora la visibilidad de las consultas y se puede copiar y pegar
                    //respetando los saltos de linea ya que los br los pasa el portapapeles o el navegador a salto de linea simple \n
                    //el problema es que si se quiera recuperar la consulta del html generado los tags fastidian la consulta.
                    $sFieldValue = str_replace("SELECT ","<b>SELECT </b>",$sFieldValue); 
                    $sFieldValue = str_replace(" AS ","<b> AS </b>",$sFieldValue);
                    $sFieldValue = str_replace("FROM","<br/><b>FROM</b>",$sFieldValue);
                    $sFieldValue = str_replace("WHERE ","<br/><b>WHERE </b>",$sFieldValue);
                    $sFieldValue = str_replace("INNER JOIN","<br/><b>INNER JOIN </b>",$sFieldValue);
                    $sFieldValue = str_replace("LEFT JOIN","<br/><b>LEFT JOIN </b>",$sFieldValue);
                    $sFieldValue = str_replace(" AND ","<br/><b> AND </b>",$sFieldValue);
                    $sFieldValue = str_replace(" OR ","<br/><b> OR </b>",$sFieldValue);
                    $sFieldValue = str_replace(" IN ","<b> IN </b>",$sFieldValue);
                    $sFieldValue = str_replace(" ON ","<b> ON </b>",$sFieldValue);
                    $sFieldValue = str_replace(" NULL","<b> NULL</b>",$sFieldValue);
                    $sFieldValue = str_replace("ORDER BY ","<br/><b>ORDER BY </b>",$sFieldValue);
                    $sFieldValue = str_replace("GROUP BY ","<br/><b>GROUP BY </b>",$sFieldValue);
                    $sFieldValue = str_replace("INSERT INTO ","<b>INSERT INTO </b>",$sFieldValue);
                    $sFieldValue = str_replace("VALUES","<br/><b>VALUES </b>",$sFieldValue);
                    
                    if(strstr($sFieldValue,"UPDATE "))
                    {                   
                        $sFieldValue = str_replace("UPDATE ","<b>UPDATE </b>",$sFieldValue);
                        $sFieldValue = str_replace(",","<br/>,",$sFieldValue);
                        $sFieldValue = str_replace("SET ","<br/><b>SET </b>",$sFieldValue);
                    }
                    
                    $sFieldValue = str_replace("DELETE FROM ","<b>DELETE FROM </b>",$sFieldValue);
                    if(!$isError)
                    {
                        $arSubstrings = array("get_select_","load_by","autoinsert","autoupdate","autoquarantine","autodelete");
                        if(isone_substring($arSubstrings,$sFieldValue)) 
                            $sTdStyle = "clsTrList";
                        if(strstr($sFieldValue,"%highlight%"))
                            $sTdStyle = "clsTrHighlight";    
                    }
                    
                    $sHtmlTable .= "<td class=\"$sTdStyle\">$sFieldValue</td>\n";
                }
                $sHtmlTable .= "</tr>\n";
            }
            $sHtmlTable .= "</table>\n";
        }
        return $sHtmlTable;
    }
}//ComponentDebug