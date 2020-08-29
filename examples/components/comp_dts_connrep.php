<?php
/*
 * @file: comp_dts_connrep.php 1.0.0
 * @info: proyecto Flamagas
 * extrae todos los nombres de los archivos configurados en las dts y recupera de 
 * ERP_IMP_Taules todos estos de modo que se pueda comprobar los que faltan
*/
include(TFW_DOCROOTDS."vendor/theframework/components/autoload.php");

use TheFramework\Components\ComponentDtsConnrep;
$oComp = new ComponentDtsConnrep();
//0 no imprime por pantalla.
$oComp->run(0);

