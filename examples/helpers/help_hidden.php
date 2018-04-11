<?php
//\helpers\help_hidden.php
use TheFramework\Helpers\HelperHidden;
use TheFramework\Helpers\HelperButtonBasic;
use TheFramework\Helpers\HelperForm;

if(isset($_POST["hidOne"]))//required
    //pr(): is an echo function
    pr("{hidOne:{$_POST["hidOne"]},hidTwo:{$_POST["hidTwo"]}}","\$_POST");

$oHidden1 = new HelperHidden();
$oHidden1->set_id("hidOne");
$oHidden1->set_name("hidOne");
$oHidden1->set_value((isset($_POST["hidOne"])?$_POST["hidOne"]:"some value for one"));

$oHidden2 = new HelperHidden();
$oHidden2->set_id("hidTwo");
$oHidden2->set_name("hidTwo");
$oHidden2->set_value((isset($_POST["hidOne"])?$_POST["hidOne"]:"some value for two"));

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
$oForm->show(); 
