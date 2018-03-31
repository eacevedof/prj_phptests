<?php
/*
 * @file: comp_gd2 1.0.0
 * @info: proyecto Hydra
 * Clase prototipo para trabajar con gd2
 * Espera variables globales propias de hydra. No se ha terminado, se quedo en fase de prueba
 * contiene errores.
*/
include("vendor/theframework/components/autoload.php");
use TheFramework\Components\ComponentGd2;
$oGd2 = new ComponentGd2();
$oGd2->add_from("pathfolder","C:\\Users\\eduardo alexei\\Desktop\\upload");
$oGd2->add_from("filename","cat3.jpg");

$oGd2->add_to("pathfolder","C:\\Users\\eduardo alexei\\Desktop\\upload");
$oGd2->add_to("filename","cat3_s.jpg");

$oGd2->resize(array("w"=>100));
$oGd2->show_errors();


 

