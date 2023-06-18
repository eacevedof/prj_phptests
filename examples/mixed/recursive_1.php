<?php
/**
 * recursive_1.php
 * test recursive
 */

$data = [];
for($i = 0; $i<100; $i++)
    $data[] = $i;

function printAll(array $ar, int $i): void
{
    if (!isset($ar[$i]))
        return;
    echo "\n{$ar[$i]}";
    printTree($ar, $i + 1);
}

printTree($data, 0);