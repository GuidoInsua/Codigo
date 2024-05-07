<?php

require_once "usuario.php";

class manejadorUsuarios 
{
    private $_archivo;

    public function __construct($archivo) {
        $this->_archivo = $archivo;
    }

    public function agregarUsuario(Usuario $usuario) {
        if($usuario instanceof usuario){
            $linea = $usuario->getNombre() . ',' . $usuario->getClave() . ',' . $usuario->getMail() . PHP_EOL;

            return file_put_contents($this->_archivo, $linea, FILE_APPEND);
        }
        return false;
    }
}

?>