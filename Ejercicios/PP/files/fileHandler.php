<?php

class FileHandler{

    static $_dir = '../archivos/';

    //return int/false    
    public static function serializeObj($ruta, $obj)
    {
        if(!is_dir(FileHandler::$_dir)) mkdir(FileHandler::$_dir);
        $res = "";
        if (file_exists(FileHandler::$_dir.$ruta)) {
            $ar = fopen(FileHandler::$_dir.$ruta, 'a');
            $res = fwrite($ar, serialize($obj) . PHP_EOL); 
            fclose($ar);
        } else {
            $ar = fopen(FileHandler::$_dir.$ruta, 'w');
            $res = fwrite($ar, serialize($obj) . PHP_EOL);
            fclose($ar);
        }
        return $res;
    }

    //return array/false
    public static function unserializeObj($ruta)
    {
        
        if (file_exists(FileHandler::$_dir.$ruta)){
            $lista = array();
            $ar = fopen(FileHandler::$_dir.$ruta, 'r');
                while (!feof($ar)) {
                    $obj = unserialize(fgets($ar));
                    if ($obj != null)
                        array_push($lista, $obj);
                }
                fclose($ar);
                if(isset($lista))
                    return $lista;
        }    
        return false;    
    }

    //return lista/false
    static function getJSON($ruta)
    {
        if (file_exists(FileHandler::$_dir.$ruta)) {
            $ar = fopen(FileHandler::$_dir.$ruta, 'r');
            $lista = json_decode(fgets($ar));
            fclose($ar);
            if (isset($lista)) {
                return $lista;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    //return int/false
    static function SaveJson($filename, $obj)
    {
        if(!is_dir(FileHandler::$_dir)) mkdir(FileHandler::$_dir);
        $res = false;
        $lista = FileHandler::getJSON($filename);

        if (!$lista) {
            $lista = array();
        }
        $ar = fopen(FileHandler::$_dir.$filename, 'w');
        array_push($lista, $obj);
        $res = fwrite($ar, json_encode($lista));
        fclose($ar);
        return $res;
    }

}
