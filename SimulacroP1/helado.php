<?php

require_once 'jsonDeserializable.php';

class helado implements JsonSerializable, jsonDeserializable{
    private string $_sabor;
    private float  $_precio;
    private string $_tipo;
    private string $_vaso;
    private float  $_stock;

    public function __construct($sabor, $precio, $tipo, $vaso, $stock) {
        $this->_sabor = (!empty($sabor)) ? ucfirst(strtolower($sabor)) : " ";
        $this->_precio = ($precio > 0) ? $precio : 0;
        $this->_tipo = ($tipo == "Agua" || $tipo == "Crema") ? ucfirst(strtolower($tipo)) : " ";
        $this->_vaso = ($vaso == "Cucurucho" || $vaso == "Plástico") ? ucfirst(strtolower($vaso)) : " ";
        $this->_stock = ($stock >= 0) ? $stock : 0;
    }

    public function jsonSerialize(): mixed {
        return [
            'sabor' => $this->_sabor,
            'precio' => $this->_precio,
            'tipo' => $this->_tipo,
            'vaso' => $this->_vaso,
            'stock' => $this->_stock
        ];
    }

    public static function jsonDeserialize(array $data): helado {
        return new self(
            $data['sabor'],
            $data['precio'],
            $data['tipo'],
            $data['vaso'],
            $data['stock']
        );
    }

    public function equals($unObjeto)
    {
        if($unObjeto instanceof helado){
            if ($unObjeto->getSabor() === $this->getSabor() && $unObjeto->getTipo() === $this->getTipo()) {
                return true;
            }
        }
        return false;
    }

    public function getSabor() {
        return $this->_sabor;
    }

    public function getPrecio() {
        return $this->_precio;
    }

    public function getTipo() {
        return $this->_tipo;
    }

    public function getVaso() {
        return $this->_vaso;
    }

    public function getStock() {
        return $this->_stock;
    }

    public function setStock($stock) {
        $this->_stock = $stock;
    }
}

?>