<?php
//index.php 2.0.8
//phpinfo();die;

//<editor-fold defaultstate="collapsed" desc="HELPERS">
/**
 * HELPERS
 **
require_once "vendor/autoload.php";//generdo por composer
use TheFramework\Helpers\HelperLabel;
use TheFramework\Helpers\HelperInputText;
use TheFramework\Helpers\HelperDiv;
use TheFramework\Helpers\HelperButtonBasic;
use TheFramework\Helpers\HelperForm;

//FIELD 1
$oLabel = new HelperLabel();
$oLabel->set_for("example-text-input");
$oLabel->add_class("col-2 col-form-label");
$oLabel->set_innerhtml("Text");

$oInputText = new HelperInputText();
$oInputText->set_id("example-text-input");
$oInputText->set_value("Artisanal kale");
$oInputText->add_class("form-control");
$oInputText->required();

$oDiv2 = new HelperDiv();
$oDiv2->add_class("col-10");
$oDiv2->add_inner_object($oInputText);

$oDiv = new HelperDiv();
$oDiv->set_comments("div form row");
$oDiv->add_class("form-group row");
$oDiv->add_inner_object($oLabel);
$oDiv->add_inner_object($oInputText);

//FIELD 2
$oLabe2 = clone $oLabel;
$oLabe2->set_for("inlineFormInputGroup");
$oLabe2->set_class("sr-only");
$oLabe2->set_innerhtml("Username");

$oInputText = new HelperInputText();
$oInputText->set_id("inlineFormInputGroup");
$oInputText->add_class("form-control");
$oInputText->add_extras("placeholder","Username");

$oDiv2 = new HelperDiv();
$oDiv2->add_class("input-group mb-2 mr-sm-2 mb-sm-0");
$oDiv2->add_inner_object(new HelperDiv("@",NULL,"input-group-addon"));
$oDiv2->add_inner_object($oInputText);

$oButton = new HelperButtonBasic();
$oButton->set_type("submit");
$oButton->add_class("btn btn-primary");
$oButton->set_innerhtml("Submit");

$oForm = new HelperForm();
$oForm->set_id("myForm");
$oForm->set_comments("This is a comment");
$oForm->set_method("post");
$oForm->add_style("border:1px dashed #4f9fcf;");
$oForm->add_style("padding:5px;");
$oForm->add_class("form-inline");
$oForm->add_inner_object($oDiv);
$oForm->add_inner_object($oLabe2);
$oForm->add_inner_object($oDiv2);
$oForm->add_inner_object($oButton);
$oForm->show();
 * 
 */
//</editor-fold>

//<editor-fold defaultstate="collapsed" desc="COMPONENTES">
/**
 * COMPONENTES
 **/
ini_set('max_execution_time',3000);
require_once "vendor/theframework/components/autoload.php";
//use TheFramework\Components\ComponentErpaux;
//$oQ = new ComponentErpaux();
//$oQ->get_all();

use TheFramework\Components\Db\Integration\ComponentExpImpMssql;

$arConn["server"]="localhost\MSSQLSERVER2014";
$arConn["database"]="db_theframework";

$oExImp = new ComponentExpImpMssql($arConn);
$arTables = $oExImp->get_tables();
echo "<br/><pre>";
print_r($arTables);

use TheFramework\Components\Db\ComponentMssql;
use TheFramework\Components\Db\ComponentMysql;

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
/*
use TheFramework\Components\ComponentDtsxrep;
$o = new ComponentDtsxrep();
//$o->replace();
$o->replace_status();
*/

/**
require_once "vendor/theframework/components/autoload.php";
//extrae los archvios tratadas en la dts
use TheFramework\Components\ComponentExtract;
$oComp = new ComponentExtract();
$oComp->run(0);

//archivos .XNT que nos han proporcionado
$oComp = new \TheFramework\Components\ComponentScandir();
$oComp->run();

//recupero los alter table
$oComp = new \TheFramework\Components\ComponentHydrapk();
$oComp->run();

/**/

/*
<div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
  </div>
 
use TheFramework\Components\ComponentSqlserver;

use TheFramework\Helpers\HelperLabel;
use TheFramework\Helpers\HelperDate;

$oSql = new ComponentSqlserver();
$oSql->query();

$oLabel = new HelperLabel("datBirthdate","Birthdate","lblBirthdate");
$oDate = new HelperDate();
$oDate->set_type("date");
$oDate->set_id("datBirthdate");
$oDate->set_name("datBirthdate");
$oDate->show();
*/

/*
use TheFramework\Components\ComponentGd2;
$oGd2 = new ComponentGd2();
$oGd2->add_from("pathfolder","C:\\Users\\eduardo alexei\\Desktop\\upload");
$oGd2->add_from("filename","cat3.jpg");

$oGd2->add_to("pathfolder","C:\\Users\\eduardo alexei\\Desktop\\upload");
$oGd2->add_to("filename","cat3_s.jpg");

$oGd2->resize(array("w"=>100));
$oGd2->show_errors();
 */

//use TheFramework\Components\ComponentHydralogs;
//$oWLogs = new ComponentHydralogs();
//$oWLogs->run();
//</editor-fold>

//<editor-fold defaultstate="collapsed" desc="SNIPETS">

//$sText = file_get_contents("c:\\shared\\flamagas_logs\\work_crm3_flamagas_2_20180126.log");
//
//$sPattern = "/\[[0-9,\-,\s:]* \[ok\](.?)*\[/";
//$sPattern = "/\[[0-9,\-,\s:]?\] \[ok\].*$/";
//$sPattern = "/\[([0-9,\-,\s:]?)\] \[ok\] (.?)*/";
//$sPattern = "/\[([0-9]+\-[0-9]+\-[0-9]+ [0-9]+:[0-9]+:[0-9]+)\] /";
//$sPattern = "/\[([0-9]+\-[0-9]+\-[0-9]+ [0-9]+:[0-9]+:[0-9]+)\] \[ok\](.?)*\n\[([0-9]+\-[0-9]+\-[0-9]+ [0-9]+:[0-9]+:[0-9]+)\]/";
//$sPattern = "/\[ok\](.*)\[ok\]/s";
//
//$arResult = array();
//$iResult = preg_match_all($sPattern,$sText,$arResult);
//
//echo "<pre>";
//var_dump($arResult,"patron completo:",$iResult);
//    

//</editor-fold>
