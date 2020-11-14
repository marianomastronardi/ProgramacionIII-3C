<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteCollectorProxy;
use Seguridad\Usuario;
use Slim\Factory\AppFactory;
use App\Controllers\UserController;
use App\Controllers\VehiculoController;
use App\Controllers\ServicioController;
use App\Controllers\TurnoController;
use Config\Database;
use Illuminate\Container\Container;

use \Firebase\JWT\JWT;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Exception\HttpNotFoundException;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Middleware\ErrorMiddleware;

use Psr\Http\Message\UploadedFileInterface;
use App\Middlewares\JsonMiddleware;
use App\Middlewares\AuthMiddleware;
use App\Middlewares\UserMiddleware;

require __DIR__ . '/vendor/autoload.php';
$container = new Container();
AppFactory::setContainer($container);
$app = AppFactory::create();
$app->addRoutingMiddleware();

$app->setBasePath("/ProgramacionIII-3C/RPP");
new Database();

$app->post('/registro', UserController::class . ":signup")->add(new JsonMiddleware);
$app->post('/login', UserController::class . ":LogIn")->add(new JsonMiddleware);
$app->post('/vehiculo', VehiculoController::class . ":save")->add(new JsonMiddleware)->add(new AuthMiddleware);
$app->get('/patente/{patente}', VehiculoController::class . ":getOne")->add(new JsonMiddleware)->add(new AuthMiddleware);
$app->post('/servicio', ServicioController::class . ":save")->add(new JsonMiddleware)->add(new AuthMiddleware);
$app->get('/turno/{patente}/{fecha}/{tipo}', TurnoController::class . ":save")->add(new JsonMiddleware)->add(new AuthMiddleware);
$app->post('/stats', TurnoController::class . ":getStats")->add(new JsonMiddleware)->add(new UserMiddleware)->add(new AuthMiddleware);

$app->run(); 
