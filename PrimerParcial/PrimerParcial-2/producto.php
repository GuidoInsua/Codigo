<?php

require_once 'jsonDeserializable.php';

class producto implements JsonSerializable, jsonDeserializable{
    private string $_marca;
    private float $_precio;
    private string $_tipo;
    private string $_modelo;
    private string $_color;
    private int $_stock;
    private int $_id;

    public function __construct($marca, $precio, $tipo, $modelo, $color, $stock, $id = 0) {
        $this->_marca = $marca;
        $this->_precio = $precio;
        $this->_tipo = $tipo;
        $this->_modelo = $modelo;
        $this->_color = $color;
        $this->_stock = $stock;
        $this->_id = $id;
    }

    public function jsonSerialize(): mixed {
        return [
            'marca' => $this->_marca,
            'precio' => $this->_precio, 
            'tipo' => $this->_tipo,
            'modelo' => $this->_modelo,
            'color' => $this->_color,
            'stock' => $this->_stock,
            'id' => $this->_id
        ];
    }

    public static function jsonDeserialize(array $data): producto {
        return new self(
            $data['marca'],
            $data['precio'],
            $data['tipo'],
            $data['modelo'],
            $data['color'],
            $data['stock'],
            $data['id']
        );
    }

    public function equals(producto $unProducto)
    {
        if($unProducto instanceof producto){
            if ($unProducto->getMarca() == $this->_marca && $unProducto->getTipo() == $this->_tipo) {
                return true;
            }
        }
        return false;
    }

    public function imprimirProducto() {
        return 
        " - ID: " . $this->_id . "<br>" .
        "- Marca: " . $this->_marca . "<br>" .
        " Precio: " . $this->_precio . "<br>" .
        "- Tipo: " . $this->_tipo . "<br>" .
        "- Modelo: " . $this->_modelo . "<br>" .
        "- Color: " . $this->_color . "<br>" .
        "- Stock: ". $this->_stock . "<br> -------------------- <br>";
    }

    public function getMarca(): string {
        return $this->_marca;
    }

    public function getPrecio(): float {
        return $this->_precio;
    }

    public function getTipo(): string {
        return $this->_tipo;
    }

    public function getModelo(): string {
        return $this->_modelo;
    }

    public function getColor(): string {
        return $this->_color;
    }

    public function getStock(): int {
        return $this->_stock;
    }

    public function getId(): int {
        return $this->_id;
    }

    public function setId($id) {
        $this->_id = $id;
    }

    public function setPrecio($precio) {
        $this->_precio = $precio;
    }

    public function setStock($stock) {
        $this->_stock = $stock;
    }

    // ------ Estaticos

    public static function actualizarProductoExistente(&$productos, $nuevoProducto) {
        // Recorre la lista de productos para verificar si ya existe uno igual
        foreach ($productos as $producto) {
            if ($nuevoProducto->equals($producto)) {
                // Si existe, aumenta el stock y actualiza el precio
                $nuevoStock = $producto->getStock() + $nuevoProducto->getStock();
                $producto->setStock($nuevoStock);
                $producto->setPrecio($nuevoProducto->getPrecio());
                return true;
            }
        }
        return false;
    }

    public static function obtenerMaximoId($productos) {
        $maximoId = 0;

        // Recorre la lista de productos para encontrar el ID máximo
        foreach ($productos as $producto) {
            if ($producto->getId() > $maximoId) {
                $maximoId = $producto->getId();
            }
        }

        return $maximoId;
    }

    static function descontarStockProductoExistente(&$productos, $unProducto, &$productoEncontrado) {
        // Recorre la lista de productos para verificar si ya existe uno igual
        foreach ($productos as $producto) {
            if ($unProducto->equals($producto) && $producto->getStock() >= $unProducto->getStock()) {
                // Si existe y hay stock suficiente, descuenta el stock
                $nuevoStock = $producto->getStock() - $unProducto->getStock();
                $producto->setStock($nuevoStock);
                $productoEncontrado = $producto;
                return true;
            }
        }
        return false;
    }

    public static function listaProductosEntreDosPrecios($productos, $precio1, $precio2) {
        if($precio1 == $precio2){
            throw new Exception("Los precios no pueden ser iguales.");
        }

        if($precio1 > $precio2){
            $aux = $precio1;
            $precio1 = $precio2;
            $precio2 = $aux;
        }

        $listaProductos = [];

        foreach ($productos as $producto) {
            if ($producto->getPrecio() >= $precio1 && $producto->getPrecio() <= $precio2) {
                $listaProductos[] = $producto;
            }
        }

        return $listaProductos;
    }
}

?>