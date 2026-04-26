<?php

$regions = array(
    "Московская область" => array("Москва", "Зеленоград", "Клин"),
    "Ленинградская область" => array("Санкт-Петербург", "Всеволожск", "Павловск", "Кронштадт"),
    "Рязанская область" => array("Рязань", "Касимов", "Скопин", "Ряжск")
);

foreach ($regions as $region => $cities) {

    $i = 0;
    $count = count($cities);

    echo "$region: <br>";
    foreach ($cities as $city) {

        $i++;
        echo "$city";
        
        if ($i < $count) {
            echo ", ";
        } else {
            echo ".";
        }

    }
    echo "<br>";
}

?>