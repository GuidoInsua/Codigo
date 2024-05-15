<?php

require_once "controladorHelado.php";

class heladoConsultar{

    private controladorHelado $_controlador;
    private $_archivo;

    public function __construct($archivo) {
        $this->_archivo = $archivo;
        $this->_controlador = controladorHelado::getInstance($archivo);
    }

    public function consultarExistenciaHelado($sabor, $tipo){

        $helado = new helado($sabor, 0, $tipo, "", 0);

        if ($this->_controlador->existeHeladoEnLista($helado, $indice)) {
            echo "existe";
            exit;
        } else {
            echo "No existe el helado";
            exit;
        }
        exit;
    }
}

?>