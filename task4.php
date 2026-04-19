<?php

require_once __DIR__ . '/task3.php';

function mathOperation($arg1, $arg2, $operation) {
    switch ($operation) {
        case 'Summ':
            return Summ($arg1, $arg2);
        case 'Diff':
            return Diff($arg1, $arg2);
        case 'Mult':
            return Mult($arg1, $arg2);
        case 'Div':
            return Div($arg1, $arg2);
    }
}

$a = rand(-10, 10);
$b = rand(-10, 10);

$operation = 'Summ';
$result = mathOperation($a, $b, $operation);
echo "Числа a = $a, b = $b <br>";
echo "Результат операции $operation: $result <br>";

$operation = 'Diff';
$result = mathOperation($a, $b, $operation);
echo "Результат операции $operation: $result <br>";

$operation = 'Mult';
$result = mathOperation($a, $b, $operation);
echo "Результат операции $operation: $result <br>";

$operation = 'Div';
$result = mathOperation($a, $b, $operation);
echo "Результат операции $operation: $result <br>";

?>