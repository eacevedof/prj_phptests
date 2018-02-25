<?php
//index.php 1.0.0 Extract mejorado
//carga el loader de composer. Este loader solo tiene registrado el loader de helpers.
require_once "vendor/autoload.php";
use TheFramework\Helpers\HelperDiv;
$oDiv = new HelperDiv();
$oDiv->set_innerhtml("some div");
$oDiv->show();

$oRaw = new TheFramework\Helpers\HelperRaw("<p>hello</p>");
$oRaw->show();


//require_once "vendor/theframework/components/autoload.php";

//extrae los archvios tratadas en la dts
use TheFramework\Components\ComponentExtract;
$oComp = new ComponentExtract();
$oComp->run(0);

//archivos .XNT que nos han proporcionado
//$oComp = new \TheFramework\Components\ComponentScandir();
//$oComp->run();

//recupero los alter table
//$oComp = new \TheFramework\Components\ComponentHydrapk();
//$oComp->run();

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
