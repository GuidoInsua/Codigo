<?php

class usuario 
{
    private $_nombre;
    private $_apellido;
    private $_clave;
    private $_mail;
    private $_localidad;

    public function __construct($nombre, $apellido, $clave, $mail, $localidad) {
        $this->_nombre = $nombre;
        $this->_apellido = $apellido;
        $this->_clave = $clave;
        $this->_mail = $mail;
        $this->_localidad = $localidad;
    }

    public function toArray()
    {
        return array(
            'nombre' => $this->_nombre,
            'apellido' => $this->_apellido,
            'clave' => $this->_clave,
            'mail' => $this->_mail,
            'localidad' => $this->_localidad
        );
    }

    public function getNombre() {
        return $this->_nombre;
    }

    public function getApellido() {
        return $this->_apellido;
    }

    public function getClave() {
        return $this->_clave;
    }

    public function getMail() {
        return $this->_mail;
    }

    public function getLocalidad() {
        return $this->_localidad;
    }
}

?>