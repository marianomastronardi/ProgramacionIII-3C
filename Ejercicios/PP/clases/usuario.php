<?php

require_once '../files/fileHandler.php';
require_once './token.php';

class Usuario
{

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

    function SaveUsuarioAsJSON($ruta)
    {
        if (!$this->getUser($ruta)){
            //$this->_clave = iToken::encodeUserToken($this->_email, $this->_clave);
            FileHandler::SaveJson($ruta, $this);
        } 
    }

    function SaveSerializedUser($ruta)
    {
        if (!$this->getUser($ruta)){
            //$this->_clave = iToken::encodeUserToken($this->_email, $this->_clave);
            FileHandler::serializeObj($ruta, $this);
        } 
    }

    //devuelve true o false
    function getUser($ruta)
    {
        $ext = explode('.', $ruta);
        $ext = $ext[count($ext)-1];
        $lista = ($ext === 'json') ? FileHandler::getJSON($ruta) : FileHandler::unserializeObj($ruta);
        $ret = false;
       
        if ($lista) {
            foreach ($lista as $value) {
                $ret = ($value->_email == $this->_email);
                if ($ret){
                    $ret = $value; 
                break;
            }
            }
        }
        return $ret;
    }

    function LogIn($ruta)
    {
        $user = ($this->getUser($ruta));

         if(!$user){
             echo "El Usuario no existe";
         }else{
            if($user->_clave != $this->_clave){
                echo "Contraseña incorrecta"; 
            }else{
                return $this->getToken();
            }
         } ;
    }

    function getToken(){
        return iToken::encodeUserToken($this->_email, $this->_clave);
    }
}
