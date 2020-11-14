<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Log\LoggerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteCollectorProxy;
use Seguridad\Usuario;
use Slim\Factory\AppFactory;
use App\Controllers\UserController;
use App\Controllers\SubjectController;
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
use App\Middlewares\AlumnoMiddleware;

require __DIR__ . '/vendor/autoload.php';
$container = new Container();
AppFactory::setContainer($container);
$app = AppFactory::create();
$app->addRoutingMiddleware();

$app->setBasePath("/ProgramacionIII-3C/SPX");
new Database();

$app->group('/usuario', function (RouteCollectorProxy $group) {
    $group->post('', UserController::class . ":add");
    $group->post('/{legajo}', UserController::class . ":setEntity")->add(new AuthMiddleware);
})->add(new JsonMiddleware);

$app->post('/login', UserController::class . ":LogIn")->add(new JsonMiddleware);

$app->post('/inscripcion/{idMateria}', SubjectController::class . ":enrolment")->add(new JsonMiddleware)->add(new AlumnoMiddleware);

 $app->group('/materia', function (RouteCollectorProxy $group) {
    $group->post('', SubjectController::class . ":add")->add(new UserMiddleware);
    $group->get('/{id}', SubjectController::class . ":getByEntity");
})->add(new JsonMiddleware)->add(new AuthMiddleware);  

$app->get('/materias', SubjectController::class . ":getAll")->add(new JsonMiddleware)->add(new AuthMiddleware);

$app->run(); 
