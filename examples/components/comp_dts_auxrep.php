<?php
//file: comp_gd2.php 1.0.0
/*
 * @info: proyecto Flamagas
 * Lee C:/xampp/htdocs/dts_flamagas_prod/interfaz obteniendo todos los archivos .dtsx
 * recupera su contenido y remplaza (STATUS='T',0,9)) en un nuevo archivo
 * 
*/
include("vendor/theframework/components/autoload.php");
use TheFramework\Components\ComponentDtsxrep;
$oComp = new ComponentDtsxrep();
$oComp->replace();
$oComp->replace_status();
 

