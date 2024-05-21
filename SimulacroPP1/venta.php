<?php

require_once 'jsonDeserializable.php';

class venta implements JsonSerializable, jsonDeserializable{
    private string $_fecha;
    private int $_numeroDePedido;
    private int $_id;

    public function __construct($fecha, $numeroDePedido, $id) {
        $this->_fecha = $fecha;
        $this->_numeroDePedido = $numeroDePedido;
        $this->_id = $id;
    }

    public function jsonSerialize(): mixed {
        return [
            'fecha' => $this->_fecha,
            'numeroDePedido' => $this->_numeroDePedido,
            'id' => $this->_id
        ];
    }

    public static function jsonDeserialize(array $data): venta {
        return new self(
            $data['fecha'],
            $data['numeroDePedido'],
            $data['id']
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

    public function setFecha($fecha) {
        $this->_fecha = $fecha;
    }

    public function setNumeroDePedido($numeroDePedido) {
        $this->_numeroDePedido = $numeroDePedido;
    }

    public function setId($id) {
        $this->_id = $id;
    }

}

?>