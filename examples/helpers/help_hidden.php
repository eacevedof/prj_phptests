<?php
//\helpers\help_hidden.php
use TheFramework\Helpers\HelperInputText;
use TheFramework\Helpers\HelperButtonBasic;
use TheFramework\Helpers\HelperForm;

if(isset($_POST["hidOne"]))//required
    //pr(): is an echo function
    pr("{hidOne:{$_POST["hidOne"]},hidTwo:{$_POST["hidTwo"]}}","\$_POST");

$oDate = new HelperInputText();
$oDate->set_type("date"); //you can change to phone format.
$oDate->set_separator("/");
$oDate->set_id("datDate");
$oDate->set_name("datDate");
$oDate->add_class("form-control col-2");
$oDate->set_value((isset($_POST["datDate"])?$_POST["datDate"]:NULL));


$oButton = new HelperButtonBasic();
$oButton->set_type("submit");
$oButton->add_class("btn btn-primary");
$oButton->set_innerhtml("Submit");

$oForm = new HelperForm();
$oForm->set_id("myForm");
$oForm->set_method("post");
$oForm->add_style("border:1px dashed #4f9fcf;");
$oForm->add_style("padding:5px;");
$oForm->add_inner_object($oHidden1);
$oForm->add_inner_object($oHidden2);
$oForm->add_inner_object($oButton);
$oForm->show(); //show() is the same as echo $oForm->get_html();
