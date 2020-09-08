<?php
require_once '../clases/alumno.php';
require_once '../files/fileHandler.php';
/*
$alumno = new Alumno('Mariano', 'Mastronardi', '22334455', "1980-03-26", 108050);
$alumno->_delimiter = ';';

//echo $alumno;

//Archivos
//creo un archivo

$filename = 'alumnos.txt';
$listAlumnos = array();
array_push($listAlumnos,$alumno->__toString()); 
//var_dump($listAlumnos);
$res = createFileFromStringArray($filename, $listAlumnos);

if($res) echo "El archivo fue generado correctamente<br>";


//leo un archivo
$arrFromFile = array();

$arrFromFile = getAlumnosArrayFromFile('alumnos.txt');

//var_dump($arrFromFile);

foreach($arrFromFile as $value) 
{
    var_dump($value->__toString());
    echo "<br>";
}
*/
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
        
        if(escribirArchivo('alumno.txt', $alumno->__toString())){
            echo "Alumno creado<br>";
        }else{
            echo "Error al crear un alumno<br>";
        };        

    } else if ($method == 'GET') {
        $values = explode('&', $_SERVER["QUERY_STRING"]);
        $value = explode('=', $values[0]);
        $alumno = findAlumnoFromFile('alumno.txt', $value[1]);

        var_dump($alumno);
        
    } else {
        echo "Metodo no permitido";
    }
} else {
    echo 'Path erroneo';
}
