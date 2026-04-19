<?php

function Summ(float $a, float $b) : float {
    return $a + $b;
}

function Diff(float $a, float $b) : float {
    return $a - $b;
}

function Mult(float $a, float $b) : float {
    $result = $a * $b;
    if ($result == 0.0) {
        return 0.0;
    }

    return $result;
}

function Div(float $a, float $b) : float {
    if ($b == 0) {
        return 0;
    }

    $result = $a / $b;
    if ($result == 0.0) {
        return 0.0;
    }

    return $result;
}

?>