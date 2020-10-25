<?php

require_once './AccesoDatos.php';

class Materia{

    public $_id;
    public $_nombre;
    public $_cuatrimestre;

    function __construct($id, $nombre, $cuatrimestre)
    {
        $this->_id = $id;
        $this->_nombre = $nombre;
        $this->_cuatrimestre = $cuatrimestre;
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

    /* GET */
    public static function getMateriaAsClass()
    {
        $lista = array();
        $index = 0;
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $query = $pdo->objetoPDO->query("select * from materias");
        $query->setFetchMode( PDO::FETCH_CLASS, 'Materia');
        $fila = $query->fetchAll(PDO::FETCH_CLASS);

        while ($index < count($fila)) {
/*             print_r($fila[0]->nombre);
            print_r($fila[0]->cuatrimestre); */
            //print_r($fila);
            array_push($lista, new Profesor($fila[$index]->id, $fila[$index]->nombre, $fila[$index]->cuatrimestre));
            $index++;
        }

        return $lista;
    }

    public static function getMateriaAsObject()
    {
        $lista = array();
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $query = $pdo->RetornarConsulta("select * from materias");
        if ($query->execute()) {
             while ($fila = $query->fetch(PDO::FETCH_LAZY)) {
                array_push($lista, new Profesor($fila->id, $fila->nombre, $fila->cuatrimestre));
           } 
          }
        return $lista;
    }

    public static function getMateriaAsArray()
    {
        $lista = array();
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $query = $pdo->RetornarConsulta("select * from materias");
        if ($query->execute()) {
             while ($fila = $query->fetch(PDO::FETCH_ASSOC)) {
/*               echo $fila['nombre'].PHP_EOL;
              echo $fila['cuatrimestre'].PHP_EOL; */
              array_push($lista, $fila);
            } 
          }
          return $lista;
    }

    public static function getMateriaAsNumber()
    {
        $lista = array();
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $query = $pdo->RetornarConsulta("select * from materias");
        if ($query->execute()) {
             while ($fila = $query->fetch(PDO::FETCH_NUM)) {
/*                 echo $fila[0].PHP_EOL;
                echo $fila[1].PHP_EOL; */
                array_push($lista, $fila);
            } 
          }
        
          return $lista;
    }

    public static function getMateriaAsBoth()
    {
        $lista = array();
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $query = $pdo->RetornarConsulta("select * from materias");
        if ($query->execute()) {
             while ($fila = $query->fetch(PDO::FETCH_BOTH)) {
/*                 echo $fila['nombre'].PHP_EOL;
                echo $fila['cuatrimestre'].PHP_EOL;
                echo $fila[0].PHP_EOL;
                echo $fila[1].PHP_EOL; */
                array_push($lista, $fila);
            } 
          }
          return $lista;
    }

     /* GET BY ID */
     public static function getMateriaById($legajo)
     {
         $lista = array();
         $pdo = AccesoDatos::dameUnObjetoAcceso();
         $query = $pdo->objetoPDO->prepare("select * from materias where id = :id");
         $query->bindParam(':id', $legajo, PDO::PARAM_INT | PDO::PARAM_INPUT_OUTPUT);
 
         if ($query->execute()) {
             while ($fila = $query->fetch(PDO::FETCH_ASSOC)) {
                 array_push($lista, new Materia($fila['id'], $fila['nombre'], $fila['cuatrimestre']));
             }
 
             return $lista;
         }
     }

    /* POST */
    static function Save($nombre, $cuatrimestre){
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $sentencia = $pdo->objetoPDO->prepare('INSERT INTO MATERIAS (nombre, cuatrimestre) VALUES (:nombre, :cuatrimestre)');
        $sentencia->bindParam(':nombre', $nombre);
        $sentencia->bindParam(':cuatrimestre', $cuatrimestre);

        if(!Materia::verifyAlreadyExist($nombre, $cuatrimestre)){
            if($sentencia->execute()){
                echo json_encode(array('message' => 'Materia guardada correctamente'));
            }; 
        }else{
            echo json_encode(array('message' => 'La Materia ya existe para el cuatrimestre informado'));
        }
    }

    static function verifyAlreadyExist($nombre, $cuatrimestre){
        $resultado = null;
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $query = $pdo->objetoPDO->prepare("select * from materias where nombre = :nombre and cuatrimestre = :cuatrimestre");
        $query->bindParam(':nombre', $nombre, PDO:: PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 30);
        $query->bindParam(':cuatrimestre', $cuatrimestre, PDO:: PARAM_INT | PDO::PARAM_INPUT_OUTPUT);
        if($query->execute()){
            while ($fila = $query->fetch(PDO::FETCH_ASSOC)) {
                if($fila['nombre'] == $nombre && $fila['cuatrimestre'] == $cuatrimestre){
                    $resultado = $fila;
                    break;
                }
            }
        };
        return $resultado;
    }

}

?>