<?php

require_once './materia.php';
require_once './profesor.php';

class AsignacionMateria
{

    public $_id;
    public $_legajo;
    public $_idMateria;
    public $_turno;

    function __construct($legajo, $idMateria, $turno, $id = 0)
    {
        $this->_id = $id;
        $this->_legajo = $legajo;
        $this->_idMateria = $idMateria;
        $this->_turno = $turno;
    }

    function __get($name)
    {
        return $this->$name;
    }

    function __set($name, $value)
    {
        $this->$name = $value;
    }

    static function Save($legajo, $idMateria, $turno)
    {
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $sentencia = $pdo->objetoPDO->prepare('INSERT INTO ASIGNACION_MATERIA (legajo, idMateria, turno) VALUES (:legajo, :idMateria, :turno)');
        $sentencia->bindParam(':legajo', $legajo);
        $sentencia->bindParam(':idMateria', $idMateria);
        $sentencia->bindParam(':turno', $turno);

        if (AsignacionMateria::profesorExists(($legajo))) {
            if (AsignacionMateria::materiaExists($idMateria)) {
                if (!AsignacionMateria::verifyAlreadyExists($legajo, $idMateria, $turno)) {
                    if ($sentencia->execute()) {
                        echo json_encode(array('message' => 'Asignacion guardada correctamente'));
                    };
                } else {
                    echo json_encode(array('message' => 'La asignacion ya existe'));
                }
            } else {
                echo json_encode(array('message' => 'El ID Materia no existe'));
            }
        } else {
            echo json_encode(array('message' => 'El legajo no existe'));
        };
    }

    static function verifyAlreadyExists($legajo, $idMateria, $turno)
    {
        $resultado = null;
        $pdo = AccesoDatos::dameUnObjetoAcceso();
        $query = $pdo->objetoPDO->prepare("select * from asignacion_materia where legajo = :legajo and idMateria = :idMateria and turno = :turno");
        $query->bindParam(':legajo', $legajo, PDO::PARAM_INT | PDO::PARAM_INPUT_OUTPUT);
        $query->bindParam(':idMateria', $idMateria, PDO::PARAM_INT | PDO::PARAM_INPUT_OUTPUT);
        $query->bindParam(':turno', $turno, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 6);


        if ($query->execute()) {
            while ($fila = $query->fetch(PDO::FETCH_ASSOC)) {
                if (
                    $fila['legajo'] == $legajo
                    && $fila['idMateria'] == $idMateria
                    && $fila['turno'] == $turno
                ) {
                    $resultado = $fila;
                    break;
                }
            }
        };
        return $resultado;
    }

    static function profesorExists($legajo)
    {
        $lista = Profesor::getProfesorByLegajo($legajo);
        return $lista;
    }

    static function materiaExists($idMateria)
    {
        $lista = Materia::getMateriaById($idMateria);
        return $lista;
    }
}
