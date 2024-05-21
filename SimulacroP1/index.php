<?php

require_once "helado.php";
require_once "heladeriaAlta.php";

function enviarRespuesta($codigo, $mensaje) {
    http_response_code($codigo);
    echo json_encode(['error' => $mensaje]);
    exit;
}

function validarParametro($parametro, $tipo) {
    switch ($tipo) {
        case 'string':
            return is_string($parametro) && !empty(trim($parametro));
        case 'float':
            return is_numeric($parametro) && (float)$parametro > 0;
        case 'tipo':
            $parametro = strtolower($parametro);
            return in_array($parametro, ['agua', 'crema']);
        case 'vaso':
            $parametro = strtolower($parametro);
            return in_array($parametro, ['cucurucho', 'plastico']);
        case 'int':
            return filter_var($parametro, FILTER_VALIDATE_INT) !== false && (int)$parametro >= 0;
        default:
            return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    enviarRespuesta(405, "Método no permitido. Esta API solo acepta solicitudes POST.");
}

if (!isset($_GET['solicitud'])) {
    enviarRespuesta(400, "Falta el parámetro 'solicitud' en la solicitud.");
}

$solicitud = $_GET['solicitud'];

switch ($solicitud) {
    case 'HeladeriaAlta':

        $parametros = ['sabor', 'precio', 'tipo', 'vaso', 'stock'];
        $tipos = ['string', 'float', 'tipo', 'vaso', 'int'];

        foreach ($parametros as $index => $parametro) {
            if (!isset($_POST[$parametro]) || !validarParametro($_POST[$parametro], $tipos[$index])) {
                enviarRespuesta(400, "Parámetro {$parametro} inválido");
            }
        }

        $_POST["sabor"] = ucfirst(strtolower(trim($_POST["sabor"])));
        $_POST["tipo"] = ucfirst(strtolower(trim($_POST["tipo"])));
        $_POST["vaso"] = ucfirst(strtolower(trim($_POST["vaso"])));

        $nuevoHelado = new helado(0, $_POST["sabor"], $_POST["precio"], $_POST["tipo"], $_POST["vaso"], $_POST["stock"]);

        try {
            heladeriaAlta::darAltaHelado("Jsons/heladeria.json", $nuevoHelado);
            echo "Helado dado de alta exitosamente.";
        } catch (Exception $e) {
            enviarRespuesta(500, "Error: " . $e->getMessage());
        }

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
        enviarRespuesta(404, "Solicitud no encontrada.");
        break;
}
?>