<?php
//\helpers\help_hidden.php
include(TFW_DOCROOTDS."vendor/autoload.php");

use TheFramework\Helpers\Form\Input\Hidden;
use TheFramework\Helpers\Html\ButtonBasic;
use TheFramework\Helpers\HelperForm;

if(isset($_POST["hidOne"]))//required
    //pr(): is an echo function
    pr("{_POST[hidOne]:{$_POST["hidOne"]}, _POST[hidTwo]:{$_POST["hidTwo"]}}","\$_POST");

$oHidden1 = new Hidden();
$oHidden1->set_id("hidOne");
$oHidden1->set_name("hidOne");
$oHidden1->set_value((isset($_POST["hidOne"])?$_POST["hidOne"]:"some value for one"));

$oHidden2 = new Hidden();
$oHidden2->set_id("hidTwo");
$oHidden2->set_name("hidTwo");
$oHidden2->set_value((isset($_POST["hidTwo"])?$_POST["hidTwo"]:"some value for two"));

$oButton = new ButtonBasic();
$oButton->set_type("submit");
$oButton->add_class("btn btn-primary");
$oButton->set_innerhtml("Test");

$oForm = new HelperForm();
$oForm->set_id("myForm");
//$oForm->set_action("/");
$oForm->set_method("post");
$oForm->add_style("border:1px dashed #4f9fcf;");
$oForm->add_style("padding:5px;");
$oForm->add_inner_object($oHidden1);
$oForm->add_inner_object($oHidden2);
$oForm->add_inner_object($oButton);
$oForm->show(); 
