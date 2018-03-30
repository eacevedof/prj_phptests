<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheFramework\Components\Db\ComponentExpImpMssql 
 * @file component_exp_imp_mssql.php v1.1.0
 * @date 30-03-2018 12:06 SPAIN
 * @observations
 */
namespace TheFramework\Components\Db\Integration;

use TheFramework\Components\ComponentLog;
use TheFramework\Components\Db\ComponentMssql;

class ComponentExpImpMssql 
{
    private $arConn;
    private $isError;
    private $arErrors;    
    private $iAffected;
    private $oDb;
    
    public function __construct($arConn=["server"=>"","database"=>"","user"=>"","password"=>""]) 
    {
        $this->isError = FALSE;
        $this->arErrors = [];
        $this->arConn = $arConn;
        $this->oDb = new ComponentMssql($this->arConn);
    }//__construct
    
    private function log($sText,$sTitle="",$sType="debug")
    {
        $sPathLogs = $_SERVER["DOCUMENT_ROOT"].DIRECTORY_SEPARATOR."logs";
        $sPathLogs = realpath($sPathLogs);
        $oLog = new ComponentLog($sPathLogs,$sType);
        $oLog->save($sText,$sTitle);
    }//log

    public function get_tables()
    {
        $sSQL = "/*ComponentExpImpMssql.get_tables*/
        SELECT DISTINCT LOWER(sqltable.name) AS id
        ,sqltable.name AS description
        FROM sysobjects sqltable
        WHERE 1=1
        AND (sqltable.xtype = 'U' OR sqltable.xtype = 'V')
        ORDER BY sqltable.name";
        
        $arTmp = $this->oDb->query($sSQL);
        
        foreach($arTmp as $arT)
            $arTables[$arT["id"]] = $arT["description"];
        
        return $arTables;        
    }//get_tables
    
    public function get_fields($sTableName)
    {
        $sSQL = "/*ComponentExpImpMssql.get_fields*/
        SELECT LOWER(cols.name) AS id
        ,' '+LOWER(cols.name)+' - '+types.name +'('
        +CASE types.name 
            WHEN 'text' THEN '1000000' 
            ELSE CONVERT(VARCHAR,cols.Length) 
        END +')' AS description
        FROM syscolumns AS cols
        INNER JOIN systypes AS types 
        ON cols.xtype=types.xtype
        INNER JOIN sysobjects AS tables 
        ON tables.id=cols.id
        AND tables.name = '$sTableName'
        ORDER BY cols.colid ASC";
        
        $arTmp = $this->oDb->query($sSQL);
        
        foreach($arTmp as $arT)
            $arTables[$arT["id"]] = $arT["description"];
        
        return $arTables;          
    }//get_fields
    
    public function get_fields_info($sTableName)
    {
        $sSQL = "/*ComponentExpImpMssql.get_fields_info*/
        SELECT field_name
        ,field_type
        ,CASE field_type
            WHEN 'varchar' THEN CONVERT(VARCHAR,mxlen)
            WHEN 'int' THEN '11'
            WHEN 'float' THEN '-'
            WHEN 'real' THEN '-'
            WHEN 'money' THEN '10,0'
            WHEN 'datetime' THEN '-'
            WHEN 'smalldatetime' THEN '-'
            WHEN 'numeric' THEN CONVERT(VARCHAR,intpos)+','+CONVERT(VARCHAR,floatpos)
            WHEN 'decimal' THEN CONVERT(VARCHAR,intpos)+','+CONVERT(VARCHAR,floatpos)
            ELSE
                CONVERT(VARCHAR,mxlen)
        END AS field_length
        ,REPLACE(REPLACE(ISNULL(defvalue,'NULL'),'(',''),')','') defvalue
        ,is_nullable
        ,ispk
        FROM
        (
            SELECT syscols.name AS field_name
            ,systypes.name AS field_type 
            ,syscols.max_length AS mxlen
            ,syscols.precision AS intpos
            ,syscols.scale AS floatpos
            ,syscols.is_nullable AS 'is_nullable'
            ,extra.defvalue
            ,ISNULL(sysindexes.is_primary_key,0) AS ispk
            ,syscols.column_id
            FROM sys.columns AS syscols
            INNER JOIN 
            (
                SELECT TABLE_NAME AS table_name
                ,COLUMN_NAME AS field_name
                ,COLUMN_DEFAULT AS defvalue
                FROM INFORMATION_SCHEMA.COLUMNS
                WHERE TABLE_NAME='$sTableName'
            ) AS extra
            ON syscols.object_id = OBJECT_ID(extra.table_name)
            AND syscols.name = extra.field_name
            INNER JOIN sys.types AS systypes 
            ON syscols.user_type_id = systypes.user_type_id
            LEFT OUTER JOIN sys.index_columns AS colsidx 
            ON colsidx.object_id = syscols.object_id 
            AND colsidx.column_id = syscols.column_id
            LEFT OUTER JOIN sys.indexes AS sysindexes
            ON colsidx.object_id = sysindexes.object_id 
            AND colsidx.index_id = sysindexes.index_id
            WHERE 1=1
            AND syscols.object_id = OBJECT_ID('$sTableName')
        ) AS tabledef
        ORDER BY tabledef.column_id";
        
        $arFields = $this->oDb->query($sSQL);
        return $arFields;          
    }//get_fields_info    
    
    private function add_error($sMessage){$this->isError = TRUE;$this->iAffected=-1; $this->arErrors[]=$sMessage;}    
    public function is_error(){return $this->isError;}
    public function get_errors(){return $this->arErrors;}
    public function show_errors(){echo "<pre>".var_export($this->arErrors,1);}
    
    public function add_conn($k,$v){$this->arConn[$k]=$v;}
    
}//ComponentExpImpMssql
