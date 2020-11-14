<?php

namespace App\Controllers;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;
use DI\ContainerBuilder;
use Seguridad\iToken;
use App\Models\Subject;


class SubjectController
{

    public function add(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $body = $request->getParsedBody();
        $nombre = $body['nombre']??'';
        $cuatrimestre = $body['cuatrimestre']??'';
        $cupos = $body['cupos']??'';
        $materia = new Subject();

        if(strlen($nombre) > 0){
            $materia->nombre = $nombre;
            if(strlen($cuatrimestre) > 0){
                $materia->cuatrimestre = $cuatrimestre;
                if(strlen($cupos) > 0){
                    $materia->cupos = $cupos;
                    //$materia->save();
                    $response->getBody()->write(json_encode(array('message' => 'Subject added!!')));
                }else{
                    $response->getBody()->write(json_encode(array('message' => 'Debe ingresar los cupos')));
                }
            }else{
                $response->getBody()->write(json_encode(array('message' => 'Debe ingresar el cuatrimestre')));
            }
        }else{
            $response->getBody()->write(json_encode(array('message' => 'Debe ingresar el nombre')));
        }       
        return $response;
    }

    public function getAll(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $materias = Subject::get();
        $response->getBody()->write(json_encode($materias));
        return $response;
    }

    public function getOne(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $materia = Subject::find($args['id']);
        $response->getBody()->write(json_encode($materia));
        return $response;
    }
}