<?php
/*
Aplicación Nº 9 (Arrays asociativos)
Realizar las líneas de código necesarias para generar un Array asociativo $lapicera, que
contenga como elementos: ‘color’ , ‘marca’ , ‘trazo’ y ‘precio’ . Crear, cargar y mostrar tres
lapiceras.
*/



for($i = 0; $i < 3;$i++){

    switch($i){
        case 0:
            $lapicera = array("color" => 'negro', "marca" => 'bic', "trazo" => 'fino', "precio" => 20);
        break;
        case 1:
             $lapicera = array("color" => 'rojo', "marca" => 'schoerer', "trazo" => 'grueso', "precio" => 150);
        break;
        case 2:
              $lapicera = array("color" => 'verde', "marca" => 'shompie', "trazo" => 'micro', "precio" => 280);
        break;      

    }

    foreach($lapicera as $key=>$value){
        echo $key." => ".$value."<br/>";
    }
    echo "<br/>";
}
