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

$ch = [];
function get_childs($id, $ar)
{
    global $ch;

    $childs = array_filter($ar, function ($item) use ($id){
       return $item["id_parent"] === $id;
    });

    if(!$childs) return [];

    $ids = array_map(function ($item){
       return $item["id"];
    }, $childs);

    $ch = array_merge($ch, $ids);
    $ch = array_unique($ch);

    foreach ($ids as $id)
        get_childs($id, $ar);
}

pr($ar);
$parent = get_parent(8,$ar);
bug($parent, "parent of id=8");
$childs = get_childs(2, $ar);
bug($ch, "all childs of id=2");