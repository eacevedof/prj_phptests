<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.0.0
 * @name ComponentExtract
 * @date 01-06-2014 12:45
 * @file component_extract.php
 * @observations
 */
namespace TheFramework\Components;

class ComponentExtract 
{
    private $sRegexp;
    private $sFilePath;
    private $arLines;
    
    public function __construct() 
    {
        $this->sRegexp = "<DTS:Property DTS:Name=\"ObjectName\">.*<\/DTS:Property>";
        $this->sFilePath = "C:\Proyectos\Interfaz\Flamagas\Interfaz Flamagas\ImportFlamagas.dtsx";
        $this->arLines = [];
        //echo "<DTS:Property DTS:Name=\"ObjectName\">FATRVA - ERP_auxiliar</DTS:Property>";
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
    
    public function run()
    {
        $sContent = file_get_contents($this->sFilePath);
        $arContent = explode("\n",$sContent);
        foreach($arContent as $i=>$sLine)
        {
            $arMatches = [];
            preg_match("/$this->sRegexp/",$sLine,$arMatches);
            if($arMatches)
            {
                //bug($arMatches,"line:$i");
                if(!$this->in_string(["{","}",".log","sql.desa1","Restricción"],$sLine))
                {
                    $this->clean(["<DTS:Property DTS:Name=\"ObjectName\">","</DTS:Property>"],$sLine);
                    $this->arLines[$i] = trim($sLine); 
                }
            }
        }//foreach
    }//run()
    
    public function set_path_file($value){$this->sFilePath=$value;}
    public function set_regex($value){$this->sRegexp=$value;}
    
    public function get_extracted(){return $this->arLines;}
    
}//ComponentExtract