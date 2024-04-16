/*
    Aplicación No 2 (Mostrar fecha y estación)
    Obtenga la fecha actual del servidor (función date) y luego imprímala dentro de la página con
    distintos formatos (seleccione los formatos que más le guste). Además indicar que estación del
    año es. Utilizar una estructura selectiva múltiple.

    Guido Insua  
*/

<?php
$dia = date("z"); 
$estacion;

echo "<br>";
echo date("F j, Y, g:i a");
echo "<br>";
echo date("j, n, Y"); 
echo "<br>";
echo date("Ymd");
echo "<br>";
echo date('l jS \of F Y h:i:s A');
echo "<br>";

if ($dia >= 355 || ($dia >= 1 && $dia <= 80)) {
    $estacion = "verano";
} elseif ($dia >= 81 && $dia <= 172) {
    $estacion = "otoño";
} elseif ($dia >= 173 && $dia <= 264) {
    $estacion = "invierno";
} else {
    $estacion = "primavera";
}

echo "La estación en la que te encuentras es: $estacion";
?>