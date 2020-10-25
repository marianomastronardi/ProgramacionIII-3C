<?php

require_once './AccesoDatos.php';

class Profesor
{

    public $_id;
    public $_nombre;
    public $_legajo;

    function __construct($id, $nombre, $legajo)
    {
        $this->_id = $id;
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

    /* GET */
    public static function getProfesorAsClass()
    {
        $lista = array();
        $index = 0;
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $query = $pdo->objetoPDO->query("select * from profesores");
        $query->setFetchMode(PDO::FETCH_CLASS, 'Profesor');
        $fila = $query->fetchAll(PDO::FETCH_CLASS);

        while ($index < count($fila)) {
            /*             print_r($fila[0]->nombre);
            print_r($fila[0]->legajo); */
            //print_r($fila);
            array_push($lista, new Profesor($fila[$index]->id, $fila[$index]->nombre, $fila[$index]->legajo));
            $index++;
        }

        return $lista;
    }

    public static function getProfesorAsObject()
    {
        $lista = array();
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $query = $pdo->RetornarConsulta("select * from profesores");
        if ($query->execute()) {
            while ($fila = $query->fetch(PDO::FETCH_LAZY)) {
                array_push($lista, new Profesor($fila->id, $fila->nombre, $fila->legajo));
            }
        }
        return $lista;
    }

    public static function getProfesorAsArray()
    {
        $lista = array();
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $query = $pdo->RetornarConsulta("select * from profesores");
        if ($query->execute()) {
            while ($fila = $query->fetch(PDO::FETCH_ASSOC)) {
                /*               echo $fila['nombre'].PHP_EOL;
              echo $fila['legajo'].PHP_EOL; */
                array_push($lista, $fila);
            }
        }
        return $lista;
    }

    public static function getProfesorAsNumber()
    {
        $lista = array();
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $query = $pdo->RetornarConsulta("select * from profesores");
        if ($query->execute()) {
            while ($fila = $query->fetch(PDO::FETCH_NUM)) {
                /*                 echo $fila[0].PHP_EOL;
                echo $fila[1].PHP_EOL; */
                array_push($lista, $fila);
            }
        }

        return $lista;
    }

    public static function getProfesorAsBoth()
    {
        $lista = array();
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $query = $pdo->RetornarConsulta("select * from profesores");
        if ($query->execute()) {
            while ($fila = $query->fetch(PDO::FETCH_BOTH)) {
                /*                 echo $fila['nombre'].PHP_EOL;
                echo $fila['legajo'].PHP_EOL;
                echo $fila[0].PHP_EOL;
                echo $fila[1].PHP_EOL; */
                array_push($lista, $fila);
            }
        }
        return $lista;
    }

    /* GET BY LEGAJO */
    public static function getProfesorByLegajo($legajo)
    {
        $lista = array();
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $query = $pdo->objetoPDO->prepare("select * from profesores where legajo = :legajo");
        $query->bindParam(':legajo', $legajo, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 6);

        if ($query->execute()) {
            while ($fila = $query->fetch(PDO::FETCH_ASSOC)) {
                /*              print_r($fila[0]->nombre);
            print_r($fila[0]->legajo);  */
                //print_r($fila);
                array_push($lista, new Profesor($fila['id'], $fila['nombre'], $fila['legajo']));
            }

            return $lista;
        }
    }

    /*POST */
    static function Save($nombre, $legajo)
    {
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $sentencia = $pdo->objetoPDO->prepare('INSERT INTO PROFESORES (nombre, legajo) VALUES (:nombre, :legajo)');
        $sentencia->bindParam(':nombre', $nombre);
        $sentencia->bindParam(':legajo', $legajo);

        if (!Profesor::verifyLegajoAlreadyExist($legajo)) {
            if ($sentencia->execute()) {
                echo json_encode(array('message' => 'Profesor guardado correctamente'));
            };
        } else {
            echo json_encode(array('message' => 'El legajo ya existe'));
        }
    }

    /* Validations */
    static function verifyLegajoAlreadyExist($legajo)
    {
        $resultado = null;
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $query = $pdo->objetoPDO->prepare("select * from profesores where legajo = :legajo");
        $query->bindParam(':legajo', $legajo, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 6);

        if ($query->execute()) {
            while ($fila = $query->fetch(PDO::FETCH_ASSOC)) {
                if ($fila['legajo'] == $legajo) {
                    $resultado = $fila;
                    break;
                }
            }
        };
        return $resultado;
    }
}
