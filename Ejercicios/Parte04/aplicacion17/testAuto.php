<?php
/*
Ejemplo: $importeDouble = Auto::Add($autoUno, $autoDos);
En t estAuto.php :
● Crear dos objetos “Auto” de la misma marca y distinto color.
● Crear dos objetos “Auto” de la misma marca, mismo color y distinto precio.
● Crear un objeto “Auto” utilizando la sobrecarga restante.
● Utilizar el método “AgregarImpuesto” en los últimos tres objetos, agregando $ 1500
al atributo precio.
● Obtener el importe sumado del primer objeto “Auto” más el segundo y mostrar el
resultado obtenido.
● Comparar el primer “Auto” con el segundo y quinto objeto e informar si son iguales o
no.
● Utilizar el método de clase “ MostrarAuto ” para mostrar cada los objetos impares (1, 3,
5)
 */
require_once "./auto.php";
/*
$autoUno = new Auto("fiat", "rojo");
$autoDos = new Auto("fiat", "negro");


$autoTres = new Auto("fiat", "rojo", 3000);
$autoCuatro = new Auto("fiat", "rojo", 2500);

$autoCinco = new Auto("fiat", "rojo", 3000, "12/10/2010");
$autoSeis = new Auto("fiat", "rojo", 2500, "02/01/2020");
*/
$method = $_SERVER['REQUEST_METHOD'];
$pathinfo = $_SERVER['PATH_INFO'];
/*
var_dump($_SERVER);
die();
*/
if(isset($pathinfo)){
    switch($method){
        case 'GET':
            switch($pathinfo){
                case '/auto/':
                    $autoUno = new Auto($_GET['marca']??'', $_GET['color']??'',$_GET['precio']??0, $_GET['fecha']??'');
                    echo $autoUno;
                break;
                default: echo 'Path erroneo';
            break;
            }
        break;
        case 'POST':
            switch($pathinfo){
                case '/auto/':
                    $autoUno = new Auto($_POST['marca']??'', $_POST['color']??'',$_POST['precio']??0, $_POST['fecha']??'');
                    echo $autoUno;
                break;
                default: echo 'Path erroneo';
            break;
            }
        break;
        default: echo 'Metodo no permitido';
    break;
    }
}else{
    echo 'Path no definido';
}

 ?>