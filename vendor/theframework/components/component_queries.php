<?php
namespace TheFramework\Components;

use TheFramework\Components\ComponentSqlserver;

class ComponentQueries
{
    public function __consturct(){;}
    

    public function get_tables_aux()
    {
        $sSQL = "
        SELECT DISTINCT TOP 10 tablename
        FROM view_gettable
        WHERE 1=1
        AND tablename LIKE 'ERP_%_AUX'
        ORDER BY tablename";
        $oComp = new ComponentSqlserver();
        $arRows = $oComp->query($sSQL);
        return $arRows;        
    }
    
    public function get_fields($sTableAux)
    {
        $sSQL = "
        SELECT DISTINCT fieldname
        FROM view_gettable
        WHERE 1=1
        AND tablename LIKE '$sTableAux'
        ORDER BY fieldname";
        $oComp = new ComponentSqlserver();
        $arRows = $oComp->query($sSQL);
        return $arRows;        
    }    
    
    public function get_pks($sTableAux)
    {
        $sSQL = "
        SELECT DISTINCT fieldname 
        FROM view_gettable
        WHERE 1=1
        AND tablename LIKE '$sTableAux'
        AND ispk='Y'
        ORDER BY fieldname";
        $oComp = new ComponentSqlserver();
        $arRows = $oComp->query($sSQL);
        return $arRows;        
    }
    
    public function get_nopks($sTableAux)
    {
        $sSQL = "
        SELECT DISTINCT fieldname 
        FROM view_gettable
        WHERE 1=1
        AND tablename LIKE '$sTableAux'
        AND ispk=''
        ORDER BY fieldname";
        $oComp = new ComponentSqlserver();
        $arRows = $oComp->query($sSQL);
        return $arRows;        
    }    
    
    public function get_delete($sTableAux,$arPks)
    {
        $sTableFull = str_replace("_AUX","",$sTableAux);
        $sSQL = "
        DELETE FROM $sTableFull 
        FROM $sTableAux
        INNER JOIN $sTableFull
        ON ";
        $arOns = [];
        foreach ($arPks as $sPk)
            $arOns[] = "$sTableAux.$sPk = $sTableFull.$sPk";
        $sSQL .= implode("\nAND ",$arOns);
        return $sSQL;
    }
    
    public function get_insert($sTableAux,$arPks)
    {
        $sTableFull = str_replace("_AUX","",$sTableAux);
        $sSQL = "
        INSERT INTO $sTableFull 
        SELECT $sTableAux.*
        FROM $sTableAux
        LEFT OUTER JOIN $sTableFull
        ON ";
        $arOns = [];
        foreach ($arPks as $sPk)
            $arOns[] = "$sTableAux.$sPk = $sTableFull.$sPk";
        $sSQL .= implode("\nAND ",$arOns);

        $sSQL .= " WHERE 1=1 AND $sTableFull.$sPk IS NULL";
        
        return $sSQL;
    }
    
    public function get_all()
    {
        $arQueries = [];
        $arTables = $this->get_tables_aux();
        foreach($arTables as $sTableAux)
        {
            $sTableAux =$sTableAux["tablename"];
            //print_r($sTableAux);die;
            $arPks = $this->get_pks($sTableAux);
            $arPks = array_column($arPks,"fieldname");
            //$arNoPks = $this->get_nopks($sTableAux);
            $sDelete = $this->get_delete($sTableAux,$arPks);
            $sInsert = $this->get_insert($sTableAux,$arPks);
            
            $arQueries[] = $sDelete;
            $arQueries[] = $sInsert;
        }        
        echo "<pre>";
        print_r($arQueries);
    }
    
    /*

DELETE FROM ERP_T001
FROM ERP_T001_AUX 
INNER JOIN ERP_T001 
ON ERP_T001_AUX.BUKRS = ERP_T001.BUKRS

                         
INSERT INTO ERP_T001 (Status, BUKRS, BUTXT, KTOPL, WAERS, KOKRS)
SELECT  ERP_T001_AUX.Status, ERP_T001_AUX.BUKRS, ERP_T001_AUX.BUTXT, ERP_T001_AUX.KTOPL, ERP_T001_AUX.WAERS, ERP_T001_AUX.KOKRS
FROM  ERP_T001_AUX 
LEFT OUTER JOIN ERP_T001 AS ERP_T001_1 
ON ERP_T001_AUX.BUKRS = ERP_T001_1.BUKRS
WHERE (ERP_T001_1.BUKRS IS NULL)    
     * 
INSERT INTO ERP_T001 
SELECT  ERP_T001_AUX.*
FROM  ERP_T001_AUX 
LEFT OUTER JOIN ERP_T001 AS ERP_T001_1 
ON ERP_T001_AUX.BUKRS = ERP_T001_1.BUKRS
WHERE (ERP_T001_1.BUKRS IS NULL)
     *  */
    
    
    

}//ComponentSqlserver