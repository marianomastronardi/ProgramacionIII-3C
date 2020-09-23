<?php

require_once './fileHandler.php';

class Profesor{

    public $_nombre;
    public $_legajo;

    function __construct($nombre, $legajo)
    {
        $this->_nombre = $nombre;
        $this->_legajo = $legajo;
    }

    function __toString()
    {
        
    }

    function __get($name)
    {
        return $this->$name;
    }

    function __set($name, $value)
    {
        $this->$name = $value;
    }

    function ValidarLegajoAsJSON($ruta, $legajo){
        $lista = FileHandler::getJSON($ruta);

        if($lista){
            foreach($lista as $value){
                if($legajo === $value->_legajo){
                    return false;
                }
            }
        }
        return true;
    }

    function SaveUsuarioAsJSON($ruta){
        return FileHandler::SaveJson($ruta,$this);
    }
}

?>