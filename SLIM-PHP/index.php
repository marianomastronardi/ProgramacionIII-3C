<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteCollectorProxy;
use Seguridad\Usuario;
use Seguridad\iToken;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();
$app->setBasePath("/ProgramacionIII-3C/SLIM-PHP");

 $app->get('/login', function (Request $request, Response $response, $args) {
    //$response->getBody()->write("Hello world from GET!");
    $query = $request->getQueryParams();
    $user = Usuario::getUser($query['email']);
    if($user){
        if(!password_verify($query['password'], $user["clave"])){
            echo "Contraseña incorrecta"; 
        }else{
            $response->getBody()->write(Usuario::getToken($query['email'], $query['password']));
        }
    }else{
        return json_encode(array('message' => 'El email no existe'));
    }
    return $response;
});

$app->post('/login', function (Request $request, Response $response, $args) {
    //$response->getBody()->write("Hello world from GET!");
    $body = $request->getParsedBody();
    $user = Usuario::getUser($body['email']);
    //var_dump($user);
    if($user){
        if(!password_verify($body['password'], $user["clave"])){
            echo "Contraseña incorrecta"; 
        }else{
            $response->getBody()->write(Usuario::getToken($body['email'], $body['password']));
        }
    }else{
        return json_encode(array('message' => 'El email no existe'));
    }
    return $response;
});
$app->group('/usuarios', function (RouteCollectorProxy $group) {
$group->post('', function (Request $request, Response $response, $args) {
    //$response->getBody()->write("Hello world from POST!");
    $body = $request->getParsedBody();
    $response->getBody()->write(Usuario::Save($body["email"], $body["password"])); 
    //echo $response;
    return $response ->withHeader('Content-Type', 'application/json');;
});

$group->get('/{email}', function (Request $request, Response $response, $args) {
    $user = Usuario::getUser($args["email"]);
    $response->getBody()->write(json_encode(new Usuario($user['email'], $user['clave'])));
    return $response ->withHeader('Content-Type', 'application/json');;
});
});

$app->post('/productos', function (Request $request, Response $response, $args) {
    $params = $request->getServerParams();
    $token = $params['HTTP_TOKEN'] ?? null;
    if($token){
        if (iToken::decodeUserToken($token)) {
            echo 'Signature valid';
       }
    }
    return $response;
}); 

$app->run(); 

/* use Seguridad\Usuario;
use Seguridad\iToken;

$user = new Usuario('magama', '123');

$user->name = 'Mariano';
echo $user->name; */
/* $method = $request->getMethod();
echo $method; */