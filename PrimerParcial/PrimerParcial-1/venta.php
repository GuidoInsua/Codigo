<?php

require_once 'jsonDeserializable.php';

class venta implements JsonSerializable, jsonDeserializable{
    private string $_fecha;
    private int $_numeroDePedido;
    private int $_id;
    private int $_cantidadVendida;
    private string $_usaurio;
    private string $_marca;
    private string $_tipo;
    private string $_modelo;

    public function __construct($fecha, $numeroDePedido, $id, $cantidadVendida, $usaurio, $marca, $tipo, $modelo) {
        $this->_fecha = $fecha;
        $this->_numeroDePedido = $numeroDePedido;
        $this->_id = $id;
        $this->_cantidadVendida = $cantidadVendida;
        $this->_usaurio = $usaurio;
        $this->_marca = $marca;
        $this->_tipo = $tipo;
        $this->_modelo = $modelo;
    }

    public function jsonSerialize(): mixed {
        return [
            'fecha' => $this->_fecha,
            'numeroDePedido' => $this->_numeroDePedido,
            'id' => $this->_id,
            'cantidadVendida' => $this->_cantidadVendida,
            'usaurio' => $this->_usaurio,
            'marca' => $this->_marca,
            'tipo' => $this->_tipo,
            'modelo' => $this->_modelo
        ];
    }

    public static function jsonDeserialize(array $data): venta {
        return new self(
            $data['fecha'],
            $data['numeroDePedido'],
            $data['id'],
            $data['cantidadVendida'],
            $data['usaurio'],
            $data['marca'],
            $data['tipo'],
            $data['modelo']
        );
    }

    public function equals(venta $unaVenta)
    {
        if($unaVenta instanceof venta){
            if ($unaVenta->getNumeroDePedido() === $this->getNumeroDePedido() && $unaVenta->getId() === $this->getId()) {
                return true;
            }
        }
        return false;
    }

    public function getFecha() {
        return $this->_fecha;
    }

    public function getNumeroDePedido() {
        return $this->_numeroDePedido;
    }

    public function getId() {
        return $this->_id;
    }

    public function getCantidadVendida() {
        return $this->_cantidadVendida;
    }

    public function getUsaurio() {
        return $this->_usaurio;
    }

    public function getMarca() {
        return $this->_marca;
    }

    public function getTipo() {
        return $this->_tipo;
    }

    public function getModelo() {
        return $this->_modelo;
    }

}

?>