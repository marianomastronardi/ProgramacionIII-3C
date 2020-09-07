<?php

abstract class Persona
{
    protected $_nombre;
    protected $_apellido;
    protected $_documento;
    protected $_fechaNacimiento;
    protected $_edad;
    protected $_delimiter;

    public function __construct($nombre, $apellido, $documento, $fechaNacimiento, $edad = null)
    {
        $this->_nombre = $nombre;
        $this->_apellido = $apellido;
        $this->_documento = $documento;
        $this->_fechaNacimiento = $fechaNacimiento;
        $this->_edad = $edad??$this->CalcularEdad();
        $this->_delimiter = ';';
    }

    public function __toString()
    {
        return $this->_nombre
            . $this->_delimiter
            . $this->_apellido
            . $this->_delimiter
            . $this->_documento
            . $this->_delimiter
            . $this->_fechaNacimiento
            . (isset($this->_edad) ? $this->_delimiter
                . $this->_edad
                : '');
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
         $this->$name = $value;
    }

    public function CalcularEdad(){
        return date_diff(date_create($this->_fechaNacimiento), new DateTime())->format('%y');
    }
}
