<?php
/*
 * @file: comp_mssql_export.php 1.0.3
 * @info: proyecto general
 * Ejemplos: ComponentMssqlExport->get_insert_bulk(...) y ComponentMssqlExport->get_schema()
*/
include("vendor/theframework/components/autoload.php");
ini_set("max_execution_time",3000);
use TheFramework\Components\Db\Integration\ComponentMssqlExport;
$arConn["server"]="localhost\MSSQLSERVER2014";
$arConn["database"]="theframework";
$arConn["user"]="sa";
$arConn["password"]="Sasql2014";

$oExImp = new ComponentMssqlExport($arConn);
$oExImp->set_motor("mysql");
$arCreate = $oExImp->get_create_table_mysql("version_db");
print_r($arCreate);

//$arSchema = $oExImp->get_schema();
//print_r($arSchema);

//$arFields = $oExImp->get_fields_info("app_order_line");
//print_r($arFields);

//$arBulk = $oExImp->get_insert_bulk("app_order_line");
//print_r($arBulk);

