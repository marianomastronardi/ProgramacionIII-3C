<?php

require_once '../files/fileHandler.php';

class Materia{

    public $_id;
    public $_nombre;
    public $_cuatrimestre;

    function __construct($nombre, $cuatrimestre, $id = 0)
    {
        $this->_nombre = $nombre;
        $this->_cuatrimestre = $cuatrimestre;
        $this->_id = $id;
    }

    function __toString()
    {
        return 'id: '.$this->_id.' nombre '.$this->_nombre.' cuatrimestre '.$this->_cuatrimestre;
    }

    function __get($name)
    {
        return $this->$name;
    }

    function __set($name, $value)
    {
        $this->$name = $value;
    }

    function SaveMateriaAsJSON($ruta){
        $lista = FileHandler::getJson($ruta);
        $this->_id = $lista ? count($lista) + 1 : 1;
        return FileHandler::SaveJson($ruta,$this);
    }

}

?>