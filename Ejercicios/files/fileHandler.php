<?php
require_once '../clases/alumno.php';

//fopen
function getReadOnlyFile($file){
    return fopen($file, 'r');
}

function getRemoveAndWriteFile($file){
    return fopen($file, 'w');
}

function getWriteAppendFile($file){
    return fopen($file, 'a');
}

function getReadOnlyAndCheckFile($file){
    return fopen($file, 'x');
}

function getReadWriteFile($file){
    return fopen($file, 'r+');
}

function getReadRemoveAndWriteFile($file){
    return fopen($file, 'w+');
}

function getReadWriteAppendFile($file){
    return fopen($file, 'a+');
}

function getReadWriteAndCheckFile($file){
    return fopen($file, 'x+');
}

//fclose
function setCloseFile($file){
    return fclose($file);
}

//fread/fgets
function LeerArchivo($file, $len = 0)
{
    $res = "";
    if($file){
        $res = fread($file, $len > 0 ? $len : filesize($file));
    }
    else{
        $res = "El archivo no ha sido abierto";
    }
    $res = fclose($file);

    return $res;
}

function fillArrayFromFile($filename, $array, $delimiter = '*'){

    $file = fopen($filename, 'r');
    while (!feof($file)) {
        $linea = fgets($file);
    
        $datos = explode($delimiter, $linea);
        
        //if (count($datos) > 3) {
        //    $nuevoAuto = new Auto($datos[0], $datos[1], $datos[2], $datos[3]);
            array_push($array, $datos);
        //}
    }
    fclose($file);

    return $array;
}

//fwrite/fputs
function escribirArchivo($filename, $text, $len = null){
    $file = getWriteAppendFile($filename);
    if(isset($file)){
        if(isset($len)){
            fwrite($file, $text.PHP_EOL, $len);
        }else{
            fwrite($file, $text.PHP_EOL);
        }
    }
    return fclose($file);
}

//copy
function copyFile($from, $to){
    copy($from, $to);
}

//unlink
function deleteFile($filename){
    unlink($filename);
}

//create
function createFileFromStringArray($filename, $array){
    $file = getWriteAppendFile($filename);
    $str = "";

    //foreach($array as $value) $str = $str.$value."\n";

    //fwrite($file, $str);
    
    foreach($array as $value) fwrite($file, $str.$value, PHP_EOL);

    return fclose($file);
}

function getAlumnosArrayFromFile($filename){
    $file = getReadOnlyFile($filename);
    $alumnos = array();

    while(!feof($file)){
        $linea = fgets($file);

        $arrAlumno = explode(';', $linea);
    
    if (count($arrAlumno) > 1) {
        //var_dump($arrAlumno);
        //echo "<br>";
        $alumno = new Alumno($arrAlumno[0], $arrAlumno[1], $arrAlumno[2], $arrAlumno[3], $arrAlumno[5]);
        array_push($alumnos, $alumno);
    }
    }

    fclose($file);

    return $alumnos;
}

function findAlumnoFromFile($filename, $value){
    $file = getReadOnlyFile($filename);
    $alumno = "";

    while(!feof($file)){
        $linea = fgets($file);

        $arrValues = explode(';', $linea);
    
        if (count($arrValues) > 1) {
            
            for($i = 0; $i < count($arrValues); $i++){
                if($arrValues[$i] === $value){
                    $alumno = new Alumno($arrValues[0], $arrValues[1], $arrValues[2], $arrValues[3], $arrValues[5]);
                    break;
                }
            }
        }
    }
           
    return $alumno;
}
