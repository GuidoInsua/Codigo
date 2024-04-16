/*
    Aplicación No 4 (Calculadora)
    Escribir un programa que use la variable $operador que pueda almacenar los símbolos
    matemáticos: ‘+’, ‘-’, ‘/’ y ‘*’; y definir dos variables enteras $op1 y $op2. De acuerdo al
    símbolo que tenga la variable $operador, deberá realizarse la operación indicada y mostrarse el
    resultado por pantalla.

    Guido Insua  
*/
<br>
<?php

$operador = "y";
$op1 = 1;
$op2 = 3;
$res = 0;

switch($operador)
{
    case "+":
        $res = $op1 + $op2;
    break;

    case "-":
        $res = $op1 + $op2;
    break;

    case "*":
        $res = $op1 + $op2;
    break;

    case "/":
        $res = $op1 + $op2;
    break;
}

echo "El resultado es: " . $res;
?>