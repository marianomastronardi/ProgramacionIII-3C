<?php

class Archivo
{
    static $_imgdir = './img/';
    static $_bkpdir = './bkp/';
    static $_filedir = './files/';
    static $_dir = './archivos/';

    public static function serializeObj($ruta, $obj)
    {
        $res = "";
        if (file_exists(Archivo::$_filedir . $ruta)) {
            $ar = fopen(Archivo::$_filedir . $ruta, 'a');
            $res = fwrite($ar, serialize($obj) . PHP_EOL);
            fclose($ar);
        } else {
            $ar = fopen(Archivo::$_filedir . $ruta, 'w');
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

        if (file_exists(Archivo::$_filedir . $ruta)) {
            $lista = array();
            $ar = fopen(Archivo::$_filedir . $ruta, 'r');
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
        if (file_exists(Archivo::$_dir . $ruta)) {
            $ar = fopen(Archivo::$_dir . $ruta, 'r');
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
        $lista = Archivo::getJSON($filename);

        if (!isset($lista)) {
            $lista = array();
        }
        $ar = fopen(Archivo::$_filedir . $filename, 'w');
        array_push($lista, $obj);
        fwrite($ar, json_encode($lista));
        fclose($ar);
    }

    static function changePhotoJson($filename, $email, $newPhoto)
    {
        $lista = Archivo::getJSON($filename);
        if (isset($lista)) {
            foreach ($lista as $value) {
                if($value->_email == $email){
                    Archivo::deleteFile($value->_foto);
                    var_dump($value->_foto);
                    $value->_foto = $newPhoto;
                    var_dump($value->_foto);
                break;
                }
            }

        $ar = fopen(Archivo::$_dir . $filename, 'w');
        
        fwrite($ar, json_encode($lista));
        fclose($ar);
        }
    }

    static function imageHandler($nombre, $obj)
    {
        Archivo::checkIsDir(Archivo::$_imgdir);
        Archivo::checkIsDir(Archivo::$_bkpdir);
        foreach ($obj as $value) {
            $ext = Archivo::getExtensionFile('/', $value['type']);
            $origen = $value['tmp_name'];
            $rand = date_timestamp_get(new DateTime());
            $destino = Archivo::$_imgdir . $nombre . $rand .'.'. $ext;
            //var_dump($value);
            if (Archivo::isImage($ext)) {
                if (Archivo::checkSizeInMB(3.5, $value['size'])) {
                    echo "Archivo $nombre excede el tamaño permitido";
                } else {
                    if (move_uploaded_file($origen, $destino)) {
                        echo "Archivo $nombre subido correctamente";
                        return $nombre . $rand .'.'. $ext;
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
        return $maxSize <= (int)$size / 1024 / 1024;
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
        Archivo::checkIsDir(Archivo::$_imgdir);
        Archivo::checkIsDir(Archivo::$_bkpdir);
        //echo 'paso1';
        if (Archivo::isImage(Archivo::getExtensionFile('.', $source))) {
          //  echo 'paso2';
            copy(Archivo::$_imgdir . $source, Archivo::$_bkpdir . $source);
            unlink(Archivo::$_imgdir . $source);
        }
    }

    static function checkIsDir($ruta){
        if(!is_dir($ruta)) mkdir($ruta);
    }
}
