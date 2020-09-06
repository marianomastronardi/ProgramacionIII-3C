<?php
/*
Aplicación Nº 6 (Carga aleatoria)
Definir un Array de 5 elementos enteros y asignar a cada uno de ellos un número (utilizar la
función rand ). Mediante una estructura condicional, determinar si el promedio de los números
son mayores, menores o iguales que 6. Mostrar un mensaje por pantalla informando el
resultado.
*/
$min = 0;
$max = 10;
$arr =array();
$tot = 0;

for($i = 0; $i < 5; $i++){
    $arr[$i] = random_int($min, $max);
    $tot += $arr[$i];
    echo $arr[$i]."<br/>";
};

if($tot/count($arr) > 6){
    echo "promedio mayor a 6";
}
elseif($tot/count($arr) < 6){
    echo "promedio menor a 6";
}else{
    echo "promedio igual a 6";
};

?>