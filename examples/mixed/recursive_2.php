<?php
/**
 * recursive_2.php
 * test recursive childs
 */

ini_set("memory_limit", "256M");

$data = [];
for($i = 0; $i<100; $i++)
    $data[] = $i;

for($i = 0; $i<33; $i=$i+2)
    $data[$i] = ["a$i"];

for($i = 33; $i<45; $i=$i+2)
    $data[$i] = [["b$i"], ["c$i"]];

//print_r($data);die;

function printTree(array $tree): void
{
    foreach ($tree as $i=>$leaf) {
        if (!is_array($leaf)) {
            echo "$leaf, ";
            continue;
        }
        else {
            printTree($tree);
        }
        //printTree($tree);
    }
}

printTree($data);