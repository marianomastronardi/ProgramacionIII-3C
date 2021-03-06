<?php

require_once './archivo.php';

$method = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['PATH_INFO'] ?? 0;
/**
 * subir imagen
 * validar q sea imagen
 * validar q sea menor a 3.5 MB
 * cambiar el nombre por nombre unico
 */

switch ($method) {
    case 'POST':
        switch ($path) {
            case '/upload':
                if (isset($_POST['nombre']) && isset($_FILES)) {
                    $nombre = $_POST['nombre'];
                    Archivo::imageHandler($nombre, $_FILES);
                }
                break;
            default:
                echo 'Path incorrecto';
                break;
        }
        break;

    case 'GET':
        switch ($path) {
            case '/upload':
                //var_dump($_GET['nombre']);
                if (isset($_GET['nombre'])) {
                  //  echo 'paso1.1';
                    $nombre = $_GET['nombre'];
                    Archivo::deleteFile($nombre);
                }
                break;

            default:
                echo 'Path incorrecto';
                break;
        }
        break;

    default:
        echo 'Metodo incorrecto';
        break;
}
