<?php

require_once "helado.php";
require_once "controladorJson.php";

class heladeriaAlta{

    public static function darAltaHelado($direccionJson, helado $nuevoHelado, $archivoImagen, &$mensaje) {
        try {
            // Crea un controlador JSON
            $controlador = new controladorJson($direccionJson);
        } catch (Exception $e) {
            throw new Exception("Error al obtener la instancia del controlador JSON: " . $e->getMessage());
        }

        try {
            // Convierte los registros del archivo JSON en objetos de tipo 'helado'
            $helados = $controlador->convertirRegistrosEnObjetos("helado");
        } catch (Exception $e) {
            throw new Exception("Error al convertir los registros en objetos: " . $e->getMessage());
        }

        // Si existe un helado igual, aumenta su stock y actualiza el precio
        if (self::actualizarHeladoExistente($helados, $nuevoHelado)) {
            try {
                // Actualiza el json
                $controlador->actualizarRegistrosEnArchivo($helados);
                $mensaje =  "Helado actualizado exitosamente.";
            } catch (Exception $e) {
                throw new Exception("Error al actualizar los registros en el archivo: " . $e->getMessage());
            }
        }
        else
        {
            // Si no existe un helado igual, asigna un nuevo ID y agrega el helado al archivo
            try {
                $nuevoHelado->setId(self::obtenerMaximoId($helados) + 1);
                $controlador->agregarRegistroAlArchivo($nuevoHelado);
                controladorJson::cargarFoto($archivoImagen, $nuevoHelado->getSabor() . $nuevoHelado->getTipo(), 'ImagenesDeHelados/2024/');
                $mensaje = "Helado agregado exitosamente.";
            } catch (Exception $e) {
                throw new Exception("Error al agregar el nuevo registro al archivo: " . $e->getMessage());
            }
        }
    }

    private static function actualizarHeladoExistente(&$helados, $nuevoHelado) {
        // Recorre la lista de helados para verificar si ya existe uno igual
        foreach ($helados as $helado) {
            if ($nuevoHelado->equals($helado)) {
                // Si existe, aumenta el stock y actualiza el precio
                $nuevoStock = $helado->getStock() + $nuevoHelado->getStock();
                $helado->setStock($nuevoStock);
                $helado->setPrecio($nuevoHelado->getPrecio());
                return true;
            }
        }
        return false;
    }

    private static function obtenerMaximoId($helados) {
        $maximoId = 0;

        // Recorre la lista de helados para encontrar el ID máximo
        foreach ($helados as $helado) {
            if ($helado->getId() > $maximoId) {
                $maximoId = $helado->getId();
            }
        }

        return $maximoId;
    }
}

?>