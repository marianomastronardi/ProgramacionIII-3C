<?php

/* Aplicación Nº 14 (Par e impar)
Crear una función llamada esPar que reciba un valor entero como parámetro y devuelva T RUE
si este número es par ó F ALSE si es impar.
Reutilizando el código anterior, crear la función esImpar . */

require_once './funciones.php';

$par = 8;
$impar = 7;


echo $par.(esPar($par) ? ' es un numero par' : ' es un numero impar').'<br>';
echo $impar.(esPar($impar) ? ' es un numero par' : ' es un numero impar').'<br>';
echo $par.(!esImpar($par) ? ' es un numero par' : ' es un numero impar').'<br>';
echo $impar.(!esImpar($impar) ? ' es un numero par' : ' es un numero impar').'<br>';
?>