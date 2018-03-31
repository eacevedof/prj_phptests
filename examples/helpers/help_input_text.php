<?php
//file: helpers.php 1.0.0
/*
 * NOTES:
 * testing of TheFramework\Helpers\
 * http://helpers.theframework.es
*/

//<editor-fold defaultstate="" desc="HELPERS">
/**
 * HELPERS
 **/
require_once "../vendor/autoload.php";//generdo por composer
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

//</editor-fold>
