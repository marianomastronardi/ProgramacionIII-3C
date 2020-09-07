<?php

require_once '../clases/persona.php';

class Profesor extends Persona
{

    private $_cursos;

    public function __construct($nombre, $apellido, $documento, $fechaNacimiento, $edad = null)
    {
        parent::__construct($nombre, $apellido, $documento, $fechaNacimiento, $edad);
    }

    public function __toString()
    {
        return parent::__toString();
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
