<?php

namespace App\Controllers;

use App\Models\Customer;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;
use DI\ContainerBuilder;
use Seguridad\iToken;
use App\Models\User;
use App\Models\PetType;
use App\Models\Pet;

class MascotaController
{

    public function add(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $body = $request->getParsedBody();
        $nombre = $body['nombre'] ?? '';
        $cliente_id = $body['cliente_id'] ?? '';
        $edad = $body['edad'] ?? '';
        $tipo_mascota = $body['tipo_mascota'] ?? '';
        $petType = new PetType();

        try {
            if (strlen($nombre) == 0) {
                $response->getBody()->write(json_encode(array('message' => 'Name is required')));
            } else {
                if (strlen($cliente_id) == 0) {
                    $response->getBody()->write(json_encode(array('message' => 'cliente_id is required')));
                }else{
                    if (strlen($edad) == 0) {
                        $response->getBody()->write(json_encode(array('message' => 'edad is required')));
                    }else{
                        if (strlen($tipo_mascota) == 0) {
                            $response->getBody()->write(json_encode(array('message' => 'tipo_mascota is required')));
                        }else{
                            $petType = PetType::whereRaw("UPPER(descripcion) = '". strtoupper($tipo_mascota)."'")->get();
                            
                            //tipo_mascota
                            if (!isset($petType[0]['id'])) {
                                $response->getBody()->write(json_encode(array('message' => 'Pet Type does not exists')));
                            } else {
                                $count = Customer::find($cliente_id)->count();

                                //cliente_id
                                if ($count == 0) {
                                    $response->getBody()->write(json_encode(array('message' => 'Customer does not exists')));
                                } else {
                                $pet = new Pet();
                                $pet->nombre = $nombre;
                                $pet->cliente_id = $cliente_id;
                                $pet->edad = $edad;
                                $pet->tipo_mascota_id = $petType[0]['id'];
                                $pet->save();
                                $response->getBody()->write(json_encode(array('message' => 'Pet has been saved')));
                            }
                            }
                        }
                    }
                }
            }
                return $response; 
        } catch (\Throwable $th) {
            $response->getBody()->write($th->getMessage());
            return $response;
        }
    }

    public function addPetType(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $body = $request->getParsedBody();
        $desc = $body['descripcion'] ?? '';

        try {
            if (strlen($desc) == 0) {
                $response->getBody()->write(json_encode(array('message' => 'Descriptoion is required')));
            } else {
                $count = PetType::whereRaw("UPPER(descripcion) = '". strtoupper($desc)."'")->count();

                if ($count > 0) {
                    $response->getBody()->write(json_encode(array('message' => 'Pet Type already exists')));
                } else {
                    $petType = new PetType();
                    $petType->descripcion = $desc;
                    $petType->save();
                    $response->getBody()->write(json_encode(array('message' => 'Pet Type has been saved')));
                }
                
            }
            return $response;
        } catch (\Throwable $th) {
            $response->getBody()->write($th->getMessage());
            return $response;
        }
    }
}
