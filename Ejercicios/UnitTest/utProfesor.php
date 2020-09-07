<?php
require_once '../clases/profesor.php';

$profesor = new Profesor('Mario', 'Rampi', '12345678', "1985-05-24");
$profesor->_delimiter = '*';
echo $profesor;

//Archivos

?>