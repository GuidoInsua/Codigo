<?php

class auto 
{

    private $_color; 
    private $_precio; 
    private $_marca; 
    private $_fecha;

    public function __construct($color, $precio = null, $marca = null, $fecha = null)
    {
        $this->_color = $color;
        $this->_precio = $precio;
        $this->_marca = $marca;
        $this->_fecha = $fecha;
    }

    public function agregarImpuestos($impuesto)
    {
        if($impuesto != null && (is_numeric($impuesto) == 1))
        {
            $this->_precio = $this->_precio + $impuesto;
        }
    }

    public static function mostrarAuto($unAuto)
    {
        if($unAuto instanceof auto)
        {
            echo "Color: " . $unAuto->_color . "<br>";
            echo "Precio: " . $unAuto->_precio . "<br>";
            echo "Marca: " . $unAuto->_marca . "<br>";
            echo "Fecha: " . $unAuto->_fecha . "<br>";
        }
    }
}

?>