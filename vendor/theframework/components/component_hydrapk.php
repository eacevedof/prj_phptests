<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name ComponentHydrapk
 * @file component_scandir.php
 * @version 1.0.1
 * @date 27-07-2017 12:06
 * @observations
 * Extrae los 
 *  alter table accounts_agrupation2_tr add constraint acut_guain_r2416_PK primary key (Language_tr,Code,Code_Agrupation1);
 * con el fin de pasarlos a drop para despues poder vaciar las tablas con truncate 
 * https://stackoverflow.com/questions/2337717/removing-all-primary-keys
 * Al final no ha servido pq al aplicar los drop no se ejecutan bien las consultas
 */
namespace TheFramework\Components;

class ComponentHydrapk 
{
    private $sRegexp;
    private $sFilePath;
    private $arLines;
    
    public function __construct() 
    {
        $this->sRegexp = "alter table .*";
        $this->sFilePath = "C:\shared\constraints.sql";
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
        $this->load_lines();
        $this->arLines = array_unique($this->arLines);
        asort($this->arLines);
        $sSQLIn = implode("','",$this->arLines);
        echo "'$sSQLIn'";
   
    }//run()
    
    public function set_path_file($value){$this->sFilePath=$value;}
    public function set_regex($value){$this->sRegexp=$value;}
    
    public function get_extracted(){return $this->arLines;}
    
}//ComponentHydrapk