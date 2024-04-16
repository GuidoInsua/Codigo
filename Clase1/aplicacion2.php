<?php

// mostrar fecha y estacion . Guido Insua

date_default_timezone_set('America/Argentina/Buenos_Aires');
$fecha_actual = date('d-m-Y');

echo $fecha_actual . "<br>";

echo date("F j, Y, g:i a") . "<br>";
echo date('h-i-s, j-m-y, it is w Day') . "<br>";  
echo date('\i\t \i\s \t\h\e jS \d\a\y.') . "<br>";

$dia = date('d');
$mes = date('m');
$estacion = "";

switch($mes)
{
    case 1:
    case 2:
        $estacion = "Verano";
        break;
    case 3:
        if($dia <= 20)
        {
            $estacion = "Verano";
        }
        else
        {
            $estacion = "Otoño";
        }
        break;
    case 4:
    case 5:
        $estacion = "Otoño";
        break;
    case 6:
        if($dia <= 20)
        {
            $estacion = "Otoño";
        }
        else
        {
            $estacion = "Invierno";
        }
        break;
    case 7:
    case 8:
        $estacion = "Invierno";
        break;
    case 9:
        if($dia <= 20)
        {
            $estacion = "Invierno";
        }
        else
        {
            $estacion = "Primavera";
        }
        break;
    case 10:
    case 11:
        $estacion = "Primavera";
        break;
    case 12:
        if($dia <= 20)
        {
            $estacion = "Primavera";
        }
        else
        {
            $estacion = "Verano";
        }
        break;
}

echo $estacion;

?>