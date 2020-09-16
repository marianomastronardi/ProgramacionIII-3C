<?php

class Archivo
{
    
    public static function serializeObj($ruta, $obj)
    {
        $res = "";
        if (file_exists('../files/' . $ruta)) {
            $ar = fopen('../files/' . $ruta, 'a');
            $res = fwrite($ar, serialize($obj) . PHP_EOL);
            fclose($ar);
        } else {
            $ar = fopen('../files/' . $ruta, 'w');
            $res = fwrite($ar, serialize($obj) . PHP_EOL);
            fclose($ar);
        }
        if ($res) {
            echo "Archivo serializado correctamente" . PHP_EOL;
        } else {
            echo "No se ha podido serializar el objeto" . PHP_EOL;
        }
    }

    public static function unserializeObj($ruta)
    {

        if (file_exists('../files/' . $ruta)) {
            $lista = array();
            $ar = fopen('../files/' . $ruta, 'r');
            while (!feof($ar)) {
                $obj = unserialize(fgets($ar));
                if ($obj != null)
                    array_push($lista, $obj);
            }
            fclose($ar);
            if (isset($lista))
                return $lista;
        } else {
            echo 'El archivo no existe' . PHP_EOL;
        }
    }

    //get JSON

    static function getJSON($ruta)
    {
        if (file_exists('../files/' . $ruta)) {
            $ar = fopen('../files/' . $ruta, 'r');
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
        $ar = fopen('../files/' . $filename, 'w');
        array_push($lista, $obj);
        fwrite($ar, json_encode($lista));
        fclose($ar);
    }

    static function imageHandler($nombre, $obj)
    {

        foreach ($obj as $value) {
            $ext = Archivo::getExtensionFile('/', $value['type']);
            $origen = $value['tmp_name'];
            $rand = date_timestamp_get(new DateTime());
            $destino = '../img/' . $nombre . $rand .'.'. $ext;
            //var_dump($value);
            if (Archivo::isImage($ext)) {
                if (Archivo::checkSizeInMB(3.5, $value['size'])) {
                    echo "Archivo $nombre excede el tamaño permitido";
                } else {
                    if (move_uploaded_file($origen, $destino)) {
                        echo "Archivo $nombre subido correctamente";
                    } else {
                        echo "Error al subir el archivo $nombre";
                    }
                }
            } else {
                echo "$nombre No es una imagen";
            }
        }
    }

    static function getExtensionFile($delimiter, $path)
    {
        $path = explode($delimiter, $path);
        return $path[count($path) - 1];
    }

    static function checkSizeInMB($maxSize, $size)
    {
        return $maxSize <= (int)1 / 1024 / 1024;
    }

    static function isImage($ext)
    {
        $ret = false;
        $imgExt = array('png' => 'image/png',
        'jpe' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'gif' => 'image/gif',
        'bmp' => 'image/bmp',
        'ico' => 'image/vnd.microsoft.icon',
        'tiff' => 'image/tiff',
        'tif' => 'image/tiff',
        'svg' => 'image/svg+xml',
        'svgz' => 'image/svg+xml');
        
        //return ($ext === 'jpeg' || $ext === 'jpg');
        return array_key_exists($ext, $imgExt);
    }

    static function deleteFile($source)
    {
        var_dump($source);
        if (Archivo::isImage(Archivo::getExtensionFile('.', $source))) {
            copy('../img/' . $source, '../bkp/' . $source);
            unlink('../img/' . $source);
        }
    }
}
