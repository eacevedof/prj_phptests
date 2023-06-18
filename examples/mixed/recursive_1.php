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
    echo $ar[$i];
    printAll($ar, $i + 1);
}