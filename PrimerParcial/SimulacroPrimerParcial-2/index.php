<?php

require_once "helado.php";
require_once "heladeriaAlta.php";
require_once "heladoConsultar.php";
require_once "altaVenta.php";
require_once "consultarVentas.php";

function enviarRespuesta($codigo, $mensaje) {
    http_response_code($codigo);
    echo json_encode(['error' => $mensaje]);
    exit;
}

function validarImagen($archivo) {
    // Asumiendo que $archivo es el array $_FILES['imagen']
    $tiposPermitidos = ['image/jpeg', 'image/png'];
    return isset($archivo['tmp_name']) &&
           !empty($archivo['tmp_name']) &&
           in_array(mime_content_type($archivo['tmp_name']), $tiposPermitidos) &&
           $archivo['error'] === UPLOAD_ERR_OK;
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
        case 'imagen':
            return isset($_FILES[$parametro]) && validarImagen($_FILES[$parametro]);
        case 'email':
            return filter_var($parametro, FILTER_VALIDATE_EMAIL) !== false;
        default:
            return false;
    }
}

// ---------------------------------------------------------------------------------------------

if (!isset($_GET['solicitud'])) {
    enviarRespuesta(400, "Falta el parámetro 'solicitud' en la solicitud.");
}

$solicitud = $_GET['solicitud'];

switch ($solicitud) {
    case 'HeladeriaAlta':

        $parametros = ['sabor', 'precio', 'tipo', 'vaso', 'stock', 'imagen'];
        $tipos = ['string', 'float', 'tipo', 'vaso', 'int', 'imagen'];

        foreach ($parametros as $index => $parametro) {
            if ($parametro === 'imagen') {
                if (!isset($_FILES[$parametro]) || !validarParametro($parametro, $tipos[$index])) {
                    enviarRespuesta(400, "Parametro {$parametro} invalido");
                }
            } else {
                if (!isset($_POST[$parametro]) || !validarParametro($_POST[$parametro], $tipos[$index])) {
                    enviarRespuesta(400, "Parametro {$parametro} invalido");
                }
            }
        }

        $_POST["sabor"] = ucfirst(strtolower(trim($_POST["sabor"])));
        $_POST["tipo"] = ucfirst(strtolower(trim($_POST["tipo"])));
        $_POST["vaso"] = ucfirst(strtolower(trim($_POST["vaso"])));

        $nuevoHelado = new helado(0, $_POST["sabor"], $_POST["precio"], $_POST["tipo"], $_POST["vaso"], $_POST["stock"]);

        try {
            heladeriaAlta::darAltaHelado("Jsons/heladeria.json", $nuevoHelado, $_FILES['imagen'], $mensaje);
            echo $mensaje;
        } catch (Exception $e) {
            enviarRespuesta(500, "Error: " . $e->getMessage());
        }

        break;
    case 'HeladoConsultar':

        $parametros = ['sabor', 'tipo'];
        $tipos = ['string', 'tipo'];

        foreach ($parametros as $index => $parametro) {
            if (!isset($_POST[$parametro]) || !validarParametro($_POST[$parametro], $tipos[$index])) {
                enviarRespuesta(400, "Parametro {$parametro} invalido");
            }
        }

        $_POST["sabor"] = ucfirst(strtolower(trim($_POST["sabor"])));
        $_POST["tipo"] = ucfirst(strtolower(trim($_POST["tipo"])));

        $unHelado = new helado(0, $_POST["sabor"], 0, $_POST["tipo"], " ", 0);

        try {
            heladoConsultar::consultarExistenciaHelado("Jsons/heladeria.json", $unHelado, $mensaje);
            echo $mensaje;
        } catch (Exception $e) {
            enviarRespuesta(500, "Error: " . $e->getMessage());
        }

        break;
    case 'AltaVenta':
        $parametros = ['email', 'sabor', 'tipo', 'stock', 'imagen'];
        $tipos = ['email', 'string', 'tipo', 'int', 'imagen'];

        foreach ($parametros as $index => $parametro) {
            if ($parametro === 'imagen') {
                if (!isset($_FILES[$parametro]) || !validarParametro($parametro, $tipos[$index])) {
                    enviarRespuesta(400, "Parametro {$parametro} invalido");
                }
            } else {
                if (!isset($_POST[$parametro]) || !validarParametro($_POST[$parametro], $tipos[$index])) {
                    enviarRespuesta(400, "Parametro {$parametro} invalido");
                }
            }
        }

        $_POST["sabor"] = ucfirst(strtolower(trim($_POST["sabor"])));
        $_POST["tipo"] = ucfirst(strtolower(trim($_POST["tipo"])));

        $nuevoHelado = new helado(0, $_POST["sabor"], 0, $_POST["tipo"], " ", $_POST["stock"]);

        try {
            altaVenta::darAltaVenta("Jsons/heladeria.json", "Jsons/ventas.json", $nuevoHelado, $_FILES['imagen'], $_POST['email'], $mensaje);
            echo $mensaje;
        } catch (Exception $e) {
            enviarRespuesta(500, "Error: " . $e->getMessage());
        }

        break;
    case 'ConsultarVentas':
        $parametros = ['fecha1', 'fecha2', 'email'];
        $tipos = ['string', 'string', 'email'];

        foreach ($parametros as $index => $parametro) {
            if (!isset($_POST[$parametro]) || !validarParametro($_POST[$parametro], $tipos[$index])) {
                enviarRespuesta(400, "Parametro {$parametro} invalido");
            }
        }

        try {
            consultarVentas::obtenerConsultaVentras("Jsons/heladeria.json", "Jsons/ventas.json", $_POST["fecha1"], $_POST["fecha2"], $_POST["email"], $mensaje);
            echo $mensaje;
        } catch (Exception $e) {
            enviarRespuesta(500, "Error: " . $e->getMessage());
        }

        break;
    default:
        enviarRespuesta(404, "Solicitud no encontrada.");
        break;
}
?>