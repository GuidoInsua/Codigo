<?php

require_once "controladorHelado.php";

class HeladeriaAlta{

    private controladorHelado $_controlador;

    public function __construct($archivo) {
        $this->_controlador = controladorHelado::getInstance($archivo);
    }

    public function darAltaHelado(helado $helado){
        if ($this->_controlador->existeHeladoEnLista($helado, $indice)) {
            $this->_controlador->aumentarStockHelado($helado->getStock(), $indice);
            echo "El helado ya existe, se ha aumentado el stock.";
            exit;
        } else {
            $this->_controlador->agregarHelado($helado);
            echo "Helado agregado correctamente.";
            exit;
        }
    }
}

?>