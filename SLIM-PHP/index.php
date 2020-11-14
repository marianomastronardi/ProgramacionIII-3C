<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteCollectorProxy;
use Seguridad\Usuario;
use Seguridad\iToken;
use Slim\Factory\AppFactory;
use App\Controllers\UserController;
use Config\Database;
use Illuminate\Container\Container;

use \Firebase\JWT\JWT;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Exception\HttpNotFoundException;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Middleware\ErrorMiddleware;

use App\Middlewares\JsonMiddleware;
use App\Middlewares\AuthMiddleware;
use App\Middlewares\UserMiddleware;

require __DIR__ . '/vendor/autoload.php';
$container = new Container();
AppFactory::setContainer($container);
$app = AppFactory::create();
$app->addRoutingMiddleware();

// Define Custom Error Handler
$customErrorHandler = function (
    ServerRequestInterface $request,
    Throwable $exception,
    bool $displayErrorDetails,
    bool $logErrors,
    bool $logErrorDetails,
    ?LoggerInterface $logger = null
) use ($app) {
    $logger->error($exception->getMessage());

    $payload = ['error' => $exception->getMessage()];

    $response = $app->getResponseFactory()->createResponse();
    $response->getBody()->write(
        json_encode($payload, JSON_UNESCAPED_UNICODE)
    );

    return $response;
};

$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorMiddleware->setDefaultErrorHandler($customErrorHandler);
//$app->setBasePath("./public_html");
new Database();
/** Grupo /login */
/* $app->group('/login', function (RouteCollectorProxy $group) {
    $group->get('', function (Request $request, Response $response, $args) {
        //$response->getBody()->write("Hello world from GET!");
        $query = $request->getQueryParams();
        $user = Usuario::getUser($query['email']);
        if ($user) {
            if (!password_verify($query['password'], $user["clave"])) {
                echo "Contraseña incorrecta";
            } else {
                $response->getBody()->write(Usuario::getToken($query['email'], $query['password']));
            }
        } else {
            return json_encode(array('message' => 'El email no existe'));
        }
        return $response;
    });

    $group->post('', function (Request $request, Response $response, $args) {
        //$response->getBody()->write("Hello world from GET!");
        $body = $request->getParsedBody();
        $user = Usuario::getUser($body['email']);
        //var_dump($user);
        if ($user) {
            if (!password_verify($body['password'], $user["clave"])) {
                echo "Contraseña incorrecta";
            } else {
                $response->getBody()->write(Usuario::getToken($body['email'], $body['password']));
            }
        } else {
            return json_encode(array('message' => 'El email no existe'));
        }
        return $response;
    });
});
 */
/** Grupo /usuarios */
/* $app->group('/usuarios', function (RouteCollectorProxy $group) {
    $group->post('', function (Request $request, Response $response, $args) {
        //$response->getBody()->write("Hello world from POST!");
        $body = $request->getParsedBody();
        $response->getBody()->write(Usuario::Save($body["email"], $body["password"]));
        //echo $response;
        return $response->withHeader('Content-Type', 'application/json');
    });

    $group->get('/{email}', function (Request $request, Response $response, $args) {
        $user = Usuario::getUser($args["email"]);
        $response->getBody()->write(json_encode(new Usuario($user['email'], $user['clave'])));
        return $response->withHeader('Content-Type', 'application/json');
    });
});

$app->post('/productos', function (Request $request, Response $response, $args) {
    $params = $request->getServerParams();
    $token = $params['HTTP_TOKEN'] ?? null;
    if ($token) {
        if (iToken::decodeUserToken($token)) {
            echo 'Signature valid';
        }
    }
    return $response;
}); */


 $app->group('/users', function (RouteCollectorProxy $group) {

    $group->get('/{email}', UserController::class . ":getOne");
    $group->get('[/]', UserController::class . ":getAll");
    $group->post('[/]', UserController::class . ":add");
}); 

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hello world from HOME!");
    return $response->withHeader('Content-Type', 'application/json');
});

$app->get('/users2', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Hello world from users!");
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run(); 

/* use Seguridad\Usuario;
use Seguridad\iToken;

$user = new Usuario('magama', '123');

$user->name = 'Mariano';
echo $user->name; */
/* $method = $request->getMethod();
echo $method;
$group->get('/{id}', UserController::class . ":getOne");
 */