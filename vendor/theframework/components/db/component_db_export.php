partial_queries.php 

//<editor-fold defaultstate="collapsed" desc="QUERY EXPORT">
    protected function build_queryexp_opbuttons()
    {
        $arButTabs = array();
        $arButTabs["list"]=array("href"=>$this->build_url(),"icon"=>"awe-search","innerhtml"=>tr_mdbexp_dashboard);
        return $arButTabs;
    }//build_queryexp_opbuttons()

    protected function build_queryexp_form($usePost=0)
    {
        $oForm = new HelperForm("frmInsert");
        $oForm->add_class("form-horizontal");
        $oForm->add_style("margin-bottom:0");
        $arFields = $this->build_queryexp_fields($usePost);
        $oForm->add_controls($arFields);
        return $oForm;
    }//build_queryexp_form()
    
    protected function build_queryexp_fields($usePost=0)
    {   //bugpg();
        //bug($arFields);die;
        $oQuery = new AppComponentQueries();
        $arFields = array(); $oAuxField = NULL; //$oAuxLabel = NULL;
        $arFields[]= new ApphelperFormhead("Table In Query Export");

        $arTmp = $oQuery->get_databases();
        $arOptions = array(""=>tr_main_none);
        foreach($arTmp as $i=>$arT)
            $arOptions[$i] = $arT["alias"];        
        $oAuxField = new HelperSelect($arOptions,"selDb","selDb");
        $oAuxField->set_postback();
        $oAuxField->set_value_to_select($this->get_post("selDb"));
        $oAuxLabel = new HelperLabel("selDb",tr_mdbexp_queryexp_db,"selDb");
        $oAuxLabel->add_class("labelreq");
        //$oAuxField->readonly();
        $arFields[] = new ApphelperControlGroup($oAuxField,$oAuxLabel);    
        
        $arOptions = $this->get_origin_tables();
        $oAuxField = new HelperSelect($arOptions,"selTableFrom","selTableFrom");
        $oAuxField->set_postback();
        $oAuxField->add_class("span8");
        $oAuxField->set_value_to_select($this->get_post("selTableFrom"));
        $oAuxLabel = new HelperLabel("selTableFrom",tr_mdbexp_queryexp_tablefrom,"selTableFrom");
        $oAuxLabel->add_class("labelreq");
        //$oAuxField->readonly();
        $arFields[] = new ApphelperControlGroup($oAuxField,$oAuxLabel);        

        $arOptions = $this->get_origin_fields();
        $oAuxField = new HelperSelect($arOptions,"selFields","selFields");
        $oAuxField->add_class("span8");
        $oAuxField->set_multiple_size(20);
        $oAuxField->set_value_to_select($this->get_post("selFields"));
        $oAuxLabel = new HelperLabel("selFields",tr_mdbexp_queryexp_selfields,"selFields");
        $oAuxLabel->add_class("labelreq");
        //$oAuxField->readonly();
        $arFields[] = new ApphelperControlGroup($oAuxField,$oAuxLabel);        

        $arTmp = $oQuery->get_datatypes();
        $arOptions = array(""=>tr_main_none);
        foreach($arTmp as $id=>$sValue)
            $arOptions[$id] = $sValue;        
        $oAuxField = new HelperSelect($arOptions,"selDataTypes","selDataTypes");
        $oAuxField->add_class("span6");
        $oAuxField->set_multiple_size(5);

        $oAuxField->set_value_to_select($this->get_post("selDataTypes"));
        $oAuxLabel = new HelperLabel("selDataTypes",tr_mdbexp_queryexp_selfields,"selDataTypes");
        $oAuxLabel->add_class("labelreq");
        //$oAuxField->readonly();
        $arFields[] = new ApphelperControlGroup($oAuxField,$oAuxLabel);            

        if($this->get_post("txaSql"))
        {
            $oAuxField = new HelperTextarea();
            $oAuxField->add_style("width:850px; height:600px; background-color:#ddd;");
            $oAuxField->set_innerhtml($this->get_post("txaSql"));
            $oAuxLabel = new HelperLabel("txaSql",tr_mdbexp_queryexp_sql,"lblSql");
            $oAuxField->readonly();
            $arFields[] = new ApphelperControlGroup($oAuxField,$oAuxLabel);   
        }
        
        if($this->get_post("txaMissing"))
        {
            $oAuxField = new HelperTextarea();
            $oAuxField->add_style("width:850px; height:600px; background-color:#ddd;");
            $oAuxField->set_innerhtml($this->get_post("txaMissing"));
            $oAuxLabel = new HelperLabel("txaMissing",tr_mdbexp_queryexp_missing,"lblMissing");
            $oAuxField->readonly();
            $arFields[] = new ApphelperControlGroup($oAuxField,$oAuxLabel);   
        }
        
        //Boton
        $oAuxField = new HelperButtonBasic("butSave",tr_ins_savebutton);
        $oAuxField->add_class("btn btn-primary");
        $oAuxField->set_js_onclick("insert();");
        $arFields[] = new ApphelperFormactions(array($oAuxField));
               
        //Accion
        //POST INFO
        $oAuxField = new HelperInputHidden("hidAction","hidAction");
        $arFields[] = $oAuxField;
        $oAuxField = new HelperInputHidden("hidPostback","hidPostback");
        $arFields[] = $oAuxField;
       
        return $arFields;
    }//build_queryexp_fields()
    
    private function get_field_pair($sType,$sDbFrom,$sDbTo)
    {
        $arPairs = array();
        $arPairs["mssql"]["1"]="float";
        $arPairs["mssql"]["2"]="int";
        $arPairs["mssql"]["3"]="numeric";
        $arPairs["mssql"]["4"]="varchar";
        $arPairs["mssql"]["5"]="datetime";
        $arPairs["mssql"]["6"]="real";
        $arPairs["mssql"]["7"]="smalldatetime";
        $arPairs["mssql"]["8"]="decimal";
        $arPairs["mssql"]["9"]="money";

        $arPairs["mysql"]["1"]="float";
        $arPairs["mysql"]["2"]="int";
        $arPairs["mysql"]["3"]="decimal";
        $arPairs["mysql"]["4"]="varchar";
        $arPairs["mysql"]["5"]="datetime";
        $arPairs["mysql"]["6"]="decimal";
        $arPairs["mysql"]["7"]="datetime";
        $arPairs["mysql"]["8"]="decimal";//10,8
        $arPairs["mysql"]["9"]="decimal";//10,0  
        
        $arFrom = $arPairs[$sDbFrom];
        foreach($arFrom as $i=>$sFieldType)
            if($sFieldType==$sType)
                break;
       
        return $arPairs[$sDbTo][$i];
    }//get_field_pair

    private function build_sqlcreate($iDbFrom,$sTableName,$arFields=array())
    {
        $oQuery = new AppComponentQueries();
        $sSQL = "/*build_sqlfrom*/
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
        //pr($sSQL);
        $arFields = $oQuery->get_data($sSQL,$iDbFrom);
        
        //pr($arFields,"fields");
        $arSQL[] = "DROP TABLE IF EXISTS `$sTableName`;";
        $arSQL[] = "CREATE TABLE `$sTableName` (";
        foreach($arFields as $arFld)
        {
            $sFieldName = $arFld["field_name"];
            $sFieldType = $arFld["field_type"];
            $sFieldType = $this->get_field_pair($sFieldType,"mssql","mysql");
            
            //$sFieldName = "`id` int(11) NOT NULL AUTO_INCREMENT,";
            $sFieldLen = $arFld["field_length"];
            if($sFieldLen=="-")
                $sFieldLen = "";
            else 
                $sFieldLen = "($sFieldLen)";
            
            $sDefault = $arFld["defvalue"];
            
            $arSQLf[] = "`$sFieldName` $sFieldType$sFieldLen DEFAULT $sDefault";
        }
        $arSQL[] = implode("\n,",$arSQLf);
        $arSQL[] = ")";
        $arSQL[] = "ENGINE=MyISAM DEFAULT CHARSET=utf8;";
        
        $arSQL[] = "ALTER TABLE `$sTableName`";
        $arSQL[] = "CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT,";
        $arSQL[] = "ADD PRIMARY KEY(`id`);";
        
        $sSQL = implode("\n",$arSQL);
        return $sSQL;
    }//build_sqlcreate

    private function get_origin_fields()
    {
        $sTableName=$this->get_post("selTableFrom");
       
        $sSQL = "/*get_origin_tables*/
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
        
        $oQuery = new AppComponentQueries();
        $arTmp = $oQuery->get_data($sSQL,1);
        
        $arOptions = array(""=>tr_main_none);
        foreach($arTmp as $i=>$arT)
            $arOptions[$arT["id"]] = $i.": ".$arT["description"];
        
        return $arOptions;
    }//get_origin_fields
    
    private function get_origin_tables()
    {
        $idDb=$this->get_post("selDb");
        
        $sSQL = "/*get_origin_tables*/
        SELECT DISTINCT LOWER(sqltable.name) AS id
        ,sqltable.name AS description
        FROM sysobjects sqltable
        WHERE 1=1
        AND (sqltable.xtype = 'U' OR sqltable.xtype = 'V')
        ORDER BY sqltable.name";
        
        $oQuery = new AppComponentQueries();
        $arTmp = $oQuery->get_data($sSQL,$idDb);
        
        $arTables = array(""=>tr_main_none);
        foreach($arTmp as $arT)
            $arTables[$arT["id"]] = $arT["description"];
        
        return $arTables;
    }//get_missin_tables
    
    private function get_target_tables()
    {
        $sSQL = "/*get_target_tables*/
        SELECT TABLE_NAME AS id
        ,TABLE_NAME AS description
        FROM information_schema.tables 
        WHERE 1=1
        AND table_schema='theframework'
        ORDER BY table_name ASC";
        
        $oQuery = new AppComponentQueries();
        $arTmp = $oQuery->get_data($sSQL,2);
        
        $arTables = array(""=>tr_main_none);
        foreach($arTmp as $arT)
            $arTables[$arT["id"]] = $arT["description"];
        
        return $arTables;
    }//get_target_tables
    
    private function get_missing_tables()
    {
        $arMissing = array();
        $arOrigin = $this->get_origin_tables();
        $arTarget = $this->get_target_tables();
        //bug($arOrigin,"origin");bug($arTarget,"target");
        
        $arOrigin = array_keys($arOrigin);
        $arTarget = array_keys($arTarget);
        
        foreach($arOrigin as $sTableO)
            if(!in_array($sTableO,$arTarget))
                $arMissing["target"][] = $sTableO;
        
        foreach($arTarget as $sTableT)
            if(!in_array($sTableT,$arOrigin))
                $arMissing["origin"][] = $sTableT;
        
        return $arMissing;
    }//get_missing_tables
    
    public function queryexport()
    {
        //errorson();
        $arFieldsConfig = array();
        $arFieldsConfig["selTable"] = array("id"=>"selTable","label"=>tr_table
            ,"length"=>100,"type"=>array("required"));
        
        $this->set_post("txaMissing",var_export($this->get_missing_tables(),1));
        
        if($this->is_inserting())
        {
            //array de configuracion length=>i,type=>array("numeric","required")
            $oAlert = new ApphelperAlertdiv();
            $oAlert->use_close_button();
           
            $arFieldsValues = $this->get_fields_from_post();
            //$oValidate = new ComponentValidate($arFieldsConfig,$arFieldsValues);
            //$arErrData = $oValidate->get_error_field();
            //bug($arErrData); die;
            if($arErrData)
            {
                $oAlert->set_type("e");
                $oAlert->set_title(tr_module_not_built);
                $oAlert->set_content("Field <b>".$arErrData["label"]."</b> ".$arErrData["message"]);
            }
            //no error
            else
            {
                $iDbFrom = $this->get_post("selDb");
                $sTableName = $this->get_post("selTableFrom");
                $this->set_post("txaSql",$this->build_sqlcreate($iDbFrom,$sTableName));
            }//fin else: no error
        }//fin if post action=save

        //Si hay errores se recupera desde post
        if($arErrData) 
            $oForm = $this->build_queryexp_form(1);
        else 
            $oForm = $this->build_queryexp_form();
        //bug($oForm); die;
       
        $oJavascript = new HelperJavascript();
        $oJavascript->set_formid("frmInsert");
        $oJavascript->set_validate_config($arFieldsConfig);
        $oJavascript->set_focusid("id_all");
       
        $oOpButtons = new ApphelperButtontabs(tr_entities);
        $oOpButtons->set_tabs($this->build_queryexp_opbuttons());

        //bug($oForm); die;
        $this->oView->add_var($oOpButtons,"oOpButtons");
        $this->oView->add_var($oAlert,"oAlert");
        $this->oView->add_var($oForm,"oForm");
        $this->oView->add_var($oJavascript,"oJavascript");
        $this->oView->set_path_view("adminpannel/_base/view_insert");
        $this->oView->show_page();
    }//queryexport()
    
    private function save_repo()
    {
        pr("save_repo");
    }
//</editor-fold>