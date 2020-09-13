<?php

class Archivos
{


    public static function serializeObj($ruta, $obj)
    {
        $res = "";
        if (file_exists('../files/'.$ruta)) {
            $ar = fopen('../files/'.$ruta, 'a');
            $res = fwrite($ar, serialize($obj) . PHP_EOL); 
            fclose($ar);
        } else {
            $ar = fopen('../files/'.$ruta, 'w');
            $res = fwrite($ar, serialize($obj) . PHP_EOL);
            fclose($ar);
        }
        if($res){
            echo "Archivo serializado correctamente" . PHP_EOL;
        }else{
            echo "No se ha podido serializar el objeto" . PHP_EOL;
        }
    }

    public static function unserializeObj($ruta)
    {
        
    if (file_exists('../files/'.$ruta)){
        $lista = array();
        $ar = fopen('../files/'.$ruta, 'r');
            while (!feof($ar)) {
                $obj = unserialize(fgets($ar));
                if ($obj != null)
                    array_push($lista, $obj);
            }
            fclose($ar);
            if(isset($lista))
                return $lista;
    }else{
        echo 'El archivo no existe' . PHP_EOL;
    }
        
    }

    //get JSON

    static function getJSON($ruta)
    {
        if (file_exists('../files/'.$ruta)) {
            $ar = fopen('../files/'.$ruta, 'r');
            $lista = json_decode(fgets($ar));
            fclose($ar);
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
