
<?php

/*
    Aplicación No 3 (Obtener el valor del medio)
    Dadas tres variables numéricas de tipo entero $a, $b y $c realizar una aplicación que muestre
    el contenido de aquella variable que contenga el valor que se encuentre en el medio de las tres
    variables. De no existir dicho valor, mostrar un mensaje que indique lo sucedido. 
    Ejemplo 1: $a = 6; $b = 9; $c = 8; => se muestra 8.
    Ejemplo 2: $a = 5; $b = 1; $c = 5; => se muestra un mensaje “No hay valor del medio”

    Set de pruebas para el ejercicio de num en el medio:
    1   5   3    el 3 es del medio
    5   1   5    no hay numero del medio
    3   5   1    el 3 es del medio
    3   1   5    el 3 es del medio
    5   3   1    el 3 es del medio
    1   5   1    no hay numero del medio

    Guido Insua  
*/

$a = rand(0, 100);
$b = rand(0, 100);
$c = rand(0, 100);

echo $a."-".$b."-".$c;

if($a == $b || $a == $c || $b == $c)
{
    echo "<br>No hay numero del medio";
}
else
{
    if($a > $b && $a < $c || $a < $b && $a > $c)
    {
        echo "<br>" . $a;
        return;
    }

    if($b > $a && $b < $c || $b < $a && $b > $c)
    {
        echo "<br>" . $b;
        return;
    }
    echo "<br>" . $c;
}

/*
$a = 1;
$b = 5;
$c = 1;

$vector = array($a,$b,$c);

sort($vector);

if($vector[1] != $vector[0] && $vector[1] != $vector[2])
{
    echo "El numero del medio es: " . $vector[1];
}
else
{
    echo "No hay valor del medio";
}
*/
?>

