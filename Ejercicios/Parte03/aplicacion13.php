<?php

/* Aplicación Nº 13 (Invertir palabra)
Crear una función que reciba como parámetro un string ($ palabra ) y un entero ($ max ). La
función validará que la cantidad de caracteres que tiene $ palabra no supere a $ max y además
deberá determinar si ese valor se encuentra dentro del siguiente listado de palabras válidas:
“Recuperatorio”, “Parcial” y “Programacion”. Los valores de retorno serán:
1 si la palabra pertenece a algún elemento del listado.
0 en caso contrario. */

require_once './funciones.php';

$validStr = 'Recuperatorio';
$notValidStr = 'Mariano';
$max1 = 1;
$max15 = 15;

echo (isValidString($validStr, $max1) ? 'Valid' : 'Not Valid').'<br>';
echo (isValidString($validStr, $max15) ? 'Valid' : 'Not Valid').'<br>';
echo (isValidString($notValidStr, $max1) ? 'Valid' : 'Not Valid').'<br>';
echo (isValidString($notValidStr, $max15) ? 'Valid' : 'Not Valid').'<br>';

?>