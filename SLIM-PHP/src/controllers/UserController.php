<?php

namespace App\Controllers;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Seguridad\Usuario;
use App\Models\User;

class UserController{
    public function getAll(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            $rta = User::get();
            //$body = $request->getParsedBody();
            $response->getBody()->write(json_encode($rta));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (\Throwable $th) {
            var_dump($th);
            $response->getBody()->write(json_encode($th));
            return $response->withHeader('Content-Type', 'application/json');            
        }
    }

    public function add (ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
            //$response->getBody()->write("Hello world from POST!");
            try {
                $body = $request->getParsedBody();
                var_dump($body);
                $user = new User;
                $user->email = $body["email"];
                $user->password = $body["password"];
                //$response->getBody()->write(Usuario::Save($body["email"], $body["password"]));
                var_dump($user);
                $response->getBody()->write('previo al alta');
                $user->save();
                return $response->withHeader('Content-Type', 'application/json');
            } catch (\Throwable $th) {
                $response->getBody()->write(json_encode($th));
                return $response->withHeader('Content-Type', 'application/json');
            }
           
        }
    
    public function getOne (ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        try {
            $user = User::where('email', $args["email"]);
            $response->getBody()->write(json_encode($user));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (\Throwable $th) {
            $response->getBody()->write(json_encode($th));
            return $response->withHeader('Content-Type', 'application/json');
        }    
    }
}