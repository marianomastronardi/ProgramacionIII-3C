<?php

class Archivos
{


    public static function serializeObj($ruta, $obj)
    {
        if (file_exists('../files/'.$ruta)) {
            $ar = fopen('../files/'.$ruta, 'a');
            fwrite($ar, serialize($obj) . PHP_EOL);
            fclose($ar);
        } else {
            $ar = fopen('../files/'.$ruta, 'w');
            fwrite($ar, serialize($obj) . PHP_EOL);
            fclose($ar);
        }
    }

    public static function unserializeObj($ruta)
    {
        $lista = array();
        $ar = fopen('../files/'.$ruta, 'r');

        while (!feof($ar)) {
            $obj = unserialize(fgets($ar));
            if ($obj != null)
                array_push($lista, $obj);
        }

        fclose($ar);
        return $lista;
    }

    //get JSON

    static function getJSON($ruta)
    {
        if (file_exists('../files/'.$ruta)) {
            $ar = fopen('../files/'.$ruta, 'r');
            //echo fgets($ar).PHP_EOL;
            //var_dump(json_decode(fgets($ar)));
            $lista = json_decode(fgets($ar));
            fclose($ar);
            //var_dump($lista);
            if (isset($lista)) {
                return $lista;
            } else {
                echo "La lista esta vacia" . PHP_EOL;
            }
        } else {
            echo 'El archivo no existe' . PHP_EOL;
        }
    }

    //guardar en JSON
    static function SaveJson($filename, $obj)
    {
        $lista = Archivos::getJSON($filename);

        if (!isset($lista)) {
            $lista = array();
        }
        $ar = fopen('../files/'.$filename, 'w');
        array_push($lista, $obj);
        fwrite($ar, json_encode($lista));
        fclose($ar);
    }
}
