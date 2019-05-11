<?php
$str = "w3resourcerasdfasfasr";
$char = [];
$count = 0;

for ($i=0; $i<strlen($str); $i++) {
    $char[$i] = $str[$i];
}

for ($i=0; $i<strlen($str); $i++) {
    if ($char[$i] == 'r') {
        $count++;
    }
}

echo "Found {$count}  r";