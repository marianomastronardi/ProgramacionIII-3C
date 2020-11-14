<?php

namespace App\Controllers;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Models\Vehiculo;

class VehiculoController
{
    public function save(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            $body = $request->getParsedBody();
            $vehiculo = new Vehiculo();
            $patente = $body['patente']??'';
            $modelo = $body['modelo']??'';
            $marca = $body['marca']??'';
            $precio = $body['precio']??'';

            if (strlen($patente) > 0) {
                    $vehiculo->patente = $patente;
               } else {
                $response->getBody()->write(json_encode(array('warning' => 'Debe ingresar la patente')));
                return $response;
            }

            if (strlen($modelo) > 0) {
                $vehiculo->modelo = $modelo;
            } else {
                $response->getBody()->write(json_encode(array('warning' => 'Debe ingresar el modelo')));
                return $response;
            }

            if (strlen($marca) > 0) {
                $vehiculo->marca = $marca;
            } else {
                $response->getBody()->write(json_encode(array('warning' => 'Debe ingresar la marca')));
                return $response;
            }

            if (strlen($precio) > 0) {
                $vehiculo->precio = $precio;
            } else {
                $response->getBody()->write(json_encode(array('warning' => 'Debe ingresar el precio')));
                return $response;
            }
            $vehiculo->save();
            $response->getBody()->write(json_encode(array('message' => 'Vehiculo guardado correctamente')));
            return $response;
        } catch (\Throwable $th) {
            $response->getBody()->write($th->getMessage());
            return $response;
        }
    }

    public function getOne(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        try {
            $vehiculo = Vehiculo::find(strtoupper($args["patente"]));
            
            if(!isset($vehiculo)){
                $response->getBody()->write(json_encode(array('message' => "No existe " . $args['patente'])));
            }else{
                $response->getBody()->write(json_encode($vehiculo));
            }
            
            return $response;
        } catch (\Throwable $th) {
            $response->getBody()->write(json_encode($th));
            return $response;
        }
    }
}
