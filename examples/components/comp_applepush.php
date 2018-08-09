<?php
/*
 * @file: comp_applepush 1.0.0
 * @info: proyecto reparto
 * Lee envia notificacion push a APN
 * 
*/
include("vendor/theframework/components/autoload.php");
use TheFramework\Components\Apple\ComponentPushapple;
$oComp = new ComponentPushapple();

//usa la vista view_gettable
//cambia las tablas erp_archivo por erp_archivo_aux
//guarda el archivo remplazado con ok_<nombre-archivo>
$oComp->send_push();



