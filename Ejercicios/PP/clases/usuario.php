<?php

class Usuario{

    public $_email;
    public $_clave;

    function __construct($email, $clave)
    {
        $this->_email = $email;
        $this->_clave = $clave;
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

    function SaveUsuarioAsJSON($ruta){
        return FileHandler::SaveJson($ruta,$this);
    }
}

?>