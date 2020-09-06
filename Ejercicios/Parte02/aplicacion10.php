<?php
/**Aplicación Nº 10 (Arrays de Arrays)
Realizar las líneas de código necesarias para generar un Array asociativo y otro indexado que
contengan como elementos tres Arrays del punto anterior cada uno. Crear, cargar y mostrar los
Arrays de Arrays. */

$i = 0;
$arrIndexado = array();
$arrAsociativo = array();
$lapicera = array();
array_push($lapicera, array("color" => 'negro', "marca" => 'bic', "trazo" => 'fino', "precio" => 20));
array_push($lapicera, array("color" => 'rojo', "marca" => 'schoerer', "trazo" => 'grueso', "precio" => 150));
array_push($lapicera, array("color" => 'verde', "marca" => 'shompie', "trazo" => 'micro', "precio" => 280));

//lleno los arrays
foreach($lapicera as $key => $value){
    $arrIndexado[0] = $value;
    $i++;
    $arrAsociativo[$key] = $value; 
}

echo "Array Indexado<br/><br/>";
    for($i = 0; $i < count($arrIndexado); $i++){

        foreach($arrIndexado[$i] as $value) echo $value."<br/>";
    }
    echo "<br/>";

    echo "Array Asociativo<br/><br/>";
    foreach($arrAsociativo as $values){
        foreach($values as $key=>$value){
            echo $key." => ".$value."<br/>";
        }
        echo "<br/>";
    }
    
?>