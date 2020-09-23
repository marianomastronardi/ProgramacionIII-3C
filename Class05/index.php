<?php

require_once './materia.php';
require_once './usuario.php';
require_once './profesor.php';
require_once './token.php';
require_once './asignacion-materia.php';

$method = $_SERVER['REQUEST_METHOD'];
if(isset($_SERVER['PATH_INFO'])){
    $pathInfo = explode('/', $_SERVER['PATH_INFO']);
    $path = '/'.$pathInfo[1];
    if(count($pathInfo) > 2) $param = $pathInfo[2];

    //$path = $_SERVER['PATH_INFO'] ?? 0;
}

$token = $_SERVER['HTTP_TOKEN'] ?? '';
//var_dump($_SERVER);
switch ($method) {
    case 'POST';
        switch ($path) {
            case '/usuario':

                if(isset($param)){
                    if (strlen($token) > 0) {
                        if (iToken::decodeUserToken($token)) {
                            $foto = $_FILES;
                           if (isset($_FILES)) {
                             Usuario::changePhoto('users.json', $param, $foto);
                           }
                       }
                   }
                }else{
                    $email = $_POST['email'] ?? '';
                    $clave = $_POST['clave'] ?? '';
                    $foto = $_FILES;
                    if (strlen($email) > 0 && strlen($clave) > 0 && isset($_FILES)) {
                        $usuario = new Usuario($email, $clave, $foto);
    
                        $usuario->SaveUsuarioAsJSON('users.json');
                    }
                }
                
                
                break;
            case '/login':
                $email = $_POST['email'] ?? '';
                $clave = $_POST['clave'] ?? '';
                if (strlen($email) > 0 && strlen($clave) > 0) {
                    $usuario = new Usuario($email, $clave);
                    
                   echo $usuario->LogIn('users.json', true);
                 }
                break;
            case '/materia':

                $nombre = $_POST['nombre'] ?? '';
                $cuatrimestre = $_POST['cuatrimestre'] ?? '';
               
                if (strlen($token) > 0) {
                     if (iToken::decodeUserToken($token)) {
                        if (strlen($nombre) > 0 && strlen($cuatrimestre) > 0) {
                            $materia = new Materia($nombre, $cuatrimestre);
                            $materia->SaveMateriaAsJSON('materias.json');
                        }
                    }
                }

                break;
            case '/profesor':
                $nombre = $_POST['nombre'] ?? '';
                $legajo = $_POST['legajo'] ?? '';
               
                if (strlen($token) > 0) {
                    if (iToken::decodeUserToken($token)) {
                        if (strlen($nombre) > 0 && strlen($legajo) > 0) {
                            $profesor = new Profesor($nombre, $legajo);

                            if ($profesor->ValidarLegajoAsJSON('profesores.json', $profesor->_legajo)) {
                                $profesor->SaveUsuarioAsJSON('profesores.json');
                            }
                        }
                    }
                }

                break;

            case '/asignacion':
                $legajo = $_POST['legajo'] ?? '';
                $id = $_POST['id'] ?? '';
                $turno = $_POST['turno'] ?? '';
                
                if (strlen($token) > 0) {
                    if (iToken::decodeUserToken($token)) {
                        if (strlen($legajo) > 0 && strlen($id) > 0 && strlen($turno) > 0) {
                            $asignacionMateria = new AsignacionMateria($legajo, $id, $turno);

                            $asignacionMateria->saveAsignacionMateriaJSON('materias-profesores.json');
                        }
                    }
                }

                break;

            default:
                echo "Path incorecto";
                break;
        }
        break;

    case 'GET':
        switch ($path) {
            case '/materia':

               $ruta = 'materias.json';
               $lista = FileHandler::getJson($ruta);
               
               if (!$lista) $lista = array();

                if (strlen($token) > 0) {
                    if (iToken::decodeUserToken($token)) {
                        echo json_encode($lista);
                  }
                }
                break;

            case '/profesor':
                $ruta = 'profesores.json';

                $lista = FileHandler::getJson($ruta);

                if (!$lista) $lista = array();

                if (strlen($token) > 0) {
                    if (iToken::decodeUserToken($token)) {
                        echo json_encode($lista);
                    }
                }
                break;

            case '/asignacion':
                $ruta = 'materias-profesores.json';
                $lista = FileHandler::getJson($ruta);

                if (!$lista) $lista = array();

                if (strlen($token) > 0) {
                    if (iToken::decodeUserToken($token)) {
                        echo json_encode($lista);
                    }
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
