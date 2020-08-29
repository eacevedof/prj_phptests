<?php
/*
 * @file: comp_dts_auxrepl 1.0.0
 * @info: proyecto Flamagas
 * Lee C:/xampp/htdocs/dts_flamagas_prod/interfaz obteniendo todos los archivos .dtsx
 * recupera su contenido y remplaza (STATUS='T',0,9)) en un nuevo archivo
 * 
*/
include(TFW_DOCROOTDS."vendor/theframework/components/autoload.php");
use TheFramework\Components\ComponentDtsAuxrepl;
$oComp = new ComponentDtsAuxrepl();

//usa la vista view_gettable
//cambia las tablas erp_archivo por erp_archivo_aux
//guarda el archivo remplazado con ok_<nombre-archivo>
$oComp->replace();

//añade la condicion IIF($sTable.STATUS='T' a todos los archivos
$oComp->replace_status();
 

