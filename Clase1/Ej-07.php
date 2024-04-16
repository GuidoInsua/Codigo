/*
    Aplicación No 7 (Mostrar impares)
    Generar una aplicación que permita cargar los primeros 10 números impares en un Array.
    Luego imprimir (utilizando la estructura for) cada uno en una línea distinta (recordar que el
    salto de línea en HTML es la etiqueta br). Repetir la impresión de los números
    utilizando las estructuras while y foreach.

    Guido Insua  
*/
<br>
<?php

$arrayImpar = array();
$numImpar = 1;
$j = 0;

for ($i = 0; $i<10; $i++)
{
    $arrayImpar[$i] = $numImpar;
    $numImpar = $numImpar + 2;

    echo "<br>" . $arrayImpar[$i];
}

echo "<br>---------";

while($j < 10)
{
    echo "<br>" . $arrayImpar[$j];
    $j++;
}

echo "<br>--------";

foreach($arrayImpar as $num)
{
    echo "<br>" . $num;
}

?>