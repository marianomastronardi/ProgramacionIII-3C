<?php

require_once '../clases/alumno.php';
require_once './utMethods.php';

$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['PATH_INFO'] ?? 0;

if ($path === '/alumno') {
    if ($method == 'POST') {
        $nombre = $_POST['nombre'] ?? '';
        $apellido = $_POST['apellido'] ?? '';
        $documento = $_POST['documento'] ?? '';
        $fechaNacimiento = $_POST['fechaNacimiento'] ?? '';
        $legajo = $_POST['legajo'] ?? 0;
        
        $alumno = new Alumno($nombre, $apellido, $documento, $fechaNacimiento, $legajo);
        
        if($alumno != null){
            Metodos::GuardarObjeto('alumnosSerialized.txt', $alumno);
            Metodos::SaveJson('alumnosJson.txt', $alumno);
        }else{
            echo "Error al crear un alumno".PHP_EOL;
        };        

    } else if ($method == 'GET') {
        $listaSerialized = Metodos::LeerObjeto('alumnosSerialized.txt');
        $listaJson = Metodos::GetJSON('alumnosJson.txt');
       
        if(isset($listaJson)){
            $lstFound = array();
            foreach($listaJson as $value){
                if(isset($_GET['nombre'])){
                    if($value->_nombre == $_GET['nombre']){
                        //echo "JSON list ".$value->_nombre.PHP_EOL;
                        array_push($lstFound, $value);
                        continue;
                    }
                }
                if(isset($_GET['apellido'])){
                    if($value->_apellido == $_GET['apellido']){
                        //echo "JSON list ".$value->_nombre.PHP_EOL;
                        array_push($lstFound, $value);
                        continue;
                    }
                }    
            }

            if(count($lstFound) > 0){
                var_dump($lstFound);
            }else{
                echo "Alumno no encontrado JSON.".PHP_EOL;
            }
            
        }else{
            echo "No hay coincidencias en lista JSON".PHP_EOL;
        }
       
        if(isset($listaSerialized)){
            $lstFound = array();
            foreach($listaSerialized as $value){
                if(isset($_GET['nombre'])){
                    if($value->_nombre == $_GET['nombre']){
                        //echo "Serialized list ".$value->_nombre.PHP_EOL;
                        array_push($lstFound, $value);
                        continue;
                    }
                }
                if(isset($_GET['apellido'])){
                    if($value->_apellido == $_GET['apellido']){
                        //echo "Serialized list ".$value->_nombre.PHP_EOL;
                        array_push($lstFound, $value);
                        continue;
                    }
                }    
            }

            if(count($lstFound) > 0){
                var_dump($lstFound);
            }else{
                echo "Alumno no encontrado Serialized.".PHP_EOL;
            }

        }else{
            echo "No hay coincidencias en lista Serialized".PHP_EOL;
        }
        
    } else {
        echo "Metodo no permitido";
    }
} else {
    echo 'Path erroneo';
}

?>