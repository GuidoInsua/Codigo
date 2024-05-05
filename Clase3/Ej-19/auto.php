<?php

class auto 
{

    private $_color; //string
    private $_precio; //double
    private $_marca; //string
    private $_fecha; //DateTime

    public function __construct($color, $precio = 0, $marca = " ", $fecha = " ")
    {
        $this->_color = $color;

        if(is_numeric($precio) == 1 && $precio >= 0)
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
            $this->_precio += $impuesto;
        }
    }

    public static function mostrarAuto($unAuto)
    {
        if($unAuto instanceof auto)
        {
            $fechaImprimible = auto::obtenerStringFecha($unAuto->_fecha);

            echo "Color: " . $unAuto->_color . "<br>";
            echo "Precio: " . $unAuto->_precio . "<br>";
            echo "Marca: " . $unAuto->_marca . "<br>";
            echo "Fecha: " . $fechaImprimible . "<br>";
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
                $suma = $unAuto->_precio + $otroAuto->_precio;
                return $suma;
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

    private static function obtenerStringFecha($fecha)
    {
        $stringFecha = " ";
        
        if($fecha != null && $fecha instanceof DateTime)
        {
            $stringFecha = $fecha->format('Y-m-d');
        }

        return $stringFecha;
    }

    public function guardarEnCsv($nombreArchivo) 
    {
        if (!preg_match('/^[a-zA-Z0-9_-]+\.(csv)$/i', $nombreArchivo)) 
        {
            return "El nombre del archivo no es válido o no tiene la extensión .csv";
        }
        
        $file = fopen($nombreArchivo, 'a+');

        if (flock($file, LOCK_EX)) 
        {
            $stringFecha = auto::obtenerStringFecha($this->_fecha);
            fputcsv($file, array($this->_color, $this->_precio, $this->_marca, $stringFecha));

            flock($file, LOCK_UN);
            fclose($file);

            return "Auto guardado exitosamente";
        } 
        else 
        {
            return "No se pudo obtener el candado para escribir en el archivo CSV.";
        }
    }

    private static function convertirArrayDataEnAuto($data)
    {
        if (count($data) != 4) 
        {
            return null;
        }

        $color = is_string($data[0]) ? $data[0] : "";
        $precio = (is_numeric($data[1]) && $data[1] >= 0) ? $data[1] : 0;
        $marca = is_string($data[2]) ? $data[2] : "";

        if(is_string($data[3]) && strlen($data[3]) > 2)
        {
            $fecha = DateTime::createFromFormat('Y-m-d', $data[3]);
            $unAuto = new auto(color: $color, precio: $precio, marca: $marca, fecha: $fecha);
        }
        else
        {
            $unAuto = new auto(color: $color, precio: $precio, marca: $marca);
        }

        return $unAuto;
    }

    public static function generarArrayAutosDeCsv($nombreArchivo) 
    {
        if (!preg_match('/^[a-zA-Z0-9_-]+\.(csv)$/i', $nombreArchivo)) 
        {
            return "El nombre del archivo no es válido o no tiene la extensión .csv";
        }

        $autos = array();

        if (($file = fopen($nombreArchivo, 'r')) !== false) 
        {
            while (($data = fgetcsv($file, 1000, ',')) !== false) 
            {
                $autos[] = auto::convertirArrayDataEnAuto($data);
            }

            fclose($file);
        } 
        else 
        {
            return "Error al abrir el archivo CSV.";
        }
        
        return $autos;
    }
}

?>