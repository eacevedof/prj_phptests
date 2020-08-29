<?php
/*
 * @file: comp_dts_queryrep.php 1.0.0
 * @info: proyecto Flamagas
 * Genera consulta del tipo: 
 * DELETE FROM ERP_T001 FROM ERP_T001_AUX INNER JOIN ERP_T001 ON ERP_T001_AUX.BUKRS = ERP_T001.BUKRS
*/
include(TFW_DOCROOTDS."vendor/theframework/components/autoload.php");
$oComp = new TheFramework\Components\ComponentDtsQueryrep();
$oComp->get_all();

 

