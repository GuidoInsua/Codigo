<?php

require_once 'interfazJson.php';

date_default_timezone_set('America/Argentina/Buenos_Aires');

class controladorJson
{
    private static $_instancia;

    private $_archivo;
    private $_idAutoincremental;

    private function __construct($archivo) {
        $this->_archivo = $archivo;
        $this->_idAutoincremental = 0;

        if($archivo != null){
        $this->obtenerIdAutoincremental();
        }
    }

    public static function getInstance($archivo) {
        if (self::$_instancia === null) {
            self::$_instancia = new controladorJson($archivo);
        }
        return self::$_instancia;
    }

    public function obtenerIdAutoincremental() {
        $Objetos = $this->obtenerObjetosDelJson();
        $this->_idAutoincremental = count($Objetos);
    }

    public function agregarUnObjetoAlJson(JsonSerializable $unObjeto) {
        $Objetos = [];
        $json_contenido = file_get_contents($this->_archivo);
        if ($json_contenido !== false) {
            $Objetos = json_decode($json_contenido, true);
        }

        $arrayObjeto = $unObjeto->jsonSerialize();
        $arrayObjeto['id'] = $this->_idAutoincremental++;
        $arrayObjeto['fecha_registro'] = date('Y-m-d H:i:s');
        
        $Objetos[] = $arrayObjeto;

        $objetos_json = json_encode($Objetos, JSON_PRETTY_PRINT);

        if (file_put_contents($this->_archivo, $objetos_json) === false) {
            throw new Exception("Error al agregar el objeto al archivo.");
        }
    }

    public function obtenerObjetosDelJson(string $nombreClase) {
        $Objetos = [];

        if (!class_exists($nombreClase)) {
            throw new InvalidArgumentException("La clase " . $nombreClase . " no existe.");
        }

        if (!in_array(InterfazJson::class, class_implements($nombreClase))) {
            throw new InvalidArgumentException("La clase " . $nombreClase . " no implementa la interfaz InterfazJson.");
        }
    
        $json_contenido = file_get_contents($this->_archivo);
        if ($json_contenido !== false) {
            $dataObjetos = json_decode($json_contenido, true);
            if ($dataObjetos !== null) {
                foreach ($dataObjetos as $dataObjeto) {
                    $Objetos[] = $nombreClase::crearDesdeData($dataObjeto);
                }
            }
        }
        return $Objetos;
    }

    public function existeObjetoEnJson(interfazJson $unObjeto) {
        $objetos = $this->obtenerObjetosDelJson(get_class($unObjeto));
        foreach ($objetos as $objetoCargado) {
            if ($unObjeto->equals($objetoCargado)) {
                return true;
            }
        }
        return false;
    }

    public function aumentarDatoNumericoEnJson(interfazJson $unObjeto, string $nombreDato, int $incremento) {
        $objetos = $this->obtenerObjetosDelJson(get_class($unObjeto));

        foreach ($objetos as $objeto)
        {
            if ($unObjeto->equals($objeto)) {
                $objeto->aumentarDatoNumerico($nombreDato, $incremento);
                break;
            }
        }
    
        foreach ($objetos as $objeto)
        {
            $this->agregarUnObjetoAlJson($objeto);
        }
    }

    public function disminuirStockHelado($stock, $indice) {
        $jsonString = file_get_contents($this->_archivo);
        $productos = json_decode($jsonString, true); 
    
        if ($indice >= 0 && $indice < count($productos)) {
            if ($productos[$indice]['stock'] < $stock){
                return false;
            }
            else{
                $productos[$indice]['stock'] -= $stock;
            }
            $nuevoJsonString = json_encode($productos, JSON_PRETTY_PRINT);
            if (file_put_contents($this->_archivo, $nuevoJsonString) === false) {
                throw new Exception("Error al modificar el stock del helado en el archivo.");
            }
            return true;
        } else {
            throw new Exception("No se encontró ningún helado con el ID proporcionado.");
        }
    }



}

?>
