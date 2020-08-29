<?php
/*
 * @file: comp_hydra_logs 1.0.0
 * @info: proyecto Hydra
 * Recupera y muestra por pantalla todos los logs que cumplen ciertas condiciones.
 * Son logs de trabajo de determinados usuarios
*/
include(TFW_PATHROOTDS."vendor/theframework/components/autoload.php");
use TheFramework\Components\ComponentHydralogs;
$oWLogs = new ComponentHydralogs();
$oWLogs->run();
if($oWLogs->is_error())
    $oWLogs->show_errors();


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