<?php

require_once "producto.php";
require_once "tiendaAlta.php";
require_once "productoConsultar.php";
require_once "altaVenta.php";

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
            return in_array($parametro, ['impresora', 'cartucho']);
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
    case 'TinedaAlta':

        $parametros = ['marca', 'precio', 'tipo', 'modelo', 'color', 'stock', 'imagen'];
        $tipos = ['string', 'float', 'tipo', 'string', 'string', 'int', 'imagen'];

        foreach ($parametros as $index => $parametro) {
            if ($parametro === 'imagen') {
                if (!isset($_FILES[$parametro]) || !validarParametro($parametro, $tipos[$index])) {
                    enviarRespuesta(400, "Parametro {$parametro} invalido");
                }
            } else {
                if (!isset($_POST[$parametro]) || !validarParametro($_POST[$parametro], $tipos[$index])) {
                    enviarRespuesta(400, "Parametro {$parametro} invalido");
                }

                $_POST[$parametro] = ucfirst(strtolower(trim($_POST[$parametro])));
            }
        }

        $unProducto = new Producto($_POST['marca'], $_POST['precio'], $_POST['tipo'], $_POST['modelo'], $_POST['color'], $_POST['stock']);

        try {
            tiendaAlta::darAltaProducto("Jsons/tienda.json", $unProducto, $_FILES['imagen'], $mensaje);
            echo $mensaje;
        } catch (Exception $e) {
            enviarRespuesta(500, "Error: " . $e->getMessage());
        }

        break;
    case 'ProductoConsultar':

        $parametros = ['marca', 'tipo', 'color'];
        $tipos = ['string', 'tipo', 'string'];

        foreach ($parametros as $index => $parametro) {
            if ($parametro === 'imagen') {
                if (!isset($_FILES[$parametro]) || !validarParametro($parametro, $tipos[$index])) {
                    enviarRespuesta(400, "Parametro {$parametro} invalido");
                }
            } else {
                if (!isset($_POST[$parametro]) || !validarParametro($_POST[$parametro], $tipos[$index])) {
                    enviarRespuesta(400, "Parametro {$parametro} invalido");
                }

                $_POST[$parametro] = ucfirst(strtolower(trim($_POST[$parametro])));
            }
        }

        $unProducto = new Producto($_POST['marca'], 0, $_POST['tipo'], " ", $_POST['color'], 0);

        try {
            productoConsultar::consultarExistenciaDeProducto("Jsons/tienda.json", $unProducto, $mensaje);
            echo $mensaje;
        } catch (Exception $e) {
            enviarRespuesta(500, "Error: " . $e->getMessage());
        }

        break;
    case 'AltaVenta':

        $parametros = ['email', 'marca', 'tipo', 'modelo', 'stock', 'imagen'];
        $tipos = ['email', 'string', 'tipo', 'string', 'int', 'imagen'];

        foreach ($parametros as $index => $parametro) {
            if ($parametro === 'imagen') {
                if (!isset($_FILES[$parametro]) || !validarParametro($parametro, $tipos[$index])) {
                    enviarRespuesta(400, "Parametro {$parametro} invalido");
                }
            } else {
                if (!isset($_POST[$parametro]) || !validarParametro($_POST[$parametro], $tipos[$index])) {
                    enviarRespuesta(400, "Parametro {$parametro} invalido");
                }

                $_POST[$parametro] = ucfirst(strtolower(trim($_POST[$parametro])));
            }
        }

        $unProducto = new Producto($_POST['marca'], 0, $_POST['tipo'], $_POST['modelo'], " ", $_POST['stock']);

        try {
            altaVenta::darAltaVenta("Jsons/tienda.json", "Jsons/ventas.json", $unProducto, $_FILES['imagen'], $_POST['email'], $mensaje);
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

?>