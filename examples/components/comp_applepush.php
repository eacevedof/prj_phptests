<?php
/*
 * @file: comp_applepush 2.0.0
 * @info: proyecto reparto
 * Envia notificacion push a APN
 */

include(TFW_PATHROOTDS."vendor/theframework/components/autoload.php");
use TheFramework\Components\Apple\ComponentPushapple;
$oComp = new ComponentPushapple();
//carga configuración de desarrollo ckdev.pem
$oComp->load_dev();
//carga configuración de produccion ckprod.pem
//$oComp->load_prod();
//usa la vista view_gettable
//cambia las tablas erp_archivo por erp_archivo_aux
//guarda el archivo remplazado con ok_<nombre-archivo>
$oComp->send_push();