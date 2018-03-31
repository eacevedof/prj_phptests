<?php
//file: comp_gd2.php 1.0.0
/*
 * NOTES:
 * 
*/
require_once "vendor/theframework/components/autoload.php";
//extrae los archvios tratadas en la dts
use TheFramework\Components\ComponentExtract;
$oComp = new ComponentExtract();
$oComp->run(0);

