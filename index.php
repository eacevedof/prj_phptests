<?php
//index.php 2.0.3

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
use TheFramework\Components\ComponentQueries;

$oQ = new ComponentQueries();
$oQ->get_all();

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
