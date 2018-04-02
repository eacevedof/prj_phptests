<?php
/*
 * @file: comp_mssql_export.php 1.0.4
 * @info: proyecto general
 * Ejemplos: ComponentMssqlExport->get_insert_bulk(...) y ComponentMssqlExport->get_schema()
*/
include("vendor/theframework/components/autoload.php");
ini_set("max_execution_time",3000);
use TheFramework\Components\Db\Integration\ComponentMssqlExport;
$arConn["server"]="localhost\MSSQLSERVER2014";
$arConn["database"]="GemiCar1";
$arConn["user"]="sa";
$arConn["password"]="Sasql2014";

$oExImp = new ComponentMssqlExport($arConn);
$oExImp->set_motor("mysql");
//$arCreate = $oExImp->get_create_table("version_db");
//print_r($arCreate);

//$sSchema = $oExImp->get_schema();
//$sSchema = $oExImp->get_create_table("CambiosPME");
//file_put_contents("C:\Users\ioedu\Desktop\schema.sql",$sSchema);
//pr("total caracteres escritos schema:".strlen($sSchema));
//print_r($sSchema);

$sBulk = $oExImp->get_insert_bulk();
file_put_contents("C:\Users\ioedu\Desktop\insert.sql",$sBulk);
pr("total caracteres escritos insert:".strlen($sBulk));

//$arFields = $oExImp->get_fields_info("app_order_line");
//print_r($arFields);

//$arBulk = $oExImp->get_insert_bulk("app_order_line");
//print_r($arBulk);

