<?php

class usuario 
{
    private $_nombre;
    private $_clave;
    private $_mail;

    public function __construct($nombre = null, $clave, $mail) {
        $this->_nombre = $nombre;
        $this->_clave = $clave;
        $this->_mail = $mail;
    }

    public function toArray()
    {
        // Convierte el objeto a un array asociativo
        return array(
            'nombre' => $this->_nombre,
            'clave' => $this->_clave,
            'mail' => $this->_mail
        );
    }

    public function getNombre() {
        return $this->_nombre;
    }

    public function getClave() {
        return $this->_clave;
    }

    public function getMail() {
        return $this->_mail;
    }
}

?>