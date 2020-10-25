<?php

require_once './fileHandler.php';
require_once '../PDO/AccesoDatos.php';

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

    public static function getProfesor()
    {
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $query = $pdo->RetornarConsulta("select nombre, legajo from profesores");
        if ($query->execute()) {
/*             while ($fila = $query->fetch()) {
              print_r($fila);
            } */
            while($fila = $query->fetchAll(PDO::FETCH_CLASS, "Profesor")){
                print_r($fila->nombre);
                echo '<br/>';
            }
          }
    }

    public static function addProfesor($nombre, $legajo){
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $sentencia = $pdo->objetoPDO->prepare('INSERT INTO PROFESORES (nombre, legajo) VALUES (:nombre, :legajo)');
        $sentencia->bindParam(':nombre', $nombre);
        $sentencia->bindParam(':legajo', $legajo);

/*         if($sentencia->execute()){
            echo 'Profesor guardado correctamente';
        }; */
    }
}

?>