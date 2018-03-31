<?php
//file: comp_gd2.php 1.0.0
/*
 * NOTES:
 * 
*/
ini_set('max_execution_time',3000);
require_once "vendor/theframework/components/autoload.php";
//use TheFramework\Components\ComponentErpaux;
//$oQ = new ComponentErpaux();
//$oQ->get_all();

use TheFramework\Components\Db\Integration\ComponentExpImpMssql;

$arConn["server"]="localhost\MSSQLSERVER2014";
$arConn["database"]="theframework";
$arConn["user"]="sa";
$arConn["password"]="Sasql2014";

$oExImp = new ComponentExpImpMssql($arConn);
//$arTemp = $oExImp->get_fields_info("app_order_line");
$arTemp = $oExImp->get_insert_bulk("app_order_line");
//$arTemp = $oExImp->get_schema();
echo "<br/><pre>";
print_r($arTemp);

die;
