<?php

require_once "controladorHelado.php";

class altaVenta{

    private controladorHelado $_controlador;

    public function __construct($archivo) {
        $this->_controlador = controladorHelado::getInstance($archivo);
    }

    public function darAltaVenta(helado $helado){
        if ($this->_controlador->existeHeladoEnLista($helado, $indice)) {
            if($this->_controlador->disminuirStockHelado($helado->getStock(), $indice)){
                echo "venta realizada";
            }
            else {
                echo "Stock insuficiente";
            }
        }
        else {
            echo "no existe helado";
            exit;
        }
    }
}

?>
