
<?php

/*
    Aplicación No 6 (Carga aleatoria)
    Definir un Array de 5 elementos enteros y asignar a cada uno de ellos un número (utilizar la
    función rand). Mediante una estructura condicional, determinar si el promedio de los números
    son mayores, menores o iguales que 6. Mostrar un mensaje por pantalla informando el
    resultado.

    Guido Insua  
*/

$vec = array(0,0,0,0,0);
$mayor = 0;
$menor = 0;
$igual = 0;

for ($i = 0; $i < 5; $i++)
{
    $vec[$i] = rand(0, 10);
    
    if($vec[$i] > 6)
    {
        $mayor++;
    }
    else
    {
        if($vec[$i] < 6)
        {
            $menor++;
        }
        else
        {
            $igual++;
        }
    }
}

if($mayor > $menor && $mayor > $igual)
{
    echo "La mayoria de los numeros son mas grandes que 6";
}
else
{
    if($menor > $igual)
    {
        echo "La mayoria de los numeros son mas chicos que 6";
    }
    else
    {
        echo "la mayoria de los numeros son igual a 6";
    }
}

?>