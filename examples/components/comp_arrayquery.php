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
    ["id"=>7,"description"=>"some description 6 z","price"=>20.25,"date"=>"20221105"],
    ["id"=>8,"description"=>"some description 8 v","price"=>5.99,"date"=>"20170228"],
    ["id"=>9,"description"=>null,"price"=>7.65,"date"=>"20100228"],
    ["id"=>9,"description"=>"","price"=>13.99,"date"=>"19900228"],
];

$oComp = new ComponentArrayquery($result);
//$r = $oComp->remove_column(["id"])->distinct()->where("price",20.22);
//$r = $oComp->distinct()->where("price","20.2%","like")->where("date","%05","like" );
//$r = $oComp->distinct()->where("description","%z%","like");
//$r = $oComp->distinct()->where("price",6,">")->where("price",11,"<");
//$r = $oComp->is_null("description");
$r = $oComp->is_empty("description");
pr($r->get_result(),"result");



