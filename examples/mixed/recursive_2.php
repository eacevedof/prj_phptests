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

print_r($data);

function printAll(array $ar, int $i): void
{
    if (!isset($ar[$i]))
        return;
    echo "\n{$ar[$i]}";
    printAll($ar, $i + 1);
}

//printAll($data, 0);