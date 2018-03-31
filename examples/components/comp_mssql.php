<?php
/*
 * @file: comp_mssql.php 1.0.0
 * @info: proyecto general
 * Ejemplos: ComponentMssql->query(Select * from...) y ComponentMssql->exec(insert into...)
*/
include("vendor/theframework/components/autoload.php");
use TheFramework\Components\Db\ComponentMssql;

$arConn = ["server"=>"localhost/MSSQL2014","database"=>"theframework","user"=>"sa","password"=>"xYz"];
$oMs = new ComponentMssql($arConn);
$arRows = $oMs->query("SELECT * FROM app_customer");

echo "<br>{$oMs->get_affected()}<br/>";
if($oMs->is_error())
{
    $oMs->show_errors();
    die();
}
/*
+--------------+-------------------+------+---------+--------+
|    Tabla     |      Columna      | ispk |  Tipo   | Tamaño |
+--------------+-------------------+------+---------+--------+
| app_activity | code_erp          |      | varchar |     25 |
| app_activity | date_accomplished |      | varchar |      8 |
| app_activity | date_programmed   |      | varchar |      8 |
| app_activity | description       |      | varchar |    200 |
+--------------+-------------------+------+---------+--------+
*/

$sSQL = "INSERT INTO app_activity(code_erp,date_accomplished,date_programmed,description)
        VALUES('AA','BBB','CCçÇC','ññññÜ')
        ";
$oMs->exec($sSQL);
if($oMs->is_error())
{
    $oMs->show_errors();
    die();
}
echo "<br>{$oMs->get_affected()}<br/>";



 

