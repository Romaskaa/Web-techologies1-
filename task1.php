<?php

$a = (int) -10;
$b = (int) 20;

if ($a >= 0 && $b >= 0) {
    $difference = $a - $b;
    echo "Разность между $a и $b: $difference";
}

if ($a < 0 && $b < 0) {
    $product = $a * $b;
    echo "Произведение $a и $b: $product";
}

if (($a < 0 && $b >= 0) || ($a >= 0 && $b < 0)) {
    $sum = $a + $b;
    echo "Сумма $a и $b: $sum";
}

?>