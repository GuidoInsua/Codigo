
<?php

/*
    Aplicación No 1 (Sumar números)
    Confeccionar un programa que sume todos los números enteros desde 1 mientras la suma no
    supere a 1000. Mostrar los números sumados y al finalizar el proceso indicar cuantos números
    se sumaron.

    Guido Insua  
*/

$numero = 0;
$suma = 1;
$contador = 0;

echo "<br>";

while ($numero < 990)
{
    $numero = $numero + $suma;
    $suma = $suma + 1;
    $contador++;
    echo $numero . "<br>";
}
echo "<br>Se sumaron: " . $contador;
?>
