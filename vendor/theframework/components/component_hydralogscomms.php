<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name ComponentHydralogs
 * @file component_hydralogs.php
 * @version 1.0.1
 * @date 30-01-2018 11:24
 * @observations
 * Genera un archivo log work_total con todos los archivos de trabajo de admin y developer
 * Sin probar y nunca usado 22/05/2018
 */
namespace TheFramework\Components;

class ComponentHydralogs 
{
    private $arErros;
    private $isError;
    
    private $sRegexp;
    private $sPathLogs;
    private $arLines;
    
    public function __construct() 
    {
        $this->sRegexp = "\[([0-9]+\-[0-9]+\-[0-9]+ [0-9]+:[0-9]+:[0-9]+)\] \[ok\] ";
        $this->sPathLogs = realpath("C:\\shared\\flamagas_logs");
        $this->arLines = [];
    }
    
    private function in_string($arChars=[],$sString)
    {
        foreach($arChars as $c)
            if(strstr($sString,$c))
                return TRUE;
        return FALSE;
    }
    
    private function clean($arSubstrings=[],&$sString)
    {
        $sReplace = $sString;
        foreach($arSubstrings as $str)
            $sReplace = str_replace ($str,"",$sReplace);
        $sString = $sReplace;
    }
    
    private function get_only_work($arLogs)
    {
        $arWorkLogs = array_filter($arLogs,function($sFileName){return strstr($sFileName,"work_");});
        return $arWorkLogs;
    }
    
    private function get_over_date($arLogs,$sDate)
    {
        $arWorkLogs = array_filter($arLogs,function ($sFileName) use ($sDate) {
            $arTmp = explode(".",$sFileName);
            $arTmp = $arTmp[0];
            $arTmp = explode("_",$arTmp);
            $sFileDate = end($arTmp);
            return ($sFileDate>=$sDate);
        });
        return $arWorkLogs;
    }
    
    private function get_by_users($arLogs,$arUsers)
    {
        $arWorkLogs = array_filter($arLogs, function($sFileName) use ($arUsers) {
            $arTmp = explode(".",$sFileName);
            $arTmp = $arTmp[0];
            $arTmp = explode("_",$arTmp);
            $sUser = $arTmp[3];
            return (in_array($sUser,$arUsers));
        });
        return $arWorkLogs;
    }
    
    private function get_date($sFileName)
    {
        $arTmp = explode(".",$sFileName);
        $arTmp = $arTmp[0];
        $arTmp = explode("_",$arTmp);
        $sFileDate = end($arTmp);
        return $sFileDate;
    }
    
    private function get_sorted_by_date($arLogs)
    {
         $isOk = usort($arLogs, function($sFileA,$sFileB){
            $sDateA = (int)$this->get_date($sFileA);
            $sDateB = (int)$this->get_date($sFileB);
            return ($sDateA>$sDateB);
        });
        return $arLogs;
    }
    
    private function get_worklogs()
    {
        $arLogs = scandir($this->sPathLogs);
        //unset($arLogs[0]); unset($arLogs[1]);//. y ..
        $arLogs = $this->get_only_work($arLogs);
        $arLogs = $this->get_over_date($arLogs,"20180115");
        $arLogs = $this->get_by_users($arLogs,["2","x0"]);
        $arLogs = $this->get_sorted_by_date($arLogs);
        //$this->debug($arLogs);
        //die;
        return $arLogs;
    }//get_worklogs
    
    private function load_lines($sPathLog)
    {
        $sContent = file_get_contents($sPathLog);
        $arContent = explode("\n",$sContent);
        foreach($arContent as $i=>$sLine)
        {
            $arMatches = [];
            preg_match("/$this->sRegexp/",$sLine,$arMatches);
            if($arMatches)
            {
                $this->arLines[$i] = trim($sLine);
            }
        }//foreach        
        //array_unique($this->arLines);
    }
    
    public function run()
    {
        if(is_dir($this->sPathLogs))
        {
            $arRm = scandir($this->sPathLogs);
            unset($arRm[0]); unset($arRm[1]);

            $arLogs = $this->get_worklogs();
            foreach($arRm as $sFileName)
            {
                if(!in_array($sFileName,$arLogs))
                {
                    $iR = unlink($this->sPathLogs.DIRECTORY_SEPARATOR.$sFileName);
                    $this->debug("borrado $sFileName,r:$iR");
                }
                //$this->load_lines($this->sPathLogs.DIRECTORY_SEPARATOR.$sFileName);            
            }
        }
        else
            $this->add_error("sPathLogs:$this->sPathLogs no es un dir");
    }//run()
    
    public function debug($mxVar){echo "<pre>".var_export($mxVar,1);}    
    private function add_error($sMessage){$this->isError = TRUE;$this->arErrors[]=$sMessage;}
    
    public function set_path_file($value){$this->sPathLogs=$value;}
    public function set_regex($value){$this->sRegexp=$value;}
    
    public function get_extracted(){return $this->arLines;}
    
    public function is_error(){return $this->isError;}
    public function get_errors(){return $this->arErrors;}
    public function show_errors(){echo "<pre>".var_export($this->arErrors,1);}    
}//ComponentHydralogs