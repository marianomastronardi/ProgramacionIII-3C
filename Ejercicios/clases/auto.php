<?php

require_once '../interfaces/ivehiculo.php';
require_once '../interfaces/ireportes.php';

class Auto implements IVehiculo, IReporte {

    private $_marca;
    private $_color;
    private $_modelo;
    private $_velocidad = 0;
    private $_delimiter = '---';

    public function __construct($marca, $color, $modelo, $velocidad = 0)
    {
        $this->_marca = $marca;
        $this->_color = $color;
        $this->_modelo = $modelo;
        $this->_velocidad = $velocidad;
    } 

    public function AumentarVelocidad($km)
    {
        $this->_velocidad += $km;
    }

    public function __toString()
    {
        return $this->_marca.$this->_delimiter.$this->_color.$this->_delimiter.$this->_velocidad;
    }

    public function getVehiculos()
    {
        return $this->__toString();
    }
}
?>