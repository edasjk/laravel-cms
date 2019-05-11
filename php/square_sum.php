<?php

echo "Number \tSquare \tSum<br>";
$sum = [];
$start = 5;
$end = 50;

for ($i = 1; $i <= $end; $i++) {

    if ($i === 1) {
        $sum[$i] = 1;
    } else {
        $sum[$i] = $sum[$i-1] + $i;
    }
}

for ($i = $start; $i <= $end; $i++) {
    echo $i . "\t \t \t". $i * $i . "\t" . $sum[$i] ."<br>";
}
