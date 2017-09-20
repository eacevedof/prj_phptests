<?php
//index.php 1.0.0 Extract mejorado
//carga el loader de composer. Este loader solo tiene registrado el loader de helpers.
require_once "vendor/autoload.php";
//$oRaw = new Theframework\Helpers\HelperRaw("<p>hello</p>");
//$oRaw->show();
//use Theframework\Helpers\HelperDiv;
//$oDiv = new HelperDiv();
//$oDiv->set_innerhtml("some div");
//$oDiv->show();

require_once "vendor/theframework/components/autoload.php";

//extrae los archvios tratadas en la dts
use TheFramework\Components\ComponentExtract;
$oComp = new ComponentExtract();
//$oComp->run(0);

//archivos .XNT que nos han proporcionado
$oComp = new \TheFramework\Components\ComponentScandir();
//$oComp->run();

//recupero los alter table
$oComp = new \TheFramework\Components\ComponentHydrapk();
$oComp->run();
