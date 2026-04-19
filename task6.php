<?php

function power(float $val, float $pow) : float{
    if ($pow == 0) {
        return 1;
    }

    if ($pow < 0) {
        return 1 / power($val, -$pow);
    }

    return $val * power($val, $pow - 1);
}

$val = -2.5;
$pow = 9;

echo "Число: " . $val . "<br> Степень: " . $pow . "<br> Результат: " . power($val, $pow);

?>