<?php

require_once "helado.php";
require_once "controladorJson.php";

class heladoConsultar{

    public static function consultarExistenciaHelado($direccionJson, helado $unHelado, &$mensaje)
    {
        try {
            // crea un controlador JSON
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

        foreach ($helados as $helado) {
            if ($unHelado->equals($helado)) {
                $mensaje = "El helado existe.";
                return true;
            }
        }
        $mensaje = "El helado no existe.";
        return false;
    }
}   


?>