<?php
namespace TheFramework\Components;

use TheFramework\Components\Db\ComponentMssql;

class ComponentDtsQueryrep
{
    public function __consturct(){;}
    

    public function get_tables_aux()
    {
/*
/*
 CONFIG -- NO TIENE CLAVES, (DATOS PARTICULARES DE CADA TERMINAL) ok cambio clave a ZTERMIN
 * 
FTIIVA  -- DEBERIA APLICAR CLAVES, PERO CON SU CI HAY REPETIDOS POR CLAVES. (TIPOS DE IVA) ok se mantienen las claves
LIKP  -- NO TIENE CLAVES (DOCUMENTOS DE VENTAS - ENTREGAS X PEDIDO) sigue fallando
 
 * stpo añadidas claves
STPO -- DEBERIA APLICAR COMO CLAVE CAMPO STLNR, PERO HAY REPETIDOS EN SU CI  (MATERIALES - DETALE LLISTA MATERIALES) corregido por pedro
T002T -- DEBERIA TENER CLAVES (SPRAS,SPRSL), PERO HAY REPTEIDOS EN SU CI (IDIOMAS) ok se mantienen las claves
 * 
 

La tabla CONFIG tiene como clave el dato ZTERMIN, que corresponde al número de terminal del AUTOCOMM. 
 * Lo que no tengo claro es si esta tabla la váis a utilizar ahora, piensa que, entre otros datos, 
 * contiene el contador para pedidos y para clientes.
La clave de LIKP es VBELN, que corresponde al número de entrega. (sigue sin funcionar)
 * FCLIPL eliminada
*/        
        $sSQL = "
        SELECT DISTINCT TOP 200 tablename
        FROM view_gettable
        WHERE 1=1
        AND tablename LIKE 'ERP_%_AUX'
        AND tablename IN ('ERP_CONFIG_AUX','ERP_FTIIVA_AUX','ERP_LIKP_AUX','ERP_STPO_AUX','ERP_T002T_AUX')
        ORDER BY tablename";
        $oComp = new ComponentMssql(["server"=>"localhost/MSSQL2014","database"=>"crm3_flamagas","user"=>"sa","password"=>"xYz"]);
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
        $oComp = new ComponentMssql(["server"=>"localhost/MSSQL2014","database"=>"crm3_flamagas","user"=>"sa","password"=>"xYz"]);
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
        $oComp = new ComponentMssql(["server"=>"localhost/MSSQL2014","database"=>"crm3_flamagas","user"=>"sa","password"=>"xYz"]);
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
        $oComp = new ComponentMssql(["server"=>"localhost/MSSQL2014","database"=>"crm3_flamagas","user"=>"sa","password"=>"xYz"]);
        $arRows = $oComp->query($sSQL);
        return $arRows;        
    }    
    
    public function get_delete($sTableAux,$arPks)
    {
        $sTableFull = str_replace("_AUX","",$sTableAux);
        $sComm = "";
        if(!$arPks) $sComm = "-- NOPKS";        
        $sSQL = " $sComm
        DELETE FROM $sTableFull 
        FROM $sTableAux
        INNER JOIN $sTableFull
        ON ";
        $arNopks = [];
        if(!$arPks)
        {
            $arNopks = $this->get_nopks($sTableAux);
            $arNopks = array_column($arNopks,"fieldname");
            $arPks = $arNopks;
        }        
        foreach ($arPks as $sPk)
            $arOns[] = "$sTableAux.$sPk = $sTableFull.$sPk";
        $sSQL .= implode("\nAND ",$arOns);

        return $sSQL;
    }
    
    public function get_insert($sTableAux,$arPks)
    {
        $sTableFull = str_replace("_AUX","",$sTableAux);
        
        $sComm = "";
        if(!$arPks) $sComm = "-- NOPKS";
        $sSQL = " $sComm
        INSERT INTO $sTableFull 
        SELECT $sTableAux.*
        FROM $sTableAux
        LEFT OUTER JOIN $sTableFull
        ON ";
        $arOns = [];
        
        $arNopks = [];
        if(!$arPks)
        {
            $arNopks = $this->get_nopks($sTableAux);
            $arNopks = array_column($arNopks,"fieldname");
            $arPks = $arNopks;
        }
        
        foreach ($arPks as $sPk)
            $arOns[] = "$sTableAux.$sPk = $sTableFull.$sPk";
        $sSQL .= implode("\nAND ",$arOns);

        $sSQL .= "\nWHERE 1=1 \nAND $sTableFull.$sPk IS NULL";
        
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
            
            $arQueries[$sTableAux] = [$sDelete,$sInsert];
        }        
        echo "<pre>";
        
        foreach($arQueries as $sTable => $arQ)
        {
            //echo "-- =========================================\n";
            echo "-- $sTable generado con component_erpaux.php\n";
            echo "-- =========================================\n";
            echo $arQ[0]."\n";
            echo $arQ[1]."\n";
        }
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
    
    
    

}//ComponentDtsQueryrep