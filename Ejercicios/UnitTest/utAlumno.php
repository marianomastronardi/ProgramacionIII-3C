<?php
require_once '../clases/alumno.php';
require_once '../files/fileHandler.php';

$alumno = new Alumno('Mariano', 'Mastronardi', '22334455', "1980-03-26", 108050);
$alumno->_delimiter = ';';
//echo $alumno;

//Archivos
//creo un archivo
/*
$filename = 'alumnos.txt';
$listAlumnos = array();
array_push($listAlumnos,$alumno->__toString()); 
//var_dump($listAlumnos);
$res = createFileFromStringArray($filename, $listAlumnos);

if($res) echo "El archivo fue generado correctamente<br>";
*/

//leo un archivo
$arrFromFile = array();

$arrFromFile = getAlumnosArrayFromFile('alumnos.txt');

//var_dump($arrFromFile);

foreach($arrFromFile as $value) 
{
    var_dump($value->__toString());
    echo "<br>";
}
?>