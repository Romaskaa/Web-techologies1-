<?php

$date1 = date("Y");
$date2 = new DateTime();
$date3 = getdate();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Начальная страница</title>
</head>
<body>
    <h1>Задача 5</h1>
    <p>Текущий год (Способ 1): <?php echo $date1; ?></p>
    <p>Текущий год (Способ 2): <?php echo $date2->format("Y"); ?></p>
    <p>Текущий год (Способ 3): <?php echo $date3["year"]; ?></p>
</body>
</html>