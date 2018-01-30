<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name ComponentHydralogs
 * @file component_hydralogs.php
 * @version 1.0.0
 * @date 30-01-2018 11:24
 * @observations
 * Genera un archivo log work_total con todos los archivos de trabajo de admin y developer
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
        $this->sRegexp = "alter table .*";
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
    
    private function get_worklogs()
    {
        $arLogs = scandir($this->sPathLogs);
        $this->debug($arLogs);
        die;
    }//get_worklogs
    
    private function load_lines()
    {
        
        $sContent = file_get_contents($this->sPathLogs);
        $arContent = explode("\n",$sContent);
        foreach($arContent as $i=>$sLine)
        {
            $arMatches = [];
            preg_match("/$this->sRegexp/",$sLine,$arMatches);
            if($arMatches)
            {
                $iPos1 = strpos($sLine,"alter table");
                $iPos1 += 11;
                $iPos2 = strpos($sLine,"add constraint");
                $iPos2 = $iPos2-$iPos1;
                $sLine = substr($sLine,$iPos1,$iPos2);
                $this->arLines[$i] = trim($sLine);
            }
        }//foreach        
        //array_unique($this->arLines);
    }
    
    public function run()
    {
        $this->get_worklogs();
        $this->load_lines();
        $this->arLines = array_unique($this->arLines);
        asort($this->arLines);
        $sSQLIn = implode("','",$this->arLines);
        echo "'$sSQLIn'";
   
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