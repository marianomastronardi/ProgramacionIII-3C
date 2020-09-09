<?php
require_once '../clases/archivos.php';
class Metodos{

/*  public function __construnct(){

 }  */

public static function LeerObjeto($ruta){
    return Archivos::unserializeObj($ruta);
}

public static function GuardarObjeto($ruta, $obj){
    Archivos::serializeObj($ruta, $obj);
}

public static function SaveJson($ruta, $obj){
    Archivos::SaveJson($ruta, $obj);
}

public static function GetJSON($path){
    return Archivos::getJSON($path);
}
}

?>