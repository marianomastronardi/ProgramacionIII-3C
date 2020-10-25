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
                            Materia::Save($nombre, $cuatrimestre);
                        }
                    }
                }

                break; 
            case '/profesor':
                $nombre = $_POST['nombre'] ?? '';
                    $legajo = $_POST['legajo'] ?? '';
                    if (strlen($token) > 0) {
                        if (iToken::decodeUserToken($token)) {
                            Profesor::Save($nombre, $legajo);
                        }
                    }

                break;      
             case '/asignacion':
                $legajo = $_POST['legajo'] ?? '';
                $idMateria = $_POST['idMateria'] ?? '';
                $turno = $_POST['turno'] ?? '';
                
                if (strlen($token) > 0) {
                    if (iToken::decodeUserToken($token)) {
                        if (strlen($legajo) > 0 && strlen($idMateria) > 0 && strlen($turno) > 0) {
                            AsignacionMateria::Save($legajo, $idMateria, $turno);
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
            
                if (strlen($token) > 0) {
                    if (iToken::decodeUserToken($token)) {
                        //echo 'getMateriaAsClass'.PHP_EOL;
                        echo json_encode(Materia::getMateriaAsClass());

                        //echo 'getMateriaAsArray'.PHP_EOL;
                        //echo json_encode(Materia::getMateriaAsArray());

                        //echo 'getMateriaAsNumber'.PHP_EOL;
                        //echo json_encode(Materia::getMateriaAsNumber());
                        
                        //echo 'getMateriaAsBoth'.PHP_EOL;
                        //echo json_encode(Materia::getMateriaAsBoth());

                        //echo 'getMateriaAsObject'.PHP_EOL;
                        //echo json_encode(Materia::getMateriaAsObject());
                  }
                }
                break; 

            case '/profesor':
                if (strlen($token) > 0) {
                    if (iToken::decodeUserToken($token)) {
                        //echo 'getProfesorAsClass'.PHP_EOL;
                        //echo json_encode(Profesor::getProfesorAsClass());

                        //echo 'getProfesorAsArray'.PHP_EOL;
                        //echo json_encode(Profesor::getProfesorAsArray());

                        //echo 'getProfesorAsNumber'.PHP_EOL;
                        //echo json_encode(Profesor::getProfesorAsNumber());
                        
                        //echo 'getProfesorAsBoth'.PHP_EOL;
                        //echo json_encode(Profesor::getProfesorAsBoth());

                        //echo 'getProfesorAsObject'.PHP_EOL;
                        echo json_encode(Profesor::getProfesorAsObject());
                    }
                }
                break;
            
             case '/asignacion':
               if (strlen($token) > 0) {
                    if (iToken::decodeUserToken($token)) {
                         //echo 'getProfesorAsClass'.PHP_EOL;
                        //echo json_encode(Profesor::getProfesorAsClass());

                        //echo 'getProfesorAsArray'.PHP_EOL;
                        //echo json_encode(Profesor::getProfesorAsArray());

                        //echo 'getProfesorAsNumber'.PHP_EOL;
                        //echo json_encode(Profesor::getProfesorAsNumber());
                        
                        //echo 'getProfesorAsBoth'.PHP_EOL;
                        //echo json_encode(Profesor::getProfesorAsBoth());

                        //echo 'getProfesorAsObject'.PHP_EOL;
                        //echo json_encode(Profesor::getProfesorAsObject());
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
