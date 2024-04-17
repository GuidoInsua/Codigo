<?php

/*
    Aplicación No 12 (Invertir palabra)
    Realizar el desarrollo de una función que reciba un Array de caracteres y que invierta el orden
    de las letras del Array.
    Ejemplo: Se recibe la palabra “HOLA” y luego queda “ALOH”.

    Guido Insua
*/

$array1 = array('H','O','L','A');

$arrayInvertido = invertirArray($array1);

foreach($array1 as $letra)
{
    echo $letra;
}

echo "<br>";

foreach($arrayInvertido as $letra)
{
    echo $letra;
}

//-------------------------------------------------------

function invertirArray($array1)
{
    $invertido = array_reverse($array1);

    return $invertido;
}

?>