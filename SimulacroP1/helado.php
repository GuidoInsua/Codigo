<?php

require_once 'jsonDeserializable.php';

class helado implements JsonSerializable, jsonDeserializable{
    private float $_id;
    private string $_sabor;
    private float $_precio;
    private string $_tipo;
    private string $_vaso;
    private float $_stock;

    public function __construct($id = 0, $sabor, $precio, $tipo, $vaso, $stock) {
        $this->_id = $id;
        $this->_sabor = $sabor;
        $this->_precio = $precio;
        $this->_tipo = $tipo;
        $this->_vaso = $vaso;
        $this->_stock = $stock;
    }

    public function jsonSerialize(): mixed {
        return [
            'id' => $this->_id,
            'sabor' => $this->_sabor,
            'precio' => $this->_precio,
            'tipo' => $this->_tipo,
            'vaso' => $this->_vaso,
            'stock' => $this->_stock
        ];
    }

    public static function jsonDeserialize(array $data): helado {
        return new self(
            $data['id'],
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

    public function getId() {
        return $this->_id;
    }

    public function setPrecio($precio) {
        $this->_precio = $precio;
    }

    public function setStock($stock) {
        $this->_stock = $stock;
    }

    public function setId($id) {
        $this->_id = $id;
    }
}

?>