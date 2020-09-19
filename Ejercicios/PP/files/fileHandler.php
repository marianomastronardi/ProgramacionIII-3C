<?php

class FileHandler{

    public static function serializeObj($ruta, $obj)
    {
        $res = "";
        if (file_exists('../archivos/'.$ruta)) {
            $ar = fopen('../archivos/'.$ruta, 'a');
            $res = fwrite($ar, serialize($obj) . PHP_EOL); 
            fclose($ar);
        } else {
            $ar = fopen('../archivos/'.$ruta, 'w');
            $res = fwrite($ar, serialize($obj) . PHP_EOL);
            fclose($ar);
        }
        /*if($res){
            echo "Archivo serializado correctamente" . PHP_EOL;
        }else{
            echo "No se ha podido serializar el objeto" . PHP_EOL;
        }*/
    }

    public static function unserializeObj($ruta)
    {
        
    if (file_exists('../archivos/'.$ruta)){
        $lista = array();
        $ar = fopen('../archivos/'.$ruta, 'r');
            while (!feof($ar)) {
                $obj = unserialize(fgets($ar));
                if ($obj != null)
                    array_push($lista, $obj);
            }
            fclose($ar);
            if(isset($lista))
                return $lista;
    }/*else{
        echo 'El archivo no existe' . PHP_EOL;
    }*/
        
    }

    //get JSON
    //devuelve una lista o false
    static function getJSON($ruta)
    {
        if (file_exists('../archivos/'.$ruta)) {
            $ar = fopen('../archivos/'.$ruta, 'r');
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

    //guardar en JSON
    //devuelve una int o false
    static function SaveJson($filename, $obj)
    {
        $res = false;
        $lista = FileHandler::getJSON($filename);

        if (!$lista) {
            $lista = array();
        }
        $ar = fopen('../archivos/'.$filename, 'w');
        array_push($lista, $obj);
        $res = fwrite($ar, json_encode($lista));
        fclose($ar);
        return $res;
    }

}

?>