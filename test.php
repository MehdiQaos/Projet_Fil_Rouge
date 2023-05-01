<?php

$l = [
    'a' => 1,
    'b' => 2,
    'c' => 3,
];

print_r($l);
unset($l['b']);
print_r($l);

// $t = ['a' => 10];

// echo array_key_exists('b', $t);

// $tab = [5,1,2,3,4,1,2,1,2,3,4];

// for ($i = 0; $i < count($tab)-1; $i++) {
//     // $k = $i;
//     for ($j = 1; $j < count($tab); $j++) {
//         // if ($tab[$j] < $tab[$k])
//         //     $k = $j;
//         if ($tab[$j] < $tab[$i]) {
//             $temp = $tab[$i];
//             $tab[$i] = $tab[$j];
//             $tab[$j] = $temp;
//         }
//     }
//     // if ($k !== $i) {
//     //     $temp = $tab[$k];
//     //     $tab[$k] = $tab[$i];
//     //     $tab[$i] = $temp;
//     // }
// }

// for ($i = 0; $i < count($tab); $i++)
//     echo $tab[$i] . "\n";

// echo "{count($tab)}\n";

// $dict = [];
// foreach ($tab as $e) {
//     if (array_key_exists($e, $dict)) {
//         $dict[$e]++;
//     } else
//         $dict[$e] = 1;
// }

// foreach ($dict as $k => $v) {
//     echo "$k: $v\n";
// }

// for ($i = count($l) - 1; $i >= 0; $i--) {
//     echo $l[$i] . "\n";
// }

// for ($i = 0; $i < count($l); ++i) {
//     echo $l[count($l) - $i - 1];
// }


// $s = 'mehdi';
// echo $s[-1];

// $r = true;
// for ($i = 0; $i< 1000; $i++) {
//     $ll = array_rand($l, 2);
//     if ($ll[0] === $ll[1]) {
//         $r = false;
//         break;
//     }
// }
// var_dump($r);
// $l['name'] = 'mehdi';
// foreach ($l as $e) {
//     echo $e;
//     if ($e == 2) {
//         break;
//     }
// }

// echo $l['name'];

// var_dump(boolval(6 % 2));
