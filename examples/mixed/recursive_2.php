<?php
/**
 * recursive_2.php
 * test recursive childs
 */

$data = [];
for($i = 0; $i<100; $i++)
    $data[] = $i;

for($i = 0; $i<33; $i=$i+2)
    $data[$i] = [$i];

for($i = 33; $i<45; $i=$i+2)
    $data[$i] = [[$i]];

function printTree(array $tree): void
{
    foreach ($tree as $leaf) {
        if (!is_array($leaf)) {
            echo $leaf;
            continue;
        }
        printTree($tree);
    }
}

printAll($data);