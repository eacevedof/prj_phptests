<?php
//index.php 2.0.2

//<editor-fold defaultstate="collapsed" desc="HELPERS">
//carga el loader de composer. Este loader solo tiene registrado el loader de helpers.
/**
 * HELPERS
 **/
require_once "vendor/autoload.php";//generdo por composer
use TheFramework\Helpers\HelperLabel;
use TheFramework\Helpers\HelperInputFile;
use TheFramework\Helpers\HelperForm;
use TheFramework\Helpers\HelperDiv;
use TheFramework\Helpers\HelperRaw;
use TheFramework\Helpers\HelperButtonBasic;

//<label for="exampleInputFile">File input</label>
$oLabel = new HelperLabel();
$oLabel->set_for("exampleInputFile");
$oLabel->set_innerhtml("File input");

//<input type="file" class="form-control-file" id="exampleInputFile" aria-describedby="fileHelp">
$oFile = new HelperInputFile("exampleInputFile");
$oFile->add_class("form-control-file");
$oFile->add_extras("aria-describedby","fileHelp");

//there is no such a "HelperSmall" thats why I use HelperRaw in place.
$oRaw = new HelperRaw("<small id=\"fileHelp\" class=\"form-text text-muted\">"
        . "This is some placeholder block-level help text for the above input. "
        . "It's a bit lighter and easily wraps to a new line."
        . "</small>");

//<button type="submit" class="btn btn-primary">Submit</button>
$oButton = new HelperButtonBasic();
$oButton->set_type("submit");
$oButton->add_class("btn btn-primary");
$oButton->set_innerhtml("Submit");

//<div class="form-group">
$oDiv = new HelperDiv();
$oDiv->set_comments("div for label and input");
$oDiv->add_class("form-group");

$oDiv->add_inner_object($oLabel);
$oDiv->add_inner_object($oFile);
$oDiv->add_inner_object($oRaw);

$oForm = new HelperForm();
$oForm->set_action("/helper-input-file/examples/");
$oForm->set_id("myForm");
$oForm->set_comments("This is a comment");
$oForm->set_method("post");
$oForm->set_enctype("multipart/form-data");
$oForm->add_style("border:1px dashed #4f9fcf;");
$oForm->add_style("padding:5px;");
$oForm->add_inner_object($oDiv);
$oForm->add_inner_object($oButton);
$oForm->show();

//</editor-fold>

//<editor-fold defaultstate="collapsed" desc="COMPONENTES">
/**
 * COMPONENTES
 **/

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
