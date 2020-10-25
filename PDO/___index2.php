<?php 
$id = $_GET['id'];
echo $id;
try {
    //code...
    $pdo = new PDO('mysql:host=localhost;dbname=veterinaria;charset=utf8', 'root', '');

    // $query = $pdo->query("select * from mascotas where id = $id");
    
    // echo "Filas " . $query->rowCount();
    $query = $pdo->prepare("select * from usuarios where id = :id");
    $query->bindParam(':id', $id, PDO:: PARAM_STR | PDO::PARAM_INPUT_OUTPUT, 5);
    // $resultado = $query->fetchAll(PDO::FETCH_CLASS, "Mascota");
    $resultado = $query->execute();
    var_dump($query->fetchAll());
    // foreach ($resultado as $key => $value) {
    //     # code...
    //     // var_dump($value[0]);
    //     echo $key . ' ' . $value['nombre'];
    // }

    // $resultado = $query->fetch();

    while ($fila = $query->fetch(PDO::FETCH_LAZY)) {
        print_r($fila->nombre);
        echo "<br>\n";
    }

    // $resultado = $query->fetchObject('Mascota');
    // var_dump($resultado);
} catch (\Throwable $th) {
    //throw $th;
    echo $th->getMessage();
}