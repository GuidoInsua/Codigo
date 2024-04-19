<?php

class auto 
{

    private $_color; //string
    private $_precio; //double
    private $_marca; //string
    private $_fecha; //DateTime

    public function __construct($color, $precio = null, $marca = null, $fecha = null)
    {
        $this->_color = $color;

        if(is_numeric($precio) == 1)
        {
            $this->_precio = $precio;
        }

        $this->_marca = $marca;

        if($fecha instanceof DateTime)
        {
            $this->_fecha = $fecha;
        }
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
        $fechaImprimible = "";

        if($unAuto instanceof auto)
        {
            echo "Color: " . $unAuto->_color . "<br>";
            echo "Precio: " . $unAuto->_precio . "<br>";
            echo "Marca: " . $unAuto->_marca . "<br>";

            if($unAuto->_fecha != null)
            {
                $fechaImprimible = $unAuto->_fecha->format('Y-m-d');
                echo "Fecha: " . $fechaImprimible;
            }
            else
            {
                echo "Fecha: <br>";
            }
        }
    }

    public function equals($unAuto)
    {
        if($unAuto instanceof auto && $unAuto->_marca == $this->_marca)
        {
            return true;
        }

        return false;
    }

    public static function add($unAuto, $otroAuto)
    {
        $suma = 0;

        if($unAuto instanceof auto && $otroAuto instanceof auto)
        {
            if($unAuto->_marca == $otroAuto->_marca && $unAuto->_color == $otroAuto->_color)
            {
                if(is_numeric($unAuto->_precio) == 1 && is_numeric($otroAuto->_precio) == 1)
                {
                    $suma = $unAuto->_precio + $otroAuto->_precio;
                    return $suma;
                }
                else
                {
                    return "No se pudo realizar la operacion";
                }
            }
            else
            {
                return "La marca o el color no son iguales";
            }
        }
        else
        {
            return "Algun parametro no es un auto";
        }
    }
}

?>