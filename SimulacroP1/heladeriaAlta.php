<?php

require_once "helado.php";
require_once "controladorJson.php";

class heladeriaAlta{

    public static function darAltaHelado($archivo, helado $nuevoHelado) {
        try {
            // Obtiene la instancia del controlador JSON
            $controlador = controladorJson::getInstance($archivo);
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
        if (self::actualizarObjetoExistente($helados, $nuevoHelado)) {
            try {
                // Actualiza el json
                $controlador->actualizarRegistrosEnArchivo($helados);
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
                self::cargarFoto($nuevoHelado->getSabor() . $nuevoHelado->getTipo(), 'ImagenesDeHelados/2024/');
            } catch (Exception $e) {
                throw new Exception("Error al agregar el nuevo registro al archivo: " . $e->getMessage());
            }
        }
    }

    private static function actualizarObjetoExistente(&$helados, $nuevoHelado) {
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

    public static function cargarFoto($nombre, $destino)
    {
        try {
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            
                // Obtiene la extensión del archivo original
                $extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
            
                // Agrega la extensión al nombre específico
                $imagen_nombre_con_extension = $nombre . '.' . $extension;
            
                // Nombre temporal del archivo en el servidor
                $imagen_tmp_name = $_FILES['imagen']['tmp_name'];
            
                // Mueve el archivo desde la ubicación temporal a la carpeta de destino con el nuevo nombre
                if (!move_uploaded_file($imagen_tmp_name, $destino . $imagen_nombre_con_extension)) {
                    enviarRespuesta(423, "Error No se pudo subir la imagen.");
                }
            }
        } catch (Exception $e) {
            throw new Exception("Error al subir imagen: " . $e->getMessage());
        }
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