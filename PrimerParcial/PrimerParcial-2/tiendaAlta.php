<?php

require_once "producto.php";
require_once "controladorJson.php";

class tiendaAlta{

    public static function darAltaProducto($direccionJson, producto $nuevoProducto, $archivoImagen, &$mensaje) {
        try {
            // Crea un controlador JSON
            $controlador = new controladorJson($direccionJson);
        } catch (Exception $e) {
            throw new Exception("Error al obtener la instancia del controlador JSON: " . $e->getMessage());
        }

        try {
            // Convierte los registros del archivo JSON en objetos de tipo 'producto'
            $productos = $controlador->convertirRegistrosEnObjetos("producto");
        } catch (Exception $e) {
            throw new Exception("Error al convertir los registros en objetos: " . $e->getMessage());
        }

        // Si existe un producto igual, aumenta su stock y actualiza el precio
        if (producto::actualizarProductoExistente($productos, $nuevoProducto)) {
            try {
                // Actualiza el json
                $controlador->actualizarRegistrosEnArchivo($productos);
                $mensaje =  "Producto actualizado exitosamente.";
            } catch (Exception $e) {
                throw new Exception("Error al actualizar los registros en el archivo: " . $e->getMessage());
            }
        }
        else
        {
            // Si no existe un producto igual, asigna un nuevo ID y agrega el producto al archivo
            try {
                $nuevoProducto->setId(producto::obtenerMaximoId($productos) + 1);
                $controlador->agregarRegistroAlArchivo($nuevoProducto);
                controladorJson::cargarFoto($archivoImagen, $nuevoProducto->getModelo() . $nuevoProducto->getTipo(), 'ImagenesDeProductos/2024/');
                $mensaje = "Producto agregado exitosamente.";
            } catch (Exception $e) {
                throw new Exception("Error al agregar el nuevo registro al archivo: " . $e->getMessage());
            }
        }
    }
}

?>