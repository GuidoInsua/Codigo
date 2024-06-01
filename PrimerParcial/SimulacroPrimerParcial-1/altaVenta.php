<?php

require_once "helado.php";
require_once "venta.php";
require_once "controladorJson.php";

date_default_timezone_set('America/Argentina/Buenos_Aires');

class altaVenta{

    public static function darAltaVenta($direccionHelados, $direccionVentas, helado $unHelado, $archivoImagen, $email, &$mensaje) {
        try {
            // crea dos controlador JSON
            $controladorHelado = new controladorJson($direccionHelados);
            $controladorVenta = new controladorJson($direccionVentas);
        } catch (Exception $e) {
            throw new Exception("Error al obtener la instancia del controlador JSON: " . $e->getMessage());
        }

        try {
            // Convierte los registros del archivo JSON en objetos de tipo 'helado'
            $helados = $controladorHelado->convertirRegistrosEnObjetos("helado");
        } catch (Exception $e) {
            throw new Exception("Error al convertir los registros en objetos: " . $e->getMessage());
        }

        // Si existe un helado igual, descuenta su stock
        if (self::descontarStockHeladoExistente($helados, $unHelado, $heladoEncontrado)) {
            try {
                $controladorHelado->actualizarRegistrosEnArchivo($helados);
                $venta = new venta(date("Y-m-d"), rand(1, 1000), $heladoEncontrado->getId());
                // Agrega la venta al archivo JSON
                $controladorVenta->agregarRegistroAlArchivo($venta);

                // Carga la imagen en la carpeta correspondiente
                $divicionEmail = explode('@', $email);
                $nombreUsuario = $divicionEmail[0];
                $nombreImagen = $heladoEncontrado->getSabor() . $heladoEncontrado->getTipo() . $heladoEncontrado->getVaso() . $nombreUsuario . date("Y-m-d");
                controladorJson::cargarFoto($archivoImagen, $nombreImagen, 'ImagenesDeVenta/2024/');
                $mensaje = "Venta realizada exitosamente.";
            } catch (Exception $e) {
                throw new Exception("Error al agregar la venta al archivo: " . $e->getMessage());
            }
        }
        else
        {
            throw new Exception("No hay stock suficiente para realizar la venta o el Helado no Existe.");
        }
    }

    static function descontarStockHeladoExistente(&$helados, $unHelado, &$heladoEncontrado) {
        // Recorre la lista de helados para verificar si ya existe uno igual
        foreach ($helados as $helado) {
            if ($unHelado->equals($helado) && $helado->getStock() >= $unHelado->getStock()) {
                // Si existe y hay stock suficiente, descuenta el stock
                $nuevoStock = $helado->getStock() - $unHelado->getStock();
                $helado->setStock($nuevoStock);
                $heladoEncontrado = $helado;
                return true;
            }
        }
        return false;
    }
}   


?>