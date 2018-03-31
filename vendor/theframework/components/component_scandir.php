<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name ComponentScandir
 * @file component_scandir.php
 * @version 1.1.0
 * @date 31-03-2018 17:34
 * @observations
 * Flamagas devuelve todos los archivos .XNT que nos han pasado
 */
namespace TheFramework\Components;

class ComponentScandir 
{
    private $arPaths;
    private $arFiles;

    public function __construct() 
    {
        $this->arPaths = [
            "E:/xampp/htdocs/proy_hydra_flamagas/dts/update_20170620_pricing",
            "E:/xampp/htdocs/proy_hydra_flamagas/dts/update_20170705_tablas_enblanco",
            "E:/xampp/htdocs/proy_hydra_flamagas/dts/update_20170706_campo_en_knb1",
            "e:/xampp/htdocs/proy_hydra_flamagas/dts/Datos/IN/BackUP"
        ];
        
        $this->arFiles = [];
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
    
    private function get_files()
    {
        foreach($this->arPaths as $sPath)
        {
            if(is_dir($sPath))
            {
                $arFiles = scandir($sPath);
                $sPath = explode("/",$sPath);
                $sPath = end($sPath);
                foreach($arFiles as $sFileName)
                {
                    if($this->in_string([".XNT"],$sFileName))
                    {
                        $this->clean([".XNT"],$sFileName);
                        if(strlen($sFileName)>(14+3))
                            $sFileName = substr($sFileName,14);
                        $this->arFiles[$sPath][] = $sFileName;
                    }
                }
                if(isset($this->arFiles[$sPath]))
                    asort($this->arFiles[$sPath]);
            }
        }
        return $this->arFiles;
    }
    
    public function run()
    {
        $arFiles = $this->get_files();
        pr($arFiles);
    }

    public function add_path($value){}
    
}//ComponentScandir