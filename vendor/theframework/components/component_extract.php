<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name ComponentExtract
 * @file component_extract.php
 * @version 1.0.1
 * @date 01-06-2014 12:45
 * @observations
 * usado en flamagas para extraer de los archivos .dtsx (xml)
 * devuelve las tablas que ya se han tratado 
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
    
    private function load_lines()
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
    }
    
    public function run($isPrintL=1)
    {
        $this->load_lines();
        $this->arLines = array_unique($this->arLines);
        asort($this->arLines);
        if($isPrintL)
            print_r($this->arLines);
        $sSQLIn = implode("','",$this->arLines);
        $sSQLIn = "('$sSQLIn')";
        $sSQLIn = "
        SELECT DISTINCT tabla,a_erptabla
        FROM ERP_Taules_Telynet
        WHERE 1=1
        AND tabla IN $sSQLIn
        ";
        print_r($sSQLIn);     
    }//run()
    
    public function set_path_file($value){$this->sFilePath=$value;}
    public function set_regex($value){$this->sRegexp=$value;}
    
    public function get_extracted(){return $this->arLines;}
    
}//ComponentExtract