
<?php

/*
    Aplicación No 9 (Arrays asociativos)
    Realizar las líneas de código necesarias para generar un Array asociativo $lapicera, que
    contenga como elementos: ‘color’, ‘marca’, ‘trazo’ y ‘precio’. Crear, cargar y mostrar tres
    lapiceras.

    Guido Insua  
*/

$lapiceras = array(
    array("Color" => "Rojo", "Marca" => "Faber castel", "Trazo" => "Fino", "Precio" => "$800"),
    array("Color" => "Azul", "Marca" => "BIC", "Trazo" => "Medio", "Precio" => "$900"),
    array("Color" => "Verde", "Marca" => "BIC", "Trazo" => "Grande", "Precio" => "$700")
);

foreach ($lapiceras as $unaLapicera)
{
    echo "<br>Color = " . $unaLapicera["Color"];
    echo "<br>Marca = " . $unaLapicera["Marca"];
    echo "<br>Trazo = " . $unaLapicera["Trazo"];
    echo "<br>Precio = " . $unaLapicera["Precio"];
    echo "<br>";
}

?>