
<?php

/*
    Aplicación Nº 13 (Invertir palabra)
    Crear una función que reciba como parámetro un string ($palabra) y un entero ($max). La
    función validará que la cantidad de caracteres que tiene $palabra no supere a $max y además
    deberá determinar si ese valor se encuentra dentro del siguiente listado de palabras válidas:
    “Recuperatorio”, “Parcial” y “Programacion”. Los valores de retorno serán: 1 si la palabra
    pertenece a algún elemento del listado.
    0 en caso contrario.

    Guido Insua
*/

$palabra = "Recuperatorio";
$palabrasValidas = array("Recuperatorio", "Parcial", "Programacion");
$max = 50;
$resultado = -1;

$resultado = palabraCumpleRequisitos($palabra, $max, $palabrasValidas);

echo $resultado;


function palabraCumpleRequisitos ($palabra, $max, $arrayPalabrasValidas)
{
    //interpreto que retorna 1 solo si la palabra se encuentra en el listado y cumple la condicion de max

    if(palabraNoSuperaMax($palabra, $max) && stringExisteEnArray($palabra, $arrayPalabrasValidas))
    {
        return 1;
    }

    return 0;
    
}

function palabraNoSuperaMax($palabra, $max)
{
    if(is_int($max) && strlen($palabra) <= $max)
    {
        return true;
    }

    return false;
}

function stringExisteEnArray($palabra1, $arrayPalabrasValidas)
{
    if (is_bool(array_search($palabra1, $arrayPalabrasValidas)))
    {
        return false;
    }

    return true;
}

?>