/*
    Aplicación No 5 (Números en letras)
    Realizar un programa que en base al valor numérico de una variable $num, pueda mostrarse
    por pantalla, el nombre del número que tenga dentro escrito con palabras, para los números
    entre el 20 y el 60.
    Por ejemplo, si $num = 43 debe mostrarse por pantalla “cuarenta y tres”.

    Guido Insua  
*/
<br>
<?php

$num = 21;

$nombres = array("cero","uno","dos","tres","cuatro","cinco","seis","siete","ocho","nueve");

$decenas = array("veinte","treinta","cuarenta","cincuenta","sesenta");

if ($num >= 20 && $num <= 60) {
    if ($num % 10 == 0) {
        $nombre = $decenas[($num / 10)-2];
    } else {
        $decena = floor($num / 10);
        $unidad = $num % 10;
        $nombre = $decenas[$decena-2] . ' y ' . $nombres[$unidad];
    }

    echo "Número: $num<br>";
    echo "En palabras: $nombre<br>";
} else {
    echo "El número no está en el rango de 20 a 60.";
}
?>