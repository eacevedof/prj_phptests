<?php
/*
 * @file: comp_arrayquery 1.0.0
 * @info: Ejecutar queries tipo sql sobre un array
 * Es un componente tipo wrapper que permite acotar resultados seggun sus métodos tipo query
 */

include(TFW_PATHROOTDS."vendor/theframework/components/autoload.php");
use TheFramework\Components\ComponentArrayquery;
$result = [
    ["id"=>1,"description"=>"some description 1 x","price"=>10.00,"date"=>"20100220"],
    ["id"=>2,"description"=>"some description 2 y","price"=>20.22,"date"=>"20221001"],
    ["id"=>3,"description"=>"some description 3 z","price"=>20.22,"date"=>"20221001"],
    ["id"=>4,"description"=>"some description 1 x","price"=>10.00,"date"=>"20100220"],
    ["id"=>5,"description"=>"some description 2 y","price"=>20.22,"date"=>"20221001"],
    ["id"=>6,"description"=>"some description 3 z","price"=>20.22,"date"=>"20221001"],
];

$oComp = new ComponentArrayquery($result);




