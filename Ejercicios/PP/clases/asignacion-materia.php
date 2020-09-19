<?php

require_once '../files/fileHandler.php';

class AsignacionMateria{

    public $_legajo;
    public $_id;
    public $_turno;

    function __construct($legajo, $id, $turno)
    {
        $this->_legajo = $legajo;
        $this->_id = $id;
        $this->_turno = $turno;
    }

    function __get($name)
    {
        return $this->$name;
    }

    function __set($name, $value)
    {
        $this->$name = $value;
    }

    function validarAsigancion($ruta){
        $lista = FileHandler::getJSON($ruta);

        if($lista){
            foreach($lista as $value){
                if($this->_legajo === $value->_legajo 
                    && $this->_id === $value->_id
                    && $this->_turno === $value->_turno){
                    return false;
                }
            }
        }
        return true;
    }

    function saveAsignacionMateriaJSON($ruta){
        if($this->validarAsigancion($ruta)) FileHandler::SaveJson($ruta, $this);
    }
}

?>