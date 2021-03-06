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
use App\Controllers\EnrolmentController;
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
    $group->post('', UserController::class . ":add"); //1
    $group->post('/{legajo}', UserController::class . ":setEntity")->add(new AuthMiddleware); //4
})->add(new JsonMiddleware);

$app->post('/login', UserController::class . ":LogIn")->add(new JsonMiddleware); //2

$app->post('/inscripcion/{idMateria}', EnrolmentController::class . ":add")
            ->add(new JsonMiddleware)
            ->add(new AuthMiddleware); //5

 $app->group('/materias', function (RouteCollectorProxy $group) {
    $group->get('', SubjectController::class . ":getAll");    //6
    $group->get('/{id}', SubjectController::class . ":getOne");//7
})->add(new JsonMiddleware)->add(new AuthMiddleware);  

$app->post('/materia', SubjectController::class . ":add")
        ->add(new JsonMiddleware)
        ->add(new AuthMiddleware)
        ->add(new UserMiddleware); //3


$app->run(); 
