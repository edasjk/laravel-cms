<?php

$arr = [];
$str = [];

for ($i=0; $i<100; $i++) {
    $arr[$i] = $i;
}

for ($i=0; $i<100; $i++) {
    if (strlen($arr[$i]) === 1) {
       $arr[$i] = "0" . $arr[$i];
    }
    if ( $i % 10 == 0) {
        $arr[$i] = "<br>" . $arr[$i];    
    }
}

$comma = implode(", ", $arr );

echo $comma;