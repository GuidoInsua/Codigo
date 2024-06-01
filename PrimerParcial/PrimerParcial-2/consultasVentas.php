<?php

require_once "producto.php";
require_once "venta.php";
require_once "controladorJson.php";

class consultasVentas{

    public static function obtenerConsultaVentas($direccionProductos, $direccionVentas, $fechaParticular, $email, $precio1, $precio2, &$mensaje) {
        try {
            // crea dos controlador JSON
            $controladorProductos = new controladorJson($direccionProductos);
            $controladorVentas = new controladorJson($direccionVentas);
        } catch (Exception $e) {
            throw new Exception("Error al obtener la instancia del controlador JSON: " . $e->getMessage());
        }

        try {
            // Convierte los registros del archivo JSON en objetos de tipo 'producto'
            $ventas = $controladorVentas->convertirRegistrosEnObjetos("venta");
            $productos = $controladorProductos->convertirRegistrosEnObjetos("producto");
        } catch (Exception $e) { 
            throw new Exception("Error al convertir los registros en objetos: " . $e->getMessage());
        }

        try {
            if ($fechaParticular != null)
            {
                //A- La cantidad de productos vendidos en un día en particular (se envía por parámetro), si no se pasa fecha, se muestran los del día de ayer.
                $cantidad = venta::cantidadProductoVendidoEnFecha($fechaParticular, $ventas);

                echo "RESPUESTA CONSULTA: <br><br>";
                echo "Cantidad de productos vendidos en la fecha: " . $fechaParticular . " : " . $cantidad . "<br><br>";
            }
            if ($email != null)
            {
                //B- El listado de ventas de un usuario ingresado.
                $divicionEmail = explode('@', $email);
                $usuario = $divicionEmail[0];

                $ventasPorUsuario = venta::listadoVentasPorUsuario($usuario, $ventas);

                echo "**********VENTAS POR USUARIO: <br><br>";

                foreach ($ventasPorUsuario as $venta) {
                    if($venta instanceof venta){
                        echo $venta->imprimirVenta();
                    }
                }
            }
            if ($ventas != null)
            {
                //C- El listado de ventas por tipo de producto. 
                // primero uno despues el otro ??
                $ventasPorTipo = venta::listadoVentasPorTipo($ventas);

                echo "<br>**********VENTAS POR TIPO: <br><br>";

                foreach ($ventasPorTipo as $venta) {
                    if($venta instanceof venta){
                        echo $venta->imprimirVenta();
                    }
                }
            }
            if ($precio1 != null && $precio2 != null)
            {
                //D- El listado de productos cuyo precio esté entre dos números ingresados.

                $productosEnRangoPrecio = producto::listaProductosEntreDosPrecios($productos, $precio1, $precio2);

                echo "<br>**********PRODUCTOS EN RANGO PRECIO: <br><br>";

                foreach ($productosEnRangoPrecio as $producto) {
                    if($producto instanceof producto){
                        echo $producto->imprimirProducto();
                    }
                }
            }
            if ($productos != null)
            {
                //E- El listado de ingresos (ganancia de las ventas) por día de una fecha ingresada. Si no se ingresa una fecha, se muestran los ingresos de todos los días.
            }
            if ($productos != null)
            {
                //F- Mostrar el producto más vendido.

                $idMasVendido = venta::productoMasVendido($ventas);
            }

            $mensaje = "Consulta realizada exitosamente.";
        }
        catch (Exception $e) {
            throw new Exception("Error : " . $e->getMessage());
        }

    }

}   


?>