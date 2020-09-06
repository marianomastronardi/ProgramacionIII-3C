<?php

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
function escribirArchivo($filename, $text, $len = 0){
    $res = null;
    $file = getRemoveAndWriteFile($filename);
    if(isset($file)){
        $res = fwrite($file, $text, $len > 0 ? $len : null);
    }
    return $res;
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
function createFileFromClassArray($filename, $array, $delimiter = '*'){
    $file = getWriteAppendFile($filename);
    $str = "";
    foreach($array as $values){
        foreach($values as $key=>$value){
             $str = $str.$value.$delimiter;
        }
        $str = $str.'<br>';
    }
    return fwrite($file, $str);
}
?>
