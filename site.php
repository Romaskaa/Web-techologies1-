<?php
$username = "Роман";
$pageName = "Приветственная страница";
$year = date("Y");

function getCurrentTimeWithDeclension(): string
{
    $hours = (int) date("G");
    $minutes = (int) date("i");

    $hLast = $hours % 10;

    if ($hours >= 11 && $hours <= 19) {
        $hourWord = "часов";
    } elseif ($hLast === 1) {
        $hourWord = "час";
    } elseif ($hLast >= 2 && $hLast <= 4) {
        $hourWord = "часа";
    } else {
        $hourWord = "часов";
    }

    $mLast = $minutes % 10;

    if ($minutes >= 11 && $minutes <= 19) {
        $minuteWord = "минут";
    } elseif ($mLast === 1) {
        $minuteWord = "минута";
    } elseif ($mLast >= 2 && $mLast <= 4) {
        $minuteWord = "минуты";
    } else {
        $minuteWord = "минут";
    }

    return "{$hours} {$hourWord} {$minutes} {$minuteWord}";
}

date_default_timezone_set('Asia/Yekaterinburg');
$currentTime = getCurrentTimeWithDeclension();

include ("template.php");
?>