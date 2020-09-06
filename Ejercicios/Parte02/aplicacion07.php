<?php

/*
Aplicación Nº 7 (Mostrar impares)
Generar una aplicación que permita cargar los primeros 10 números impares en un Array.
Luego imprimir (utilizando la estructura for ) cada uno en una línea distinta (recordar que el
salto de línea en HTML es la etiqueta < br/> ). Repetir la impresión de los números utilizando
las estructuras while y foreach .
*/
$i = 0;
$arr = array();

while($i <= 20){
    if($i%2 == 1) array_push($arr, $i);
    $i++;
}

//for
echo "Estructura For<br/>";
for($i = 0; $i < count($arr); $i++){
    echo $arr[$i]."<br/>";
};

//while
$i = 0;
echo "Estructura While<br/>";
while($i < count($arr)){
    echo $arr[$i]."<br/>";
    $i++;
};

//foreach
echo "Estructura ForEach<br/>";
foreach($arr as $value){
    echo $value."<br/>";
};
?>