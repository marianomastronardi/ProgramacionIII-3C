<?php
use \Firebase\JWT\JWT;
require_once '../vendor/autoload.php';


class iToken{
  
static $_key = "pro3-parcial";

function __get($name)
{
    return $this->_key;
}

static function encodeUserToken($email, $pass)
{
    $payload = array(
        "iss" => "http://example.org",
        "aud" => "http://example.com",
        "iat" => 1356999524,
        "nbf" => 1357000000,
        "email" => $email,
        "password" => $pass
    );
    
    /**
     * IMPORTANT:
     * You must specify supported algorithms for your application. See
     * https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40
     * for a list of spec-compliant algorithms.
     */
    
    $jwt = JWT::encode($payload, iToken::$_key);
    return $jwt;
}   

static function decodeUserToken($jwt){
    try {
        $decoded = JWT::decode($jwt, iToken::$_key, array('HS256'));
    return (array) $decoded;
    } catch (\Throwable $th) {
        echo "Signature Invalid";
        return false;
    }
    
}


//print_r($decoded);
//var_dump($jwt);
/*
 NOTE: This will now be an object instead of an associative array. To get
 an associative array, you will need to cast it as such:
*/

//$decoded_array = (array) $decoded;

/**
 * You can add a leeway to account for when there is a clock skew times between
 * the signing and verifying servers. It is recommended that this leeway should
 * not be bigger than a few minutes.
 *
 * Source: http://self-issued.info/docs/draft-ietf-oauth-json-web-token.html#nbfDef
 */
//JWT::$leeway = 60; // $leeway in seconds
//$decoded = JWT::decode($jwt, $key, array('HS256'));
}
?>