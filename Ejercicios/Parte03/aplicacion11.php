<?php

/**
 * Aplicación Nº 11 (Potencias de números)
* Mostrar por pantalla las primeras 4 potencias de los números del uno 1 al 4 (hacer una función
* que las calcule invocando la función pow ).
 */
require_once './funciones.php';

for($i = 1; $i <= 4; $i++)
{
    echo "Cuadrado de $i: ".cuadrado($i)."<br>";
}


?>