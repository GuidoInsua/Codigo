<?php

/*
    Aplicación No 19 (Auto)
    Realizar una clase llamada “Auto” que posea los siguientes atributos privados:
    _color (String)
    _precio (Double)
    _marca (String).
    _fecha (DateTime)

    Realizar un constructor capaz de poder instanciar objetos pasándole como parámetros:
    i. La marca y el color.
    ii. La marca, color y el precio.
    iii. La marca, color, precio y fecha.

    Realizar un método de instancia llamado “AgregarImpuestos”, que recibirá un doble por parámetro y que se sumará al precio del objeto.
    Realizar un método de clase llamado “MostrarAuto”, que recibirá un objeto de tipo “Auto” por parámetro y que mostrará todos los atributos de dicho objeto.
    Crear el método de instancia “Equals” que permita comparar dos objetos de tipo “Auto”. Sólo devolverá TRUE si ambos “Autos” son de la misma marca.
    Crear un método de clase, llamado “Add” que permita sumar dos objetos “Auto” (sólo si son de la misma marca, y del mismo color, de lo contrario informarlo)
    y que retorne un Double con la suma de los precios o cero si no se pudo realizar la operación.
    Ejemplo: $importeDouble = Auto::Add($autoUno, $autoDos);
    Crear un método de clase para poder hacer el alta de un Auto, guardando los datos en un archivo autos.csv.
    Hacer los métodos necesarios en la clase Auto para poder leer el listado desde el archivo autos.csv
    Se deben cargar los datos en un array de autos.

    En testAuto.php:
    ● Crear dos objetos “Auto” de la misma marca y distinto color.
    ● Crear dos objetos “Auto” de la misma marca, mismo color y distinto precio. 
    ● Crear un objeto “Auto” utilizando la sobrecarga restante.
    ● Utilizar el método “AgregarImpuesto” en los últimos tres objetos, agregando $ 1500 al atributo precio.
    ● Obtener el importe sumado del primer objeto “Auto” más el segundo y mostrar el resultado obtenido.
    ● Comparar el primer “Auto” con el segundo y quinto objeto e informar si son iguales o no.
    ● Utilizar el método de clase “MostrarAuto” para mostrar cada los objetos impares (1, 3, 5)

    Guido Insua
*/

require_once "auto.php";

date_default_timezone_set('America/Argentina/Buenos_Aires');

$fecha_actual = new DateTime();

$unAuto = new auto(color: "Rojo", marca: "Fiat");
$unAuto2 = new auto(color: "Verde", marca: "Fiat");
$unAuto3 = new auto(color: "Negro", marca: "Chevrolet", precio: 111111);
$unAuto4 = new auto(color: "Negro", marca: "Chevrolet", precio: 222222);
$unAuto5 = new auto(color: "Azul", marca: "Volkswagen", precio: 524523, fecha: $fecha_actual);

$unAuto3->agregarImpuestos(1500);
$unAuto4->agregarImpuestos(1500);
$unAuto5->agregarImpuestos(1500);

echo "<br>";

echo auto::add($unAuto, $unAuto2);

if($unAuto->equals($unAuto2))
{
    echo "<br>El primer y segundo auto, son iguales";
}
else
{
    echo "<br>El primer y segundo auto, son distintos";
}

if($unAuto->equals($unAuto5))
{
    echo "<br>El primer y quinto auto, son iguales";
}
else
{
    echo "<br>El primer y quinto auto, son distintos";
}

$unAuto->guardarEnCsv("autos.csv");
$unAuto2->guardarEnCsv("autos.csv");
$unAuto3->guardarEnCsv("autos.csv");
$unAuto4->guardarEnCsv("autos.csv");
$unAuto5->guardarEnCsv("autos.csv");

echo "<br>";

$autos = auto::generarArrayAutosDeCsv("autos.csv");

foreach($autos as $auto)
{
    if($auto instanceof auto)
    {
        auto::mostrarAuto($auto);
        echo "<br>------------------------------------<br>";
    }
}


?>