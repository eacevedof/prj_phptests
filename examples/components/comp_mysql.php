<?php
/*
 * @file: comp_mysql.php 1.0.0
 * @info: proyecto general
 * Ejemplos: ComponentMysql->query(Select * from...) y ComponentMysql->exec(insert into...)
*/
include(TFW_PATHROOTDS."vendor/theframework/components/autoload.php");
use TheFramework\Components\Db\ComponentMysql;
$oMs = new ComponentMysql();
$oMs->add_conn("server","localhost");
$oMs->add_conn("database","db_killme");
$oMs->add_conn("user","root");
$oMs->add_conn("password","");
$arRows = $oMs->query("SELECT * FROM base_user");
echo "<br>MYSQL: {$oMs->get_affected()}<br/>";
if($oMs->is_error())
{
    $oMs->show_errors();
    die();
}
$sSQL = "INSERT INTO app_activity(code_erp,date_accomplished,date_programmed,description)
        VALUES('111','555çÇ','ññññ','kkkhh888')
        ";
$oMs->exec($sSQL);
if($oMs->is_error())
{
    $oMs->show_errors();
    die();
}
echo "<br>{$oMs->get_affected()}<br/>";


 

