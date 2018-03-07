<?php
namespace TheFramework\Components;

use TheFramework\Components\ComponentSqlserver;

class ComponentDtsxrep
{
    private $sDir;
    
    public function __construct()
    {
        //echo "hola";
        $sPath = "C:/xampp/htdocs/dts_flamagas_prod/interfaz";
        $sPath = realpath($sPath);
        $this->sDir = $sPath;
        //echo $this->sDir; die;
    }
   
    public function get_erp_tables()
    {
        $sSQL = "
        SELECT DISTINCT TOP 200 tablename
        FROM view_gettable
        WHERE 1=1
        AND tablename LIKE 'ERP_%_AUX'
        --AND tablename IN ('ERP_CONFIG_AUX','ERP_FTIIVA_AUX','ERP_LIKP_AUX','ERP_STPO_AUX','ERP_T002T_AUX')
        ORDER BY tablename";
        $oComp = new ComponentSqlserver();
        $arRows = $oComp->query($sSQL);
        return $arRows;        
    }
    
    public function get_files()
    {
        $arRet = [];        
        if($this->sDir)
        {
            $arFiles = scandir($this->sDir);       

            foreach($arFiles as $sFile)
            {
                if(strstr($sFile,"archivos_"))
                {
                    if(!strstr($sFile,"_sql.dtsx") && !strstr($sFile,"_axnt_"))
                    {
                        $arRet[] = $sFile;
                        break;
                    }
                }
            }
        }
        return $arRet;        
    }
    
    public function get_files_iif()
    {
        $arRet = [];        
        if($this->sDir)
        {
            $arFiles = scandir($this->sDir);       

            foreach($arFiles as $sFile)
            {
                
                if(strstr($sFile,"erp_") || strstr($sFile,"erpimp_"))
                {
                    $arRet[] = $sFile;
                }
            }
        }
        return $arRet;
    }
        
    private function save($sContent,$sFile)
    {
        $sPathFile = $this->sDir."/$sFile";
        if(is_file($sPathFile))
            $oCursor = fopen($sPathFile,"a");
        else
            $oCursor = fopen($sPathFile,"x");

        if($oCursor !== FALSE)
        {
            fwrite($oCursor,""); //Grabo el caracter vacio
            if(!empty($sContent)) fwrite($oCursor,$sContent);
            fclose($oCursor); //cierro el archivo.
        }
        else
        {
            return FALSE;
        }
        return TRUE;        
    }      
    
    public function replace()
    {
        echo "<pre>";
        $arTables = $this->get_erp_tables();
        $arTables = array_column($arTables,"tablename");
        //print_r($arTables);die;
        
        $arFiles = $this->get_files();
        foreach($arFiles as $sFile)
        {
            echo " $sFile\n";
            $sContet = file_get_contents($this->sDir."/".$sFile);
            $sRep = $sContet;
            foreach($arTables as $sTableAux)
            {
                $sTable = str_replace("_AUX","",$sTableAux);
                if(strstr($sRep,$sTable))
                {
                    echo "\t$sTableAux\n";
                    $sRep = str_replace($sTable,$sTableAux,$sRep); 
                }
            }
            $this->save($sRep,"ok_".$sFile);
        }
    }//replace
    
    public function get_name_iniif($sLine)
    {
        //$string = "IIF(ISNULL(ERP_TSPA.STATUS,'')='',0,9) AS Transfer_Status";
        //preg_match("/IIF\(ISNULL\((.*?).STATUS/",$string,$m );
        preg_match("/IIF\(ISNULL\((.*?).STATUS/",$sLine,$arMatch);
        //var_dump($m);        
        return $arMatch;
    }
    
    public function replace_status()
    {
        echo "<pre>";
        $arFiles = $this->get_files_iif();
        foreach($arFiles as $sFile)
        {
            $sFilePath = $this->sDir."/".$sFile;
            $isFound = 0;
            echo " $sFile\n\t";

            $sContent = file_get_contents($sFilePath);
            $arContent = explode("\n",$sContent);
            foreach($arContent as $i=>$sLine)
            {
                //IIF(ISNULL(ERP_FAGEMA.STATUS,'')='',0,9) AS Transfer_Status, 
                //0,IIF(xxx.STATUS='T',0,9)) AS Transfer_Status
                if(strstr($sLine,"IIF(ISNULL(") && strstr($sLine,"STATUS,'')='',0,9) AS Transfer_Status"))
                {
                    $isFound = 1;
                    echo "$i => ";
                    $arName = $this->get_name_iniif($sLine);
                    $sTable = $arName[1];
                    
                    $sNew = "0,IIF($sTable.STATUS='T',0,9)) AS Transfer_Status";
                    $sLine = str_replace("0,9) AS Transfer_Status",$sNew,$sLine);
                    
                    $arContent[$i] = $sLine;
                }
            }
            
            if($isFound)
            {
                $sContent = implode("\n",$arContent);
                $this->save($sContent,"ok_$sFile");
                die;
            }
        }//foreach($arfiles)
    }//replace_status

}//class