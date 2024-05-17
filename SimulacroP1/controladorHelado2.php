<?php

require_once "helado.php";

date_default_timezone_set('America/Argentina/Buenos_Aires');

class controladorHelado 
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
            self::$_instancia = new controladorHelado($archivo);
        }
        return self::$_instancia;
    }

    public function obtenerIdAutoincremental() {
        $helados = $this->obtenerHelados();
        $this->_idAutoincremental = count($helados);
    }

    public function agregarHelado(helado $helado) {
        $helados = [];
        $json_contenido = file_get_contents($this->_archivo);
        if ($json_contenido !== false) {
            $helados = json_decode($json_contenido, true);
        }

        $arrayHelado = $helado->toArray();
        $arrayHelado['id'] = $this->_idAutoincremental++;
        $arrayHelado['fecha_registro'] = date('Y-m-d H:i:s');
        
        $helados[] = $arrayHelado;

        $helados_json = json_encode($helados, JSON_PRETTY_PRINT);

        if (file_put_contents($this->_archivo, $helados_json) === false) {
            throw new Exception("Error al agregar el helado al archivo.");
        }
    }

    public function obtenerHelados() {
        $helados = [];
        $dataHelados = [];
        $json_contenido = file_get_contents($this->_archivo);
        if ($json_contenido !== false) {
            $dataHelados = json_decode($json_contenido, true); 
            if($dataHelados !== null){
                foreach ($dataHelados as $dataHelado) {
                    $helados[] = new helado($dataHelado['sabor'], $dataHelado['precio'], $dataHelado['tipo'], $dataHelado['vaso'], $dataHelado['stock']);
                }
            }
        }
        return $helados;
    }

    public function guardarHelados($helados)

    {
        $helados_json = json_encode($helados, JSON_PRETTY_PRINT);
        if (file_put_contents($this->_archivo, $helados_json) === false) {
            throw new Exception("Error al guardar los helados en el archivo.");
        }

        //tengo problemas con los datos que no son propios del helado
    }

    public function existeHeladoEnLista(helado $helado, &$indice) {
        $helados = $this->obtenerHelados();
        foreach ($helados as $key => $heladoRegistrado) {
            if ($heladoRegistrado->getSabor() === $helado->getSabor() && $heladoRegistrado->getTipo() === $helado->getTipo()) {
                $indice = $key;
                return true;
            }
        }
        return false;
    }

    public function aumentarStockHelado($stock, $indice) {
        $jsonString = file_get_contents($this->_archivo);
        $productos = json_decode($jsonString, true); 
    
        if ($indice >= 0 && $indice < count($productos)) {
            $productos[$indice]['stock'] += $stock;

            $nuevoJsonString = json_encode($productos, JSON_PRETTY_PRINT);
            if (file_put_contents($this->_archivo, $nuevoJsonString) === false) {
                throw new Exception("Error al modificar el stock del helado en el archivo.");
            }
        } else {
            throw new Exception("No se encontró ningún helado con el ID proporcionado.");
        }
    }

    public function disminuirStockHelado($stock, $indice) {
        $jsonString = file_get_contents($this->_archivo);
        $productos = json_decode($jsonString, true); 
    
        if ($indice >= 0 && $indice < count($productos)) {
            $productos[$indice]['stock'] -= $stock;

            $nuevoJsonString = json_encode($productos, JSON_PRETTY_PRINT);
            if (file_put_contents($this->_archivo, $nuevoJsonString) === false) {
                throw new Exception("Error al modificar el stock del helado en el archivo.");
            }
        } else {
            throw new Exception("No se encontró ningún helado con el ID proporcionado.");
        }
    }



}

?>