<?php


class helado{
    
    private $_sabor;
    private $_precio;
    private $_tipo;
    private $_vaso;
    private $_stock;

    public function __construct($sabor, $precio, $tipo, $vaso, $stock) {
        $this->_sabor = $sabor;
        $this->_precio = $precio;
        $this->_tipo = $tipo;
        $this->_vaso = $vaso;
        $this->_stock = $stock;
    }

    public function toArray()
    {
        return array(
            'sabor' => $this->_sabor,
            'precio' => $this->_precio,
            'tipo' => $this->_tipo,
            'vaso' => $this->_vaso,
            'stock' => $this->_stock
        );
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