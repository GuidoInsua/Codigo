
<?php

/*
    Aplicación No 4 (Calculadora)
    Escribir un programa que use la variable $operador que pueda almacenar los símbolos
    matemáticos: ‘+’, ‘-’, ‘/’ y ‘*’; y definir dos variables enteras $op1 y $op2. De acuerdo al
    símbolo que tenga la variable $operador, deberá realizarse la operación indicada y mostrarse el
    resultado por pantalla.

    Guido Insua  
*/

$operador = '/';
$op1 = rand(0, 100);
$op2 = rand(0, 100);
$resultado;

switch($operador)
{
    case '+':
        $resultado = $op1 + $op2;
        break;
    
    case '-':
        $resultado = $op1 - $op2;
        break;
    
    case '/':
        if($op2 != 0)
        {
            $resultado = $op1 / $op2;
        }
        else
        {
            $resultado = "ERROR";
        }
        break;

    case '*':
        $resultado = $op1 = $op2;
        break;
}

echo $op1 . $operador . $op2 . "<br>";
echo $resultado;

?>