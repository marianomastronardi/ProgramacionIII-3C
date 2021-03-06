<?php
namespace Seguridad;

use \Firebase\JWT\JWT;

class iToken{
  
static $_key = "segundoparcial";

function __get($name)
{
    return $this->_key;
}

static function encodeUserToken($email, $nombre)
{
    $payload = array(
        "iss" => "http://example.org",
        "aud" => "http://example.com",
        "iat" => 1356999524,
        "nbf" => 1357000000,
        "email" => $email,
        "nombre" => $nombre
    );
    
 
    $jwt = JWT::encode($payload, iToken::$_key);
    return $jwt;
}   

static function decodeUserToken($jwt){
    try {
        $decoded = JWT::decode($jwt, iToken::$_key, array('HS256'));
    return (array) $decoded;
    } catch (\Throwable $th) {
        //echo "Signature Invalid";
        return false;
    }
    
}
}
?>