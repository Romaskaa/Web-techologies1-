<?php

$letters = array(
    'а' => 'a', 
    'б' => 'b',
    'в' => 'v',
    'г' => 'g',
    'д' => 'd',
    'е' => 'e',
    'ё' => 'yo',
    'ж' => 'zh',
    'з' => 'z',
    'и' => 'i',
    'й' => 'y',
    'к' => 'k',
    'л' => 'l',
    'м' => 'm',
    'н' => 'n',
    'о' => 'o',
    'п' => 'p',
    'р' => 'r',
    'с' => 's',
    'т' => 't',
    'у' => 'u',
    'ф' => 'f',
    'х' => 'h',
    'ц' => 'c',
    'ч' => 'ch',
    'ш' => 'sh',
    'щ' => 'sch',
    'ь' => '',
    'ы' => 'y',
    'ъ' => '',
    'э' => 'e',
    'ю' => 'yu',
    'я' => 'ya'
);

function translate($string, $letters) {
    $upper = array();

    foreach ($letters as $ru => $en) {
        $upper[mb_strtoupper($ru)] = ucfirst($en);
    }

    $letters = array_merge($letters, $upper);

    return str_replace(array_keys($letters), array_values($letters), $string);
}

$string = "Доброе утро!";
echo "Исходная строка: $string <br>";
echo "Перевод: " . translate($string, $letters);

?>