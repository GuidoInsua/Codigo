/*
    Aplicación No 8 (Carga aleatoria)
    Imprima los valores del vector asociativo siguiente usando la estructura de control foreach:
    $v[1]=90; $v[30]=7; $v['e']=99; $v['hola']= 'mundo';

    Guido Insua  
*/
<br>
<?php

$v[1] = 90;
$v[30] = 7;
$v['e'] = 99;
$v['hola'] = 'mundo';

foreach ($v as $clave => $valor) 
{
    echo "Clave: $clave, Valor: $valor<br>";
}

?>