<?php
require_once './clases/auto.php';

$auto = new Auto('ABC 333', 'Ford', 'Azul', 80000);
$file = 'archivo.txt';
$modo = 'r';

// copy($file, 'nuevo_archivo.txt');
// unlink('nuevo_archivo.txt');

$listaDeAutos = array();

$archivo = fopen($file, $modo);

// $size = filesize($file);

// $fwrite = fwrite($archivo, $auto . PHP_EOL);

// echo "fwrite $fwrite <br>";
// $fread = fread($archivo, $size); // Todo el archivo
// echo $fread;
while (!feof($archivo)) {
    $linea = fgets($archivo);

    $datos = explode('*', $linea);
    
    if (count($datos) > 3) {
        $nuevoAuto = new Auto($datos[0], $datos[1], $datos[2], $datos[3]);
        array_push($listaDeAutos, $nuevoAuto);
    }

    // echo $linea;
}

$close = fclose($archivo);

// var_dump($listaDeAutos);

foreach ($listaDeAutos as $value) {
    # code...

    echo $value->_patente;
}
