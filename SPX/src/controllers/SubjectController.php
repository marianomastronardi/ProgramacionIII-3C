<?php

namespace App\Controllers;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;
use DI\ContainerBuilder;
use Seguridad\iToken;
use App\Models\Subject;
use App\Models\User;
use App\Models\Enrolment;

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
                    if(Subject::where('nombre', $materia->nombre)->where('cuatrimestre', $materia->cuatrimestre)->first()){
                        $response->getBody()->write(json_encode(array('message' => 'La materia ya existe!')));
                    }else{
                        $materia->save();
                        $response->getBody()->write(json_encode(array('message' => 'Subject added!!')));
                    }                    
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

        $arr = $request->getHeader('token');
        if(count($arr) > 0) $token = $arr[0];
        $jwt = isset($token) ? iToken::decodeUserToken($token) : false; // VALIDAR EL TOKEN
        
        if($jwt['email']){
             $user = User::find($jwt['email']);
          
             if($user->tipo == 'alumno'){
                $enrolment = Enrolment::select('users.email', 'subjects.nombre')
                ->join('users', 'enrolments.email', '=', 'users.email')
                ->join('subjects', 'enrolments.subject_id', '=', 'subjects.id')
                ->get();
               
                $response->getBody()->write(json_encode($enrolment));
            }else{
                $response->getBody()->write(json_encode(array('message' => 'You must be student to get your subjects')));
            }
        }else{
            $response->getBody()->write(json_encode(array('message' => 'You are not logged')));
        }
        
        return $response;
    }

    public function getOne(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $materia = Subject::find($args['id']);
        $response->getBody()->write(json_encode($materia));
        return $response;
    }
}