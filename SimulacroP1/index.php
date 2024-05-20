<?php

require_once "helado.php";
require_once "heladeriaAlta.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "405 Error: Método no permitido. Esta API solo acepta solicitudes POST.";
    exit;
}

if(!isset($_GET['solicitud'])){
    echo "400 Error: Falta el parámetro 'solicitud' en la solicitud.";
    exit;
}

$solicitud = $_GET['solicitud'];

switch ($solicitud) {
    case 'HeladeriaAlta':
        if (!isset($_POST["sabor"]) || !isset($_POST["precio"]) || !isset($_POST["tipo"]) || !isset($_POST["vaso"]) || !isset($_POST["stock"])) {
            echo " 400 Error: Faltan parametros";
            exit;
        }

        $nuevoHelado = new helado($_POST["sabor"], $_POST["precio"], $_POST["tipo"], $_POST["vaso"], $_POST["stock"]);

        heladeriaAlta::darAltaHelado("Jsons\heladeria.json", $nuevoHelado);

        break;
    case 'HeladoConsultar':
        if (!isset($_POST["sabor"]) || !isset($_POST["tipo"])) {
            exit;
        }

        //$heladoConsultar = new heladoConsultar("heladeria.json");

        //$heladoConsultar->consultarExistenciaHelado($_POST["sabor"], $_POST["tipo"]);

        break;
    case 'AltaVenta':
        if (!isset($_POST["email"]) || !isset($_POST["sabor"]) || !isset($_POST["tipo"]) || !isset($_POST["stock"])) {
            exit;
        }

        //$nuevoHelado = new helado($_POST["sabor"], 0, $_POST["tipo"], "", $_POST["stock"]);

        //$altaVenta = new altaVenta("heladeria.json");

        //$altaVenta->darAltaVenta($nuevoHelado);

        break;
    default:
        echo "404 Error: Solicitud no encontrada.";
        exit;
        
        break;
}

?>