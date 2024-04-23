
<?php

require_once "auto.php";

class garage
{
    private $_razonSocial; //string
    private $_precioPorHora; //double
    private $_autos; //array auto

    public function __construct($razonSocial, $precioPorHora = null)
    {
        $this->_razonSocial = $razonSocial;
        
        if(is_numeric($precioPorHora) == 1)
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

}

?>