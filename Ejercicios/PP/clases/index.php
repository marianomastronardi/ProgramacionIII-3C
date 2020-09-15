<?php

require_once './materia.php';
require_once './usuario.php';
require_once './profesor.php';

$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['PATH_INFO'] ?? 0;


switch ($method) {
    case 'POST';
        switch ($path) {

            case '/usuario':

                $email = $_POST['email'] ?? '';
                $clave = $_POST['clave'] ?? '';

                $usuario = new Usuario($email, $clave);

                if ($usuario->SaveUsuarioAsJSON('users.json')) {
                    echo 'Usuario guardado correctamente con formato JSON';
                } else {
                    echo 'Error al guardar el Usuario con formato JSON';
                }
                break;

                break;
            case '/materia':

                $nombre = $_POST['nombre'] ?? '';
                $cuatrimestre = $_POST['cuatrimestre'] ?? '';

                $materia = new Materia($nombre, $cuatrimestre);

                if ($materia->SaveMateriaAsJSON('materias.json')) {
                    echo 'Materia guardada correctamente con formato JSON';
                } else {
                    echo 'Error al guardar la Materia con formato JSON';
                }
                break;
            case '/profesor':
                $nombre = $_POST['nombre'] ?? '';
                $legajo = $_POST['legajo'] ?? '';

                $profesor = new Profesor($nombre, $legajo);

                if($profesor->ValidarLegajoAsJSON('profesores.json', $profesor->_legajo)){
                    if ($profesor->SaveUsuarioAsJSON('profesores.json')) {
                        echo 'Profesor guardado correctamente con formato JSON';
                    } else {
                        echo 'Error al guardar el Profesor con formato JSON';
                    }
                }else{
                    echo 'El legajo ya existe. No se pudo guardar el profesor.';
                }
                
                break;


            default:
                echo "Path incorecto";
                break;
        }
        break;

    case 'GET':
        switch ($path) {

            case '/profesor':
                //$nombre = $_GET['nombre'] ?? '';
                // $legajo = $_GET['legajo'] ?? '';
                $ruta = 'profesores.json';
               
                $lista = FileHandler::getJson($ruta);
                
                if ($lista) {
                    echo json_encode($lista);/*
                    foreach ($lista as $value) {
                        if ($value->_nombre == $nombre) {
                            //array_push($lista, $value);
                            $ret = $ret.' '.$value->_nombre.' '.$value->_legajo;    
                            continue;
                        }
                        if ($value->_legajo == $legajo) {
                            //array_push($lista, $value);
                            $ret = $ret.$value->_nombre.' '.$value->_legajo;
                            continue;
                        }
                        echo $value->_nombre . ' ' . $value->_legajo . PHP_EOL;
                    }*/
                   // echo json_decode($lista);
                } else {
                    echo 'No hay datos en la lista o no hay coincidencias con la busqueda';
                }
                break;
            case '/materia':

                //$nombre = $_GET['nombre'] ?? '';
                // $cuatrimestre = $_GET['cuatrimestre'] ?? '';
                $ruta = 'materias.json';
                //$ret = '';
                $lista = FileHandler::getJson($ruta);

                if ($lista) {
                    echo json_encode($lista);
                  /*  foreach ($lista as $value) {
                        if ($value->_nombre == $nombre) {
                            //array_push($lista, $value);
                            $ret = $ret.' '.$value->_nombre.' '.$value->_cuatrimestre;    
                            continue;
                        }
                        if ($value->_cuatrimestre == $cuatrimestre) {
                            //array_push($lista, $value);
                            $ret = $ret.$value->_nombre.' '.$value->_cuatrimestre;
                            continue;
                        }
                        echo $value->_nombre . ' ' . $value->_cuatrimestre . PHP_EOL;
                    }*/
                } else {
                    echo 'No hay datos en la lista o no hay coincidencias con la busqueda';
                }

                break;

            case '/usuario':
                //$email = $_GET['email'] ?? '';
                // $clave = $_GET['clave'] ?? '';
                $ruta = 'users.json';
                //$ret = '';
                $lista = FileHandler::getJson($ruta);

                if ($lista) {
                    echo json_encode($lista);
                   /* foreach ($lista as $value) {
                        if ($value->_email == $email) {
                            //array_push($lista, $value);
                            $ret = $ret.' '.$value->_email.' '.$value->_clave;    
                            continue;
                        }
                        if ($value->_clave== $clave) {
                            //array_push($lista, $value);
                            $ret = $ret.$value->_email.' '.$value->_clave;
                            continue;
                        }
                        echo $value->email . ' ' . $value->_clave . PHP_EOL;
                    }*/
                } else {
                    echo 'No hay datos en la lista o no hay coincidencias con la busqueda';
                }
                break;
            default:
                echo "Path incorecto";
                break;
        }
        break;

    default:
        echo "Metodo incorrecto";
        break;
}
