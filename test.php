<?php
$l = [1, 2, 3, 4];
$l['name'] = 'mehdi';
foreach ($l as $e) {
    echo $e;
    if ($e == 2) {
        break;
    }
}

echo $l['name'];
