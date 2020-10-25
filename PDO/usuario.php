<?php

require_once './fileHandler.php';
require_once './token.php';
require_once './archivo.php';
 
class Usuario
{

    public $_email;
    public $_clave;
    public $_foto;

    function __construct($email, $clave, $foto = null)
    {
        $this->_email = $email;
        $this->_clave = $clave;
        if(isset($foto))
        $this->_foto = Usuario::createPhoto($email, $foto);
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
        $this->_clave = password_hash($this->_clave, PASSWORD_BCRYPT);
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
            //if($user->_clave != $this->_clave){
            if(!password_verify($this->_clave, $user->_clave)){
                echo "Contraseña incorrecta"; 
            }else{
                return $this->getToken();
            }
         } ;
    }

    function getToken(){
        
        return iToken::encodeUserToken($this->_email, password_hash($this->_clave, PASSWORD_BCRYPT));
    }

    static function createPhoto($email, $foto){

        $photoAddress = Archivo::imageHandler($email, $foto);
        return $photoAddress;
    }

    static function changePhoto($ruta, $email, $newPhoto){
        Archivo::changePhotoJson($ruta, $email, Usuario::createPhoto($email, $newPhoto));
    }

}
