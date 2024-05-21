<?php

require_once "producto.php";
require_once "controladorJson.php";

class productoConsultar{

    public static function consultarExistenciaDeProducto($direccionJson, producto $unProducto, &$mensaje)
    {
        try {
            // crea un controlador JSON
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

        $mensaje = "No existe el producto";

        foreach ($productos as $producto) {
            if ($unProducto->getMarca() == $producto->getMarca() && $unProducto->getTipo() == $producto->getTipo() && $unProducto->getColor() == $producto->getColor()) {
                $mensaje = "Existe un producto identico.";
                return true;
            } elseif ($unProducto->getMarca() == $producto->getMarca() && $unProducto->getTipo() == $producto->getTipo()) {
                $mensaje = "Existe un producto con la misma Marca y Tipo pero no Color.";
            } elseif ($unProducto->getMarca() == $producto->getMarca()) {
                $mensaje = "Existe un producto con la misma Marca pero no Tipo.";
            } elseif ($unProducto->getTipo() == $producto->getTipo()) {
                $mensaje = "Existe un producto con el mismo Tipo pero no Marca.";
            }
        }

        if ($mensaje == "No existe el producto") {
            return false;
        }

        return true;
    }   
}

?>