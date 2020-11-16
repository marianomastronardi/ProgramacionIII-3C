<?php

namespace App\Controllers;

use App\Models\Enrolment;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;
use DI\ContainerBuilder;
use Seguridad\iToken;
use App\Models\Subject;
use App\Models\User;


class EnrolmentController
{

    public function add(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        //$email = $body['email']??'';
        $id_materia = $args['idMateria'] ?? '';

        //if(strlen($email) > 0){
        if (strlen($id_materia) > 0) {
            $arr = $request->getHeader('token');
            if (count($arr) > 0) $token = $arr[0];
            $jwt = isset($token) ? iToken::decodeUserToken($token) : false; // VALIDAR EL TOKEN

            if ($jwt) {
                $user = User::where('email', $jwt["email"])->first();
                if ($user->tipo == 'alumno') {
                    $enrolment = new Enrolment();
                    $enrolment->email = $user->email;
                    $enrolment->subject_id = $id_materia;
                    $enrolment->save();
                    $response->getBody()->write(json_encode(array('message' => 'Enrolment has been saved!!')));
                } else {
                    $response->getBody()->write(json_encode(array('message' => 'Debe ser alumno para poder inscribirse')));
                }
            }
        } else {
            $response->getBody()->write(json_encode(array('message' => 'Debe cargar la materia')));
        }
        //}else{
        //    $response->getBody()->write(json_encode(array('message' => 'Debe cargar el email')));
        //}

        return $response;
    }
}
