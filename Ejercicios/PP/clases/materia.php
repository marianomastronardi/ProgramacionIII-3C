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
        
        return $this->verifyIdAndExist($lista) >= 0 ? FileHandler::SaveJson($ruta,$this) : false;
    }

    function verifyIdAndExist($lista){
        $id = 0;
        if($lista){
            foreach ($lista as $value) {
                if($id <= $value->_id){
                    $id = $value->_id;
                }
                
                if($this->_nombre == $value->_nombre && $this->_cuatrimestre == $value->_cuatrimestre){
                    $id = -1;
                break;
                } 
            }
        }
        
        if($id != -1)$this->_id = $id + 1;
        return $id;
    }

}

?>