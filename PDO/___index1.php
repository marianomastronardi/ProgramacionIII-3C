<?php

$id = $_GET['id'];
try {
    //code...
    $pdo = new PDO('mysql:host=localhost;dbname=prueba', $usuario, $contraseña);

    $query = $pdo->query("Select * from productos where id = $id");//no hacer esto nunca

    echo $query->rowCount();

    $resultado = $query->fetchAll();
    $resultado = $query->fetchAll(PDO::FETCH_CLASS, "mi clase");

    while($fila = $query->fetch(PDO::FETCH_NUM)){
        print_r($fila[0]);
        echo '<br/>';
    }

    while($fila = $query->fetch(PDO::FETCH_ASSOC)){
        print_r($fila['id']);
        echo '<br/>';
    }

    while($fila = $query->fetch(PDO::FETCH_CLASS, "mi clase")){
        print_r($fila->id);
        echo '<br/>';
    }

    while($fila = $query->fetch(PDO::FETCH_LAZY)){
        print_r($fila->id);
        echo '<br/>';
    }

    $resultado = $query->fetchObject("Mi clase");

} catch (\Throwable $th) {
    echo $th->getMessage();
}


?>