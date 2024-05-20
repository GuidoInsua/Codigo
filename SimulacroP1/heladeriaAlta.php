<?php

require_once "helado.php";
require_once "controladorJson.php";

class heladeriaAlta{

    public static function darAltaHelado($archivo, helado $nuevoHelado){
        $controlador = controladorJson::getInstance($archivo);

        $helados = $controlador->convertirRegistrosEnObjetos("helado");

        foreach ($helados as $helado) {
            if ($nuevoHelado->equals($helado)) {
                $nuevoStock = $helado->getStock() + $nuevoHelado->getStock();
                $helado->setStock($nuevoStock);
                $controlador->actualizarRegistrosEnArchivo($helados);
                exit;
            }
        }

        $controlador->agregarRegistroAlArchivo($nuevoHelado);
    }

    /*

    public static function darAltaHelado2($archivo, helado $helado){
        $controlador = controladorJson::getInstance($archivo);

        if ($controlador->existeHeladoEnLista($helado)) {
            $$controlador->aumentarStockHelado($helado->getStock());
            echo "El helado ya existe, se ha aumentado el stock.";
            exit;
        } else {
            $controlador->agregarHelado($helado);
            echo "Helado agregado correctamente.";
            exit;
        }
    }

    */
}

?>