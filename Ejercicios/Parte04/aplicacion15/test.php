<?php

require_once('./triangulo.php');
require_once('./rectangulo.php');

$triangulo = new triangulo(5, 5);
$rectangulo = new rectangulo(5, 5);

$triangulo->CalcularDatos();
$triangulo->Dibujar();
echo $triangulo;

$rectangulo->CalcularDatos();
$rectangulo->Dibujar();
echo $rectangulo;

?>