<?php

$number = 0;

do {
    if ($number == 0) {
        echo "$number – это ноль. <br>";
    } elseif ($number % 2 == 0) {
        echo "$number – это чётное число. <br>";
    } else {
        echo "$number – это нечётное число. <br>";
    }

    $number++;

} while ($number <= 10);

?>