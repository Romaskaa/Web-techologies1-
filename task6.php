<?php

$regions = array(
    "Московская область" => array("Москва", "Зеленоград", "Клин", "Королёв"),
    "Ленинградская область" => array("Санкт-Петербург", "Всеволожск", "Павловск", "Кронштадт"),
    "Рязанская область" => array("Рязань", "Касимов", "Скопин", "Ряжск")
);

foreach ($regions as $region => $cities) {

    $i = 0;
    $first = "К";
    $count = 0;

    foreach ($cities as $city) {
        if ($first === mb_substr($city, 0, 1)) {
            $count++;
        }
    }

    echo "$region: <br>";

    foreach ($cities as $city) {

        if ($first === mb_substr($city, 0, 1)) {
            $i++;
            echo "$city";

            if ($i < $count) {
                echo ", ";
            } else {
                echo ".";
            }
        }

    }

    echo "<br>";
}

?>