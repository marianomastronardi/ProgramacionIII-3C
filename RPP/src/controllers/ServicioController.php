<?php

namespace App\Controllers;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Models\Servicio;

class ServicioController
{
    public function save(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            $body = $request->getParsedBody();
            $servicio = new Servicio();
            $tipo = $body['tipo']??'';
            $precio = $body['precio']??'';
            $demora = $body['demora']??'';

           if (strlen($tipo) > 0) {
                $servicio->tipo = $tipo;
            } else {
                $response->getBody()->write(json_encode(array('warning' => 'Debe ingresar el tipo')));
                return $response;
            }

            if (strlen($demora) > 0) {
                $servicio->demora = $demora;
            } else {
                $response->getBody()->write(json_encode(array('warning' => 'Debe ingresar la demora')));
                return $response;
            }

            if (strlen($precio) > 0) {
                $servicio->precio = $precio;
            } else {
                $response->getBody()->write(json_encode(array('warning' => 'Debe ingresar el precio')));
                return $response;
            }
            $servicio->save();
            $response->getBody()->write(json_encode(array('message' => 'Servicio guardado correctamente')));
            return $response;
        } catch (\Throwable $th) {
            $response->getBody()->write($th->getMessage());
            return $response;
        }
    }

    
}
