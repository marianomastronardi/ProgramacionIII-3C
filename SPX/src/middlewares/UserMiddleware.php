<?php

namespace App\Middlewares;

use App\Controllers\UserController;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use Seguridad\iToken;
use App\Models\User;

class UserMiddleware {

    public function __invoke (Request $request, RequestHandler $handler) {

        $arr = $request->getHeader('token');
        print_r($request->getQueryParams());
        //$path = (substr(($request->getServerParams())['REQUEST_URI'], strrpos(($request->getServerParams())['REQUEST_URI'], '/')));
        if(count($arr) > 0) $token = $arr[0];
        $jwt = isset($token) ? iToken::decodeUserToken($token) : false; // VALIDAR EL TOKEN

        if (!$jwt) {
            $response = new Response();

            $rta = array("rta" => "No tiene permisos");

            $response->getBody()->write(json_encode($rta));

            return $response;
        } else {
            $response = $handler->handle($request);

            //solo admin
            /* switch($path){
                case '/materia'
            } */
            $user = User::where('email',$jwt["email"])->first();
            
            if($user->tipo !== 'admin'){
                $existingContent = $response->getBody();
                $resp = new Response();
                $resp->getBody()->write(json_encode(array('message' => 'Debe ser usuario admin')));
                return $resp;
            }

            $existingContent = (string) $response->getBody();

            $resp = new Response();
            $resp->getBody()->write($existingContent);

            return $resp;
        }

    }
}