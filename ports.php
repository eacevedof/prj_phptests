<?php

$out = [];
$result = [];
$ok = [
    1024,1025,1026,1027,1028,1029,3000
];
for($i=end($ok); $i<65536; $i++){
    if(in_array($i,$ok)) continue;
    $cmd = "php -S localhost:$i -t ./public; ";
    //exec($cmd,$out,$r);
    //$result[] = "port $i, r: $r";
    //system($cmd,$r);
    $id = proc_open($cmd);
    print_r($id);
}
print_r($result);