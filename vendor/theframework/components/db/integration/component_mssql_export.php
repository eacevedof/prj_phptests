<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @name TheFramework\Components\Db\ComponentMssqlExport 
 * @file component_mssql_export.php v2.0.0.B.1
 * @date 30-03-2018 12:06 SPAIN
 * @observations
 */
namespace TheFramework\Components\Db\Integration;

use TheFramework\Components\ComponentLog;
use TheFramework\Components\Db\ComponentMssql;

class ComponentMssqlExport 
{
    private $arConn;
    private $isError;
    private $arErrors;    
    private $iAffected;
    private $oDb;
    
    private $arNumeric = ["float","real","int","smallint","money"];    
    private $arString = ["varchar","text","char"];
    private $arDate = ["datetime","smalldatetime"];
    private $arNoLen = ["float","datetime","real","smalldatetime","int","text","smallint","money"];
    
    private $sMotorTo = "mssql";
    
    public function __construct($arConn=["server"=>"","database"=>"","user"=>"","password"=>""]) 
    {
        $this->isError = FALSE;
        $this->arErrors = [];
        $this->arConn = $arConn;
        $this->oDb = new ComponentMssql($this->arConn);
    }//__construct
    
    private function get_fieldmap()
    {
        $arTypeMap = [];
        $arTypeMap["mssql"]["1"]="float";
        $arTypeMap["mssql"]["2"]="int";
        $arTypeMap["mssql"]["3"]="numeric";
        $arTypeMap["mssql"]["4"]="varchar";
        $arTypeMap["mssql"]["5"]="datetime";
        $arTypeMap["mssql"]["6"]="real";
        $arTypeMap["mssql"]["7"]="smalldatetime";
        $arTypeMap["mssql"]["8"]="decimal";
        $arTypeMap["mssql"]["9"]="money";

        $arTypeMap["mysql"]["1"]="float";
        $arTypeMap["mysql"]["2"]="int";
        $arTypeMap["mysql"]["3"]="decimal";
        $arTypeMap["mysql"]["4"]="varchar";
        $arTypeMap["mysql"]["5"]="datetime";
        $arTypeMap["mysql"]["6"]="decimal";
        $arTypeMap["mysql"]["7"]="datetime";
        $arTypeMap["mysql"]["8"]="decimal";//10,8
        $arTypeMap["mysql"]["9"]="decimal";//10,0    
    }//get_fieldmap
    
    private function get_fieldtype_map($sType,$sMotorSrc,$sMotorTrg)
    {
        $arTypes = [
            "mssql"=>[
                "int"=>[
                    "sqlite"=>"INTEGER",
                    "mysql"=>"int"
                    ],
                "tinyint"=>[
                    "sqlite"=>"INTEGER",
                    "mysql"=>"int"
                    ],
                "smallint"=>[
                    "sqlite"=>"INTEGER",
                    "mysql"=>"smallint"
                    ],                
                "varchar"=>[
                    "sqlite"=>"TEXT",
                    "mysql"=>"varchar"
                ],
                "char"=>[
                    "sqlite"=>"TEXT",
                    "mysql"=>"char"
                ],        
                "text"=>[
                    "sqlite"=>"TEXT",
                    "mysql"=>"text"
                ], 
                "datetime"=>[
                    "sqlite"=>"TEXT",
                    "mysql"=>"varchar"
                ],                 
                "decimal"=>[
                    "sqlite"=>"REAL",
                    "mysql"=>"NUMERIC"
                ],
                "float"=>[
                    "sqlite"=>"REAL",
                    "mysql"=>"NUMERIC"
                ]
            ],//mssql            
            "mysql"=>[
                "int"=>[
                    "sqlite"=>"INTEGER",
                    "mssql"=>"int"
                    ],
                "tinyint"=>[
                    "sqlite"=>"INTEGER",
                    "mssql"=>"tinyint"
                    ],
                "smallint"=>[
                    "sqlite"=>"INTEGER",
                    "mssql"=>"smallint"
                    ],                
                "varchar"=>[
                    "sqlite"=>"TEXT",
                    "mssql"=>"varchar"
                ],
                "char"=>[
                    "sqlite"=>"TEXT",
                    "mssql"=>"char"
                ],        
                "text"=>[
                    "sqlite"=>"TEXT",
                    "mssql"=>"text"
                ], 
                "datetime"=>[
                    "sqlite"=>"TEXT",
                    "mssql"=>"varchar"
                ],                 
                "decimal"=>[
                    "sqlite"=>"REAL",
                    "mssql"=>"numeric"
                ],
                "float"=>[
                    "sqlite"=>"REAL",
                    "mssql"=>"numeric"
                ]
            ],//mysql
            "sqlite"=>[
                "INTEGER"=>[
                    "mysql"=>"int",
                    "mssql"=>"int"
                ], 
                "NUMERIC"=>[
                    "mysql"=>"decimal",
                    "mssql"=>"numeric"
                ],                 
                "REAL"=>[
                    "mysql"=>"decimal",
                    "mssql"=>"float"
                ],       
                "TEXT"=>[
                    "mysql"=>"text",
                    "mssql"=>"text"
                ],  
                "BLOB"=>[
                    "mysql"=>"blob",
                    "mssql"=>"-"
                ],                 
            ]
        ];
        return isset($arTypes[$sMotorSrc][$sType][$sMotorTrg])?$arTypes[$sMotorSrc][$sType][$sMotorTrg]:[];
    }//get_fieldtype_map
   
    private function log($sText,$sTitle="",$sType="debug")
    {
        $sPathLogs = $_SERVER["DOCUMENT_ROOT"].DIRECTORY_SEPARATOR."logs";
        $sPathLogs = realpath($sPathLogs);
        $oLog = new ComponentLog($sType,$sPathLogs);
        $oLog->save($sText,$sTitle);
    }//log

    public function get_tables()
    {
        $sSQL = "/*ComponentMssqlExport.get_tables*/
        -- a esta consulta no le hace falta la base de datos. Se ajusta solo a las tablas del 
        -- esquema en el que se esta
        SELECT DISTINCT LOWER(sqltable.name) AS table_id
        ,sqltable.name AS table_name
        ,LTRIM(RTRIM(LOWER(sqltable.xtype))) AS otype
        FROM sysobjects sqltable
        WHERE 1=1
        AND (sqltable.xtype = 'U'/*tablees*/ OR sqltable.xtype = 'V'/*views*/)
        ORDER BY sqltable.name
        ";
        $this->log($sSQL,"get_tables");
        $arTables = $this->oDb->query($sSQL);
        return $arTables;        
    }//get_tables
    
    public function get_fields($sTableName)
    {
        $sSQL = "/*ComponentMssqlExport.get_fields*/
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
        
        $this->log($sSQL,"get_fields");
        $arTmp = $this->oDb->query($sSQL);
        foreach($arTmp as $arT)
            $arTables[$arT["id"]] = $arT["description"];
        
        return $arTables;          
    }//get_fields
    
    public function get_fields_info($sTableName)
    {
        $sSQL = "/*ComponentMssqlExport.get_fields_info*/
        SELECT field_name
        ,MAX(field_type) AS field_type
        ,MAX(field_length) AS field_length
        ,MAX(defvalue) AS defvalue
        ,MAX(is_nullable) AS is_nullable
        ,MAX(ispk) AS ispk
        ,MAX(column_id) AS column_id
        FROM
        (
            SELECT DISTINCT field_name
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
            ,CONVERT(VARCHAR(30),is_nullable) is_nullable
            ,CONVERT(VARCHAR(30),ispk) ispk
            ,column_id
            FROM
            (
                SELECT DISTINCT syscols.name AS field_name
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
                    WHERE 1=1
                    AND TABLE_NAME='$sTableName'
                    AND TABLE_CATALOG='{$this->arConn["database"]}'
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
        ) AS a
        GROUP BY field_name
        ORDER BY column_id
        ";
        $this->log($sSQL,"get_fields_info");
        $arFields = $this->oDb->query($sSQL);
        return $arFields;          
    }//get_fields_info    
    
    public function get_insert_bulk($sTableName,$isDelete=1)
    {
        $sNow = date("Ymd-His");
        $arTables = $this->get_tables();
        if($sTableName)
            $arTables = array_filter($arTables,function($arItem) use($sTableName) {
                //print_r($arItem);
                return $arItem["table_name"] === $sTableName;
            });
        //die;
        //echo "<pre>"; print_r($arTables);die;
        $arLines = ["/*database $sNow*/\n USE {$this->arConn["database"]}-x"];
        $arLines = ["/*database $sNow*/\n USE db_killme"];
        
        foreach($arTables as $arTable)
        {
            //vistas
            if($arTable["otype"]=="v") continue;
            $sTableName = $arTable["table_name"];
            
            if($isDelete)
                $arLines[] = "-- DELETE FROM $sTableName;";
            
            $arFields = $this->get_fields_info($sTableName,1);
            //print_r($arFields);die;
            $arSelect = [];
            foreach($arFields as $arField)
                $arSelect[] = $arField["field_name"];

            $sOrderBy = "1";
            if(in_array("id",$arSelect)) $sOrderBy = "id";
            if(in_array("idn",$arSelect)) $sOrderBy = "idn";
            
            $sSelect = implode("],[",$arSelect);
            $sSelect = "[$sSelect]";
            
            $sSQL = "SELECT $sSelect FROM $sTableName ORDER BY $sOrderBy ASC";
            //print_r($sSQL);die;
            $arRows = $this->oDb->query($sSQL);
            if($arRows)
            {
                $arEnd = end($arRows);
                foreach($arRows as $arRow)
                {
                    $sInsert = "INSERT INTO $sTableName ($sSelect) VALUES(";
                    $arIns = [];
                    foreach($arSelect as $sFieldName)
                    {
                        $sFieldType = $this->get_fieldtype($sFieldName,$arFields);
                        $sValue = $arRow[$sFieldName];
                        $sValue = str_replace("'","''",$sValue);
                        $sValue = "'$sValue'";
                        if($sValue==="''")
                        {
                            if($this->is_nullable($sFieldName,$arFields)
                               || in_array($sFieldType,$this->arNumeric)
                               || in_array($sFieldType,$this->arDate))
                                $sValue = "NULL";
                        }
                        $arIns[] = $sValue;
                    }
                    $sInsert .= implode(",",$arIns);
                    $sInsert .= ")";
                    
                    if($arEnd==$arRow) $sInsert .= ";";
                    else $sInsert .= ";";
                    
                    $arLines[] = $sInsert;
                }//foreach arRows
            }//if arRows
        }//foreach tables
        $sInsert = implode("\n",$arLines);
        return $sInsert;         
    }//get_insert_bulk
       
    public function get_create_table($sTableName,$isDrop=1)
    {
        $arFields = $this->get_fields_info($sTableName);
        if($arFields)
        {
            $arSQL = [];
            if($isDrop)
                $arSQL[] = "IF (OBJECT_ID('$sTableName', 'U') IS NOT NULL) DROP TABLE dbo.$sTableName ";
            
            $arSQL[] = "CREATE TABLE [$sTableName] (";
            
            $arSQLf = [];
            $arPks = $this->get_pks($arFields);

            foreach($arFields as $arFld)
            {
                $sDefault = "";
                $sPk = "NULL";

                $sFieldDef = $arFld["defvalue"];
                $sFieldName = $arFld["field_name"];
                $sFieldType = $arFld["field_type"];
                $sFieldLen = "({$arFld["field_length"]})";
                if(in_array($sFieldType,$this->arNoLen)) $sFieldLen = "";

                //trato el default
                $sDefKey = strtolower($sTableName)."_".strtolower($sFieldName);
                if($sFieldDef!=="NULL" && strlen($sFieldDef)<20)
                    $sDefault = "CONSTRAINT [DF_$sDefKey] DEFAULT ($sFieldDef)";

                if($arFld["ispk"]) $sPk = "";

                $arSQLf[] = "[$sFieldName] [$sFieldType]$sFieldLen $sPk $sDefault";
            }//foreach

            $arSQL[] = implode(",\n",$arSQLf);
            if($arPks)
            {
                $sTableLow = strtolower($sTableName);
                $arSQL[] = ",CONSTRAINT [PK_{$sTableLow}] PRIMARY KEY CLUSTERED (";

                $arTmp = [];
                foreach($arPks as $sFieldName)
                    $arTmp[] = "[$sFieldName] ASC";

                $arSQL[] = implode(",",$arTmp).") ";
                $arSQL[] = "WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]";
            }
            $arSQL[] = ") ON [PRIMARY]";
            $sSQL = implode("\n",$arSQL);
            return $sSQL;      
        }
        else
            $this->add_error("get_create_table tabla:$sTableName sin campos");
        
        return "";
    }//get_create_table
    
    public function get_create_table_mysql($sTableName,$isDrop=1)
    {
        $arFields = $this->get_fields_info($sTableName);
        
        if($arFields)
        {
            $arSQL = [];
            if($isDrop)
                $arSQL[] = "DROP TABLE IF EXISTS `$sTableName`;";

            $arSQL[] = "CREATE TABLE `$sTableName` (";

            //sentencias para campos
            $arSQLf = [];
            $arPks = $this->get_pks($arFields);

            foreach($arFields as $arFld)
            {
                $sDefault = "";
                $sPk = "NULL";

                $sDefault = $arFld["defvalue"];
                $sFieldName = $arFld["field_name"];
                $sFieldType = $arFld["field_type"];
                $sFieldTypeTo = $this->get_fieldtype_map($sFieldType,"mssql","mysql");
                //pr($sFieldType);die;
                $sFieldLen = "({$arFld["field_length"]})";
                if(in_array($sFieldType,$this->arNoLen)) $sFieldLen = "";

                 if($arFld["ispk"]) $sPk = "NOT NULL";
                //todo si el default lleva comillas hay que tratarlo
                $arSQLf[] = "`$sFieldName` $sFieldTypeTo$sFieldLen $sPk DEFAULT $sDefault";
            }//foreach

            $arSQL[] = implode(",\n",$arSQLf);
            if($arPks)
            {
                $arSQL[] = ",PRIMARY KEY (`".implode("`,`",$arPks)."`)";
            }
            $arSQL[] = ");";
            $sSQL = implode("\n",$arSQL);
            return $sSQL;      
        }
        else
            $this->add_error("get_create_table_mysql tabla:$sTableName sin campos");
        return "";
    }//get_create_table_mysql    
    
    public function get_schema($asString=1)
    {
        $sNow = date("Ymd-His");
        $arTables = $this->get_tables();

        $arLines = ["/*database $sNow*/\n USE {$this->arConn["database"]}-x"];
        foreach($arTables as $arTable)
            if($arTable["otype"]=="u")
                $arLines[] = $this->get_create_table($arTable["table_name"]);
        
        if($asString) return implode("\n/* -- end table -- */\n",$arLines);
        return $arLines;
    }//get_schema
    
    private function get_pks($arFields)
    {
        $arReturn = [];
        foreach($arFields as $arField)
        {
            if($arField["ispk"])
                $arReturn[] = $arField["field_name"];
        }
        return $arReturn;
    }//get_pks
    
    private function get_fieldtype($sFieldName,$arFields=[])
    {
        foreach($arFields as $arField)
        {
            if($arField["field_name"]==$sFieldName)
                return $arField["field_type"];
        }
        return "";        
    }//get_fieldtype
    
    private function is_nullable($sFieldName,$arFields=[])
    {
        foreach($arFields as $arField)
        {
            if($arField["field_name"]==$sFieldName)
                return $arField["is_nullable"];
        }
        return 0;        
    }//get_fieldtype
    
    private function add_error($sMessage){$this->isError = TRUE;$this->iAffected=-1; $this->arErrors[]=$sMessage;}    
    public function is_error(){return $this->isError;}
    public function get_errors(){return $this->arErrors;}
    public function show_errors(){echo "<pre>".var_export($this->arErrors,1);}
    
    public function add_conn($k,$v){$this->arConn[$k]=$v;}
    
    /**
     * El formato de destino. En caso de querer exportar para mysql o sqlite
     * @param string $value mysql,sqlite
     */
    public function set_motor($value){$this->sMotorTo=$value;}
}//ComponentMssqlExport
