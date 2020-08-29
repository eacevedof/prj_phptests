<?php
/*
 * @file: comp_dts_extract 1.0.0
 * @info: proyecto Flamagas
 * Imprime por pantalla un array con los nombres de los directorios y sus archivos 
 * tipo <fecha><nombre-archivo>.XNT
 * lee en rutas:
 *  "C:/xampp/htdocs/proy_hydra_flamagas/dts/update_20170620_pricing",
    "C:/xampp/htdocs/proy_hydra_flamagas/dts/update_20170705_tablas_enblanco",
    "C:/xampp/htdocs/proy_hydra_flamagas/dts/update_20170706_campo_en_knb1",
    "C:/xampp/htdocs/proy_hydra_flamagas/dts/Datos/IN/BackUP"
 * 
*/
include(TFW_DOCROOTDS."vendor/theframework/components/autoload.php");
//archivos .XNT que nos han proporcionado
$oComp = new \TheFramework\Components\ComponentDtsExtract();

/*
 *  "C:/xampp/htdocs/proy_hydra_flamagas/dts/update_20170620_pricing",
    "C:/xampp/htdocs/proy_hydra_flamagas/dts/update_20170705_tablas_enblanco",
    "C:/xampp/htdocs/proy_hydra_flamagas/dts/update_20170706_campo_en_knb1",
    "C:/xampp/htdocs/proy_hydra_flamagas/dts/Datos/IN/BackUP"
 */
$oComp->run();

 

