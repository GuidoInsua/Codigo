<?php

/*
    Aplicación No 20 (Auto - Garage)
    Crear la clase Garage que posea como atributos privados:
    _razonSocial (String)
    _precioPorHora (Double)
    _autos (Autos[], reutilizar la clase Auto del ejercicio anterior)

    Realizar un constructor capaz de poder instanciar objetos pasándole como parámetros: 
    i. La razón social.
    ii. La razón social, y el precio por hora.

    Realizar un método de instancia llamado “MostrarGarage”, que no recibirá parámetros y que mostrará todos los atributos del objeto.
    Crear el método de instancia “Equals” que permita comparar al objeto de tipo Garaje con un objeto de tipo Auto. 
    Sólo devolverá TRUE si el auto está en el garaje.
    Crear el método de instancia “Add” para que permita sumar un objeto “Auto” al “Garage” 
    (sólo si el auto no está en el garaje, de lo contrario informarlo).
    Ejemplo: $miGarage->Add($autoUno);
    Crear el método de instancia “Remove” para que permita quitar un objeto “Auto” del “Garage” 
    (sólo si el auto está en el garaje, de lo contrario informarlo). 
    Ejemplo: $miGarage->Remove($autoUno);
    Crear un método de clase para poder hacer el alta de un Garage y, guardando los datos en un archivo garages.csv.
    Hacer los métodos necesarios en la clase Garage para poder leer el listado desde el archivo garage.csv
    Se deben cargar los datos en un array de garage.
    En testGarage.php, crear autos y un garage. Probar el buen funcionamiento de todos los métodos.

    Guido Insua
*/

require_once "auto.php";
require_once "garage.php";

date_default_timezone_set('America/Argentina/Buenos_Aires');

$fecha = new DateTime('2000-03-11');

$auto1 = new auto("rojo", 16345, "Peugeot");
$auto2 = new auto("Blanco", 39831, "Peugeot");
$auto3 = new auto("Gris", 57112, "Chevrolet");
$auto4 = new auto("Gris", 37555, "Chevrolet");
$auto5 = new auto("Negro", 73256, "Fiat", $fecha);

$arrayAutos = array($auto1, $auto3, $auto5);

$miGarage = new garage("Garage de Guido", 1400);
$miGarage2 = new garage("Garage de Pepe", 1400);
$miGarage3 = new garage("Garage de Luis");
$miGarage4 = new garage("Garage de Miguel");

echo $miGarage->add($auto1) . "<br>";
echo $miGarage->add($auto2) . "<br>";
echo $miGarage->add($auto3) . "<br>";
echo $miGarage->add($auto4) . "<br>";
echo $miGarage->add($auto5) . "<br>";

$miGarage->guardarEnCsv("garage.csv");
$miGarage2->guardarEnCsv("garage.csv");
$miGarage3->guardarEnCsv("garage.csv");
$miGarage4->guardarEnCsv("garage.csv");

$garages = garage::generarArrayGargaesDeCsv("garage.csv");

echo "<br>";

foreach($garages as $garage)
{
    $garage->mostrarGarage();
    echo "<br>******************************<br>";
}

?>