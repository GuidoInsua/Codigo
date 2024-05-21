<?php

require_once "helado.php";
require_once "controladorJson.php";

class consultarVentas{

    public static function obtenerConsultaVentras($direccionHelados, $direccionVentas, $fecha1, $fecha2, $email, &$mensaje) {
        try {
            // crea dos controlador JSON
            $controladorHelado = new controladorJson($direccionHelados);
            $controladorVenta = new controladorJson($direccionVentas);
        } catch (Exception $e) {
            throw new Exception("Error al obtener la instancia del controlador JSON: " . $e->getMessage());
        }

        try {
            // Convierte los registros del archivo JSON en objetos de tipo 'helado'
            $ventas = $controladorVenta->convertirRegistrosEnObjetos("venta");
            $helados = $controladorHelado->convertirRegistrosEnObjetos("helado");
        } catch (Exception $e) { 
            throw new Exception("Error al convertir los registros en objetos: " . $e->getMessage());
        }

        $divicionEmail = explode('@', $email);
        $usuario = $divicionEmail[0];

        try {
            $cantidadVendida = self::obtenerHeladoVendidoEnFecha($ventas, $fecha1);
            echo "La cantidad de helados vendidos en la fecha " . $fecha1 . " es de " . $cantidadVendida . "<br>";
            //
            $ventasUsuario = self::obtenerVentasDeUnUsuario($ventas, $usuario);
            foreach ($ventasUsuario as $venta) {
                echo "Fecha: " . $venta->getFecha() . " - Numero De Pedido: " . $venta->getNumeroDePedido() . " - Id: " . $venta->getId() . " - Cantidad Vendida: " . $venta->getCantidadVendida() . " - Usuario: " . $venta->getUsaurio() . "<br>";
            }
            //
            $ventasEntreFechas = self::listadoVentasEntreDosFechasOrdenadoPorNombre($fecha1, $fecha2, $ventas);
            foreach ($ventasEntreFechas as $venta) {
                echo "Fecha: " . $venta->getFecha() . " - Numero De Pedido: " . $venta->getNumeroDePedido() . " - Id: " . $venta->getId() . " - Cantidad Vendida: " . $venta->getCantidadVendida() . " - Usuario: " . $venta->getUsaurio() . "<br>";
            }
            //
            $ventasPorPropiedad = self::ordenarVentasPorPropiedadDeHelado($ventas, $helados);
            foreach ($ventasPorPropiedad as $sabor => $ventas) {
                echo "Sabor: $sabor <br>";
                foreach ($ventas as $detalleVenta) {
                    echo "- $detalleVenta <br>";
                }
                echo "<br>";
            }

            $mensaje = "Consulta realizada exitosamente.";
        }
        catch (Exception $e) {
            throw new Exception("Error : " . $e->getMessage());
        }

    }

    private static function obtenerHeladoVendidoEnFecha($ventas, $fecha) {
        $cantidadVendida = 0;
        foreach ($ventas as $venta) {
            if ($venta->getFecha() === $fecha) {
                $cantidadVendida += $venta->getCantidadVendida();
            }
        }
        return $cantidadVendida;
    }

    private static function obtenerVentasDeUnUsuario($ventas, $usuario) {
        $ventasUsuario = [];
        foreach ($ventas as $venta) {
            if ($venta->getUsaurio() === $usuario) {
                $ventasUsuario[] = $venta;
            }
        }
        return $ventasUsuario;
    }

    private static function listadoVentasEntreDosFechasOrdenadoPorNombre($fecha1, $fecha2, $ventas) {
        $date1 = DateTime::createFromFormat('Y-m-d', $fecha1);
        $date2 = DateTime::createFromFormat('Y-m-d', $fecha2);

        if ($date1 == $date2)
        {
            throw new exception ("Las fechas no pueden ser iguales");
        }

        // Confirmo que date1 sea menos a date2
        if ($date1 > $date2) {
            $k = $date1;
            $date1 = $date2;
            $date2 = $k;
        }

        $ventasEntreFechas = [];
        foreach ($ventas as $venta) {
            if ($venta->getFecha() >= $date1 && $venta->getFecha() <= $date2) {
                $ventasEntreFechas[] = $venta;
            }
        }

        // Ordenar el array por la propiedad 'usuario'
        usort($ventasEntreFechas, function($a, $b) {
            return strcmp($a->getUsaurio(), $b->getUsaurio());
        });

        return $ventasEntreFechas;
    }

    private static function ordenarVentasPorPropiedadDeHelado($ventas, $helados) {

        $ventasPorPropiedad = [];

        foreach ($helados as $helado) {
            // Asegurarse de que haya un array para cada sabor
            if (!isset($ventasPorPropiedad[$helado->getSabor()])) {
                $ventasPorPropiedad[$helado->getSabor()] = [];
            }
    
            foreach ($ventas as $venta) {
                if ($venta->getId() == $helado->getId()) {
                    $ventasPorPropiedad[$helado->getSabor()][] = $venta->getFecha() . " - " . $venta->getCantidadVendida() . " - " . $venta->getUsaurio();
                }
            }
        }
    
        return $ventasPorPropiedad;
    }
}   


?>