<?php

require_once "usuario.php";

class manejadorUsuarios 
{
    private $_archivo;

    public function __construct($archivo) {
        $this->_archivo = $archivo;
    }

    public function agregarUsuario(Usuario $usuario) {
        $linea = $usuario->getNombre() . ',' . $usuario->getClave() . ',' . $usuario->getMail() . PHP_EOL;
        if (file_put_contents($this->_archivo, $linea, FILE_APPEND) === false) {
            throw new Exception("Error al agregar el usuario al archivo.");
        }
    }

    public function obtenerUsuarios() {
        $usuarios = [];
        $handle = fopen($this->_archivo, "r");
        if ($handle === false) {
            throw new Exception("Error al abrir el archivo de usuarios.");
        }
        try {
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                if(count($data) == 3) {
                $usuarios[] = new Usuario($data[0], $data[1], $data[2]);
                }
            }
        } finally {
            fclose($handle);
        }
        return $usuarios;
    }

    public function existeUsuarioEnLista(usuario $usuario) {
        $usuarios = $this->obtenerUsuarios();
        foreach ($usuarios as $usuarioRegistrado) {
            if ($usuarioRegistrado->getMail() === $usuario->getMail()){
                return true;
            }
        }
        return false;
    }
}

?>

