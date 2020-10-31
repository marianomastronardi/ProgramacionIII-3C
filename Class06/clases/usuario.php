<?php
namespace Clases;

class Usuario{

    private $_email;
    private $_password;

    function __construct($email, $pass)
    {
        $this->_email = $email;
        $this->_password = $pass;
    }

    function __get($name)
    {
        return $this->$name;
    }

    function __set($name, $value)
    {
        $this->$name = $value;
    }

    function __toString()
    {
        return $this->_email.' '.$this->_password;
    }
}

?>