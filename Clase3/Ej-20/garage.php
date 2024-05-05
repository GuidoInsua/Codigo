
<?php

require_once "auto.php";

class garage
{
    private $_razonSocial; //string
    private $_precioPorHora; //double
    private $_autos; //array auto

    public function __construct($razonSocial, $precioPorHora = 0)
    {
        $this->_razonSocial = $razonSocial;
        
        if($precioPorHora != null && is_numeric($precioPorHora) == 1 && $precioPorHora >= 0)
        {
            $this->_precioPorHora = $precioPorHora;
        }

        $this->_autos = array();
    }

    public function mostrarGarage()
    {
        echo "Razon social: " . $this->_razonSocial . "<br>";
        echo "Precio por hora: " . $this->_precioPorHora . "<br>";

        if(!empty($this->_autos))
        {
            echo "Autos: <br><br>";
            foreach($this->_autos as $unAuto)
            {
                auto::mostrarAuto($unAuto);
                echo "----------------------- <br>";
            }
        }
        else
        {
            echo "No hay autos <br>";
        }
    }

    public function equals($unAuto)
    {
        if($unAuto instanceof auto)
        {
            foreach($this->_autos as $auto)
            {
                if($unAuto->equals($auto))
                {
                    return true;
                }
            }
        }

        return false;
    }

    public function add($unAuto)
    {
        if(!$this->equals($unAuto))
        {
            $this->_autos[] = $unAuto;
        }
        else
        {
            return "Ya existe el auto en el garage o el parametro no es un auto";
        }
    }

    public function remove($unAuto)
    {
        if($unAuto instanceof auto)
        {
            for($i=0;$i<count($this->_autos);$i++)
            {
                if($unAuto->equals($this->_autos[$i]))
                {
                    array_splice($this->_autos, $i, 1);
                    return true;
                }
            }
            return "No se encontro el auto en el garage";
        }
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
            fputcsv($file, array($this->_razonSocial, $this->_precioPorHora));
            
            flock($file, LOCK_UN);
            fclose($file);

            foreach($this->_autos as $auto)
            {
                $auto->guardarEnCsv($nombreArchivo);
            }

            return "Garage guardado exitosamente";
        } 
        else 
        {
            return "No se pudo obtener el candado para escribir en el archivo CSV.";
        }
    }

    private static function convertirArrayDataEnGarage($data)
    {
        if (count($data) != 2) 
        {
            return null;
        }

        $razonSocial = is_string($data[0]) ? $data[0] : "";
        $precioPorHora = (is_numeric($data[1]) && $data[1] >= 0) ? $data[1] : 0;

        $unGarage = new garage(razonSocial: $razonSocial, precioPorHora: $precioPorHora);

        return $unGarage;
    }

    public static function generarArrayGargaesDeCsv($nombreArchivo) 
    {
        $indice = 0;

        if (!preg_match('/^[a-zA-Z0-9_-]+\.(csv)$/i', $nombreArchivo)) 
        {
            return "El nombre del archivo no es válido o no tiene la extensión .csv";
        }

        $garages = array();
        $autos = array();

        if (($file = fopen($nombreArchivo, 'r')) !== false) 
        {
            while (($data = fgetcsv($file, 1000, ',')) !== false) 
            {
                if (count($data) == 2) 
                {
                    if($indice != 0)
                    {
                        $garages[$indice - 1]->_autos = $autos;
                        $autos = array();
                    }
                    $garages[$indice] = garage::convertirArrayDataEnGarage($data);
                    $indice++;
                }
                else
                {
                    $autos[] = auto::convertirArrayDataEnAuto($data);
                }
            }

            if($indice != 0)
            {
                $garages[$indice - 1]->_autos = $autos;
                $autos = array();
            }

            fclose($file);
        } 
        else 
        {
            return "Error al abrir el archivo CSV.";
        }
        
        return $garages;
    }
}

?>