<?php
/**
 * @file: php_get_top_parent.php
 * @info: A partir de un array con id y id_parent se obtiene el padre de mayor jerarquia
 */
$ar = [
    ["id"=>1,"id_parent"=>null],
    ["id"=>2,"id_parent"=>1],
    ["id"=>3,"id_parent"=>1],
    ["id"=>7,"id_parent"=>null],
    ["id"=>4,"id_parent"=>2],
    ["id"=>5,"id_parent"=>3],
    ["id"=>6,"id_parent"=>5],
    ["id"=>8,"id_parent"=>7],
    ["id"=>9,"id_parent"=>5],
    ["id"=>10,"id_parent"=>5],
];

function get_parent($id, $ar)
{
    $newar = array_filter($ar, function($item) use ($id){
        return $item["id"] === $id;
    });
    $newar = array_values($newar);
    //print_r($newar);
    $idparent = $newar[0]["id_parent"];
    if(!$idparent) return $newar[0];

    //obtener el item padre directo
    $newar = array_filter($ar, function($item) use ($idparent){
        return $item["id"] === $idparent;
    });
    $newar = array_values($newar);
    //print_r($newar);
    $idparent = $newar[0]["id_parent"];
    if(!$idparent) return $newar[0];

    return get_parent($idparent, $ar);
}

function load_childs($id, $ar, &$ac=[])
{
    $childs = array_filter($ar, function ($item) use ($id){
       return $item["id_parent"] === $id;
    });

    if(!$childs) return;

    $ids = array_map(function ($item){
       return $item["id"];
    }, $childs);

    $ac = array_merge($ac, $ids);
    foreach ($ids as $id)
        load_childs($id, $ar, $ac);
}

pr(json_encode($ar, JSON_PRETTY_PRINT));
$parent = get_parent(8, $ar);
bug($parent, "parent of id = 8");
$parent = get_parent(10, $ar);
bug($parent, "parent of id = 10");

$ch = [];
load_childs(2, $ar, $ch);
bug($ch, "all childs of id = 2");

$ch = [];
load_childs(5, $ar, $ch);
bug($ch, "all childs of id = 5");

$ch = [];
load_childs(3, $ar, $ch);
bug($ch, "all childs of id = 3");

$ch = [];
load_childs(1, $ar, $ch);
bug($ch, "all childs of id = 1");

$ch = [];
load_childs(10, $ar, $ch);
bug($ch, "all childs of id = 10");