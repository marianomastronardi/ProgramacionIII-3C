<?php
namespace Seguridad;
use DAO\AccesoDatos;
use PDO;
class Usuario{

    public $_email;
    public $_clave;
    //public $_foto;

    function __construct($email, $clave/*, $foto = null*/)
    {
        $this->_email = $email;
        $this->_clave = $clave;
       /*  if(isset($foto))
        $this->_foto = Usuario::createPhoto($email, $foto); */
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

    static function getToken($_email, $_clave){
        return iToken::encodeUserToken($_email, password_hash($_clave, PASSWORD_BCRYPT));
    }

    static function Save($email, $pass){
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $pass = password_hash($pass, PASSWORD_BCRYPT);
        $sentencia = $pdo->objetoPDO->prepare('INSERT INTO USUARIOS (email, clave) VALUES (:email, :clave)');
        $sentencia->bindParam(':email', $email);
        $sentencia->bindParam(':clave', $pass);

        //validaciones
        if (!Usuario::getUser($email)) {
            if ($sentencia->execute()) {
                return json_encode(array('message' => 'Usuario guardado correctamente'));
            };
        } else {
            return json_encode(array('message' => 'El email ya existe'));
        }
    }

    static function getUser($email)
    {
        $resultado = null;
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $query = $pdo->objetoPDO->prepare("select * from usuarios where email = :email");
        $query->bindParam(':email', $email, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 30);

        if ($query->execute()) {
            while ($fila = $query->fetch(PDO::FETCH_ASSOC)) {
                if ($fila['email'] == $email) {
                    $resultado = $fila;
                    break;
                }
            }
        };
        return $resultado;
    }

/*     static function Login(){
        if(!password_verify($this->_clave, $user->_clave)){
            echo "Contraseña incorrecta"; 
        }else{
            return $this->getToken();
        }
    } */
}