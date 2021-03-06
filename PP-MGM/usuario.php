<?php

require_once './token.php';
require_once './archivo.php';

class Usuario
{

    public $_email;
    public $_clave;
    public $_foto;

    function __construct($email, $clave, $foto)
    {
        $this->_email = $email;
        $this->_clave = $clave;
        $this->_foto = $foto;
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
        if (!$this->getUser($ruta, $this->_email)){
            $this->_clave = password_hash($this->_clave, PASSWORD_BCRYPT);
            $this->_foto =  $this->_foto ? Usuario::createPhoto($this->_email, $this->_foto) : "";
            Archivo::SaveJson($ruta, $this);
        } 
    }

    //devuelve true o false
    static function getUser($ruta, $email)
    {
        $lista = Archivo::getJSON($ruta);
        $ret = false;
       
        if ($lista) {
            foreach ($lista as $value) {
                $ret = ($value->_email == $email);
                if ($ret){
                    $ret = $value; 
                break;
            }
            }
        }
        return $ret;
    }

    //Login and Token
    static function LogIn($ruta, $email, $clave)
    {
        $user = (Usuario::getUser($ruta, $email));

         if(!$user){
             echo json_encode(array('message'=> "El Usuario no existe"));
         }else{
            //if($user->_clave != $this->_clave){
            if(!password_verify($clave, $user->_clave)){
                echo json_encode(array('message'=> "Contraseña incorrecta")); 
            }else{
                return Usuario::getToken($email, $clave);
            }
         } ;
    }

    static function getToken($email, $clave){
        return iToken::encodeUserToken($email, password_hash($clave, PASSWORD_BCRYPT));
    }

    //photo
    static function changePhoto($ruta, $email, $newPhoto){
        $user = Usuario::getUser($ruta, $email);
        if($user){
            $photpAddress = Usuario::createPhoto($email, $newPhoto);
            if($photpAddress) Archivo::changePhotoJson($ruta, $email, $photpAddress);
        }
    }
    
    static function createPhoto($email, $foto){
        $photoAddress = Archivo::imageHandler($email, $foto);
        return $photoAddress ? $photoAddress : "";
    }
}
