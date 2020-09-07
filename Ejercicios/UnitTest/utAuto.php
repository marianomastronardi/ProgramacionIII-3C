<?php
require_once '../clases/auto.php';

$auto = new Auto('Fiat', 'rojo', 2012, 10);

$auto->AumentarVelocidad(15);

echo $auto->getVehiculos();
?>