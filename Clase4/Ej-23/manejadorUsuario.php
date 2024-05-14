<?php

require_once "usuario.php";

date_default_timezone_set('America/Argentina/Buenos_Aires');

class manejadorUsuarios 
{
    private $_archivo;

    public function __construct($archivo) {
        $this->_archivo = $archivo;
    }

    public function agregarUsuario(Usuario $usuario) {
        // Leer el contenido actual del archivo JSON
        $usuarios = [];
        $json_contenido = file_get_contents($this->_archivo);
        if ($json_contenido !== false) {
            $usuarios = json_decode($json_contenido, true);
        }
        
        // Generar un ID autoincremental emulado
        $usuarioArray = $usuario->toArray();
        $usuarioArray['id'] = rand(1, 10000);
        // Agregar la fecha de registro
        $usuarioArray['fecha_registro'] = date('Y-m-d H:i:s');
        
        // Agregar el nuevo usuario al array
        $usuarios[] = $usuarioArray;
    
        // Codificar el array completo como JSON
        $usuarios_json = json_encode($usuarios, JSON_PRETTY_PRINT);
    
        // Escribir el JSON completo de usuarios de vuelta al archivo
        if (file_put_contents($this->_archivo, $usuarios_json) === false) {
            throw new Exception("Error al agregar el usuario al archivo.");
        }
    }

    public function obtenerUsuarios() {
        $usuarios = [];
        $json_contenido = file_get_contents($this->_archivo);
        if ($json_contenido !== false) {
            $usuarios_data = json_decode($json_contenido, true); 
            foreach ($usuarios_data as $usuario_data) {
                $usuarios[] = new Usuario($usuario_data['nombre'], $usuario_data['clave'], $usuario_data['mail']);
            }
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

