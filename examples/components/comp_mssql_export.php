<?php
/*
 * @file: comp_mssql_export.php 1.0.7
 * @info: proyecto general
 * Ejemplos: ComponentMssqlExport->get_insert_bulk(...) y ComponentMssqlExport->get_schema()
*/
include(TFW_PATHROOTDS."vendor/theframework/components/autoload.php");
ini_set("max_execution_time",3000);
ini_set("memory_limit","-1");
use TheFramework\Components\Db\Integration\ComponentMssqlExport;
$arConn["server"]="localhost\MSSQLSERVER2014";
$arConn["database"]="GemiCar1";
$arConn["user"]="sa";
$arConn["password"]="Sasql2014";

 $arConn = ["server"=>"192.168.5.2\sql2012","database"=>"crm3_flamagas"
    ,"user"=>"sa","password"=>"Enblanco2015"];

$oExImp = new ComponentMssqlExport($arConn);
//$oExImp->set_motor("mysql");
//$arCreate = $oExImp->get_create_table("version_db");
//print_r($arCreate);

//$sSchema = $oExImp->get_schema();
//$sSchema = $oExImp->get_create_table("CambiosPME");
//file_put_contents("C:\Users\ioedu\Desktop\schema.sql",$sSchema);
//pr("total caracteres escritos schema:".strlen($sSchema));
//print_r($sSchema);

//$sBulk = $oExImp->get_insert_bulk();
//file_put_contents("C:\Users\ioedu\Desktop\insert.sql",$sBulk);
//pr("total caracteres escritos insert:".strlen($sBulk));

//$arFields = $oExImp->get_fields_info("app_order_line");
//print_r($arFields);

//$arBulk = $oExImp->get_insert_bulk("app_order_line");
//print_r($arBulk);

//$sSQL = $oExImp->get_notnull_fields("Articulo",1);
//$sSQL = $oExImp->get_notnull_fields("accounts",1);
//$sSQL = $oExImp->get_notnull_fields("prj_accounts",1);
//$sSQL = $oExImp->get_notnull_fields("accounts_organization",1);
//$sSQL = $oExImp->get_notnull_fields("prj_accounts_organization",1);
$sSQL = $oExImp->get_notnull_fields("prj_orders_lines");

//$sSQL = $oExImp->get_empty_fields("accounts");
//$sSQL = $oExImp->get_empty_fields("prj_accounts");
//$sSQL = $oExImp->get_empty_fields("accounts_organization");
//$sSQL = $oExImp->get_empty_fields("prj_accounts_organization");
pr($sSQL);
