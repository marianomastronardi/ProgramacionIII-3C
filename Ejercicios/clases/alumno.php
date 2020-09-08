<?php

require_once '../clases/persona.php';
require_once '../files/fileHandler.php';

class Alumno extends Persona{

    private $_legajo;
    private $_cursos;
    private $_cursada;

    public function __construct($nombre, $apellido, $documento, $fechaNacimiento, $legajo, $edad = null)
    {
        parent::__construct($nombre, $apellido, $documento, $fechaNacimiento, $edad);
        $this->_legajo = $legajo;
    }

    public function __toString()
    {
        return parent::__toString()
                .$this->_delimiter
                .$this->_legajo;
    }

    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name, $value)
    {
        switch ($name) {
            case '_delimiter':
                parent::__set($name, $value);
                break;
            default:
                $this->$name = $value;
                break;
        }
    }

}

?>