<?php

// Numero de letras . Guido Insua

$num = rand(20, 60);

$unidades = array("cero","uno","dos","tres","cuatro","cinco","seis","siete","ocho","nueve");

$decenas = array("veinte","treinta","cuarenta","cincuenta","sesenta");

if ($num >= 20 && $num <= 60) {
    if ($num % 10 == 0) {
        $nombre = $decenas[($num / 10)-2];
    } else {
        $decena = floor($num / 10);
        $unidad = $num % 10;
        $nombre = $decenas[$decena-2] . ' y ' . $unidades[$unidad];
    }

    echo "Número: $num<br>";
    echo "En palabras: $nombre<br>";
} else {
    echo "El número no está en el rango de 20 a 60.";
}

?>