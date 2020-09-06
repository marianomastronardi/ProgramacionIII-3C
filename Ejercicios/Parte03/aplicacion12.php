<?php
/**
 * Aplicación Nº 12 (Invertir palabra)
*Realizar el desarrollo de una función que reciba un Array de caracteres y que invierta el orden
*de las letras del Array.
*Ejemplo: Se recibe la palabra “HOLA” y luego queda “ALOH”.
 * 
 */
require_once './funciones.php';

$miArr = array('H', 'O', 'L', 'A');

$miArr = reverseByValue($miArr);

foreach($miArr as $value){
    echo $value;
}

?>