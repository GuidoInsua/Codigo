
<?php

/*
    Aplicación No 10 (Arrays de Arrays)
    Realizar las líneas de código necesarias para generar un Array asociativo y otro indexado que
    contengan como elementos tres Arrays del punto anterior cada uno. Crear, cargar y mostrar los
    Arrays de Arrays.

    Guido Insua  
*/

$indexado = array(
    array("Color" => "Rojo", "Marca" => "Faber castel", "Trazo" => "Fino", "Precio" => "$800"),
    array("Color" => "Azul", "Marca" => "BIC", "Trazo" => "Medio", "Precio" => "$900"),
    array("Color" => "Verde", "Marca" => "BIC", "Trazo" => "Grande", "Precio" => "$700")
);

$asociativo = array(
    "lapicera1" => array("Color" => "Rojo", "Marca" => "Faber castel", "Trazo" => "Fino", "Precio" => "$800"),
    "lapicera2" => array("Color" => "Azul", "Marca" => "BIC", "Trazo" => "Medio", "Precio" => "$900"),
    "lapicera3" => array("Color" => "Verde", "Marca" => "BIC", "Trazo" => "Grande", "Precio" => "$700")
);

foreach ($indexado as $unaLapicera)
{
    echo "<br>Color = " . $unaLapicera["Color"];
    echo "<br>Marca = " . $unaLapicera["Marca"];
    echo "<br>Trazo = " . $unaLapicera["Trazo"];
    echo "<br>Precio = " . $unaLapicera["Precio"];
    echo "<br>";
}

echo "--------------------------------";

foreach ($asociativo as $lapicera => $datos)
{
    echo "<br>Nombre = " . $lapicera;
    echo "<br>Color = " . $datos["Color"];
    echo "<br>Marca = " . $datos["Marca"];
    echo "<br>Trazo = " . $datos["Trazo"];
    echo "<br>Precio = " . $datos["Precio"];
    echo "<br>";
}

?>