<?php
/*
 * @file: comp_hydra_pk 1.0.0
 * @info: proyecto Hydra
 * Lee el archivo C:\shared\constraints.sql que lleva todas las claves privadas
 * esto sirve para añadir las claves despues de volcar todos los datos.
 * El archivo constraints.sql se saca desde el admin de hydra.
*/
include(TFW_PATHROOTDS."vendor/theframework/components/autoload.php");
$oComp = new \TheFramework\Components\ComponentHydrapk();
$oComp->run();
