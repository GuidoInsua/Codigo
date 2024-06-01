<?php

require_once "producto.php";
require_once "venta.php";
require_once "controladorJson.php";

class altaVenta{

    public static function darAltaVenta($direccionProductos, $direccionVentas, producto $unProducto, $archivoImagen, $email, &$mensaje) {
        try {
            // Crea dos controladores JSON
            $controladorProductos = new controladorJson($direccionProductos);
            $controladorVentas = new controladorJson($direccionVentas);
        } catch (Exception $e) {
            throw new Exception("Error al obtener la instancia del controlador JSON: " . $e->getMessage());
        }

        try {
            // Convierte los registros del archivo JSON en objetos de tipo 'producto'
            $productos = $controladorProductos->convertirRegistrosEnObjetos("producto");
        } catch (Exception $e) {
            throw new Exception("Error al convertir los registros en objetos: " . $e->getMessage());
        }

        // Si existe un producto igual, descuenta su stock
        if (producto::descontarStockProductoExistente($productos, $unProducto, $productoEncontrado)) {
            try {
                $numeroDePedido = rand(1, 1000);
                $divicionEmail = explode('@', $email);
                $nombreUsuario = $divicionEmail[0];
                $nombreImagen = $numeroDePedido . $productoEncontrado->getTipo() . $productoEncontrado->getModelo() . $nombreUsuario . date("Y-m-d");
                
                $venta = new venta(date("Y-m-d"), $numeroDePedido, $productoEncontrado->getId(), $unProducto->getStock(), $nombreUsuario, $unProducto->getMarca(), $unProducto->getTipo(), $unProducto->getModelo());
                
                controladorJson::cargarFoto($archivoImagen, $nombreImagen, 'ImagenesDeVenta/2024/');
                $controladorProductos->actualizarRegistrosEnArchivo($productos);
                $controladorVentas->agregarRegistroAlArchivo($venta);

                $mensaje = "Venta realizada exitosamente.";
            } catch (Exception $e) {
                throw new Exception("Error al agregar la venta al archivo: " . $e->getMessage());
            }
        }
        else
        {
            throw new Exception("No hay stock suficiente para realizar la venta o el producto no Existe.");
        }
    }
}

?>