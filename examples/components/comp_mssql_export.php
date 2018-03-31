<?php
/*
 * @file: comp_mssql_export.php 1.0.0
 * @info: proyecto general
 * Ejemplos: ComponentMssqlExport->get_insert_bulk(...) y ComponentMssqlExport->get_schema()
*/
include("vendor/theframework/components/autoload.php");
ini_set('max_execution_time',3000);
use TheFramework\Components\Db\Integration\ComponentMssqlExport;
$arConn["server"]="localhost\MSSQLSERVER2014";
$arConn["database"]="theframework";
$arConn["user"]="sa";
$arConn["password"]="Sasql2014";

$oExImp = new ComponentMssqlExport($arConn);
//$arTemp = $oExImp->get_fields_info("app_order_line");
$arTemp = $oExImp->get_insert_bulk("app_order_line");
//$arTemp = $oExImp->get_schema();
print_r($arTemp);
//pr($arTemp);
