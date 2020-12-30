<?php
/*
 * @file: comp_arrayquery 1.0.0
 * @info: Ejecutar queries tipo sql sobre un array
 * Es un componente tipo wrapper que permite acotar resultados seggun sus métodos tipo query
 */

include(TFW_PATHROOTDS."vendor/theframework/components/autoload.php");
use TheFramework\Components\ComponentArrayquery;
//supongamos que un endpoint me devuelve esto
$ar1 = [
    ["id"=>1,"description"=>"some description 1 x","price"=>10.00,"date"=>"20100220"],
    ["id"=>2,"description"=>"some description 2 y","price"=>20.22,"date"=>"20221001"],
    ["id"=>3,"description"=>"some description 3 z","price"=>20.22,"date"=>"20221001"],
    ["id"=>4,"description"=>"some description 1 x","price"=>10.00,"date"=>"20100220"],
    ["id"=>5,"description"=>"some description 2 y","price"=>20.22,"date"=>"20221001"],
    ["id"=>6,"description"=>"some description 3 z","price"=>20.22,"date"=>"20221001"],
    ["id"=>7,"description"=>"some description 6 z","price"=>20.25,"date"=>"20221105"],
    ["id"=>8,"description"=>"some description 8 v","price"=>5.99,"date"=>"20170228"],
    ["id"=>9,"description"=>null,"price"=>7.65,"date"=>"20100228"],
    ["id"=>10,"description"=>"","price"=>13.99,"date"=>"19900228"],
];

//otra llamada me devuelve lo siguiente
$ar2 = [
    ["id"=>1,"description"=>"some description 1 a","price"=>10.00,"date"=>"20100220"],
    ["id"=>2,"description"=>"some description 2 y","price"=>20.22,"date"=>"20221001"],
    ["id"=>3,"description"=>"some description 3 z","price"=>20.22,"date"=>"20221001"],
    ["id"=>4,"description"=>"some description 1 x","price"=>10.00,"date"=>"20100220"],
    ["id"=>5,"description"=>"some description 2 c","price"=>20.22,"date"=>"20221001"],
    ["id"=>6,"description"=>"some description 3 z","price"=>20.22,"date"=>"20221001"],
    ["id"=>7,"description"=>"some description 6 z","price"=>20.25,"date"=>"20221105"],
    ["id"=>8,"description"=>"some description 8 v","price"=>5.99,"date"=>"20170228"],
    ["id"=>9,"description"=>null,"price"=>7.65,"date"=>"20100228"],
    ["id"=>11,"description"=>"","price"=>13.99,"date"=>"19900228"],
];

$oComp = new ComponentArrayquery($ar1);

//probando map, filter reduce
/*
$r = $oComp->map(function($item){
        return [
            //transformo el array original, cambio date por day y price por p
            "id" => $item["id"], "name"=> $item["description"], "day"=>$item["date"], "p"=>$item["price"]
        ];
    })
    ->filter(function ($item){
        //me quedo con los precios > 10
        return $item["p"] > 10;
    })
    ->reduce(function($ac, $item){
        //sumo los precios
        return $ac + $item["p"];
    },0)
;
*/

//$r = $oComp->remove_column(["id"])->distinct()->where("price",20.22);
/**
array (
    0 =>
    array (
        'description' => 'some description 2 y',
        'price' => 20.22,
        'date' => '20221001',
    ),
    1 =>
    array (
        'description' => 'some description 3 z',
        'price' => 20.22,
        'date' => '20221001',
    ),
)
 */
//$r = $oComp->distinct()->where("price","20.2%","like")->where("date","%05","like" );
/*
array (
  0 =>
  array (
    'id' => 7,
    'description' => 'some description 6 z',
    'price' => 20.25,
    'date' => '20221105',
  ),
)
 */
$r = $oComp->distinct()->where("description","%z%","like");
/*
array (
  0 =>
  array (
    'id' => 3,
    'description' => 'some description 3 z',
    'price' => 20.22,
    'date' => '20221001',
  ),
  1 =>
  array (
    'id' => 6,
    'description' => 'some description 3 z',
    'price' => 20.22,
    'date' => '20221001',
  ),
  2 =>
  array (
    'id' => 7,
    'description' => 'some description 6 z',
    'price' => 20.25,
    'date' => '20221105',
  ),
)
*/
//$r = $oComp->distinct()->where("price",6,">")->where("price",11,"<");
//$r = $oComp->is_null("description");
//$r = $oComp->is_empty("description");
//$r = $oComp->in("date", ["20221001","20221105"])->not_in("description", ["some description 2 y"]);

//$r = $oComp->innerjoin($ar2,["id"=>"id","description"=>"description"])->orderby("date", "desc");
/*
 array (
  0 =>
  array (
    'id' => 7,
    'description' => 'some description 6 z',
    'price' => 20.25,
    'date' => '20221105',
  ),
  1 =>
  array (
    'id' => 3,
    'description' => 'some description 3 z',
    'price' => 20.22,
    'date' => '20221001',
  ),
  2 =>
  array (
    'id' => 6,
    'description' => 'some description 3 z',
    'price' => 20.22,
    'date' => '20221001',
  ),
)
*/
$r = $oComp->leftjoin($ar2,["id"=>"id","description"=>"description"])->orderby("date", "desc");
/*
array (
  0 =>
  array (
    'id' => 7,
    'description' => 'some description 6 z',
    'price' => 20.25,
    'date' => '20221105',
    '*leftjoin*' => 0,
  ),
  1 =>
  array (
    'id' => 3,
    'description' => 'some description 3 z',
    'price' => 20.22,
    'date' => '20221001',
    '*leftjoin*' => 0,
  ),
  2 =>
  array (
    'id' => 6,
    'description' => 'some description 3 z',
    'price' => 20.22,
    'date' => '20221001',
    '*leftjoin*' => 0,
  ),
)
*/
pr($r->get_result(),"result");



